@extends('layouts.app')
@section('title', trans('trans.holiday'))
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

        .holiIconRed {
            margin-left: auto;a
            margin-right: auto;
            background-color: #ff7575;
            height: 17px;
            width: 17px;
            border-radius: 100%;
            margin-top: 15px;
        }

        .holiIconGreen {
            margin-left: auto;
            margin-right: auto;
            background-color: #216583;
            height: 17px;
            width: 17px;
            border-radius: 100%;
            margin-top: 15px;
        }

        .holiIconYellow {
            margin-left: auto;
            margin-right: auto;
            background-color: #f7be16;
            height: 17px;
            width: 17px;
            border-radius: 100%;
            margin-top: 15px;
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

    </style>

@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.holiday')
                        <ul class="nav nav-pills d-inline-block headerBtn">
                            <li class="nav-item d-inline-block">
                                <a class="nav-link" href="#listView" data-toggle="tab"><i
                                        class="fas fa-list-ul mr-2"></i> @lang('trans.list_view')</a>
                            </li>
                            <li class="nav-item d-inline-block"><a class="nav-link  active" href="#calendarView"
                                                                   data-toggle="tab"><i
                                        class="far fa-calendar-alt mr-2"></i> @lang('trans.calendar_view')</a>
                            </li>
                        </ul>
                    </h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.holiday')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="tab-content">
            <div class="tab-pane" id="listView">
                <div class="row">
                    <div class="col-12">
                        <div class="card vCard">
                            <div class="card-header">
                                <h3 class="card-title">@lang('trans.holiday')</h3>
                                <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                        data-target="#holidayRegisterModal"><i class="fa fa-plus"></i>
                                    @lang('trans.add_new')
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="holidayDataTable"
                                       class="table table-bordered table-striped dataTable dtr-inline text-center">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($holidays as $holiday)
                                        <tr>
                                            <th>{{$loop->index+1}}</th>
                                            <td>{{showDate($holiday->start)}}</td>
                                            <td>{{$holiday->title}}</td>
                                            {{--                                            <td>{{$holiday->description}}</td>--}}
                                            <td>{{substr($holiday->description, 0, 40)}} {{strlen($holiday->description) > 40 ? '...' : ''}}</td>

                                            <td>{{$holiday->type}}</td>
                                            <td>
                                                <button onclick="getLeaveEditInfo({{$holiday->id}})"

                                                        class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                        title="Edit holiday"><i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{route('holidays.destroy', $holiday->id)}}"
                                                      method="post" id="delete_holiday_{{$holiday->id}}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        onclick="deleteHoliday({{json_encode($holiday->id)}}, event)"
                                                        class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                        title="Delete holiday"><i class="fa fa-trash"></i>
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

            </div>
            <div class="tab-pane active" id="calendarView">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="card vCard">
                            <div class="card-body">
                                <div id='calendar'></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-3">
                        <div class="card vCard">
                            <div class="card-header">
                                <h3 class="card-title">Events</h3>
                                <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                        data-target="#holidayRegisterModal"><i class="fa fa-plus"></i>
                                    @lang('trans.add_new')
                                </button>
                            </div>
                            <div class="card-body" id="holidayEventList">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="holidayRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_holiday')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="holidayRegisterForm" action="{{route('holidays.store')}}"
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
        <div class="modal fade" id="holidayEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_holiday')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="holidayEditForm" action=""
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

        function deleteHoliday(holiday_id, e) {
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

                    $('#delete_holiday_' + holiday_id).submit();

                }
            })
        }

        function getLeaveEditInfo(id) {
            let holidays = @json($holidays);
            let date_format = @json(settings('date_format'));
            let holiday = holidays.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#holidayEditForm').attr('action', appUrl + '/holidays/' + holiday.id);
            $('#edit_title').val(holiday.title);
            $('#edit_description').val(holiday.description);
            $('#edit_start').val(moment(holiday.start).format(date_format));
            $('#edit_type option[value="' + holiday.type + '"]').prop("selected", true);

            $('#holidayEditModal').modal('show');

        }

        function setHolidayEvents($date) {

            let holidays = @json($holidays);
            let date = moment($date).format('YYYY-MM-DD')

            let holiday = holidays.filter(function (x) {
                return x.start === date
            })

            let text = '';
            $('#holidayEventList').html('')
            holiday.forEach(function (x) {
                if (x.type == 'Holiday') {
                    text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIconGreen"></div></div><div class="col-10"><h5>${x.title}</h5><hr><p>${x.description ? x.description : " No description here "}</p></div></div></div>`
                } else if (x.type == 'Flexible') {
                    text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIconYellow"></div></div><div class="col-10"><h5>${x.title}</h5><hr><p>${x.description ? x.description : " No description here"}</p></div></div></div>`
                } else {
                    text = `<div class="alert alert-default-light holiEvent" role="alert"> <div class="row"><div class="col-2"><div class="holiIconRed"></div></div><div class="col-10"><h5>${x.title}</h5><hr><p>${x.description ? x.description : " No description here "}</p></div></div></div>`
                }
                $('#holidayEventList').append(text)
            })
        }

        {{--function getLeaveEditInfo(id) {--}}

        {{--    let holidays = @json($holidays);--}}
        {{--    let date_format = @json(settings('date_format'));--}}
        {{--    let holiday = holidays.find(x => x.id === id);--}}
        {{--    const appUrl = $('meta[name="app-url"]').attr('content');--}}
        {{--    $('#holidayEditForm').attr('action', appUrl + '/holidays/' + holiday.id)--}}

        {{--    ('#edit_title').val(holiday.title)--}}
        {{--    ('#edit_description').val(holiday.description)--}}
        {{--    ('#edit_start').val(moment(holiday.start).format(date_format))--}}
        {{--    $('#edit_type option[value="' + holiday.type + '"]').prop("selected", true)--}}

        {{--    $('#holidayEditModal').modal('show')--}}

        {{--}--}}


        $(document).ready(function () {

            let today = moment()
            setHolidayEvents(today)

            let holidays = @json($holidays);

            /* Make FullCalendar event format form database*/
            let holidayEvents = [];
            holidays.forEach(function (x) {
                let color = '';
                if (x.type == 'Holiday') {
                    color = '#216583'
                } else if (x.type == 'Flexible') {
                    color = '#F7BE16'
                } else {
                    color = '#FF7575'
                }
                holidayEvents.push({
                    title: x.title,
                    start: x.start, // a property!
                    end: x.end, // a property! ** see important note below about 'end' **
                    color: color
                })
            })

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
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
                events: holidayEvents
            });
            calendar.render();


            $('#holidayRegisterForm').validate({
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

            $('#holidayEditForm').validate({
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

    </script>
@endpush
