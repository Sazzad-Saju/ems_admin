@extends('layouts.app')
@section('title',trans('trans.profile'))
@push('push-style')
    <style>
        .profile-avatar-replace {
            position: absolute;
            left: 0;
            top: 32px;
            cursor: pointer;
        }

        .profile-avatar-replace-style {
            height: 50px;
            width: 50px;
        }

        /*.select2-container .select2-selection--single {*/
        /*    height: calc(2.25rem + 2px);*/
        /*}*/
    </style>
@endpush

@section('content')
    <!-- Breadcrumb -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('trans.profile')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.profile')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card vCard card-outline shadow">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle profile-avatar-style"
                                     src="{{asset($user->avatar)}}"

                                     alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center text-capitalize">
                                {{$user->name}}
                            </h3>
                            <p class="text-muted text-center mb-0 pb-0">
                                <b>Member Since:</b>
                                {{showDiffForHuman($user->created_at)}}
{{--                                {{$user->created_at}}--}}
                            </p>
                            {{--                            <p class="text-muted text-center">`--}}
                            {{--                                <b>Membership Validity:</b>--}}
                            {{--                                {{showDiffForHuman($user->membership->ended_at)}}--}}
                            {{--                            </p>--}}
                        </div>
                    </div>
                    <div class="card vCard card-outline shadow ">
                        <div class="card-header">
                            <h3 class="card-title">@lang('trans.about_me')</h3>
                        </div>
                        <div class="card-body">
                            {{--                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>--}}

                            {{--                            <p class="text-muted">--}}
                            {{--                                {{isset($user->address1) ? $user->address1 .' ,' : "" }}--}}
                            {{--                                {{isset($user->city_id) ? $user->city->name .' ,' : "" }}--}}
                            {{--                                {{isset($user->state_id) ? $user->state->name.' ,' : "" }}--}}
                            {{--                                {{isset($user->country_id) ? $user->country->name : "" }}--}}
                            {{--                            </p>--}}
                            {{--                            <hr>--}}
                            <strong>
                                <i class="far fa-envelope mr-1"></i>Email
                            </strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">{{$user->email}}</span>
                            </p>
                            <hr>
                            <strong>
                                <i class="fas fa-mobile-alt"></i> Phone
                            </strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">{{$user->phone}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card vCard card-outline shadow">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#activity"
                                       data-toggle="tab">@lang('trans.profile')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings" data-toggle="tab">@lang('trans.settings')</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">
                                                    First Name
                                                </span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <span>{{ucfirst($user->first_name) ?? ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span
                                                    class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">Last Name</span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <span>{{ucfirst($user->last_name) ?? ''}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">Email</span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <span>{{$user->email ?? ''}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">Phone</span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <span>{{$user->phone ?? ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">Avatar</span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <img src="{{asset($user->avatar)}}"
                                                         class="rounded-circle img-fluid profile-avatar-replace-style ml-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <span class="col-lg-3 col-md-6 col-sm-2 font-weight-bold">Gender</span>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <span>{{$user->gender ?? ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="settings">
                                    <!-- form start -->
                                    <form id="profileUpdateForm"
                                          action="{{route('profile.update',['profile'=>$user->id])}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="first_name"
                                                           class="col-lg-12 col-md-6 col-sm-2 col-form-label">
                                                        First Name
                                                    </label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10">
                                                        <input type="text" name="first_name"
                                                               class="form-control @error('first_name') is-invalid @enderror"
                                                               id="first_name" value="{{$user->first_name}}"
                                                               placeholder="Enter first name">
                                                        <span class="text-danger">
                                                        {{$errors->has('first_name') ? $errors->first('first_name') : ''}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="last_name"
                                                           class="col-lg-12 col-md-6 col-sm-2 col-form-label">Last
                                                        Name</label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10">
                                                        <input type="text" name="last_name"
                                                               class="form-control @error('last_name') is-invalid @enderror"
                                                               id="last_name" value="{{$user->last_name}}"
                                                               placeholder="Enter last name">
                                                        <span class="text-danger">
                                                        {{$errors->has('last_name') ? $errors->first('last_name') : ''}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="email"
                                                           class="col-lg-12 col-md-6 col-sm-2 col-form-label">Email</label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10">
                                                        <input type="email" name="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               id="email" value="{{$user->email}}"
                                                               placeholder="Enter Email" disabled>
                                                        <span class="text-danger">
                                                        {{$errors->has('email') ? $errors->first('email') : ''}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="gender"
                                                           class="col-lg-12 col-md-6 col-sm-2 col-form-label">Gender</label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10 pt-2">
                                                        <div class="row">
                                                            <div class="form-check mr-2 ml-2">
                                                                <input class="form-check-input" value="Male"
                                                                       type="radio"
                                                                       name="gender" id="Male"
                                                                    {{$user->gender == "Male" ? 'checked': ''}}>
                                                                <label class="form-check-label" for="Male">Male</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" value="Female"
                                                                       type="radio"
                                                                       name="gender" id="Female"
                                                                    {{$user->gender == "Female" ? 'checked': ''}}>
                                                                <label class="form-check-label"
                                                                       for="Female">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="phone"
                                                           class="col-lg-12 col-md-6 col-sm-2 col-form-label">Phone
                                                    </label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10">
                                                        <input type="text" name="phone"
                                                               class="form-control @error('phone') is-invalid @enderror"
                                                               id="phone" value="{{$user->phone}}"
                                                               placeholder="Enter Phone Number">
                                                        <span class="text-danger">
                                                        {{$errors->has('phone') ? $errors->first('phone') : ''}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row no-gutters">
                                                    <label for="address1"
                                                           class="col-lg-3 col-md-6 col-sm-2 col-form-label">Avatar</label>
                                                    <div class="col-lg-9 col-md-6 col-sm-10">
                                                        <img src="{{asset($user->avatar)}}"
                                                             class="rounded-circle img-fluid profile-avatar-replace-style"
                                                             id="previewImage">
                                                        <input type="file"
                                                               class="form-control hide avatar d-none"
                                                               name="avatar" id="file" accept="image/png,image/jpeg"
                                                               onchange="changeProfileImage(event)">

                                                        <span class="badge badge-info profile-avatar-replace"
                                                              onclick="document.getElementById('file').click();">
                                                            Replace
                                                        </span>
                                                        <small class="text-danger d-block error-right-msg"
                                                               id="avatarError">
                                                            {{$errors->has('avatar') ? $errors->first('avatar') : ''}}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn defaultBtn float-right">Update</button>
                                    </form>


                                    <hr class="mt-5 border border-dark">


                                    <h3 class="mb-3"><b>Change Password</b></h3>

                                    <form id="passwordChangeForm"
                                          action="{{route('update.password',['user'=>$user->id])}}" method="POST">
                                        @csrf
                                        <div class="container mt-3">
                                            <div class="form-group row">
                                                <label for="current_password"
                                                       class="col-lg-3 col-md-6 col-sm-2 col-form-label">
                                                    Current Password
                                                </label>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <input type="password" name="current_password"
                                                           class="form-control @error('current_password') is-invalid @enderror"
                                                           placeholder="Current Password"
                                                           id="current_password">
                                                    <span class="text-danger">
                                                    {{$errors->has('current_password') ? $errors->first('current_password') : ''}}
                                                </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="new_password"
                                                       class="col-lg-3 col-md-6 col-sm-2 col-form-label">
                                                    New Password
                                                </label>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <input type="password" name="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           placeholder="New Password"
                                                           id="password">
                                                    <span class="text-danger">
                                                    {{$errors->has('password') ? $errors->first('password') : ''}}
                                                </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="confirmPassword"
                                                       class="col-lg-3 col-md-6 col-sm-2 col-form-label">
                                                    Confirm Password
                                                </label>
                                                <div class="col-lg-9 col-md-6 col-sm-10">
                                                    <input type="password" name="password_confirmation"
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           placeholder="Confirm Password"
                                                           id="confirmPassword">
                                                    <span class="text-danger">
                                                    {{$errors->has('password_confirmation') ? $errors->first('password_confirmation') : ''}}
                                                </span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn defaultBtn text-white float-right">
                                                @lang('trans.save_changes')
                                            </button>
                                            {{--                                        {{Form::close()}}--}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>

        $(document).ready(function () {

            //active tab on refresh
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#myTabs a[href="' + activeTab + '"]').tab('show');
            }


            //image size validation
            $("#file").change(function () {
                $("#avatarError").html("");
                var file_size = $('#file')[0].files[0].size;

                if (file_size > 1024000) {
                    $("#avatarError").html("<p>File size is greater than 1MB</p>");
                    return false;
                }
                return true;
            });

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


            //profile update form frontend validation
            $('#profileUpdateForm').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        emailCheck: true,
                    },
                    gender: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        phoneUS: true
                    },
                    avatar: {
                        accept: "image/jpeg,image/png",
                    },
                },
                messages: {
                    first_name: {
                        required: 'First Name is required',
                    },
                    email: {
                        required: 'Email is required',
                        emailCheck: 'Please enter a valid email',
                    },
                    gender: {
                        required: 'Gender is required',
                    },
                    phone: {
                        required: 'Phone is required',
                    },
                    avatar: {
                        accept: "Please upload an valid image(jpeg,jpg,png)",
                    },
                }
            });


            /* password update validation*/
            $("#passwordChangeForm").validate({
                rules: {
                    current_password: "required",
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        equalTo: "#password",
                        minlength: 8
                    }
                },
                message: {
                    current_password: {
                        required: "Enter the current password"
                    },
                    password: {
                        required: "Enter the password",
                    },
                }
            });
        })

        let changeProfileImage = function (event) {

            let output = document.getElementById('previewImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            }

            $("#avatarError").html('');

            var file_size = event.target.files[0].size;
            if (file_size > 1024000) {
                $("#avatarError").html("<p>File size is greater than 1MB</p>");
                $('#file').val('')
                $('#previewImage').attr('src', '');
            }

        };

    </script>
@endpush
