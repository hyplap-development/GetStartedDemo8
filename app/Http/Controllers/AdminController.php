<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class AdminController extends Controller
{
    // function storeLog($action, $function, $data)
    // {
    //     $log = new Log();
    //     $log->userId = Auth::user()->id;
    //     $log->action = $action;
    //     $log->function = $function;
    //     $log->data = $data;
    //     $log->ip = request()->ip();
    //     $log->save();
    // }

    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function Register(Request $request)
    {
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/login');
    }

    public function showforget(Request $request)
    {
        return view('forgetpassword');
    }

    public function forgetpassword(Request $request)
    {
        $user = User::where('phone', $request->phone)->count();

        if ($user == 0) {
            return response()->json([
                'status' => 201,
                'message' => 'No User with this number',
            ]);
        }
        // Session()->flash('alert-success', "Otp Sent!!");
        // return redirect()->back();

        return response()->json([
            'status' => 200,

        ]);
    }

    public function changepassword(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->pass);
        $user->update();
        return response()->json([
            'status' => 200,
            'message' => 'Password Changed Successfully',
        ]);
    }

    public function login()
    {
        if (Auth::check()) {
            // $this->storeLog('Login', 'login', 'Login');
            return redirect('dashboard');
        } else {
            return view('admin.auth.login');
            Session()->flash('alert-success', "Please Login in First");
        }
        return view('admin.auth.login');
    }

    public function checkUser(Request $request)
    {
        // return $request;
        $phone = $request->post('login');
        $email = $request->post('login');

        $result = User::where(['phone' => $phone])
            ->orWhere(['email' => $email])
            ->first();


        if ($result) {
            if ($result->status == 1 && $result->deleteId == 0) {
                if (Hash::check($request->post('password'), $result->password)) {
                    Auth::login($result);
                    // return redirect('dashboard');
                    return response()->json([
                        'status' => 200,
                        'message' => 'Logged In succesfully',
                    ]);
                } else {
                    Session()->flash('alert-danger', 'Incorrect Password');
                    // return redirect()->back();
                    return response()->json([
                        'status' => 201,
                        'message' => 'Incorrect Password',
                    ]);
                }
            } else if ($result->status != 1) {
                return response()->json([
                    'status' => 204,
                    'message' => 'User Not active',
                ]);
            } else if ($result->deleteId == 1) {
                return response()->json([
                    'status' => 205,
                    'message' => 'User Deleted',
                ]);
            }
        } else {

            return response()->json([
                'status' => 202,
                'message' => 'Invalid Details',
            ]);
        }
    }

    public function logout()
    {
        // $this->storeLog('Logout', 'logout', 'Logout');
        Auth::logout();
        return redirect('/login');
    }

    // Office User Controller

    public function indexUser()
    {
        $users = User::where('deleteId', '0')->whereIn('role', [1])->with('rolee')->get();
        $roles = Role::where('deleteId', '0')->whereIn('id', [1])->get();
        return view('admin.user', compact('users', 'roles'));
    }

    public function checkOfficeUserEmail(Request $request)
    {
        $data = User::where('email', $request->email)->where('deleteId', 0)->first();
        if ($data) {
            return response()->json([
                'status' => 201,
                'message' => 'Email Already Exist',
            ]);
        }
    }

    public function checkOfficeUserPhone(Request $request)
    {
        $data = User::where('phone', $request->phone)->where('deleteId', 0)->first();
        if ($data) {
            return response()->json([
                'status' => 201,
                'message' => 'Phone Already Exist',
            ]);
        }
    }

    public function saveUser(Request $request)
    {

        $user = new User;

        $uploadpath = 'media/images/users';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $final_name = time() . $image_name;
            $image->move($uploadpath, $final_name);
            chmod('media/images/users/' . $final_name, 0777);
            $image_path = "media/images/users/" . $final_name;
        } else {
            $image_path = "";
        }

        $user->profileImage = $image_path;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();
        Session()->flash('alert-success', "User Added Succesfully");
        return redirect()->back();
    }

    public function exportToCSV()
    {
        $data = User::all();
        $handle = fopen('export.csv', 'w');
        // fputcsv($handle, array('id', 'name', 'email', 'phone', 'role', 'status', 'created_at', 'updated_at'));
        User::chunk(100, function ($users) use ($handle) {
            foreach ($users as $row) {
                fputcsv($handle, $row->toArray(), ';');
            }
        });
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download('export.csv', 'export.csv', $headers);
    }

    public function ExportOfficeUserExcel($OfficeUser_data)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($OfficeUser_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="OfficeUsers_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportOfficeUserData()
    {
        $data = User::orderBy('id', 'DESC')->get();
        $data_array[] = array("Id", "Name", "Phone", "Email", "Role", "Status", "Created At", "Updated At");
        foreach ($data as $data_item) {
            if ($data_item->status == 1) {
                $status = 'Active';
            } else {
                $status = 'Inactive';
            }
            $data_array[] = array(
                'Id' => $data_item->id,
                'Name' => $data_item->name,
                'Phone' => $data_item->phone,
                'Email' => $data_item->email,
                'Role' => $data_item->rolee->name,
                'Status' => $status,
                'Created At' => $data_item->created_at,
                'Updated At' => $data_item->updated_at,
            );
        }
        $this->ExportOfficeUserExcel($data_array);
    }

    public function saveUserExcel(Request $request)
    {
        $this->validate($request, [
            'excel' => 'required|mimes:xls,xlsx'
        ]);
        try {
            $file = $request->file('excel');
            $filename = $file->getClientOriginalName();
            $uploadpath = 'storage/ExcelFiles/User/';
            $filepath = 'storage/ExcelFiles/User/' . $filename;
            $file->move($uploadpath, $filename);

            chmod('storage/ExcelFiles/User/' . $filename, 0777);
            $xls_file = $filepath;
            $reader = new Xlsx();
            $spreadsheet = $reader->load($xls_file);
            $loadedSheetName = $spreadsheet->getSheetNames();

            $writer = new Csv($spreadsheet);
            $sheetName = $loadedSheetName[0];
            foreach ($loadedSheetName as $sheetIndex => $loadedSheetName) {
                $writer->setSheetIndex($sheetIndex);
                $writer->save($loadedSheetName . '.csv');
            }
            $inf = $sheetName . '.csv';
            $fileD = fopen($inf, "r");
            $column = fgetcsv($fileD);
            while (!feof($fileD)) {
                $rowData[] = fgetcsv($fileD);
            }
            $skip_lov = array();
            $counter = 0;
            $failed = 0;
            foreach ($rowData as $value) {

                if (empty($value)) {
                    $counter--;
                } else {
                    $fieldData = new User();  //name of modal
                    $fieldData->name = $value[0];  //name of database feild = colm no in xls
                    $fieldData->dob = $value[1];
                    $fieldData->address = $value[2];
                    $fieldData->phone = $value[3];
                    $fieldData->email = $value[4];
                    $fieldData->password = Hash::make($value[5]);
                    $fieldData->aadhar = $value[6];
                    $fieldData->esicNumber = $value[7];
                    $fieldData->pfNumber = $value[8];
                    $fieldData->role = $value[9];
                    $fieldData->notes = $value[10];
                    $fieldData->siteId = $value[11];
                    $fieldData->dependents = $value[12];
                    $fieldData->skillLevel = $value[13];
                    $fieldData->maxTicketsPerDay = $value[14];
                    $fieldData->save();
                }
                $counter++;
            }
            Session()->flash('alert-success', "File Uploaded Succesfully");
            return redirect()->back();
        } catch (\Exception $e) {
            Session()->flash('alert-danger', 'error:' . $e);
            return redirect()->back();
        }
    }

    public function deleteUser(Request $request)
    {
        $model = User::find($request->id);
        $model->deleteId = 1;
        $model->save();
        Session()->flash('alert-success', "User Deleted Succesfully");
        // return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        $model = User::find($request->hiddenId);

        $uploadpath = 'media/images/users';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $final_name = time() . $image_name;
            $image->move($uploadpath, $final_name);
            chmod('media/images/users/' . $final_name, 0777);
            $image_path = "media/images/users/" . $final_name;
        } else {
            $image_path = User::where('id', $request->hiddenId)->first();
            $image_path = $image_path['image'];
        }

        $model->profileImage = $image_path;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->role = $request->role;
        $model->status = $request->status;
        $model->update();
        Session()->flash('alert-success', "User Updated Succesfully");

        return redirect()->back();
    }
}
