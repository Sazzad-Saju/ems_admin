@extends('layouts.app')

@section('title') @lang('trans.settings') @endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.settings')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">@lang('trans.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('trans.settings')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <ul class="nav nav-pills" id="settingTabs">
                                <li class="nav-item"><a class="nav-link active" href="#generalSetting"
                                                        data-toggle="tab">@lang('trans.general')</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#leaveSetting"
                                                        data-toggle="tab">@lang('trans.leave')</a>
                                </li>
{{--                                <li class="nav-item"><a class="nav-link" href="#socialSetting"--}}
{{--                                                        data-toggle="tab">@lang('trans.social')</a>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="generalSetting">
                                    <form action="{{route('settings.update')}}" method="POST"
                                          id="generalSettingForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="app_name">App Name</label>
                                                    <input type="text" name="app_name"
                                                           class="form-control @error('app_name') is-invalid @enderror"
                                                           value="{{$settings['app_name']}}" id="app_name"
                                                           placeholder="Enter app name">
                                                    @error('app_name') <span
                                                        class="text-danger">{{$errors->first('app_name')}}</span> @enderror

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="app_url">App Url</label>
                                                    <input type="text" name="app_url"
                                                           class="form-control  @error('app_url') is-invalid @enderror"
                                                           id="app_url"
                                                           value="{{$settings['app_url']}}"
                                                           placeholder="App url/website">
                                                    @error('app_url') <span
                                                        class="text-danger">{{$errors->first('app_url')}}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="app_email">App Email</label>
                                                    <input type="text" name="app_email"
                                                           class="form-control"
                                                           value="{{$settings['app_email']}}" id="app_email"
                                                           placeholder="App email address">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="app_phone">App Phone</label>
                                                    <input type="text" name="app_phone"
                                                           class="form-control"
                                                           id="app_phone"
                                                           value="{{$settings['app_phone']}}"
                                                           placeholder="App phone number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="office_start_hour">Office Start Hour</label>
                                                    <input type="text" name="office_start_hour"
                                                           class="form-control singleTimePicker"
                                                           id="office_start_hour"
                                                           value="{{$settings['office_start_hour']}}"
                                                           placeholder="Office Start Hour">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="office_end_hour">Office End Hour</label>
                                                    <input type="text" name="office_end_hour"
                                                           class="form-control singleTimePicker"
                                                           id="office_end_hour"
                                                           value="{{$settings['office_end_hour']}}"
                                                           placeholder="Office Start Hour">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="flexible_time">Flexible time (Minute)</label>
                                                    <input type="number" name="flexible_time"
                                                           class="form-control"
                                                           id="flexible_time"
                                                           value="{{$settings['flexible_time']}}"
                                                           placeholder="Office Flexible time">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="timezone">Timezone</label>
                                                    <select class="form-control" name="timezone" id="timezone">
                                                        @foreach($timezones as $timezone)
                                                            <option
                                                                {{$settings['timezone'] == $timezone ? 'selected' : ''}} value="{{$timezone}}">{{$timezone}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="date_format">Date Format</label>
                                                    <select class="form-control" name="date_format" id="date_format">
                                                        <option
                                                            {{$settings['date_format'] == 'DD-MM-YYYY' ? 'selected' : ''}} value="DD-MM-YYYY">
                                                            DD-MM-YYYY
                                                        </option>
                                                        <option
                                                            {{$settings['date_format'] == 'MM-DD-YYYY' ? 'selected' : ''}} value="MM-DD-YYYY">
                                                            MM-DD-YYYY
                                                        </option>
                                                        <option
                                                            {{$settings['date_format'] == 'DD-MMM-YYYY' ? 'selected' : ''}} value="DD-MMM-YYYY">
                                                            DD-MMM-YYYY
                                                        </option>
                                                        <option
                                                            {{$settings['date_format'] == 'MMM-DD-YYYY' ? 'selected' : ''}} value="MMM-DD-YYYY">
                                                            MMM-DD-YYYY
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="time_format">Time Format</label>
                                                    <select class="form-control" name="time_format"
                                                            id="time_format">
                                                        <option
                                                            {{$settings['time_format'] == 'H:mm' ? 'selected' : ''}} value="H:mm">
                                                            H:mm
                                                        </option>
                                                        <option
                                                            {{$settings['time_format'] == 'h:mm a' ? 'selected' : ''}} value="h:mm a">
                                                            h:mm a
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="per_page">Datatable Per Page</label>
                                                    <select class="form-control" name="per_page" id="per_page">
                                                        <option
                                                            {{$settings['per_page'] == 10 ? 'selected' : ''}} value="10">
                                                            10
                                                            per page
                                                        </option>
                                                        <option
                                                            {{$settings['per_page'] == 25 ? 'selected' : ''}} value="25">
                                                            25
                                                            per page
                                                        </option>
                                                        <option
                                                            {{$settings['per_page'] == 50 ? 'selected' : ''}} value="50">
                                                            50
                                                            per page
                                                        </option>
                                                        <option
                                                            {{$settings['per_page'] == 100 ? 'selected' : ''}} value="100">
                                                            100 per page
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="toast_position">Toast Position</label>
                                                    <select class="form-control" name="toast_position"
                                                            id="toast_position">
                                                        <option
                                                            {{$settings['toast_position'] == 'top-start' ? 'selected' : ''}} value="top-start">
                                                            Top Start
                                                        </option>
                                                        <option
                                                            {{$settings['toast_position'] == 'top-end' ? 'selected' : ''}} value="top-end">
                                                            Top End
                                                        </option>
                                                        <option
                                                            {{$settings['toast_position'] == 'bottom-start' ? 'selected' : ''}} value="bottom-start">
                                                            Bottom Start
                                                        </option>
                                                        <option
                                                            {{$settings['toast_position'] == 'bottom-end' ? 'selected' : ''}} value="bottom-end">
                                                            Bottom End
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                             {{--           <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="open_account_title">Open Account Title</label>
                                                    <input type="text" name="open_account_title"
                                                           class="form-control"
                                                           value="{{$settings['open_account_title']}}" id="open_account_title"
                                                           placeholder="Open account title">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="open_account_url">Open Account Url</label>
                                                    <input type="text" name="open_account_url"
                                                           class="form-control"
                                                           value="{{$settings['open_account_url']}}" id="open_account_url"
                                                           placeholder="Open account url">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="demo_account_title">Demo Account Title</label>
                                                    <input type="text" name="demo_account_title"
                                                           class="form-control"
                                                           value="{{$settings['demo_account_title']}}" id="demo_account_title"
                                                           placeholder="Demo account title">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="demo_account_url">Demo Account Url</label>
                                                    <input type="text" name="demo_account_url"
                                                           class="form-control"
                                                           value="{{$settings['demo_account_url']}}" id="demo_account_url"
                                                           placeholder="Demo account url">
                                                </div>
                                            </div>
                                        </div>--}}
                                        <button type="submit" class="btn vBtn btn-primary float-right">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="leaveSetting">
                                    <form action="{{route('settings.update')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="casual_leave">Casual leave (Days)</label>
                                                    <input type="number" name="casual_leave"
                                                           class="form-control @error('casual_leave') is-invalid @enderror"
                                                           value="{{$settings['casual_leave']}}" id="casual_leave"
                                                           placeholder="Enter Casual Leave">
                                                    @error('casual_leave') <span
                                                        class="text-danger">{{$errors->first('casual_leave')}}</span> @enderror

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="sick_leave">Sick leave (Days)</label>
                                                    <input type="number" name="sick_leave"
                                                           class="form-control @error('sick_leave') is-invalid @enderror"
                                                           value="{{$settings['sick_leave']}}" id="sick_leave"
                                                           placeholder="Enter Sick Leave">
                                                    @error('sick_leave') <span
                                                        class="text-danger">{{$errors->first('sick_leave')}}</span> @enderror

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="earned_leave">Earned leave (Days)</label>
                                                    <input type="number" name="earned_leave"
                                                           class="form-control @error('earned_leave') is-invalid @enderror"
                                                           value="{{$settings['earned_leave']}}" id="earned_leave"
                                                           placeholder="Enter Earned Leave">
                                                    @error('earned_leave') <span
                                                        class="text-danger">{{$errors->first('earned_leave')}}</span> @enderror

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="unpaid_leave">Unpaid leave (Days)</label>
                                                    <input type="number" name="unpaid_leave"
                                                           class="form-control @error('unpaid_leave') is-invalid @enderror"
                                                           value="{{$settings['unpaid_leave']}}" id="unpaid_leave"
                                                           placeholder="Enter Unpaid Leave">
                                                    @error('unpaid_leave') <span
                                                        class="text-danger">{{$errors->first('unpaid_leave')}}</span> @enderror

                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm float-right">Save
                                        </button>
                                    </form>
                                </div>
                               {{-- <div class="tab-pane" id="socialSetting">
                                    <form action="{{route('settings.update')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="facebook">Facebook</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="facebook"><i class="fab fa-facebook"></i></span>
                                                        </div>
                                                        <input type="text" name="facebook" value="{{$settings['facebook']}}" class="form-control" placeholder="Facebook link" aria-label="Facebook link" aria-describedby="facebook">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="twitter">Twitter</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="twitter"><i class="fab fa-twitter"></i></span>
                                                        </div>
                                                        <input type="text" name="twitter" value="{{$settings['twitter']}}" class="form-control" placeholder="Twitter link" aria-label="Twitter link" aria-describedby="twitter">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="linkedin">Linkedin</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="linkedin"><i class="fab fa-linkedin"></i></span>
                                                        </div>
                                                        <input type="text" name="linkedin" value="{{$settings['linkedin']}}" class="form-control" placeholder="Linkedin link" aria-label="Linkedin link" aria-describedby="linkedin">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="youtube">Youtube</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="youtube"><i class="fab fa-youtube"></i></span>
                                                        </div>
                                                        <input type="text" name="youtube" value="{{$settings['youtube']}}" class="form-control" placeholder="Youtube link" aria-label="Youtube link" aria-describedby="youtube">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="instagram">Instagram</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="instagram"><i class="fab fa-instagram"></i></span>
                                                        </div>
                                                        <input type="text" name="instagram" value="{{$settings['instagram']}}" class="form-control" placeholder="Instagram link" aria-label="Instagram link" aria-describedby="instagram">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="dribbble">Dribbble</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary" id="dribbble"><i class="fab fa-dribbble"></i></span>
                                                        </div>
                                                        <input type="text" name="dribbble" value="{{$settings['dribbble']}}" class="form-control" placeholder="Dribbble link" aria-label="Dribbble link" aria-describedby="dribbble">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm float-right">Save
                                        </button>
                                    </form>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- bootstrap color picker -->
    <script src="{{asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            //Jquery Validation
            $('#generalSettingForm').validate({
                rules: {
                    app_name: {
                        required: true,
                    },
                    app_url: {
                        required: true,
                    },
                },
                messages: {
                    app_name: {
                        required: "The app name field is required.",
                    },
                    app_url: {
                        required: "The admin url field is required.",
                    },
                }
            });
/*
            //color picker with addon
            $('.primary-colorpicker').colorpicker()
            $('.secondary-colorpicker').colorpicker()
            $('.success-colorpicker').colorpicker()
            $('.info-colorpicker').colorpicker()
            $('.warning-colorpicker').colorpicker()
            $('.danger-colorpicker').colorpicker()
            $('.light-colorpicker').colorpicker()
            $('.dark-colorpicker').colorpicker()

            $('.primary-colorpicker').on('colorpickerChange', function(event) {
                $('.primary-colorpicker .fa-square').css('color', event.color.toString());
            });

            $('.secondary-colorpicker').on('colorpickerChange', function(event) {
                $('.secondary-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.success-colorpicker').on('colorpickerChange', function(event) {
                $('.success-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.info-colorpicker').on('colorpickerChange', function(event) {
                $('.info-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.warning-colorpicker').on('colorpickerChange', function(event) {
                $('.warning-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.danger-colorpicker').on('colorpickerChange', function(event) {
                $('.danger-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.light-colorpicker').on('colorpickerChange', function(event) {
                $('.light-colorpicker .fa-square').css('color', event.color.toString());
            });
            $('.dark-colorpicker').on('colorpickerChange', function(event) {
                $('.dark-colorpicker .fa-square').css('color', event.color.toString());
            });*/
            let time_format = @json(settings('time_format'));
            let office_start_hour = @json(settings('office_start_hour'));
            office_start_hour = moment(office_start_hour,'H:mm').format(time_format)

            let office_end_hour = @json(settings('office_end_hour'));
            office_end_hour = moment(office_end_hour,'H:mm').format(time_format)

            $('#office_start_hour').val(office_start_hour)
            $('#office_end_hour').val(office_end_hour)




            //active tab on refresh
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#settingTabs a[href="' + activeTab + '"]').tab('show');
            }


        });


    </script>
@endpush
