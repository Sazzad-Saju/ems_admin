@extends('layouts.app')
@section('title', trans('trans.attendance'))
@push('css')

    <style>
        #attendanceFilterForm {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .5);
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .attendanceFilterForm .form-control:disabled, .form-control[readonly] {
            background-color: #fff;
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 400;
            margin: 0;
        }

        .buttons-pdf {
            border: none !important;
            background-color: #dc3545 !important;
            color: white !important;
        }

        .buttons-pdf:hover {
            border: none !important;
            background-color: #dc3545 !important;
            color: black !important;
        }

        .buttons-csv {
            border: none !important;
            background-color: #28a745 !important;
            color: white !important;
        }

        .buttons-csv:hover {
            border: none !important;
            background-color: #28a745 !important;
            color: black !important;
        }

        .buttons-excel {
            border: none !important;
            background-color: #ffc107 !important;
        }

        .buttons-collection {
            border: none !important;
            background-color: #138496 !important;
            color: white !important;
        }

        .button-page-length {
            border: none !important;
            background-color: #e2e6ea !important;
            color: black !important;
        }

        .dt-button.button-page-length.active {
            border: none !important;
            background-color: #5a6268 !important;
            color: black !important;
        }

        #attendanceDataTable .tr .td {
            text-align: center;
        }

    </style>

@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.attendance')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.attendance')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter -->
    <section class="content">

        <div id="attendanceFilter" style="display: none;">

            <form id="attendanceFilterForm">
                <h3 class="filter-title">@lang('trans.filter')</h3>
                <div class="row">
                    <div class="col-md-6  my-3">
                        <select class="form-control select2 select2-info" data-dropdown-css-class="select2-info"
                                name="filter_employee_id" id="filter_employee_id">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}"
                                        @if(old('filter_employee_id')==$employee->id) selected @endif>{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6  my-3">
                        <input type="text"
                               class="form-control @error('date') is-invalid @enderror"
                               placeholder="Select Date"
                               name="date_range" id="filterDate"
                               value="{{old('date_range')}}" readonly autocomplete="off">
                    </div>
                </div>
            </form>
        </div>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card vCard">
                    <div class="card-header">
                        <h3 class="card-title">@lang('trans.attendance')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right ml-3" id="filterBtn"><i
                                class="fas fa-sliders-h"></i>
                        </button>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#attendanceRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>


                    <div class="card-body">

                        <table id="attendanceDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Profile Picture</th>
                                <th>Employee name</th>
                                <th>Employee Id</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Late time (Minute)</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="attendanceRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_attendance')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="attendanceRegisterForm" action="{{route('attendances.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
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
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="date" class="mandatory">Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('date') is-invalid @enderror"
                                               placeholder="Select Date"
                                               name="date" id="date"
                                               value="{{old('date')}}">
                                        @error('date') <span
                                            class="tattext-danger float-right">{{$errors->first('date') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="start_time" class="mandatory">Start time</label>
                                        <input type="text"
                                               class="form-control singleTimePicker @error('start_time') is-invalid @enderror"
                                               placeholder="Select start time"
                                               name="start_time" id="start_time"
                                               value="{{old('start_time')}}">
                                        @error('start_time') <span
                                            class="text-danger float-right">{{$errors->first('start_time') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="end_time">End time</label>
                                        <input type="text"
                                               class="form-control singleTimePicker @error('end_time') is-invalid @enderror"
                                               placeholder="Select end time"
                                               name="end_time" id="end_time"
                                               value="{{old('end_time')}}">
                                        @error('end_time') <span
                                            class="text-danger float-right">{{$errors->first('end_time') }}</span> @enderror
                                    </div>
                                </div>
{{--                                <div class="col-sm-6 pt-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="switch">Multi attendance : </label>--}}
{{--                                        <input type="checkbox" name="isMultiAttendance" id="isMultiAttendance"--}}
{{--                                               class="employee_status_switch"--}}
{{--                                               data-bootstrap-switch--}}
{{--                                               data-off-color="danger"--}}
{{--                                               data-on-color="success">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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
        <div class="modal fade" id="attendanceEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_attendance')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="attendanceEditForm" action=""
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
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
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="date" class="mandatory">Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('date') is-invalid @enderror"
                                               placeholder="Select Date"
                                               name="date" id="edit_date"
                                               value="{{old('date')}}">
                                        @error('date') <span
                                            class="text-danger float-right">{{$errors->first('date') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="start_time">Start time</label>
                                        <input type="text"
                                               class="form-control singleTimePicker @error('start_time') is-invalid @enderror"
                                               placeholder="Select start time"
                                               name="start_time" id="edit_start_time"
                                               value="{{old('start_time')}}">
                                        @error('start_time') <span
                                            class="text-danger float-right">{{$errors->first('start_time') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="end_time">End time</label>
                                        <input type="text"
                                               class="form-control singleTimePicker @error('end_time') is-invalid @enderror"
                                               placeholder="Select end time"
                                               name="end_time" id="edit_end_time"
                                               value="{{old('end_time')}}">
                                        @error('end_time') <span
                                            class="text-danger float-right">{{$errors->first('end_time') }}</span> @enderror
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
        $(document).ready(function () {

            {{--$('#isMultiAttendance').change(function () {--}}
            {{--    console.log(document.querySelector('#isMultiAttendance').checked)--}}
            {{--    let isMultiAttendance = document.querySelector('#isMultiAttendance').checked--}}
            {{--    if(isMultiAttendance){--}}
            {{--        var start = moment().subtract(29, 'days');--}}
            {{--        var end = moment();--}}

            {{--        function updateDataTable(start, end) {--}}
            {{--            $('#date').val(start.format(dateFormat) + ' to ' + end.format(dateFormat));--}}
            {{--        }--}}

            {{--        $('#date').daterangepicker({--}}
            {{--            startDate: start,--}}
            {{--            endDate: end,--}}
            {{--            alwaysShowCalendars: true,--}}
            {{--            autoUpdateInput: false,--}}
            {{--        }, updateDataTable);--}}
            {{--        $('#date').val('')--}}
            {{--    }else {--}}
            {{--        let date_format = @json(settings('date_format'));--}}
            {{--        $('#date').prop('readonly',true)--}}
            {{--        $('#date').daterangepicker({--}}
            {{--            singleDatePicker: true,--}}
            {{--            locale: {--}}
            {{--                format: date_format--}}
            {{--            }--}}
            {{--        })--}}
            {{--        $('#date').val('')--}}
            {{--        $('#date').on('cancel.daterangepicker', function(ev, picker) {--}}
            {{--            $(this).val('');--}}
            {{--        });--}}
            {{--    }--}}
            {{--})--}}

            /*Date format*/
            let dateFormat = @json(settings('date_format'));

            /* Data table Update*/

            let dataTable = loadDataTable()


            $('#filter_employee_id').change(function () {
                // if($('#filterDate').val() == 'Select date'){
                //     $('#filterDate').val('')
                // };
                loadDataTable()
            })

            /* End Data table Update*/


            /* Active filter */

            $('#filterBtn').click(function () {
                $('#filterDate').val('')
                $('#filter_employee_id').val('')
                $('#attendanceFilter').toggle()

            })

            /* Working with daterange picker  */

            var start = moment().subtract(29, 'days');
            var end = moment();

            function updateDataTable(start, end) {
                $('#filterDate').val(start.format(dateFormat) + ' to ' + end.format(dateFormat));
                loadDataTable()
            }

            $('#filterDate').daterangepicker({
                startDate: start,
                endDate: end,
                alwaysShowCalendars: true,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, updateDataTable);


            /* End Predefine select date */


            $('#attendanceRegisterForm').validate({
                rules: {
                    employee_id: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    start_time: {
                        required: true,
                    },

                },
                messages: {
                    employee_id: {
                        required: 'Employee is required',
                    },
                    date: {
                        required: 'Date is required',
                    },
                    start_time: {
                        required: 'Start time is required',
                    },
                },

            });

            $('#attendanceEditForm').validate({
                rules: {
                    employee_id: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },

                },
                messages: {
                    employee_id: {
                        required: 'Employee is required',
                    },
                    date: {
                        required: 'Date is required',
                    },
                },

            });

        });

        function deleteAttendance(attendance_id, e) {
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

                    $('#delete_attendance_' + attendance_id).submit();

                }
            })
        }

        function getAttendanceEditInfo(e) {
            let date_format = @json(settings('date_format'));
            let time_format = @json(settings('time_format'));
            let attendance = $(e.target).closest('td').find('button').data('leave')

            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#attendanceEditForm').attr('action', appUrl + '/attendances/' + attendance.id)

            $('#edit_employee_id option[value="' + attendance.employee_id + '"]').prop("selected", true)
            $('#edit_date').val(moment(attendance.date,'YYYY-MM-DD').format(date_format)) // Convert Database time format to setting time format
            // $('#edit_start_time').val(moment(attendance.start_time,'HH:mm:ss').format(time_format)) // Convert Database time format to setting time format
            // $('#edit_end_time').val(attendance.end_time ? moment(attendance.end_time,'HH:mm:ss').format(time_format) : '')

            $('#attendanceEditModal').modal('show')

        }

        function loadDataTable() {
            // Reinitialize datatable
            $('#attendanceDataTable').DataTable().clear().destroy();

            let table = $("#attendanceDataTable").DataTable({
                "select": true,
                "dom": 'Blfrtip',
                "lengthMenu": [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', 'Show all']],
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-2" aria-hidden="true"></i>Export a PDF',
                        className: 'btn-primary',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7]
                        },
                        customize : function(doc) {
                            doc.content[1].table.widths = [ '10%', '25%', '15%', '15%', '10%', '10%', '15%'];
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv mr-2" aria-hidden="true"></i> Export a CSV',
                        className: 'btn-primary',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-2" aria-hidden="true"></i>Export a EXCEL',
                        className: 'btn-primary',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    'pageLength'
                ],
                "processing": true,
                "responsive": true,
                "autoWidth": false,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('get.attendances') }}",
                    "data": function (data) {
                        data._token = $("meta[name= 'csrf-token']").attr('content');
                        data.employeeId = $('#filter_employee_id').val()
                        data.dateRange = $('#filterDate').val()
                        // etc
                    },
                    "dataType": "json",
                    "type": "POST",

                },
                "columns": [
                    {"data": "sl"},
                    {"data": "profile_image"},
                    {"data": "employee_name"},
                    {"data": "employee_id"},
                    {"data": "date"},
                    {"data": "start_time"},
                    {"data": "end_time"},
                    {"data": "late_time"},
                    {"data": "action"},
                ],
                "order": [[ 4, "desc" ]],
                "columnDefs": [
                    {"orderable": false, "targets": [0, 1, 2 ,3, 7, 8]}
                ],
                "pageLength": {{settings('per_page')}}
            });

            table.buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

        }

    </script>
@endpush
