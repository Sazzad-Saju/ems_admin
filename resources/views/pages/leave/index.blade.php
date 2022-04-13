@extends('layouts.app')
@section('title', trans('trans.leave'))
@push('css')
    <style>
        .headerBtn li a {
            font-size: 20px !important;
            border-radius: 0 !important;
            margin-left: 10px !important;
        }

        .headerBtn li a.active {
            background-color: #106894 !important;
        }

        .headerBtn li a:hover {
            color: #0e95de !important;
        }
    </style>
@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.leave')
                        <ul class="nav nav-pills d-inline-block headerBtn">
                            <li class="nav-item d-inline-block">
                                <a class="nav-link active" href="javascript:void(0)"><i
                                            class="fas fa-list-ul mr-2"></i> @lang('trans.list_view')</a>
                            </li>
                            <li class="nav-item d-inline-block">
                                <a class="nav-link" href="{{route('view.calendar')}}"><i
                                            class="far fa-calendar-alt mr-2"></i> @lang('trans.calendar_view')</a>
                            </li>
                        </ul>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.leave')</li>
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
                        <h3 class="card-title">@lang('trans.leave')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#leaveRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="leaveDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Profile Picture</th>
                                <th>Employee name</th>
                                <th>Employee Id</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leaves as $leave)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>
                                        @if($leave->employee->profile_image)
                                            <img src="{{asset($leave->employee->profile_image)}}" class="circle-avatar"
                                                 alt="leave-avatar">
                                        @else

                                            <img src="{{asset('asset/img/leave/default.png')}}" class="circle-avatar"
                                                 alt="leave-default-avatar">
                                        @endif
                                    </td>
                                    <td>{{$leave->employee->name}}</td>
                                    <td>{{$leave->employee->custom_id}}</td>
                                    <td>{{showDate($leave->start_date)}}</td>
                                    <td>{{showDate($leave->end_date)}}</td>
                                    <td>{{humanReadableDayFromMins($leave->duration)}}</td>
                                    <td class="vBadge">
                                        @if ($leave->status == 'Pending')
                                            <span class='badge badge-warning'>Pending</span>
                                        @elseif($leave->status == 'Approved')
                                            <span class='badge badge-success'>Approved</span>
                                        @elseif($leave->status == 'Rejected')
                                            <span class='badge badge-danger'>Reject</span>
                                        @endif
                                    </td>
                                    <td>

                                        <button onclick="getLeaveShowInfo({{$leave->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getLeaveEditInfo({{$leave->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit leave"><i class="fa fa-edit"></i>
                                        </button>


                                        <form action="{{route('leaves.destroy', $leave->id)}}"
                                              method="post" id="delete_leave_{{$leave->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteLeave({{json_encode($leave->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete leave"><i class="fa fa-trash"></i>
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
        <div class="modal fade" id="leaveShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.leave_information')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>Employee Name:</th>
                                <td id="show_employee_name"></td>
                            </tr>

                            <tr>
                                <th>Employee ID:</th>
                                <td id="show_employee_id"></td>
                            </tr>

                            <tr>
                                <th>Leave type:</th>
                                <td id="show_leave_type_id"></td>
                            </tr>
                            <tr>
                                <th>Total Casual Leave :</th>
                                <td id="show_casual_leave"></td>
                            </tr>
                            <tr>
                                <th>Total Sick Leave :</th>
                                <td id="show_sick_leave"></td>
                            </tr>
                            <tr>
                                <th>Total Earned Leave :</th>
                                <td id="show_earned_leave"></td>
                            </tr>
                            <tr>
                                <th>Total Unpaid Leave :</th>
                                <td id="show_unpaid_leave"></td>
                            </tr>

                            <tr>
                                <th>Reason</th>
                                <td id="show_reason"></td>
                            </tr>

                            <tr>
                                <th>Start date</th>
                                <td id="show_start_date"></td>
                            </tr>

                            <tr>
                                <th>End date</th>
                                <td id="show_end_date"></td>
                            </tr>

                            <tr>
                                <th>Start time</th>
                                <td id="show_start_time"></td>
                            </tr>

                            <tr>
                                <th>End time</th>
                                <td id="show_end_time"></td>
                            </tr>

                            <tr>
                                <th>Duration</th>
                                <td id="show_duration"></td>
                            </tr>

                            <tr>
                                <th>Submission type</th>
                                <td id="show_submission_type"></td>
                            </tr>

                            <tr>
                                <th>Recommend employee:</th>
                                <td id="show_recommend_employee_id"></td>
                            </tr>

                            <tr>
                                <th>Status:</th>
                                <td class="vBadge" id="show_status"></td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer float-right w-100">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('trans.close')</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leaveRegisterModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_leave')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="leaveRegisterForm" action="{{route('leaves.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <!-- Total Leave -->
                            <div class="card direct-chat direct-chat-primary" id="showAddTotalLeaveTable"
                                 style="display: none">
                                <div class="card-header">
                                    <h3 class="card-title">Total leaves</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" id="createTotalLeaveCollapse"
                                                data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">Casual</th>
                                            <th scope="col">Sick</th>
                                            <th scope="col">Earned</th>
                                            <th scope="col">Unpaid</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td id="casualLeaveAdd"></td>
                                            <td id="sickLeaveAdd"></td>
                                            <td id="earnedLeaveAdd"></td>
                                            <td id="unpaidLeaveAdd"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Total Leave -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id" class="mandatory">Employee</label>
                                        <select class="form-control" name="employee_id" id="employee_id">
                                            <option value="">Choose Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}"
                                                        @if(old('employee_id')==$employee->id) selected @endif>{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id') <span
                                            class="text-danger float-right">{{$errors->first('employee_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="submission_type" class="mandatory">Submission Type</label>
                                        <select class="form-control" name="submission_type" id="submission_type">
                                            <option value="">Choose Submission Type</option>
                                            <option value="Pre">Pre Submission</option>
                                            <option value="Post">Post Submission</option>
                                        </select>
                                        @error('submission_type') <span
                                            class="text-danger float-right">{{$errors->first('submission_type') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="leave_type_id" class="mandatory">Leave type</label>
                                        <select class="form-control" name="leave_type_id" id="leave_type_id">
                                            <option value="">Choose Leave Type</option>
                                            @foreach($leaveTypes as $leaveType)
                                                <option value="{{$leaveType->id}}"
                                                        @if(old('leave_type_id')==$leaveType->id) selected @endif>{{$leaveType->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('leave_type_id') <span
                                            class="text-danger float-right">{{$errors->first('leave_type_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="reason" class="mandatory">Reason</label>
                                        <textarea class="form-control @error('reason') is-invalid @enderror"
                                                  id="reason" name="reason"
                                                  rows="3">{{old('reason')}}</textarea>
                                        @error('reason') <span
                                            class="text-danger float-right">{{$errors->first('reason') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="leave_time" class="mandatory">Leave time</label>
                                        <input type="text"
                                               class="form-control @error('leave_time') is-invalid @enderror"
                                               placeholder="Enter start date"
                                               name="leave_time" id="leave_time"
                                               value="{{old('leave_time')}}" readonly>
                                        @error('leave_time') <span
                                            class="text-danger float-right">{{$errors->first('leave_time') }}</span> @enderror
                                        <span class="text-danger float-right" id="leaveTimeError"
                                              style="display: none"></span>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="recommend_employee_id" class="mandatory">Recommend Employee</label>
                                        <select class="form-control" name="recommend_employee_id"
                                                id="recommend_employee_id">
                                            <option value="">Choose Recommend Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}"
                                                        @if(old('recommend_employee_id')==$employee->id) selected @endif>{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('recommend_employee_id') <span
                                            class="text-danger float-right">{{$errors->first('recommend_employee_id') }}</span> @enderror
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
                                    class="btn btn-sm defaultBtn float-right"
                                    id="createLeaveBtn">@lang('trans.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leaveEditModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_leave')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="leaveEditForm" action=""
                          method="post" enctype="multipart/form-data">


                        @csrf
                        @method('put')
                        <div class="modal-body">

                            <!-- Total Leave -->
                            <div class="card direct-chat direct-chat-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Total leaves</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" id="totalLeaveTable"
                                                data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">Casual</th>
                                            <th scope="col">Sick</th>
                                            <th scope="col">Earned</th>
                                            <th scope="col">Unpaid</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td id="casualLeave"></td>
                                            <td id="sickLeave"></td>
                                            <td id="earnedLeave"></td>
                                            <td id="unpaidLeave"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Total Leave -->

                            <div class="row">
                                <!-- Hold leave it for edit leave validation -->
                                <input type="hidden" value="" id="edit_leave_id">

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id" class="mandatory">Employee</label>
                                        <select class="form-control" name="employee_id" id="edit_employee_id">
                                            <option value="">Choose Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}"
                                                        @if(old('employee_id')==$employee->id) selected @endif>{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id') <span
                                            class="text-danger float-right">{{$errors->first('employee_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="submission_type" class="mandatory">Submission Type</label>
                                        <select class="form-control" name="submission_type" id="edit_submission_type">
                                            <option value="">Choose Submission Type</option>
                                            <option value="Pre">Pre Submission</option>
                                            <option value="Post">Post Submission</option>
                                        </select>
                                        @error('submission_type') <span
                                            class="text-danger float-right">{{$errors->first('submission_type') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="leave_type_id" class="mandatory">Leave type</label>
                                        <select class="form-control" name="leave_type_id" id="edit_leave_type_id">
                                            <option value="">Choose Leave Type</option>
                                            @foreach($leaveTypes as $leaveType)
                                                <option value="{{$leaveType->id}}"
                                                        @if(old('leave_type_id')==$leaveType->id) selected @endif>{{$leaveType->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('leave_type_id') <span
                                            class="text-danger float-right">{{$errors->first('leave_type_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="reason" class="mandatory">Reason</label>
                                        <textarea class="form-control @error('reason') is-invalid @enderror"
                                                  id="edit_reason" name="reason"
                                                  rows="3">{{old('reason')}}</textarea>
                                        @error('reason') <span
                                            class="text-danger float-right">{{$errors->first('reason') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="leave_time" class="mandatory">Leave time</label>
                                        <input type="text"
                                               class="form-control @error('leave_time') is-invalid @enderror"
                                               placeholder="Enter start date"
                                               name="leave_time" id="edit_leave_time"
                                               value="{{old('leave_time')}}" readonly>
                                        @error('leave_time') <span
                                            class="text-danger float-right">{{$errors->first('leave_time') }}</span> @enderror
                                        <span class="text-danger float-right" id="editLeaveTimeError"
                                              style="display: none"></span>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="recommend_employee_id" class="mandatory">Recommend Employee</label>
                                        <select class="form-control" name="recommend_employee_id"
                                                id="edit_recommend_employee_id">
                                            <option value="">Choose Recommend Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}"
                                                        @if(old('recommend_employee_id')==$employee->id) selected @endif>{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('recommend_employee_id') <span
                                            class="text-danger float-right">{{$errors->first('recommend_employee_id') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="edit_status">
                                            <option value="">Choose Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                        @error('status') <span
                                            class="text-danger float-right">{{$errors->first('status') }}</span> @enderror
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default float-right"
                                    data-dismiss="modal">@lang('trans.close')
                            </button>
                            <button type="submit"
                                    class="btn btn-sm defaultBtn float-right" id="editLeaveBtn">@lang('trans.update')</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>


@endsection


@push('js')

    <script>
        let leaves = @json($leaves);
        let employees = @json($employees)

        $(document).ready(function () {

            $('#totalLeaveTable').click();
            $('#createTotalLeaveCollapse').click();

            $('#leaveDataTable').DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [8]}
                ],
                "pageLength": {{settings('per_page')}}
            });


            let startOfficeHour = @json(settings('office_start_hour'));
            let endOfficeHour = @json(settings('office_end_hour'));
            let date_time_format = @json(settings('date_format'))+' '+@json(settings('time_format'));


            let today = new Date().toJSON().slice(0, 10); /* YYYY-MM-DD */
            let startDay = moment(today + ' ' + startOfficeHour, 'YYYY-MM-DD H:mm').format(date_time_format)
            let endDate = moment(today + ' ' + endOfficeHour, 'YYYY-MM-DD H:mm').format(date_time_format)
            let isTime24hFormat = @json(settings('time_format')) == 'H:mm'

            $('#leave_time').daterangepicker({
                timePicker: true,
                timePicker24Hour: isTime24hFormat,
                startDate: startDay,
                endDate: endDate,
                locale: {
                    format: date_time_format
                }
            });

            /* Start leave time validation for Create */

            $('#leave_time').change(function () {

                let today = new Date().toJSON().slice(0, 10); /* YYYY-MM-DD */

                let startOfficeHour = @json(settings('office_start_hour'));
                let endOfficeHour = @json(settings('office_end_hour'));
                let leaveTime = $('#leave_time').val().split(' - ');
                let leaveStartDayTime = moment(leaveTime[0], date_time_format)
                let leaveEndDayTime = moment(leaveTime[1], date_time_format)

                let leaveStartTime = leaveStartDayTime.format('HH:mm')
                let leaveEndTime = leaveEndDayTime.format('HH:mm')

                let currentDayWithOfficeStartHour = moment(today + ' ' + startOfficeHour, 'YYYY-MM-DD HH:mm')
                let currentDayWithOfficeEndHour = moment(today + ' ' + endOfficeHour, 'YYYY-MM-DD HH:mm')

                let currentDayWithStartLeaveHour = moment(today + ' ' + leaveStartTime)
                let currentDayWithEndLeaveHour = moment(today + ' ' + leaveEndTime)

                $('#leaveTimeError').hide()

                leaveValidation()
                // check leave Start valid hour
                if (currentDayWithStartLeaveHour.diff(currentDayWithOfficeStartHour) < 0 || currentDayWithStartLeaveHour.diff(currentDayWithOfficeEndHour) > 0) {
                    $('#leaveTimeError').html('Please select start time between ' + currentDayWithOfficeStartHour.format(@json(settings('time_format'))) + ' and ' + currentDayWithOfficeEndHour.format(@json(settings('time_format'))))
                    $('#leaveTimeError').show()
                    $('#createLeaveBtn').prop('disabled', true)
                }

                // check leave end valid hour
                if (currentDayWithEndLeaveHour.diff(currentDayWithOfficeEndHour) > 0 || currentDayWithEndLeaveHour.diff(currentDayWithOfficeStartHour) < 0) {
                    //statement for invalid start time
                    $('#leaveTimeError').html('Please select End time between ' + currentDayWithOfficeStartHour.format(@json(settings('time_format'))) + ' and ' + currentDayWithOfficeEndHour.format(@json(settings('time_format'))))
                    $('#leaveTimeError').show()
                    $('#createLeaveBtn').prop('disabled', true)
                }
            })


            $('#employee_id').change(function () {
                let id = $(this).val()

                let employee = employees.find(x => x.id == id);
                let leaveDuration = employee.leave_duration

                $('#casualLeaveAdd').html(leaveDuration.Casual ? leaveDuration.Casual : '--')
                $('#sickLeaveAdd').html(leaveDuration.Sick ? leaveDuration.Sick : '--')
                $('#earnedLeaveAdd').html(leaveDuration.Earned ? leaveDuration.Earned : '--')
                $('#unpaidLeaveAdd').html(leaveDuration.Unpaid ? leaveDuration.Unpaid : '--')

                $('#showAddTotalLeaveTable').show()

                leaveValidation()

            })

            $('#leave_type_id').change(function () {
                leaveValidation()
            })

            function leaveValidation() {
                let employeeId = $('#employee_id').val()
                let leaveTypeId = $('#leave_type_id').val()
                let leaveTime = $('#leave_time').val()
                let date_time_format = @json(settings('date_format'))+' '+@json(settings('time_format'));



                if (employeeId && leaveTypeId && leaveTime) {
                    let employee = employees.find(x => x.id == employeeId);

                    let today = new Date().toJSON().slice(0, 10); /* YYYY-MM-DD */
                    let leaveTime = $('#leave_time').val().split(' - ');
                    let leaveStartDayTime = moment(leaveTime[0], date_time_format)
                    let leaveEndDayTime = moment(leaveTime[1], date_time_format)
                    let leaveStartTime = leaveStartDayTime.format('HH:mm')
                    let leaveEndTime = leaveEndDayTime.format('HH:mm')

                    var duration = ''

                    if (leaveStartDayTime.format('DD-MM-YYYY') == leaveEndDayTime.format('DD-MM-YYYY')) {
                        duration = ((leaveEndDayTime.diff(leaveStartDayTime)) / 60000)
                    } else {

                        /* Firs day leave hour */
                        let currentDayWithOfficeEndHour = moment(today + ' ' + endOfficeHour, 'YYYY-MM-DD HH:mm')
                        let currentDayWithStartLeaveHour = moment(today + ' ' + leaveStartTime)
                        let firstDayLeaveMin = ((currentDayWithOfficeEndHour.diff(currentDayWithStartLeaveHour)) / 60000)

                        /* Last day leave hour*/
                        let currentDayWithEndLeaveHour = moment(today + ' ' + leaveEndTime)
                        let currentDayWithOfficeStartHour = moment(today + ' ' + startOfficeHour, 'YYYY-MM-DD HH:mm')
                        let lastDayLeaveMin = ((currentDayWithEndLeaveHour.diff(currentDayWithOfficeStartHour)) / 60000)

                        let startDate = moment(leaveStartDayTime.format('YYYY-MM-DD'))
                        let endDate = moment(leaveEndDayTime.format('YYYY-MM-DD'))

                        let totalLeaveDayInMin = ((((((endDate.diff(startDate)) / 60000) / 60) / 24) - 1) * 9) * 60 /* convert millisecond to 9hour based day and to  minute */

                        duration = firstDayLeaveMin + lastDayLeaveMin + totalLeaveDayInMin
                    }

                    $('#createLeaveBtn').prop("disabled", false)
                    $('#leaveTimeError').hide()

                    /* Check Casual leave*/
                    if (leaveTypeId == 1) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('casual_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Casual) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Casual)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#leaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#leaveTimeError').show()
                            $('#createLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Sick leave*/
                    if (leaveTypeId == 2) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('sick_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Sick) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Sick)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#leaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#leaveTimeError').show()
                            $('#createLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Earned leave*/
                    if (leaveTypeId == 3) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('earned_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Earned) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Earned)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#leaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#leaveTimeError').show()
                            $('#createLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Unpaid leave*/
                    if (leaveTypeId == 4) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('unpaid_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Unpaid) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Unpaid)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#leaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#leaveTimeError').show()
                            $('#createLeaveBtn').prop("disabled", true)
                        }
                    }

                }
            }

            /* End leave time validation for Create */



            /* Start leave time validation for edit */

            $('#edit_leave_time').change(function () {

                let today = new Date().toJSON().slice(0, 10); /* YYYY-MM-DD */
                let date_time_format = @json(settings('date_format'))+' '+@json(settings('time_format'));

                let startOfficeHour = @json(settings('office_start_hour'));
                let endOfficeHour = @json(settings('office_end_hour'));

                let leaveTime = $('#edit_leave_time').val().split(' - ');
                let leaveStartDayTime = moment(leaveTime[0], date_time_format)
                let leaveEndDayTime = moment(leaveTime[1], date_time_format)

                let leaveStartTime = leaveStartDayTime.format('HH:mm')
                let leaveEndTime = leaveEndDayTime.format('HH:mm')

                let currentDayWithOfficeStartHour = moment(today + ' ' + startOfficeHour, 'YYYY-MM-DD HH:mm')
                let currentDayWithOfficeEndHour = moment(today + ' ' + endOfficeHour, 'YYYY-MM-DD HH:mm')

                let currentDayWithStartLeaveHour = moment(today + ' ' + leaveStartTime)
                let currentDayWithEndLeaveHour = moment(today + ' ' + leaveEndTime)

                $('#editLeaveTimeError').hide()

                editLeaveValidation()
                // check leave Start valid hour
                if (currentDayWithStartLeaveHour.diff(currentDayWithOfficeStartHour) < 0 || currentDayWithStartLeaveHour.diff(currentDayWithOfficeEndHour) > 0) {
                    $('#editLeaveTimeError').html('Please select start time between ' + currentDayWithOfficeStartHour.format(@json(settings('time_format'))) + ' and ' + currentDayWithOfficeEndHour.format(@json(settings('time_format'))))
                    $('#editLeaveTimeError').show()
                    $('#editLeaveBtn').prop('disabled', true)
                }

                // check leave end valid hour
                if (currentDayWithEndLeaveHour.diff(currentDayWithOfficeEndHour) > 0 || currentDayWithEndLeaveHour.diff(currentDayWithOfficeStartHour) < 0) {
                    //statement for invalid start time
                    $('#editLeaveTimeError').html('Please select end time between ' + currentDayWithOfficeStartHour.format(@json(settings('time_format'))) + ' and ' + currentDayWithOfficeEndHour.format(@json(settings('time_format'))))
                    $('#editLeaveTimeError').show()
                    $('#editLeaveBtn').prop('disabled', true)
                }
            })

            $('#edit_employee_id').change(function () {
                editLeaveValidation()
            })

            $('#edit_leave_type_id').change(function () {
                editLeaveValidation()
            })

            function editLeaveValidation() {
                let employeeId = $('#edit_employee_id').val()
                let leaveTypeId = $('#edit_leave_type_id').val()
                let leaveTime = $('#edit_leave_time').val()
                let leaveId = $('#edit_leave_id').val()
                let date_time_format = @json(settings('date_format'))+' '+@json(settings('time_format'));

                if (employeeId && leaveTypeId && leaveTime) {
                    let employee = employees.find(x => x.id == employeeId);
                    let leave = leaves.find(x => x.id == leaveId)
                    let today = new Date().toJSON().slice(0, 10); /* YYYY-MM-DD */
                    let leaveTime = $('#edit_leave_time').val().split(' - ');
                    let leaveStartDayTime = moment(leaveTime[0], date_time_format)
                    let leaveEndDayTime = moment(leaveTime[1], date_time_format)
                    let leaveStartTime = leaveStartDayTime.format('HH:mm')
                    let leaveEndTime = leaveEndDayTime.format('HH:mm')

                    var duration = ''

                    if (leaveStartDayTime.format('DD-MM-YYYY') == leaveEndDayTime.format('DD-MM-YYYY')) {
                        duration = ((leaveEndDayTime.diff(leaveStartDayTime)) / 60000)
                    } else {

                        /* Firs day leave hour */
                        let currentDayWithOfficeEndHour = moment(today + ' ' + endOfficeHour, 'YYYY-MM-DD HH:mm')
                        let currentDayWithStartLeaveHour = moment(today + ' ' + leaveStartTime)
                        let firstDayLeaveMin = ((currentDayWithOfficeEndHour.diff(currentDayWithStartLeaveHour)) / 60000)

                        /* Last day leave hour*/
                        let currentDayWithEndLeaveHour = moment(today + ' ' + leaveEndTime)
                        let currentDayWithOfficeStartHour = moment(today + ' ' + startOfficeHour, 'YYYY-MM-DD HH:mm')
                        let lastDayLeaveMin = ((currentDayWithEndLeaveHour.diff(currentDayWithOfficeStartHour)) / 60000)

                        let startDate = moment(leaveStartDayTime.format('YYYY-MM-DD'))
                        let endDate = moment(leaveEndDayTime.format('YYYY-MM-DD'))

                        let totalLeaveDayInMin = ((((((endDate.diff(startDate)) / 60000) / 60) / 24) - 1) * 9) * 60 /* convert millisecond to 9hour based day and to  minute */

                        duration = firstDayLeaveMin + lastDayLeaveMin + totalLeaveDayInMin
                    }

                    $('#editLeaveBtn').prop("disabled", false)
                    $('#editLeaveTimeError').hide()

                    /* Check Casual leave*/
                    if (leaveTypeId == 1) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('casual_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Casual) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Casual) - parseInt(leave.duration)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#editLeaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#editLeaveTimeError').show()
                            $('#editLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Sick leave*/
                    if (leaveTypeId == 2) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('sick_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Sick) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Sick) - parseInt(leave.duration)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#editLeaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#editLeaveTimeError').show()
                            $('#editLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Earned leave*/
                    if (leaveTypeId == 3) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('earned_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Earned) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Earned) - parseInt(leave.duration)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#editLeaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#editLeaveTimeError').show()
                            $('#editLeaveBtn').prop("disabled", true)
                        }
                    }

                    /* Check Unpaid leave*/
                    if (leaveTypeId == 4) {
                        let allocatedLeaveInMin = ((parseInt(@json(settings('unpaid_leave')))) * 9) * 60
                        var consumeLeave = 0;
                        if (employee.leave_duration_in_minute.Unpaid) {
                            consumeLeave = parseInt(employee.leave_duration_in_minute.Unpaid) - parseInt(leave.duration)
                        }

                        var totalConsumeLeave = duration + consumeLeave;

                        if (totalConsumeLeave > allocatedLeaveInMin) {
                            let leaveLeft = humanReadableDayFromMins(allocatedLeaveInMin - consumeLeave)
                            $('#editLeaveTimeError').html('Only ' + leaveLeft + ' leave left')
                            $('#editLeaveTimeError').show()
                            $('#editLeaveBtn').prop("disabled", true)
                        }
                    }

                }
            }

            /* End leave time validation for edit */


            $('#leaveRegisterForm').validate({
                rules: {
                    employee_id: {
                        required: true,
                    },
                    submission_type: {
                        required: true,
                    },
                    leave_type_id: {
                        required: true,
                    },
                    reason: {
                        required: true,
                    },
                    leave_time: {
                        required: true,
                    },
                    recommend_employee_id: {
                        required: true,
                    },

                },
                messages: {
                    employee_id: {
                        required: 'Employee is required',
                    },
                    submission_type: {
                        required: 'Submission type is required',
                    },
                    leave_type_id: {
                        required: 'Leave type is required',
                    },
                    reason: {
                        required: 'Reason is required',
                    },
                    leave_time: {
                        required: 'Leave time is required',
                    },
                    recommend_employee_id: {
                        required: 'Recommend employee is required',
                    },
                },

            });

            $('#leaveEditForm').validate({
                rules: {
                    employee_id: {
                        required: true,
                    },
                    submission_type: {
                        required: true,
                    },
                    leave_type_id: {
                        required: true,
                    },
                    reason: {
                        required: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                    recommend_employee_id: {
                        required: true,
                    },
                    status: {
                        required: true,
                    }

                },
                messages: {
                    employee_id: {
                        required: 'Employee is required',
                    },
                    submission_type: {
                        required: 'Submission type is required',
                    },
                    leave_type_id: {
                        required: 'Leave type is required',
                    },
                    reason: {
                        required: 'Reason is required',
                    },
                    start_date: {
                        required: 'Start date is required',
                    },
                    end_date: {
                        required: 'End date is required',
                    },
                    recommend_employee_id: {
                        required: 'Recommend employee is required',
                    },
                    status: {
                        required: 'Status field is required',
                    }
                },

            });

        });

        function humanReadableDayFromMins(mins) {
            let hours = Math.floor(mins / 60)
            let days = 0

            mins = mins % 60

            if (hours >= 9) {
                days = Math.floor(hours / 9);
                hours = hours % 9;
            }

            if (mins > 0) {
                mins = mins + ' minute[s] '
            } else {
                mins = ''
            }
            if (hours > 0) {
                hours = hours + ' hours[s] '
            } else {
                hours = ''
            }
            if (days > 0) {
                days = days + ' days[s] '
            } else {
                days = ''
            }

            return days + hours + mins

        }


        function deleteLeave(leave_id, e) {
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

                    $('#delete_leave_' + leave_id).submit();

                }
            })
        }


        function getLeaveShowInfo(id) {

            let leaves = @json($leaves);
            let leave = leaves.find(x => x.id === id);
            let date_format = @json(settings('date_format'));
            let time_format = @json(settings('time_format'));

            let leaveDuration = leave.employee.leave_duration


            $('#show_employee_name').html(leave.employee.name)
            $('#show_employee_id').html(leave.employee.custom_id)
            $('#show_leave_type_id').html(leave.leave_type.name)
            $('#show_reason').html(leave.reason)
            $('#show_start_date').html(moment(leave.start_date,'YYYY-MM-DD').format(date_format))
            $('#show_end_date').html(moment(leave.end_date,'YYYY-MM-DD').format(date_format))
            $('#show_start_time').html(moment(leave.start_time,'H:mm').format(time_format))
            $('#show_end_time').html(moment(leave.end_time,'H:mm').format(time_format))
            $('#show_duration').html(humanReadableDayFromMins(leave.duration))
            $('#show_submission_type').html(leave.submission_type)
            $('#show_recommend_employee_id').html(leave.recommend_employee.name)
            $('#show_casual_leave').html(leaveDuration.Casual ? leaveDuration.Casual : '--')
            $('#show_sick_leave').html(leaveDuration.Sick ? leaveDuration.Sick : '--')
            $('#show_earned_leave').html(leaveDuration.Earned ? leaveDuration.Earned : '--')
            $('#show_unpaid_leave').html(leaveDuration.Unpaid ? leaveDuration.Unpaid : '--')

            $('#show_status').html("");
            if (leave.status == 'Pending') {
                $('#show_status').append("<span class='badge badge-warning'>Pending</span>");
            } else if (leave.status == 'Approved') {
                $('#show_status').append("<span class='badge badge-success'>Approved</span>");
            } else if (leave.status == 'Rejected') {
                $('#show_status').append("<span class='badge badge-danger'>Reject</span>");
            }

            $('#leaveShowModal').modal('show')
        }


        function getLeaveEditInfo(id) {

            let leaves = @json($leaves);
            let leave = leaves.find(x => x.id === id);
            let leaveDuration = leave.employee.leave_duration

            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#leaveEditForm').attr('action', appUrl + '/leaves/' + leave.id)

            $('#edit_employee_id option[value="' + leave.employee.id + '"]').prop("selected", true)
            $('#edit_submission_type option[value="' + leave.submission_type + '"]').prop("selected", true)
            $('#edit_leave_type_id option[value="' + leave.leave_type_id + '"]').prop("selected", true)
            $('#edit_recommend_employee_id option[value="' + leave.recommend_employee.id + '"]').prop("selected", true)
            $('#edit_status option[value="' + leave.status + '"]').prop("selected", true)
            $('#edit_leave_id').val(leave.id)
            $('#edit_reason').val(leave.reason)
            $('#casualLeave').html(leaveDuration.Casual ? leaveDuration.Casual : '--')
            $('#sickLeave').html(leaveDuration.Sick ? leaveDuration.Sick : '--')
            $('#earnedLeave').html(leaveDuration.Earned ? leaveDuration.Earned : '--')
            $('#unpaidLeave').html(leaveDuration.Unpaid ? leaveDuration.Unpaid : '--')


            /* Date range picker for edit */
            let date_time_format = @json(settings('date_format'))+' '+@json(settings('time_format'));
            let startDay = moment(leave.start_date + ' ' + leave.start_time, 'YYYY-MM-DD H:mm').format(date_time_format)
            let endDate = moment(leave.end_date + ' ' + leave.end_time, 'YYYY-MM-DD H:mm').format(date_time_format)
            let isTime24hFormat = @json(settings('time_format')) == 'H:mm'

            $('#edit_leave_time').daterangepicker({
                timePicker: true,
                timePicker24Hour: isTime24hFormat,
                startDate: startDay,
                endDate: endDate,
                locale: {
                    format: date_time_format
                }
            });

            $('#leaveEditModal').modal('show')


        }


        //email validation check
        $.validator.addMethod("emailCheck",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
        );


    </script>
@endpush
