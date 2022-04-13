@extends('layouts.app')
@section('title', trans('trans.leave'))
@push('css')
    <style>
        .fc-col-header-cell-cushion, .fc-daygrid-day-number {
            color: #1a252f;
        }

        .vCard {
            height: 99%;
        }

        .holiEvent {
            padding: 5px !important;
            background-color: #f7f7f7 !important;
            border-color: #f7f7f7 !important;
            border-radius: 1rem !important;
        }

        .holiEvent:hover {
            box-shadow: 0 3px 12px -4px rgba(0, 0, 0, .20);

        }

        .holiEvent p {
            margin-bottom: 0 !important;

        }

        .holiEvent hr {
            margin-top: 5px !important;
            margin-bottom: 5px !important;

        }

        .holiEvent h5 {
            font-weight: 600;
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }

        .holiIcon {
            margin-left: auto;
            margin-right: auto;
            height: 17px;
            width: 17px;
            border-radius: 100%;
            margin-top: 15px;
        }

        .bgRed {
            background-color: #ff7575;
        }

        .bgGreen {
            background-color: #216583;
        }

        .bgBlue {
            background-color: #08ccba;
        }

        .bgYellow {
            background-color: #f7be16;
        }

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

        #employee_profile .card-header {
            padding: 5px !important;
        }

        .select2 {
            width: 85%;
            margin-right: auto;
            margin-left: auto;
            color: #06364E;
        }

        .select2-selection {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-radius: 0 !important;
            text-align: center;
            font-weight: 600;
            font-size: 20px;
        }

        #designation {
            font-weight: 600;
            color: #106894;
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
                                <a class="nav-link" href="{{route('leaves.index')}}"><i
                                            class="fas fa-list-ul mr-2"></i> @lang('trans.list_view')</a>
                            </li>
                            <li class="nav-item d-inline-block"><a class="nav-link  active" href="javascript:void(0)"
                                ><i
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
            <div class="col-sm-9">
                <div class="card vCard">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3" id="employee_profile">
                <div class="card vCard">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{url('asset/img/default_user.jpg')}}" width="128" height="128"
                                     alt="profile_image" id="employee_image">
                            </div>
                            <div class="col-8 text-center">
                                <select class="select2" name="" id="leave_employee">
                                    <option value="">Select employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                                <div id="designation" class="mt-2"> --</div>
                                <div id="department" class="mt-2"> --</div>
                                <div id="departmentHead"> --</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="leaveEventList">
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="leaveRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_leave')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="leaveRegisterForm" action="{{route('leaves.store')}}"
                          method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="title" class="mandatory">Title</label>
                                        <input type="text"
                                               class="form-control @error('title') is-invalid @enderror"
                                               placeholder="Enter title"
                                               name="title" id="title"
                                               value="{{old('title')}}">
                                        @error('title') <span
                                                class="text-danger float-right">{{$errors->first('title') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description"
                                                  rows="3">{{old('description')}}</textarea>
                                        @error('description') <span
                                                class="text-danger float-right">{{$errors->first('description') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="start" class="mandatory">Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('start') is-invalid @enderror"
                                               placeholder="Select Date"
                                               name="start" id="start"
                                               value="{{old('start')}}">
                                        @error('start') <span
                                                class="text-danger float-right">{{$errors->first('start') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="type" class="mandatory">Type</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">Choose Type</option>
                                            <option value="Holiday">Holiday</option>
                                            <option value="Reserved">Reserved</option>
                                            <option value="Flexible">Flexible</option>
                                        </select>
                                        @error('type') <span
                                                class="text-danger float-right">{{$errors->first('type') }}</span> @enderror
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
        <div class="modal fade" id="leaveEditModal">
            <div class="modal-dialog">
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
                            <div class="row">

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="title" class="mandatory">Title</label>
                                        <input type="text"
                                               class="form-control @error('title') is-invalid @enderror"
                                               placeholder="Enter title"
                                               name="title" id="edit_title"
                                               value="{{old('title')}}">
                                        @error('title') <span
                                                class="text-danger float-right">{{$errors->first('title') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="edit_description" name="description"
                                                  rows="3">{{old('description')}}</textarea>
                                        @error('description') <span
                                                class="text-danger float-right">{{$errors->first('description') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="start" class="mandatory">Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('start') is-invalid @enderror"
                                               placeholder="Select Date"
                                               name="start" id="edit_start"
                                               value="{{old('start')}}">
                                        @error('start') <span
                                                class="text-danger float-right">{{$errors->first('start') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- Select multiple-->
                                    <div class="form-group">
                                        <label for="type" class="mandatory">Type</label>
                                        <select class="form-control" name="type" id="edit_type">
                                            <option value="">Choose Type</option>
                                            <option value="Holiday">Holiday</option>
                                            <option value="Reserved">Reserved</option>
                                            <option value="Flexible">Flexible</option>
                                        </select>
                                        @error('type') <span
                                                class="text-danger float-right">{{$errors->first('type') }}</span> @enderror
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

    </section>


@endsection


@push('js')

    <script>

        function deleteHoliday(leave_id, e) {
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

        function getLeaveEditInfo(id) {
            let leaves = @json($leaves);
            let date_format = @json(settings('date_format'));
            let leave = leaves.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#leaveEditForm').attr('action', appUrl + '/leaves/' + leave.id);
            $('#edit_title').val(leave.title);
            $('#edit_description').val(leave.description);
            $('#edit_start').val(moment(leave.start).format(date_format));
            $('#edit_type option[value="' + leave.type + '"]').prop("selected", true);

            $('#leaveEditModal').modal('show');

        }


        $(document).ready(function () {

            updateCalendar()

            $('#leave_employee').change(function () {
                let employeeId = $(this).val()
                updateCalendar(employeeId);
            })

            $('#leaveRegisterForm').validate({
                rules: {
                    date: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },


                },
                messages: {
                    date: {
                        required: 'Date field is required',
                    },
                    title: {
                        required: 'Title field is required',
                    },
                },

            });

            $('#leaveEditForm').validate({
                rules: {
                    date: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },


                },
                messages: {
                    date: {
                        required: 'Date field is required',
                    },
                    title: {
                        required: 'Title field is required',
                    },
                },

            });

        });

        function updateCalendar(employeeId = "") {

            let leaves = @json($leaves);
            let searchType = 'all'

            /* Select leaves for single employee*/
            if (employeeId) {
                leaves = leaves.filter(function (x) {
                    return x.employee.id == employeeId;
                })
                searchType = 'single'
            }

            /* Make FullCalendar event format form database*/
            let leaveEvents = [];

            leaves.forEach(function (x) {

                /* Select color for leave type*/
                let color = '';
                if (x.leave_type_id == 1) {
                    color = '#216583'
                } else if (x.leave_type_id == 2) {
                    color = '#F7BE16'
                } else if (x.leave_type_id == 3) {
                    color = '#08ccba'
                } else {
                    color = '#FF7575'
                }

                let start_date = x.start_date
                let end_date = ''
                if (x.start_date == x.end_date) {
                    end_date = x.end_date
                } else {
                    end_date = moment(x.end_date, 'YYYY-MM-DD').add('days', 1).format('YYYY-MM-DD') /* FullCalendar not count last date as event so add one*/
                }

                /* set title for all and single search*/
                let title = x.employee.name
                if(searchType == 'single'){
                    title = x.leave_type.name
                }
                leaveEvents.push({
                    title: title,
                    start: start_date,
                    end: end_date,
                    color: color,
                    allDay: true
                })
            })

            /* Init calendar */
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                displayEventTime: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                // dayMaxEvents: true, // allow "more" link when too many events
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                initialView: 'dayGridMonth',
                // themeSystem: 'bootstrap4',
                dateClick: function (selectionInfo) {
                    setHolidayEvents(selectionInfo.date)
                },
                events: leaveEvents,
            });
            calendar.render();


            /* Profile update for employee selection*/
            if (searchType == 'single') {
                let employees = @json($employees);

                let employee = employees.find(function (x) {
                    return x.id == employeeId
                })
                let departmentHeads = 'Head of ';
                if (employee.department_head.length) {
                    let departmentCount = employee.department_head.length
                    employee.department_head.forEach(function (x, item) {
                        if (item + 1 == departmentCount) {
                            departmentHeads += x.name
                        } else {
                            departmentHeads += x.name + ' and '
                        }
                    })
                } else {
                    departmentHeads = '';
                }

                let appUrl = $("meta[name='app-url']").attr('content')
                $('#employee_image').attr('src', appUrl + '/' + employee.profile_image)
                $('#designation').html(employee.designation.name)
                $('#department').html(employee.department.name + ' Dempartment')
                $('#departmentHead').html(departmentHeads)
            } else {
                let appUrl = $("meta[name='app-url']").attr('content')
                $('#employee_image').attr('src', appUrl + '/asset/img/default_user.jpg')
                $('#department').html('--')
                $('#designation').html('--')
                $('#departmentHead').html('--')
            }


            /* Update event in right panel*/
            let text = '';
            $('#leaveEventList').html('')
            if(searchType == 'single'){
                leaves.forEach(function (x) {
                    if (x.leave_type_id == 1) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgGreen"></div></div><div class="col-10"><h5>${x.leave_type.name}</h5><hr><p>${x.reason ? x.reason : " No description here "}</p></div></div></div>`
                    } else if (x.leave_type_id == 2) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgYellow"></div></div><div class="col-10"><h5>${x.leave_type.name}</h5><hr><p>${x.reason ? x.reason : " No description here"}</p></div></div></div>`
                    } else if (x.leave_type_id == 3) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgBlue"></div></div><div class="col-10"><h5>${x.leave_type.name}</h5><hr><p>${x.reason ? x.reason : " No description here"}</p></div></div></div>`
                    } else {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgRed"></div></div><div class="col-10"><h5>${x.leave_type.name}</h5><hr><p>${x.reason ? x.reason : " No description here "}</p></div></div></div>`
                    }
                    $('#leaveEventList').append(text)
                })
            }else{
                leaves.forEach(function (x) {
                    if (x.leave_type_id == 1) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgGreen"></div></div><div class="col-10"><h5>${x.employee.name}</h5><hr><p>${x.reason ? x.reason : " No description here "}</p></div></div></div>`
                    } else if (x.leave_type_id == 2) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgYellow"></div></div><div class="col-10"><h5>${x.employee.name}</h5><hr><p>${x.reason ? x.reason : " No description here"}</p></div></div></div>`
                    } else if (x.leave_type_id == 3) {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgBlue"></div></div><div class="col-10"><h5>${x.employee.name}</h5><hr><p>${x.reason ? x.reason : " No description here"}</p></div></div></div>`
                    } else {
                        text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIcon bgRed"></div></div><div class="col-10"><h5>${x.employee.name}</h5><hr><p>${x.reason ? x.reason : " No description here "}</p></div></div></div>`
                    }
                    $('#leaveEventList').append(text)
                })
            }
        }

    </script>
@endpush
