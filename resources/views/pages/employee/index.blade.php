@extends('layouts.app')
@section('title', trans('trans.employee'))
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.employee')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.employee')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card vCard">
                    <div class="card-header">
                        <h3 class="card-title">@lang('trans.employee')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#employeeRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>


                    <div class="card-body">
                        <table id="employeeDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Profile Picture</th>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Current Employee</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>
                                        @if($employee->profile_image)
                                            <img src="{{asset($employee->profile_image)}}" class="circle-avatar"
                                                 alt="employee-avatar">
                                        @else

                                            <img src="{{asset('asset/img/employee/default.png')}}" class="circle-avatar"
                                                 alt="employee-default-avatar">
                                        @endif
                                    </td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->custom_id}}</td>
                                    <td>{{$employee->personal_email}}</td>
                                    <td>{{$employee->phone}}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                           class="badge {{$employee->is_current_employee == 1 ? 'badge-success' : 'badge-danger'}}"

                                           onclick="employeeStatusChange({{json_encode($employee->id)}})"
                                           data-toggle="tooltip"
                                           title="Click to change status"

                                           id="employee_status_{{$employee->id}}"
                                           data-href="{{route('employees.status', $employee->id)}}"
                                        >
                                            @if($employee->is_current_employee==1)
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-power-off"></i>
                                            @endif
                                        </a>
                                    </td>

                                    <td>

                                        <button onclick="getEmployeeShowInfo({{$employee->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getEmployeeEditInfo({{$employee->id}})"

                                                class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                title="Edit employee"><i class="fa fa-edit"></i>
                                        </button>

                                        <button onclick="makeHOD({{$employee->id}})" class="btn btn-sm btn-success"
                                                data-toggle="tooltip"
                                                title="Department head" id="makeHOD"><i class="fas fa-user-alt"></i>
                                        </button>


                                        <form action="{{route('employees.destroy', $employee->id)}}"
                                              method="post" id="delete_employee_{{$employee->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteEmployee({{json_encode($employee->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete employee"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="employeeShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.employee_information')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="text-center mb-3">
                            <img id="show_profile_image" class="circle-avatar-preview" src="" alt="Profile Image"
                                 width="200px">
                        </div>

                        <table class="table table-hover">

                            <tbody>
                            <tr>
                                <th>Employee ID:</th>
                                <td id="show_custom_id"></td>
                            </tr>

                            <tr>
                                <th>Name:</th>
                                <td id="show_name"></td>
                            </tr>

                            <tr>
                                <th>Personal Email</th>
                                <td id="show_personal_email"></td>
                            </tr>

                            <tr>
                                <th>Office Email</th>
                                <td id="show_office_email"></td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td id="show_phone"></td>
                            </tr>

                            <tr>
                                <th>Office Phone</th>
                                <td id="show_office_phone"></td>
                            </tr>

                            <tr>
                                <th>Gender:</th>
                                <td id="show_gender"></td>
                            </tr>

                            <tr>
                                <th>Present Address:</th>
                                <td id="show_present_address"></td>
                            </tr>

                            <tr>
                                <th>Permanent Address:</th>
                                <td id="show_permanent_address"></td>
                            </tr>

                            <tr>
                                <th>Date of Birth:</th>
                                <td id="show_dob"></td>
                            </tr>

                            <tr>
                                <th>Emergency Contact Person:</th>
                                <td id="show_emergency_contact_person"></td>
                            </tr>

                            <tr>
                                <th>Emergency Contact Phone:</th>
                                <td id="show_emergency_contact_phone"></td>
                            </tr>

                            <tr>
                                <th>Emergency Contact Address:</th>
                                <td id="show_emergency_contact_address"></td>
                            </tr>

                            <tr>
                                <th>Emergency Contact Relation:</th>
                                <td id="show_emergency_contact_relation"></td>
                            </tr>

                            <tr>
                                <th>Blood Group:</th>
                                <td id="show_blood_group_id"></td>
                            </tr>

                            <tr>
                                <th>Department:</th>
                                <td id="show_department_id"></td>
                            </tr>

                            <tr>
                                <th>Designation:</th>
                                <td id="show_designation_id"></td>
                            </tr>

                            <tr>
                                <th>NID Number:</th>
                                <td id="show_nid_number"></td>
                            </tr>

                            <tr>
                                <th>Salary:</th>
                                <td id="show_salary"></td>
                            </tr>

                            <tr>
                                <th>Join Date:</th>
                                <td id="show_join_date"></td>
                            </tr>

                            <tr>
                                <th>Leave Date:</th>
                                <td id="show_quit_date"></td>
                            </tr>

                            <tr>
                                <th>Current Employee:</th>
                                <td class="vBadge" id="show_is_current_employee"></td>
                            </tr>

                            <tr>
                                <th>Provision Period:</th>
                                <td class="vBadge" id="show_is_provision_period"></td>
                            </tr>

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-sm-6">
                                <p class="text-bold pl-3">NID Image:</p>
                                <a href="#">
                                    <img src="" class="p-3" alt="NID Image" width="200px" id="show_nid_image">
                                </a>

                            </div>
                            <div class="col-sm-6">
                                <p class="text-bold pl-3">Certificate Image:</p>
                                <a href="#">
                                    <img src="" class="p-3" alt="Certificate Image" width="200px"
                                         id="show_certificate_image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer float-right w-100">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('trans.close')</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="employeeRegisterModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.register_new_employee')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="employeeRegisterForm" action="{{route('employees.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-bold">Personal Info</h4>
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="first_name" class="mandatory">First Name</label>
                                        <input type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               placeholder="Enter First Name"
                                               name="first_name" id="first_name" value="{{old('first_name')}}">
                                        @error('first_name') <span
                                            class="text-danger float-right">{{$errors->first('first_name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name"
                                               name="last_name" id="last_name" value="{{old('last_name')}}">
                                        @error('last_name') <span
                                            class="text-danger float-right">{{$errors->first('last_name') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="personal_email" class="mandatory">Personal Email</label>
                                        <input type="email"
                                               class="form-control @error('personal_email') is-invalid @enderror"
                                               placeholder="Enter personal email address"
                                               name="personal_email" id="personal_email"
                                               value="{{old('personal_email')}}">
                                        @error('personal_email') <span
                                            class="text-danger float-right">{{$errors->first('personal_email') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="office_email" class="mandatory">Office Email</label>
                                        <input type="email"
                                               class="form-control @error('office_email') is-invalid @enderror"
                                               placeholder="Enter office email address"
                                               name="office_email" id="office_email"
                                               value="{{old('office_email')}}">
                                        @error('office_email') <span
                                            class="text-danger float-right">{{$errors->first('office_email') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="phone" class="mandatory">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="Enter phone number"
                                               name="phone" id="phone" value="{{old('phone')}}">
                                        @error('phone') <span
                                            class="text-danger float-right">{{$errors->first('phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="office_phone" class="mandatory">Office Phone</label>
                                        <input type="text"
                                               class="form-control @error('office_phone') is-invalid @enderror"
                                               placeholder="Enter office phone number"
                                               name="office_phone" id="office_phone"
                                               value="{{old('office_phone')}}">
                                        @error('office_phone') <span
                                            class="text-danger float-right">{{$errors->first('office_phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="present_address" class="mandatory">Present Address</label>
                                        <textarea class="form-control @error('present_address') is-invalid @enderror"
                                                  id="present_address" name="present_address"
                                                  rows="3">{{old('present_address')}}</textarea>
                                        @error('present_address') <span
                                            class="text-danger float-right">{{$errors->first('present_address') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="permanent_address" class="mandatory">Permanent Address</label>
                                        <textarea class="form-control @error('permanent_address') is-invalid @enderror"
                                                  id="permanent_address" name="permanent_address"
                                                  rows="3">{{old('permanent_address')}}</textarea>
                                        @error('permanent_address') <span
                                            class="text-danger float-right">{{$errors->first('permanent_address') }}</span> @enderror
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="dob" class="mandatory">Date of birth</label>
                                        <input type="text" class="form-control singleDateRange @error('dob') is-invalid @enderror"
                                               placeholder="Enter Date of birth"
                                               name="dob" id="dob" value="{{old('dob')}}">
                                        @error('dob') <span
                                            class="text-danger float-right">{{$errors->first('dob') }}</span> @enderror
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <!-- radio -->
                                    <div class="form-group">
                                        <label class="mandatory">Gender</label>
                                        <div class="form-check">
                                            <div class="row pt-2">
                                                <div class="col-3">
                                                    <input class="form-check-input" type="radio"
                                                           id="gender_male_create"
                                                           name="gender"
                                                           value="Male"
                                                           checked>
                                                    <label for="gender_male_create"
                                                           class="form-check-label"><b>Male</b></label>

                                                </div>

                                                <div class="col-3">
                                                    <input class="form-check-input" type="radio"
                                                           id="gender_female_create" name="gender"
                                                           value="Female">
                                                    <label for="gender_female_create"
                                                           class="form-check-label"><b>Female</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="department_id" class="mandatory">Department</label>
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Choose Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}"
                                                        @if(old('department_id')==$department->id) selected @endif>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <span
                                            class="text-danger float-right">{{$errors->first('department_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="designation_id" class="mandatory">Designation</label>
                                        <select class="form-control" name="designation_id" id="designation_id">
                                            <option value="">Choose Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{$designation->id}}"
                                                        @if(old('designation_id')==$designation->id) selected @endif>{{$designation->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('designation_id') <span
                                            class="text-danger float-right">{{$errors->first('designation_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="blood_group_id" class="mandatory">Blood Group</label>
                                        <select class="form-control" name="blood_group_id" id="blood_group_id">
                                            <option value="">Choose Blood Group</option>
                                            @foreach($bloodGroups as $bloodGroup)
                                                <option value="{{$bloodGroup->id}}"
                                                        @if(old('blood_group_id')==$bloodGroup->id) selected @endif>{{$bloodGroup->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('blood_group_id') <span
                                            class="text-danger float-right">{{$errors->first('blood_group_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="profile_image" class="mandatory">Profile Picture</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewProfileImage(event)"
                                                   name="profile_image" id="profile_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="profile_image"
                                                   id="create_profile_image_label">Choose Image</label>
                                        </div>
                                        <img id="preview_profile_image_output" class="circle-avatar-preview pt-2" src=""
                                             alt="Logo"
                                             style="display: none" width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="createProfilePictureError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('profile_image') <span
                                            class="text-danger float-right">{{$errors->first('profile_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12 pt-4">
                                    <h4 class="text-bold">Emergency Contact Info</h4>
                                    <hr>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_person" class="mandatory">Emergency Contact
                                            Name</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_person') is-invalid @enderror"
                                               placeholder="Enter emergency contact name"
                                               name="emergency_contact_person" id="emergency_contact_person"
                                               value="{{old('emergency_contact_person')}}">
                                        @error('emergency_contact_person') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_person') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_phone" class="mandatory">Emergency Contact
                                            phone</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                               placeholder="Enter emergency contact phone"
                                               name="emergency_contact_phone" id="emergency_contact_phone"
                                               value="{{old('emergency_contact_phone')}}">
                                        @error('emergency_contact_phone') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_relation" class="mandatory">Emergency contact
                                            relation</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_relation') is-invalid @enderror"
                                               placeholder="Enter emergency contact phone"
                                               name="emergency_contact_relation" id="emergency_contact_relation"
                                               value="{{old('emergency_contact_relation')}}">
                                        @error('emergency_contact_relation') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_relation') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_address" class="mandatory">Emergency contact
                                            address</label>
                                        <textarea
                                            class="form-control @error('emergency_contact_address') is-invalid @enderror"
                                            id="emergency_contact_address" name="emergency_contact_address"
                                            rows="3">{{old('emergency_contact_address')}}</textarea>
                                        @error('emergency_contact_address') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_address') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 pt-3">
                                    <h4 class="text-bold">Other Info</h4>
                                    <hr>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="nid_number" class="mandatory">NID Number</label>
                                        <input type="number"
                                               class="form-control @error('nid_number') is-invalid @enderror"
                                               placeholder="Enter NID Number"
                                               name="nid_number" id="nid_number" value="{{old('nid_number')}}">
                                        @error('nid_number') <span
                                            class="text-danger float-right">{{$errors->first('nid_number') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="salary" class="mandatory">Salary</label>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                               placeholder="Enter Salary"
                                               name="salary" id="salary" value="{{old('salary')}}">
                                        @error('salary') <span
                                            class="text-danger float-right">{{$errors->first('salary') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="join_date" class="mandatory">Join Date</label>
                                        <input type="text" class="form-control singleDateRange @error('join_date') is-invalid @enderror"
                                               placeholder="Enter join date"
                                               name="join_date" id="join_date" value="{{old('join_date')}}">
                                        @error('join_date') <span
                                            class="text-danger float-right">{{$errors->first('join_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="quit_date">Leave Date</label>
                                        <input type="text" class="form-control singleDateRange @error('quit_date') is-invalid @enderror"
                                               placeholder="Enter leave date"
                                               name="quit_date" id="quit_date" value="{{old('quit_date')}}">
                                        @error('quit_date') <span
                                            class="text-danger float-right">{{$errors->first('quit_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nid_image" class="mandatory">NID Image</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewNidImageImage(event)"
                                                   name="nid_image" id="nid_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="nid_image"
                                                   id="create_nid_image_label">Choose Image</label>
                                        </div>
                                        <img id="preview_nid_image_output" class="circle-avatar-preview pt-2" src=""
                                             alt="Logo"
                                             style="display: none" width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="createNidImageError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('nid_image') <span
                                            class="text-danger float-right">{{$errors->first('nid_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="certificate_image" class="mandatory">Certificate Image</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewCertificateImageImage(event)"
                                                   name="certificate_image" id="certificate_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="certificate_image"
                                                   id="create_certificate_image_label">Choose Image</label>
                                        </div>
                                        <img id="preview_certificate_image_output" class="circle-avatar-preview pt-2"
                                             src="" alt="Logo"
                                             style="display: none" width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="createCertificateImageError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('certificate_image') <span
                                            class="text-danger float-right">{{$errors->first('certificate_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6 pt-3">
                                    <div class="form-group">
                                        <label for="switch">Current Employee</label>
                                        <input type="checkbox" name="is_current_employee" id="is_current_employee"
                                               class="employee_status_switch"
                                               checked
                                               data-bootstrap-switch
                                               data-off-color="danger"
                                               data-on-color="success">
                                    </div>
                                </div>
                                <div class="col-sm-6 pt-3">
                                    <div class="form-group">
                                        <label for="switch">Provision period</label>
                                        <input type="checkbox" name="is_provision_period" id="is_provision_period"
                                               class="employee_status_switch"
                                               checked
                                               data-bootstrap-switch
                                               data-off-color="danger"
                                               data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.modal-body-->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default float-right"
                                    data-dismiss="modal">@lang('trans.close')
                            </button>
                            <button type="submit"
                                    class="btn btn-sm defaultBtn float-right">@lang('trans.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="employeeEditModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_employee')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="employeeEditForm" action=""
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-bold">Personal Info</h4>
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="first_name" class="mandatory">First Name</label>
                                        <input type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               placeholder="Enter First Name"
                                               name="first_name" id="edit_first_name" value="">
                                        @error('first_name') <span
                                            class="text-danger float-right">{{$errors->first('first_name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name"
                                               name="last_name" id="edit_last_name" value="">
                                        @error('last_name') <span
                                            class="text-danger float-right">{{$errors->first('last_name') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="personal_email" class="mandatory">Personal Email</label>
                                        <input type="email"
                                               class="form-control @error('personal_email') is-invalid @enderror"
                                               placeholder="Enter personal email address"
                                               name="personal_email" id="edit_personal_email"
                                               value="{{old('personal_email')}}">
                                        @error('personal_email') <span
                                            class="text-danger float-right">{{$errors->first('personal_email') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="office_email" class="mandatory">Office Email</label>
                                        <input type="email"
                                               class="form-control @error('office_email') is-invalid @enderror"
                                               placeholder="Enter office email address"
                                               name="office_email" id="edit_office_email"
                                               value="{{old('office_email')}}">
                                        @error('office_email') <span
                                            class="text-danger float-right">{{$errors->first('office_email') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="phone" class="mandatory">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="Enter phone number"
                                               name="phone" id="edit_phone" value="{{old('phone')}}">
                                        @error('phone') <span
                                            class="text-danger float-right">{{$errors->first('phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="office_phone" class="mandatory">Office Phone</label>
                                        <input type="text"
                                               class="form-control @error('office_phone') is-invalid @enderror"
                                               placeholder="Enter office phone number"
                                               name="office_phone" id="edit_office_phone"
                                               value="{{old('office_phone')}}">
                                        @error('office_phone') <span
                                            class="text-danger float-right">{{$errors->first('office_phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="present_address" class="mandatory">Present Address</label>
                                        <textarea class="form-control @error('present_address') is-invalid @enderror"
                                                  id="edit_present_address" name="present_address"
                                                  rows="3">{{old('present_address')}}</textarea>
                                        @error('present_address') <span
                                            class="text-danger float-right">{{$errors->first('present_address') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="permanent_address" class="mandatory">Permanent Address</label>
                                        <textarea class="form-control @error('permanent_address') is-invalid @enderror"
                                                  id="edit_permanent_address" name="permanent_address"
                                                  rows="3">{{old('permanent_address')}}</textarea>
                                        @error('permanent_address') <span
                                            class="text-danger float-right">{{$errors->first('permanent_address') }}</span> @enderror
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="dob" class="mandatory">Date of birth</label>
                                        <input type="text" class="form-control singleDateRange @error('dob') is-invalid @enderror"
                                               placeholder="Enter date of birth"
                                               name="dob" id="edit_dob" value="{{old('dob')}}">
                                        @error('dob') <span
                                            class="text-danger float-right">{{$errors->first('dob') }}</span> @enderror
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <!-- radio -->
                                    <div class="form-group">
                                        <label class="mandatory">Gender</label>
                                        <div class="form-check">
                                            <div class="row pt-2">
                                                <div class="col-3">
                                                    <input class="form-check-input" type="radio"
                                                           id="edit_gender_male"
                                                           name="gender"
                                                           value="Male"
                                                           checked>
                                                    <label for="gender_male_create"
                                                           class="form-check-label"><b>Male</b></label>

                                                </div>

                                                <div class="col-3">
                                                    <input class="form-check-input" type="radio"
                                                           id="edit_gender_female" name="gender"
                                                           value="Female">
                                                    <label for="gender_female_create"
                                                           class="form-check-label"><b>Female</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="department_id" class="mandatory">Department</label>
                                        <select class="form-control" name="department_id" id="edit_department_id">
                                            <option value="">Choose Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}"
                                                        @if(old('department_id')==$department->id) selected @endif>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <span
                                            class="text-danger float-right">{{$errors->first('department_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="designation_id" class="mandatory">Designation</label>
                                        <select class="form-control" name="designation_id" id="edit_designation_id">
                                            <option value="">Choose Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{$designation->id}}"
                                                        @if(old('designation_id')==$designation->id) selected @endif>{{$designation->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('designation_id') <span
                                            class="text-danger float-right">{{$errors->first('designation_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="blood_group_id" class="mandatory">Blood Group</label>
                                        <select class="form-control" name="blood_group_id" id="edit_blood_group_id">
                                            <option value="">Choose Blood Group</option>
                                            @foreach($bloodGroups as $bloodGroup)
                                                <option value="{{$bloodGroup->id}}"
                                                        @if(old('blood_group_id')==$bloodGroup->id) selected @endif>{{$bloodGroup->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('blood_group_id') <span
                                            class="text-danger float-right">{{$errors->first('blood_group_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="profile_image" class="mandatory">Profile Picture</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="editPreviewProfileImage(event)"
                                                   name="profile_image" id="edit_profile_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="profile_image"
                                                   id="edit_profile_image_label">Choose Image</label>
                                        </div>
                                        <img id="edit_preview_profile_image_output" class="circle-avatar-preview pt-2"
                                             src="" alt="Logo"
                                             width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="editProfilePictureError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('profile_image') <span
                                            class="text-danger float-right">{{$errors->first('profile_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12 pt-4">
                                    <h4 class="text-bold">Emergency Contact Info</h4>
                                    <hr>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_person" class="mandatory">Emergency Contact
                                            Name</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_person') is-invalid @enderror"
                                               placeholder="Enter emergency contact name"
                                               name="emergency_contact_person" id="edit_emergency_contact_person"
                                               value="{{old('emergency_contact_person')}}">
                                        @error('emergency_contact_person') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_person') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_phone" class="mandatory">Emergency Contact
                                            phone</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                               placeholder="Enter emergency contact phone"
                                               name="emergency_contact_phone" id="edit_emergency_contact_phone"
                                               value="{{old('emergency_contact_phone')}}">
                                        @error('emergency_contact_phone') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_phone') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_relation" class="mandatory">Emergency contact
                                            relation</label>
                                        <input type="text"
                                               class="form-control @error('emergency_contact_relation') is-invalid @enderror"
                                               placeholder="Enter emergency contact phone"
                                               name="emergency_contact_relation" id="edit_emergency_contact_relation"
                                               value="{{old('emergency_contact_relation')}}">
                                        @error('emergency_contact_relation') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_relation') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="emergency_contact_address" class="mandatory">Emergency contact
                                            address</label>
                                        <textarea
                                            class="form-control @error('emergency_contact_address') is-invalid @enderror"
                                            id="edit_emergency_contact_address" name="emergency_contact_address"
                                            rows="3">{{old('emergency_contact_address')}}</textarea>
                                        @error('emergency_contact_address') <span
                                            class="text-danger float-right">{{$errors->first('emergency_contact_address') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 pt-3">
                                    <h4 class="text-bold">Other Info</h4>
                                    <hr>
                                </div>


                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="nid_number" class="mandatory">NID Number</label>
                                        <input type="number"
                                               class="form-control @error('nid_number') is-invalid @enderror"
                                               placeholder="Enter NID Number"
                                               name="nid_number" id="edit_nid_number" value="{{old('nid_number')}}">
                                        @error('nid_number') <span
                                            class="text-danger float-right">{{$errors->first('nid_number') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="salary" class="mandatory">Salary</label>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                               placeholder="Enter Salary"
                                               name="salary" id="edit_salary" value="{{old('salary')}}">
                                        @error('salary') <span
                                            class="text-danger float-right">{{$errors->first('salary') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="join_date" class="mandatory">Join Date</label>
                                        <input type="text" class="form-control singleDateRange @error('join_date') is-invalid @enderror"
                                               placeholder="Enter join date"
                                               name="join_date" id="edit_join_date" value="{{old('join_date')}}">
                                        @error('join_date') <span
                                            class="text-danger float-right">{{$errors->first('join_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="quit_date">Leave Date</label>
                                        <input type="text" class="form-control singleDateRange @error('quit_date') is-invalid @enderror"
                                               placeholder="Enter leave date"
                                               name="quit_date" id="edit_quit_date" value="{{old('quit_date')}}">
                                        @error('quit_date') <span
                                            class="text-danger float-right">{{$errors->first('quit_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nid_image" class="mandatory">NID Image</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="editPreviewNidImageImage(event)"
                                                   name="nid_image" id="edit_nid_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="nid_image"
                                                   id="edit_nid_image_label">Choose Image</label>
                                        </div>
                                        <img id="edit_preview_nid_image_output" class="circle-avatar-preview pt-2"
                                             src="" alt="Logo"
                                             width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="editNidImageError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('nid_image') <span
                                            class="text-danger float-right">{{$errors->first('nid_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="certificate_image" class="mandatory">Certificate Image</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="editPreviewCertificateImageImage(event)"
                                                   name="certificate_image" id="edit_certificate_image"
                                                   accept="image/png,image/jpeg,images/jpg">
                                            <label class="custom-file-label" for="certificate_image"
                                                   id="edit_certificate_image_label">Choose Image</label>
                                        </div>
                                        <img id="edit_preview_certificate_image_output"
                                             class="circle-avatar-preview pt-2" src="" alt="Logo"
                                             width="200px">

                                        <small class="text-danger d-block float-right"
                                               id="editCertificateImageError">
                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                        </small>

                                        @error('certificate_image') <span
                                            class="text-danger float-right">{{$errors->first('certificate_image') }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6 pt-3">
                                    <div class="form-group">
                                        <label for="switch">Current Employee</label>
                                        <input type="checkbox" name="is_current_employee" id="edit_is_current_employee"
                                               class="employee_status_switch"
                                               data-bootstrap-switch
                                               data-off-color="danger"
                                               data-on-color="success">
                                    </div>
                                </div>
                                <div class="col-sm-6 pt-3">
                                    <div class="form-group">
                                        <label for="switch">Provision period</label>
                                        <input type="checkbox" name="is_provision_period" id="edit_is_provision_period"
                                               class="employee_status_switch"
                                               data-bootstrap-switch
                                               data-off-color="danger"
                                               data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default float-right"
                                    data-dismiss="modal">@lang('trans.close')
                            </button>
                            <button type="submit"
                                    class="btn btn-sm defaultBtn float-right">@lang('trans.update')</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="modal fade" id="makeHODModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.make_head_of_the_department')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form role="form" id="makeHODForm" action="{{route('department.head.update')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="employee_id" value="" id="make_head_employee_id">
                                <div class="col-sm-12">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select class="form-control" name="department_id[]" id="make_head_department_id"
                                                multiple="multiple">
                                            <option value="">Choose Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}"
                                                        @if(old('department_id')==$department->id) selected @endif>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <span
                                            class="text-danger float-right">{{$errors->first('department_id') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--/.modal-body-->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default float-right"
                                    data-dismiss="modal">@lang('trans.close')
                            </button>
                            <button type="submit"
                                    class="btn btn-sm defaultBtn float-right">@lang('trans.update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection


@push('js')

    <script>
        $(document).ready(function () {

            let date_format = @json(settings('date_format'));

            $("#employeeDataTable").DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [6, 7]}
                ],
                "pageLength": {{settings('per_page')}}
            });


            $('#employeeRegisterForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 30,
                    },
                    last_name: {
                        maxlength: 30,
                    },
                    personal_email: {
                        required: true,
                        emailCheck: true,
                        maxlength: 50,
                    },
                    office_email: {
                        emailCheck: true,
                        maxlength: 50,
                    },
                    phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    office_phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    present_address: {
                        required: true,
                    },
                    permanent_address: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    blood_group_id: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    designation_id: {
                        required: true,
                    },
                    emergency_contact_person: {
                        required: true,
                        maxlength: 30,
                    },
                    emergency_contact_phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    emergency_contact_address: {
                        required: true,
                    },
                    emergency_contact_relation: {
                        required: true,
                        maxlength: 30,
                    },
                    nid_number: {
                        required: true,
                        minlength: 6,
                        maxlength: 12,
                    },
                    salary: {
                        required: true,
                    },
                    join_date: {
                        required: true,
                    },
                    profile_image: {
                        required: true,
                        accept: "image/jpeg,image/png,image/jpg",
                    },
                    certificate_image: {
                        required: true,
                        accept: "image/jpeg,image/png,image/jpg",
                    },
                    nid_image: {
                        required: true,
                        accept: "image/jpeg,image/png,image/jpg",
                    },

                },
                messages: {
                    first_name: {
                        required: 'First name is required',
                    },
                    personal_email: {
                        required: 'Personal email is required',
                        emailCheck: 'Please enter valid email',
                    },
                    office_email: {
                        emailCheck: 'Please enter valid email',
                    },
                    phone: {
                        required: 'Phone is required',
                        number: 'Phone must be number',
                        minlength: 'Phone must be more than 6 characters',
                        maxlength: 'Phone must be under 15 characters',
                    },
                    office_phone: {
                        required: 'Office phone is required',
                        number: 'Office phone must be number',
                        minlength: 'Office phone must be more than 6 characters',
                        maxlength: 'Office phone must be under 15 characters',
                    },
                    present_address: {
                        required: 'Present address is required',
                    },
                    permanent_address: {
                        required: 'Permanent address is required',
                    },
                    dob: {
                        required: 'Date of birth is required',
                    },
                    gender: {
                        required: 'Gender field is required',
                    },
                    blood_group_id: {
                        required: 'Blood group field is required',
                    },
                    department_id: {
                        required: 'Department field is required',
                    },
                    designation_id: {
                        required: 'Designation field is required',
                    },
                    emergency_contact_person: {
                        required: 'Emergency contact person is required',
                        maxlength: 'Contact person must be under 30 characters',
                    },
                    emergency_contact_phone: {
                        required: 'Emergency contact phone is required',
                        number: 'Emergency contact phone must be number',
                        minlength: 'Contact phone must be more than 6 characters',
                        maxlength: 'Contact phone must be under 15 characters',
                    },
                    emergency_contact_address: {
                        required: 'Emergency contact address is required',
                    },
                    emergency_contact_relation: {
                        required: 'Emergency contact relation is required',
                    },
                    nid_number: {
                        required: 'NIT number field is required',
                    },
                    salary: {
                        required: 'Salary field is required',
                    },
                    join_date: {
                        required: 'Join date field is required',
                    },
                    profile_image: {
                        required: 'Profile image field is required',
                        accept: "Please select valid image (jpeg,png,jpg)",
                    },
                    certificate_image: {
                        required: 'Certificate image field is required',
                        accept: "Please select valid image (jpeg,png,jpg)",
                    },
                    nid_image: {
                        required: 'NID image field is required',
                        accept: "Please select valid image (jpeg,png,jpg)",
                    },
                },

            });

            $('#employeeEditForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 30,
                    },
                    last_name: {
                        maxlength: 30,
                    },
                    personal_email: {
                        required: true,
                        emailCheck: true,
                        maxlength: 50,
                    },
                    office_email: {
                        emailCheck: true,
                        maxlength: 50,
                    },
                    phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    office_phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    present_address: {
                        required: true,
                    },
                    permanent_address: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    blood_group_id: {
                        required: true,
                    },
                    department_id: {
                        required: true,
                    },
                    designation_id: {
                        required: true,
                    },
                    emergency_contact_person: {
                        required: true,
                        maxlength: 30,
                    },
                    emergency_contact_phone: {
                        required: true,
                        // phoneUS: true,
                    },
                    emergency_contact_address: {
                        required: true,
                    },
                    emergency_contact_relation: {
                        required: true,
                        maxlength: 30,
                    },
                    nid_number: {
                        required: true,
                        minlength: 6,
                        maxlength: 12,
                    },
                    salary: {
                        required: true,
                    },
                    join_date: {
                        required: true,
                    },

                },
                messages: {
                    first_name: {
                        required: 'First name is required',
                        maxlength: 'First name must be under 20 characters',
                    },
                    personal_email: {
                        required: 'Personal email is required',
                        emailCheck: 'Please enter valid email',
                    },
                    office_email: {
                        emailCheck: 'Please enter valid email',
                    },
                    phone: {
                        required: 'Phone is required',
                        number: 'Phone must be number',
                        minlength: 'Phone must be more than 6 characters',
                        maxlength: 'Phone must be under 15 characters',
                    },
                    office_phone: {
                        required: 'Office phone is required',
                        number: 'Office phone must be number',
                        minlength: 'Office phone must be more than 6 characters',
                        maxlength: 'Office phone must be under 15 characters',
                    },
                    present_address: {
                        required: 'Present address is required',
                    },
                    permanent_address: {
                        required: 'Permanent address is required',
                    },
                    dob: {
                        required: 'Date of birth is required',
                    },
                    gender: {
                        required: 'Gender field is required',
                    },
                    blood_group_id: {
                        required: 'Blood group field is required',
                    },
                    department_id: {
                        required: 'Department field is required',
                    },
                    designation_id: {
                        required: 'Designation field is required',
                    },
                    emergency_contact_person: {
                        required: 'Emergency contact person is required',
                        maxlength: 'Contact person must be under 30 characters',
                    },
                    emergency_contact_phone: {
                        required: 'Emergency contact phone is required',
                        number: true,
                        minlength: 'Contact phone must be more than 6 characters',
                        maxlength: 'Contact phone must be under 15 characters',
                    },
                    emergency_contact_address: {
                        required: 'Emergency contact address is required',
                    },
                    emergency_contact_relation: {
                        required: 'Emergency contact relation is required',
                    },
                    nid_number: {
                        required: 'NIT number field is required',
                    },
                    salary: {
                        required: 'Salary field is required',
                    },
                    join_date: {
                        required: 'Join date field is required',
                    }
                },

            });

            $('#show_nid_image').click(function () {
                let path = $(this).attr('src')
                location.href = '/' + path;
            })

            $('#show_certificate_image').click(function () {
                let path = $(this).attr('src')
                location.href = '/' + path;
            })

        });


        let previewProfileImage = function (event) {
            $("#createProfilePictureError").html('');
            let outputAvatar = document.getElementById('preview_profile_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#createProfilePictureError").html("<p>File size is greater than 1MB</p>");
                $('#profile_image').val('')
                $('#create_profile_image_label').html('')
                $('#preview_profile_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#preview_profile_image_output').show()
            }
        };

        let previewNidImageImage = function (event) {
            $("#createNidImageError").html('');
            let outputAvatar = document.getElementById('preview_nid_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#createNidImageError").html("<p>File size is greater than 1MB</p>");
                $('#nid_image').val('')
                $('#create_nid_image_label').html('')
                $('#preview_nid_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#preview_nid_image_output').show()
            }
        };

        let previewCertificateImageImage = function (event) {
            $("#createCertificateImageError").html('');
            let outputAvatar = document.getElementById('preview_certificate_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#createCertificateImageError").html("<p>File size is greater than 1MB</p>");
                $('#certificate_image').val('')
                $('#create_certificate_image_label').html('')
                $('#preview_certificate_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#preview_certificate_image_output').show()
            }
        };

        let editPreviewProfileImage = function (event) {
            $("#editProfilePictureError").html('');
            let outputAvatar = document.getElementById('edit_preview_profile_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#editProfilePictureError").html("<p>File size is greater than 1MB</p>");
                $('#edit_profile_image').val('')
                $('#edit_profile_image_label').html('')
                $('#edit_preview_profile_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#edit_preview_profile_image_output').show()
            }
        };

        let editPreviewNidImageImage = function (event) {
            $("#editNidImageError").html('');
            let outputAvatar = document.getElementById('edit_preview_nid_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#editNidImageError").html("<p>File size is greater than 1MB</p>");
                $('#edit_nid_image').val('')
                $('#edit_nid_image_label').html('')
                $('#edit_preview_nid_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#edit_preview_nid_image_output').show()
            }
        };

        let editPreviewCertificateImageImage = function (event) {
            $("#editCertificateImageError").html('');
            let outputAvatar = document.getElementById('edit_preview_certificate_image_output');
            outputAvatar.src = URL.createObjectURL(event.target.files[0]);
            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {

                $("#editCertificateImageError").html("<p>File size is greater than 1MB</p>");
                $('#edit_certificate_image').val('')
                $('#edit_certificate_image_label').html('')
                $('#edit_preview_certificate_image_output').hide();
            } else {

                outputAvatar.onload = function () {
                    URL.revokeObjectURL(outputAvatar.src)
                }

                $('#edit_preview_certificate_image_output').show()
            }
        };


        function deleteEmployee(employee_id, e) {
            e.preventDefault()
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value == true) {

                    $('#delete_employee_' + employee_id).submit();

                }
            })
        }


        function getEmployeeShowInfo(id) {

            let employees = @json($employees);
            let employee = employees.find(x => x.id === id);
            let default_image = @json(asset('asset/img/employee/default.png'));
            let date_format = @json(settings('date_format'));

            $('#show_profile_image').attr("src", employee.profile_image)
            $('#show_custom_id').html(employee.custom_id)
            $('#show_name').html(employee.name)
            $('#show_personal_email').html(employee.personal_email)
            $('#show_office_email').html(employee.office_email)
            $('#show_phone').html(employee.phone)
            $('#show_office_phone').html(employee.office_phone)
            $('#show_gender').html(employee.gender)
            $('#show_present_address').html(employee.present_address)
            $('#show_permanent_address').html(employee.permanent_address)
            $('#show_dob').html(moment(employee.dob).format(date_format))
            $('#show_emergency_contact_person').html(employee.emergency_contact_person)
            $('#show_emergency_contact_phone').html(employee.emergency_contact_phone)
            $('#show_emergency_contact_address').html(employee.emergency_contact_address)
            $('#show_emergency_contact_relation').html(employee.emergency_contact_relation)
            $('#show_blood_group_id').html(employee.blood_group.name)
            $('#show_department_id').html(employee.department.name)
            $('#show_designation_id').html(employee.designation.name)
            $('#show_nid_number').html(employee.nid_number)
            $('#show_salary').html(employee.salary)
            $('#show_join_date').html(moment(employee.join_date).format(date_format))
            $('#show_quit_date').html(employee.quit_date ? moment(employee.quit_date).format(date_format) : "--")
            $('#show_nid_image').attr("src", employee.nid_image)
            $('#show_certificate_image').attr("src", employee.certificate_image)

            // $('#show_nid_image').attr("src", employee.nid_image)

            $('#show_is_current_employee').html("");
            if (employee.is_current_employee == 1) {
                $('#show_is_current_employee').append("<span class='badge badge-success'>True</span>");
            } else {
                $('#show_is_current_employee').append("<span class='badge badge-danger'>False</span>");
            }

            $('#show_is_provision_period').html("");
            if (employee.is_provision_period == 1) {
                $('#show_is_provision_period').append("<span class='badge badge-success'>True</span>");
            } else {
                $('#show_is_provision_period').append("<span class='badge badge-danger'>False</span>");
            }


            $('#employeeShowModal').modal('show')
        }

        function employeeStatusChange(employee_id) {
            let employees = @json($employees);
            let employee = employees.find(x => x.id === employee_id);
            if (employee.is_current_employee == 1) {
                var action = "deactivate"
            } else {
                var action = "activate"
            }
            Swal.fire({
                title: 'Are you sure to ' + action + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ' + action
            }).then((result) => {
                if (result.value) {
                    window.location.href = $('#employee_status_' + employee_id).data('href');
                }
            })
        }

        function getEmployeeEditInfo(id) {

            let date_format = @json(settings('date_format'));
            let employees = @json($employees);
            let employee = employees.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#employeeEditForm').attr('action', appUrl + '/employees/' + employee.id)
            let full_name = employee.name.split(" ")
            let first_name = full_name[0]
            let last_name = ''

            if (full_name.length > 1) {
                last_name = full_name[1]
            }

            $('#edit_first_name').val(first_name)
            $('#edit_last_name').val(last_name)
            $('#edit_personal_email').val(employee.personal_email)
            $('#edit_office_email').val(employee.office_email)
            $('#edit_phone').val(employee.phone)
            $('#edit_office_phone').val(employee.office_phone)
            $('#edit_present_address').val(employee.present_address)
            $('#edit_permanent_address').val(employee.permanent_address)
            $('#edit_dob').val(moment(employee.dob).format(date_format))
            $('#edit_emergency_contact_person').val(employee.emergency_contact_person)
            $('#edit_emergency_contact_phone').val(employee.emergency_contact_phone)
            $('#edit_emergency_contact_relation').val(employee.emergency_contact_relation)
            $('#edit_emergency_contact_address').val(employee.emergency_contact_address)
            $('#edit_nid_number').val(employee.nid_number)
            $('#edit_salary').val(employee.salary)
            $('#edit_join_date').val(moment(employee.join_date).format(date_format))
            $('#edit_quit_date').val( employee.quit_date ? moment(employee.quit_date).format(date_format) : '')
            $('#edit_preview_profile_image_output').attr("src", employee.profile_image)
            $('#edit_preview_nid_image_output').attr("src", employee.nid_image)
            $('#edit_preview_certificate_image_output').attr("src", employee.certificate_image)
            $('#edit_blood_group_id option[value="' + employee.blood_group_id + '"]').prop("selected", true)
            $('#edit_department_id option[value="' + employee.department_id + '"]').prop("selected", true)
            $('#edit_designation_id option[value="' + employee.designation_id + '"]').prop("selected", true)

            if (employee.gender == "Male") {
                $("#edit_gender_male").prop("checked", true);
            } else if (employee.gender == "Female") {
                $("#edit_gender_female").prop("checked", true);
            }

            if (employee.is_current_employee == 1) {
                $("#edit_is_current_employee").prop("checked", true);
            }

            if (employee.is_provision_period == 1) {
                $("#edit_is_provision_period").prop("checked", true);
            }

            $('#employeeEditModal').modal('show')

        }

        function makeHOD(id) {

            let employees = @json($employees);
            let employee = employees.find(x => x.id === id);
            // console.log(employee)

            /* Clear Select 2 selection */
            $('#make_head_department_id').val([])

            /*Select multiply department if any employee is head of more than one department*/
            if (employee.department_head[0]) {
                let department = []
                employee.department_head.forEach(function (i) {
                    department.push(i.id)
                })
                $('#make_head_department_id').val(department)
            }

            /* Attach Employee id with form as hidden input*/
            $('#make_head_employee_id').val(id)

            /* Declare select input as select 2 */
            $('#make_head_department_id').select2({
                placeholder: 'Choose Department',
                // allowClear: true
            })


            /*Show modal */
            $('#makeHODModal').modal('show')

        }


        //email validation check
        $.validator.addMethod("emailCheck",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
        );
        jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
        }, "Please specify a US format phone number");



    </script>
@endpush
