@extends('layouts.admin')

@section('title')
Office Users
@endsection

@section('header')

@endsection

@section('breadcrumb')
<h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Office User</h1>

@endsection

@section('content')

<!--Excel Modal-->
<div class="modal fade" id="importModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import User Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                    </lord-icon>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/user/addUserExcel')}}" method="post" enctype="multipart/form-data">
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

<!--User Modal-->
<!-- <div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <lord-icon src="https://cdn.lordicon.com/vfzqittk.json" trigger="hover" state="hover-2" colors="primary:#000000" style="width:35px;height:35px">
                    </lord-icon>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="{{url('/user/addUser')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 text-center mb-5">
                            <div class="image-input image-input-outline" id="kt_image_4" style=" background-image: url(/media/blank.png)">
                                <div class="image-input-wrapper" style="width: 200px; height: 200px; background-image: url(/media/blank.png)"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Image">
                                    <i class="fas fa-plus icon-sm text-muted"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="profile_avatar_remove" />
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Image">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove Image">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                        </div>
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
                                <label style="font-weight: bold;">User Status </label>
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
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" id="userAdd" class="btn btn-primary font-weight-bold">
                            <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="hover" target="#userAdd" colors="primary:#FFFFFF,secondary:#FFFFFF" style="width:35px;height:35px">
                            </lord-icon>
                            Add User
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div> -->

@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(Session::has('alert-' . $msg))
<div class="col-sm-12">
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} </p>
</div>
@endif
@endforeach
@if ($errors->any())
<div class="col-sm-12">
    @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
</div>
@endif

<!-- user table -->

@if($users->count() == 0)
<div class="card">
    <div class="card-body p-0">
        <div class="card-px text-center py-20 my-10">
            <h2 class="fs-2x fw-bold mb-10">No Users Found</h2>
            <p class="text-gray-400 fs-4 fw-semibold mb-10">Looks like you do not have any users here.
                <br/>If you want to add a User, click on the button below.</p>
            </p>
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add">Add User</a>
        </div>
        <div class="text-center px-4">
            <img class="mw-100 mh-300px" alt="" src="assets/media/illustrations/sketchy-1/5.png" />
        </div>
    </div>
</div>
@else

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                <!-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                            <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                            <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                        </svg>
                    </span>
                    Export
                </button> -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                    Add User</button>
            </div>
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                </div>
                <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
            </div>
        </div>
    </div>
    <div class="card-body pt-0" id="tableDiv">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <thead>
                <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center min-w-25px">Id</th>
                    <th class="text-center min-w-25px">Profile Image</th>
                    <th class="text-center min-w-125px">Name</th>
                    <th class="text-center min-w-125px">Email</th>
                    <th class="text-center min-w-125px">Phone</th>
                    <th class="text-center min-w-125px">Role</th>
                    <th class="text-center min-w-125px">Status</th>
                    <th class="text-center min-w-70px">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @foreach ($users as $data)
                <tr>
                    <td class="text-center">
                        {{ $data->id }}
                    </td>
                    <td class="text-center">
                        <div class="symbol symbol-50px">
                            <img src="{{$data->profileImage != null ? $data->profileImage : 'assets/media/blank.png'}}" alt="" />
                        </div>
                    </td>
                    <td class="text-center">
                        {{ $data->name }}
                    </td>
                    <td class="text-center">
                        {{ $data->email }}
                    </td>
                    <td class="text-center">
                        {{ $data->phone }}
                    </td>
                    <td class="text-center">
                        {{ $data->rolee->name }}
                    </td>
                    <td class="text-center">
                        @if($data->status == 1)
                        <div class="badge badge-light-success">
                            Active
                        </div>
                        @else
                        <div class="badge badge-light-danger">
                            Inactive
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                </svg>
                            </span>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a data-bs-toggle="modal" onclick="getId({{$data->id}})" data-bs-target="#kt_modal_update{{$data->id}}" class="menu-link px-3">Update</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="kt_modal_update{{$data->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-850px">
                        <div class="modal-content">
                            <form class="form" action="#" id="kt_modal_update_form{{$data->id}}" data-kt-redirect="">
                                <div class="modal-header" id="kt_modal_update_header{{$data->id}}">
                                    <h2 class="fw-bold">Update info of {{$data->name}}</h2>
                                    <div id="kt_modal_update_close{{$data->id}}" class="btn btn-icon btn-sm btn-active-icon-primary">
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="modal-body py-10 px-lg-17">
                                    <div class="scroll-y me-n7 pe-7" id="kt_modal_update_scroll{{$data->id}}" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_update_scroll{{$data->id}}" data-kt-scroll-offset="300px">
                                        <div class="row">
                                            <div class="col-sm-6 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Name</label>
                                                <input type="text" class="form-control form-control-solid" placeholder="" id="name{{$data->id}}" value="{{$data->name}}" required />
                                            </div>
                                            
                                            <div class="col-sm-6 fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">Email</span>
                                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                                                </label>
                                                <input type="email" class="form-control form-control-solid" placeholder="" id="email{{$data->id}}" value="{{$data->email}}" required />
                                            </div>
                                            <div class="col-sm-6 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Phone</label>
                                                <input type="text" class="form-control form-control-solid" placeholder="" id="phone{{$data->id}}" value="{{$data->phone}}" required />
                                            </div>
                                            <div class="col-sm-6 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Role</label>
                                                <select class="form-control form-control-solid" id="role{{$data->id}}"  required>
                                                    @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                                <select class="form-control form-control-solid" id="status{{$data->id}}"  required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer flex-center">
                                    <button type="reset" id="kt_modal_update_cancel{{$data->id}}" class="btn btn-light me-3">Discard</button>
                                    <button type="submit" id="kt_modal_update_submit{{$data->id}}" class="btn btn-primary">
                                        <span class="indicator-label">Update</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif
<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <form class="form" action="#" id="kt_modal_add_form" data-kt-redirect="">
                <div class="modal-header" id="kt_modal_add_header">
                    <h2 class="fw-bold">Add a Office User</h2>
                    <div id="kt_modal_add_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-sm-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="name" required />
                            </div>
                            <div class="col-sm-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Password</label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="password" required />
                            </div>

                            <div class="col-sm-6 fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Email</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                                </label>
                                <input type="email" class="form-control form-control-solid" placeholder="" id="email" required />
                            </div>
                            <div class="col-sm-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Phone</label>
                                <input type="text" class="form-control form-control-solid" placeholder="" id="phone" required />
                            </div>
                            <div class="col-sm-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Role</label>
                                <select class="form-control form-control-solid" id="role" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <select class="form-control form-control-solid" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" id="kt_modal_add_cancel" class="btn btn-light me-3">Discard</button>
                    <button type="submit" id="kt_modal_add_submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Export Customers</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_customers_export_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                            <option value="excell">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="cvs">CVS</option>
                            <option value="zip">ZIP</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Pick a date" name="date" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Row-->
                    <div class="row fv-row mb-15">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                        <!--end::Label-->
                        <!--begin::Radio group-->
                        <div class="d-flex flex-column">
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="1" checked="checked" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-semibold">All</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="2" checked="checked" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="3" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                            </label>
                            <!--end::Radio button-->
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid">
                                <input class="form-check-input" type="checkbox" value="4" name="payment_type" />
                                <span class="form-check-label text-gray-600 fw-semibold">American Express</span>
                            </label>
                            <!--end::Radio button-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_customers_export_cancel" class="btn btn-light me-3">Discard</button>
                        <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

<!-- <script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/listing.js')}}"></script> -->
<!-- <script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/add.js')}}"></script> -->
<script src="{{asset('assets/js/custom/apps/ecommerce/customers/listing/export.js')}}"></script>
<!-- <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script> -->

<!-- Adding data -->
<script>
    var KTModalAdd = function() {
        var t, e, o, n, r, i;
        return {
            init: function() {
                i = new bootstrap.Modal(document.querySelector("#kt_modal_add")),
                    r = document.querySelector("#kt_modal_add_form"),
                    t = r.querySelector("#kt_modal_add_submit"),
                    e = r.querySelector("#kt_modal_add_cancel"),
                    o = r.querySelector("#kt_modal_add_close"),
                    n = FormValidation.formValidation(r, {
                        fields: {
                            name: {
                                validators: {
                                    notEmpty: {
                                        message: "Name is required"
                                    }
                                }
                            },
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: "Email is required"
                                    }
                                }
                            },
                            phone: {
                                validators: {
                                    notEmpty: {
                                        message: "Phone is required"
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: "Password is required"
                                    }
                                }
                            },
                            role: {
                                validators: {
                                    notEmpty: {
                                        message: "Role is required"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }), t.addEventListener("click", (function(e) {
                        e.preventDefault(), n && n.validate().then((function(e) {

                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function() {
                                t.removeAttribute("data-kt-indicator"), Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function(e) {
                                    e.isConfirmed && (i.hide(), t.disabled = !1)
                                    //get the form data
                                    var formData = new FormData(r);
                                    formData.append('name', $('#name').val());
                                    formData.append('email', $('#email').val());
                                    formData.append('phone', $('#phone').val());
                                    formData.append('password', $('#password').val());
                                    formData.append('role', $('#role').val());
                                    formData.append('status', $('#status').val());
                                    console.log(formData);
                                    //send the data to the server
                                    $.ajax({
                                        url: "/user/addUser",
                                        type: "POST",
                                        data: formData,
                                        dataType: 'json',
                                        processData: false,
                                        contentType: false,
                                        success: function(data) {
                                            console.log(data);
                                            console.log("added User");
                                        },
                                        error: function(data) {
                                            console.log(data);
                                        }
                                    });
                                    //reload the page
                                    location.reload();


                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), e.addEventListener("click", (function(t) {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), o.addEventListener("click", (function(t) {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }))
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTModalAdd.init()
    }));
</script>

<!-- Updating data -->
<script>
    function getId(id)
    {
        console.log(id);
        var KTModalUpdate = function() {
            var t, e, o, n, r, i;
            return {
                init: function() {
                    i = new bootstrap.Modal(document.querySelector("#kt_modal_update"+id)),
                        r = document.querySelector("#kt_modal_update_form"+id),
                        t = r.querySelector("#kt_modal_update_submit"+id),
                        e = r.querySelector("#kt_modal_update_cancel"+id),
                        o = r.querySelector("#kt_modal_update_close"+id),
                        n = FormValidation.formValidation(r, {
                            fields: {
                                name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Name is required"
                                        }
                                    }
                                },
                                email: {
                                    validators: {
                                        notEmpty: {
                                            message: "Email is required"
                                        }
                                    }
                                },
                                phone: {
                                    validators: {
                                        notEmpty: {
                                            message: "Phone is required"
                                        }
                                    }
                                },
                                password: {
                                    validators: {
                                        notEmpty: {
                                            message: "Password is required"
                                        }
                                    }
                                },
                                role: {
                                    validators: {
                                        notEmpty: {
                                            message: "Role is required"
                                        }
                                    }
                                }
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: ""
                                })
                            }
                        }), t.addEventListener("click", (function(e) {
                            e.preventDefault(), n && n.validate().then((function(e) {
    
                                console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function() {
                                    t.removeAttribute("data-kt-indicator"), Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then((function(e) {
                                        e.isConfirmed && (i.hide(), t.disabled = !1)
                                        //get the form data
                                        var formData = new FormData(r);
                                        formData.append('name', $('#name'+id).val());
                                        formData.append('email', $('#email'+id).val());
                                        formData.append('phone', $('#phone'+id).val());
                                        formData.append('password', $('#password'+id).val());
                                        formData.append('role', $('#role'+id).val());
                                        formData.append('status', $('#status'+id).val());
                                        console.log(formData);
                                        //send the data to the server
                                        $.ajax({
                                            url: "/user/updateUser",
                                            type: "POST",
                                            data: formData,
                                            dataType: 'json',
                                            processData: false,
                                            contentType: false,
                                            success: function(data) {
                                                console.log(data);
                                                console.log("Updated User");
                                                //reload the div
                                            },
                                            error: function(data) {
                                                console.log(data);
                                            }
                                        });
                                        $("#tableDiv").load(" #tableDiv > *");
                                    }))
                                }), 2e3)) : Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        })), e.addEventListener("click", (function(t) {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        })), o.addEventListener("click", (function(t) {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        }))
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function() {
            KTModalUpdate.init()
        }));
    }
</script>


<!-- Delete Button -->
<script>
    var KTCustomersList = function() {
        var t, e, o = () => {
                e.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((e => {
                    e.addEventListener("click", (function(e) {
                        e.preventDefault();
                        const o = e.target.closest("tr"),
                            n = o.querySelectorAll("td")[2].innerText,
                            id = o.querySelectorAll("td")[0].innerText;
                        Swal.fire({
                            text: "Are you sure you want to delete " + n + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then((function(e) {
                            $.ajax({
                                type: "POST",
                                url: "/user/deleteUser",
                                data: {
                                    id: id
                                },
                                dataType: "json",
                                success: function(response) {
                                    console.log('deleted');
                                }
                            });
                            e.value ? Swal.fire({
                                text: "You have deleted " + n + "!.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                },
                            }).then((function() {
                                t.row($(o)).remove().draw()
                                //reload the page
                                location.reload();

                            })) : "cancel" === e.dismiss && Swal.fire({
                                text: n + " was not deleted.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            })
                        }))
                    }))
                }))
            },
            n = () => {
                const o = e.querySelectorAll('[type="checkbox"]'),
                    n = document.querySelector('[data-kt-customer-table-select="delete_selected"]');
                o.forEach((t => {
                    t.addEventListener("click", (function() {
                        setTimeout((function() {
                            c()
                        }), 50)
                    }))
                })), n.addEventListener("click", (function() {
                    Swal.fire({
                        text: "Are you sure you want to delete selected customers?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then((function(n) {
                        n.value ? Swal.fire({
                            text: "You have deleted all selected customers!.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then((function() {
                            o.forEach((e => {
                                e.checked && t.row($(e.closest("tbody tr"))).remove().draw()
                            }));
                            e.querySelectorAll('[type="checkbox"]')[0].checked = !1
                        })) : "cancel" === n.dismiss && Swal.fire({
                            text: "Selected customers was not deleted.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        })
                    }))
                }))
            };
        const c = () => {
            const t = document.querySelector('[data-kt-customer-table-toolbar="base"]'),
                o = document.querySelector('[data-kt-customer-table-toolbar="selected"]'),
                n = document.querySelector('[data-kt-customer-table-select="selected_count"]'),
                c = e.querySelectorAll('tbody [type="checkbox"]');
            let r = !1,
                l = 0;
            c.forEach((t => {
                t.checked && (r = !0, l++)
            })), r ? (n.innerHTML = l, t.classList.add("d-none"), o.classList.remove("d-none")) : (t.classList.remove("d-none"), o.classList.add("d-none"))
        };
        return {
            init: function() {
                (e = document.querySelector("#kt_customers_table")) && (e.querySelectorAll("tbody tr").forEach((t => {
                    const e = t.querySelectorAll("td"),
                        o = moment(e[5].innerHTML, "DD MMM YYYY, LT").format();
                    e[5].setAttribute("data-order", o)
                })), (t = $(e).DataTable({
                    info: !1,
                    order: [],
                    columnDefs: [{
                        orderable: !1,
                        targets: 0
                    }, {
                        orderable: !1,
                        targets: 6
                    }]
                })).on("draw", (function() {
                    n(), o(), c()
                })), n(), document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", (function(e) {
                    t.search(e.target.value).draw()
                })), o(), (() => {
                    const e = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
                    $(e).on("change", (e => {
                        let o = e.target.value;
                        "all" === o && (o = ""), t.column(3).search(o).draw()
                    }))
                })())
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTCustomersList.init()
    }));
</script>


<!-- Check Fields -->
<script>
    function checkEmail() {
        var email = document.getElementById('Email').value;
        var emailTitle = document.getElementById('emailTitle');
        $.ajax({
            type: "POST",
            url: "{{url('/user/checkEmail')}}",
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
            url: "{{url('/user/checkPhone')}}",
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