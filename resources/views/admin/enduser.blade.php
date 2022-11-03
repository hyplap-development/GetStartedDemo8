@extends('layouts.admin')

@section('title')
EndUsers
@endsection

@section('header')

@endsection

@section('content')

<!-- Adding Enduser modal -->

<div class=" col-sm-12 text-right">
    <button type="button" id="createBtn" class="btn btn-primary btn-lg m-4 has-ripple" data-toggle="modal" data-target="#exampleModalLong">
        <lord-icon src="https://cdn.lordicon.com/dklbhvrt.json" trigger="hover" colors="primary:#ffffff" target="#createBtn" style="width:25px;height:25px">
        </lord-icon>
        Create Enduser
    </button>
</div>

<!--Excel Modal-->
<div class="modal fade" id="importModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Enduser Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                    </lord-icon>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/enduser/addEnduserExcel')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="p-3" style="font-weight: bold;">Select Excel File <span style="color: red;">&#42</span></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="file" class="form-control" name="excel" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="p-3" style="font-weight: bold;">
                                    Download Format
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <a href="{{url('storage/ExcelFiles/User/UserExcelFormat.xlsx')}}" id="download" download class="btn btn-success">
                                    <lord-icon src="https://cdn.lordicon.com/xhdhjyqy.json" trigger="hover" colors="primary:#FFFFFF" target="#download" style="width:25px;height:25px">
                                    </lord-icon>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer m-0 p-0 pt-3">
                        <!-- <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button> -->
                        <button type="submit" id="addExcel" class="btn btn-primary font-weight-bold">
                            <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="hover" target="#addExcel" colors="primary:#FFFFFF,secondary:#FFFFFF" style="width:25px;height:25px">
                            </lord-icon>
                            Add Excel
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!--Enduser Modal-->
<div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Enduser</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                    </lord-icon>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="{{url('/enduser/addEnduser')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Name <span style="color: red;">&#42</span></label>
                                <input type="name" class="form-control" id="Name" name="name" minlength="3" pattern="[A-Za-z\s]+" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Password <span style="color: red;">&#42</span></label>
                                <input type="text" class="form-control" id="Password" onkeyup="validatePass()" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                <div class="row">
                                    
                                    <div class="col-sm-1 text-center">
                                        <i id="redCapital" class="fas fa-times" style="color: red;"></i>
                                        <i id="greenCapital" class="fas fa-check" style="color: green; display: none;"></i>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>1 Capital letter</label>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <i id="redSmall" class="fas fa-times" style="color: red;"></i>
                                        <i id="greenSmall" class="fas fa-check" style="color: green; display: none;"></i>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>1 small letter</label>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <i id="redNumber" class="fas fa-times" style="color: red;"></i>
                                        <i id="greenNumber" class="fas fa-check" style="color: green; display: none;"></i>
                                    </div>
                                    <div class="col-sm-5">
                                        <label> 1 Number </label>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <i id="redSpecial" class="fas fa-times" style="color: red;"></i>
                                        <i id="greenSpecial" class="fas fa-check" style="color: green; display: none;"></i>
                                    </div>
                                    <div class="col-sm-5">
                                        <label> 1 Special </label>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <i id="red8charac" class="fas fa-times" style="color: red;"></i>
                                        <i id="green8charac" class="fas fa-check" style="color: green; display: none;"></i>
                                    </div>
                                    <div class="col-sm-11">
                                        <label> Password should contain atleast 8 characters </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Email <span style="color: red;">&#42</span></label>
                                <input type="email" class="form-control" onkeyup="checkEmail()" id="Email" name="email" autocomplete="false" required>
                                <span id="emailTitle"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Phone <span style="color: red;">&#42</span></label>
                                <input type="text" class="form-control" onkeyup="checkPhone()" id="Phone" name="phone" maxlength="10" pattern="[789][0-9]{9}" required>
                                <span id="phoneTitle"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Select Role <span style="color: red;">&#42</span></label>
                                <select class="form-control" name="role" required id="Role">
                                    <optgroup label="Roles">

                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: bold;">Status </label>
                                <select class="form-control status" name="status" id="status">
                                    <optgroup label="Status">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </optgroup>

                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer m-0 p-0 pt-3">
                        <!-- <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button> -->
                        <button type="submit" id="userAdd"  class="btn btn-primary font-weight-bold">
                            <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="hover" target="#userAdd" colors="primary:#FFFFFF,secondary:#FFFFFF" style="width:35px;height:35px">
                            </lord-icon>
                            Add Enduser
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(Session::has('alert-' . $msg))
<div class="col-sm-12">
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
</div>
@endif
@endforeach
@if ($errors->any())
<div class="col-sm-12">
    @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endforeach
</div>
@endif

<!-- enduser table -->

<div class="col-sm-12 mt-3">
    <div class="card card-custom ">
        <div class="card-header flex-wrap">
            <div class="card-title">
                <h3 class="card-label">EndUsers </h3>
            </div>
            <div class="card-toolbar">
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" id="export" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <lord-icon src="https://cdn.lordicon.com/diyeocup.json" trigger="hover" colors="primary:#ffffff" state="hover-1" target="#export" style="width:25px;height:25px">
                        </lord-icon>
                        Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
                            <!-- <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-print"></i>
                                    </span>
                                    <span class="navi-text">Print</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-copy"></i>
                                    </span>
                                    <span class="navi-text">Copy</span>
                                </a>
                            </li> -->
                            <li class="navi-item">
                                <a href="{{url('/enduser/exportEnduserExcel')}}" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-file-excel-o"></i>
                                    </span>
                                    <span class="navi-text">Excel</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="{{url('/enduser/exportToCSV')}}" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-file-text-o"></i>
                                    </span>
                                    <span class="navi-text">CSV</span>
                                </a>
                            </li>
                            <!-- <li class="navi-item">
                                <a href="{{url('/enduser/exportToPDF')}}" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-file-pdf-o"></i>
                                    </span>
                                    <span class="navi-text">PDF</span>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>

                <button type="button" id="addExcel" class="btn btn-primary has-ripple" data-toggle="modal" data-target="#importModal">
                    <lord-icon src="https://cdn.lordicon.com/osqwjgzg.json" trigger="hover" colors="primary:#ffffff" target="#addExcel" style="width:25px;height:25px">
                    </lord-icon>
                    Import Excel
                </button>
            </div>
        </div>

        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-responsive-lg" id="tabdata" style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <th class="align-middle text-center">Sr.no</th>
                        <th class="align-middle text-center">Id</th>
                        <th class="align-middle text-center">Name</th>
                        <th class="align-middle text-center">Email</th>
                        <th class="align-middle text-center">Phone Number</th>
                        <th class="align-middle text-center">Role</th>
                        <th class="align-middle text-center">Status</th>
                        <th class="align-middle text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    @foreach($enduser as $data)
                    <tr>
                        <td class="align-middle text-center">{{$i++}}</td>
                        <td class="align-middle text-center">{{$data->id}}</td>
                        <td class="align-middle text-center">{{$data->name}}</td>
                        <td class="align-middle text-center">{{$data->email}}</td>
                        <td class="align-middle text-center">{{$data->phone}}</td>
                        <td class="align-middle text-center">
                            @if(isset($data->rolee))
                            {{$data->rolee->name}}
                            @else
                            <span style="color: red;">No Role Selected</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            @if($data->status == 1)
                            <span style="color: green;">Active</span>
                            @else
                            <span style="color: red;">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="align-middle text-center">
                                <!-- <a href="" class="btn btn-icon btn-outline-primary has-ripple" data-toggle="modal" data-target="#showModal{{$data->id}}"><i class="far fa-eye"></i> </a> -->
                                <a href="" class="btn btn-icon btn-outline-warning has-ripple" data-toggle="modal" data-target="#editModal{{$data->id}}"><i class="fas fa-pen"></i></a>
                                <a href="" class="btn btn-icon btn-outline-danger has-ripple" data-toggle="modal" data-target="#deleteModal{{$data->id}}"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </td>

                    </tr>
                    
                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Enduser Update</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                                        </lord-icon>
                                    </button>
                                </div>

                                <form action="{{url('/enduser/editEnduser')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" value="{{$data->id}}" name="hiddenId">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name <span style="color: red;">&#42</span></label>
                                                    <input type="text" value="{{$data->name}}" class="form-control" name="name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email <span style="color: red;">&#42</span></label>
                                                    <input type="email" value="{{$data->email}}" class="form-control" name="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Phone <span style="color: red;">&#42</span></label>
                                                    <input type="number" value="{{$data->phone}}" class="form-control" required name="phone">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Role <span style="color: red;">&#42</span></label>
                                                    <select class="js-example-basic-single form-control" required style="width: 100%" name="role">
                                                        <optgroup label="Selected Role">
                                                            @if(isset($data->rolee))
                                                            <option selected value="{{$data->role}}">{{$data->rolee->name}}</option>
                                                            @else
                                                            <option selected value="">No Role Selected</option>
                                                            @endif
                                                        </optgroup>
                                                        <optgroup label="Roles">
                                                            @foreach($roles as $role)
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"> Status </label>
                                                    <select class="js-example-basic-single form-control" style="width: 100%" name="status">
                                                        <optgroup label="Current Status">
                                                            @if($data->status == 1)
                                                            <option selected value="1">Active</option>
                                                            @else
                                                            <option selected value="0">Inactive</option>
                                                            @endif
                                                        </optgroup>
                                                        <optgroup label="Change Status">
                                                            <option value="1">Active</option>
                                                            <option value="0">Deactive</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="updateBtn" class="btn btn-primary btngld">
                                            <lord-icon src="https://cdn.lordicon.com/wloilxuq.json" trigger="hover" target="#updateBtn" colors="primary:#FFFFFF" state="hover-2" style="width:35px;height:35px">
                                            </lord-icon>Update
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Enduser</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                                        </lord-icon>
                                    </button>
                                </div>
                                <form action="{{url('/enduser/deleteEnduser')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$data->id}}" name="hiddenId">
                                    <div class="modal-body">
                                        <span>Are you sure you want to delete Enduser {{$data->name}}? <br> Action cannot be reverted</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="delYes" class="btn btn-danger">
                                            <lord-icon src="https://cdn.lordicon.com/dovoajyj.json" trigger="hover" target="#delYes" colors="primary:#FFFFFF" style="width:25px;height:25px">
                                            </lord-icon>
                                            Yes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
</div>

@endsection

@section('scripts')

<!-- Check Email -->
<script>
    function checkEmail() {
        var email = document.getElementById('Email').value;
        var emailTitle = document.getElementById('emailTitle');
        $.ajax({
            type: "POST",
            url: "{{url('/enduser/checkEmail')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'email': email,
            },
            dataType: "json",
            success: function(response) {
                emailTitle.innerHTML = "Email is already taken";
                emailTitle.style.color = 'red';
            },
            error: function(response) {
                emailTitle.innerHTML = "Email is available";
                emailTitle.style.color = 'green';
            }
        });
    }

    function checkPhone() {
        var phone = document.getElementById('Phone').value;
        var phoneTitle = document.getElementById('phoneTitle');
        $.ajax({
            type: "POST",
            url: "{{url('/enduser/checkPhone')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'phone': phone,
            },
            dataType: "json",
            success: function(response) {
                phoneTitle.innerHTML = "Phone is already taken";
                phoneTitle.style.color = 'red';
            },
            error: function(response) {
                phoneTitle.innerHTML = "Phone is available";
                phoneTitle.style.color = 'green';
            }
        });
    }

    function validatePass() {
        var pass = document.getElementById('Password').value;
        var countUpper = (pass.match(/[A-Z]/g) || []).length;
        var countLower = (pass.match(/[a-z]/g) || []).length;
        var countNum = (pass.match(/[0-9]/g) || []).length;
        var countSpecial = (pass.match(/[@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g) || []).length;
        // var passTitle = document.getElementById('passTitle');
        if (pass.length < 8) {
            document.getElementById('red8charac').style.display = 'block';
            document.getElementById('green8charac').style.display = 'none';
        } else {
            document.getElementById('red8charac').style.display = 'none';
            document.getElementById('green8charac').style.display = 'block';
        }

        if (countUpper == 0) {
            document.getElementById('redCapital').style.display = 'block';
            document.getElementById('greenCapital').style.display = 'none';
        } else {
            document.getElementById('redCapital').style.display = 'none';
            document.getElementById('greenCapital').style.display = 'block';
        }

        if (countLower == 0) {
            document.getElementById('redSmall').style.display = 'block';
            document.getElementById('greenSmall').style.display = 'none';
        } else {
            document.getElementById('redSmall').style.display = 'none';
            document.getElementById('greenSmall').style.display = 'block';
        }

        if (countNum == 0) {
            document.getElementById('redNumber').style.display = 'block';
            document.getElementById('greenNumber').style.display = 'none';
        } else {
            document.getElementById('redNumber').style.display = 'none';
            document.getElementById('greenNumber').style.display = 'block';
        }

        if (countSpecial == 0) {
            document.getElementById('redSpecial').style.display = 'block';
            document.getElementById('greenSpecial').style.display = 'none';
        } else {
            document.getElementById('redSpecial').style.display = 'none';
            document.getElementById('greenSpecial').style.display = 'block';
        }
    }
</script>

@endsection