<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
            return redirect('admin/dashboard');
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
                        'lastUrl' => url()->previous(),
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
}
