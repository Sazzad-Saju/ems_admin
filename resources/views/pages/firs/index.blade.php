@extends('layouts.app')
@section('title', trans('FIRs'))
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('FIRs')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('FIRs')</li>
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
                        <h3 class="card-title">@lang('FIRs')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#reportRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="reportDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Profile Picture</th>
                                <th>Employee name</th>
                                <th>Employee Id</th>
                                <th>Description</th>
                                <th>Level</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>
                                        @if($report->employee->profile_image)
                                            <img src="{{asset($report->employee->profile_image)}}" class="circle-avatar"
                                                 alt="report-avatar">
                                        @else

                                            <img src="{{asset('asset/img/report/default.png')}}" class="circle-avatar"
                                                 alt="report-default-avatar">
                                        @endif
                                    </td>
                                    <td>{{$report->employee->name}}</td>
                                    <td>{{$report->employee->custom_id}}</td>
                                    <td>{{substr($report->description, 0, 20)}} {{strlen($report->description) > 20 ? '...' : ''}}</td>
                                    <td class="vBadge">
                                        @if ($report->level == 'minor')
                                            <span class='badge badge-info'>Minor</span>
                                        @elseif($report->level == 'major')
                                            <span class='badge badge-warning'>Major</span>
                                        @elseif($report->level == 'critical')
                                            <span class='badge badge-danger'>Critical</span>
                                        @endif
                                    </td>
                                    <td>{{showDate($report->date)}}</td>
                                    <td>
                                        <button onclick="getReportShowInfo({{$report->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>

                                        <button onclick="getReportEditInfo({{$report->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit report"><i class="fa fa-edit"></i>
                                        </button>

                                        <form action="{{route('firs.destroy', $report->id)}}"
                                              method="post" id="delete_report_{{$report->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteReport({{json_encode($report->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete report"><i class="fa fa-trash"></i>
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
        <div class="modal fade" id="reportShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.FIR_information')</h4>
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
                                <th>Description:</th>
                                <td id="show_description"></td>
                            </tr>

                            <tr>
                                <th>Date:</th>
                                <td id="show_date"></td>
                            </tr>

                            <tr>
                                <th>Level:</th>
                                <td class="vBadge" id="show_level"></td>
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
        <div class="modal fade" id="reportRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_FIR')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="reportRegisterForm" action="{{route('firs.store')}}"
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
                                        <label for="level" class="mandatory">Offence level</label>
                                        <select class="form-control" name="level" id="level">
                                            <option value="">Choose Level</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                        @error('level') <span
                                            class="text-danger float-right">{{$errors->first('level') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="description" class="mandatory">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description"
                                                  rows="3">{{old('description')}}</textarea>
                                        @error('description') <span
                                            class="text-danger float-right">{{$errors->first('description') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="date" class="mandatory">Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('date') is-invalid @enderror"
                                               placeholder="Select Date"
                                               name="date" id="date"
                                               value="{{old('date')}}">
                                        @error('date') <span
                                            class="text-danger float-right">{{$errors->first('date') }}</span> @enderror
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
        <div class="modal fade" id="reportEditModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_FIR')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="reportEditForm" action=""
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
                                        <label for="level" class="mandatory">Offence level</label>
                                        <select class="form-control" name="level" id="edit_level">
                                            <option value="">Choose Level</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                        @error('level') <span
                                            class="text-danger float-right">{{$errors->first('level') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="description" class="mandatory">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="edit_description" name="description"
                                                  rows="3">{{old('description')}}</textarea>
                                        @error('description') <span
                                            class="text-danger float-right">{{$errors->first('description') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
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
        $(function () {
            $("#reportDataTable").DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [7]}
                ],
                "pageLength": {{settings('per_page')}}
            });

        });



        function deleteReport(report_id, e) {
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

                    $('#delete_report_' + report_id).submit();

                }
            })
        }


        function getReportShowInfo(id) {

            let reports = @json($reports);
            let report = reports.find(x => x.id === id);
            let date_format = @json(settings('date_format'));

            $('#show_employee_name').html(report.employee.name)
            $('#show_employee_id').html(report.employee.custom_id)
            $('#show_description').html(report.description)
            $('#show_date').html(moment(report.date,'YYYY-MM-DD').format(date_format));

            $('#show_level').html("");
            if (report.level == 'minor') {
                $('#show_level').append("<span class='badge badge-info'>Minor</span>");
            } else if (report.level == 'major') {
                $('#show_level').append("<span class='badge badge-warning'>Major</span>");
            }else if(report.level == 'critical'){
                $('#show_level').append("<span class='badge badge-danger'>Critical</span>");
            }

            $('#reportShowModal').modal('show')
        }

        function getReportEditInfo(id) {

            let reports = @json($reports);
            let date_format = @json(settings('date_format'));
            let report = reports.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#reportEditForm').attr('action', appUrl + '/firs/' + report.id)


            $('#edit_employee_id option[value="'+report.employee.id+'"]').prop("selected", true)
            $('#edit_level option[value="'+report.level+'"]').prop("selected", true)
            $('#edit_description').val(report.description)
            $('#edit_date').val(moment(report.date).format(date_format))


            $('#reportEditModal').modal('show')

        }

        $(document).ready(function () {

            $('#reportRegisterForm').validate({
                rules: {
                    employee_id:{
                        required:true,
                    },
                    level:{
                        required:true,
                    },
                    description:{
                        required:true,
                    },
                    date:{
                        required:true,
                    },

                },
                messages: {
                    employee_id:{
                        required:'Employee field is required',
                    },
                    level:{
                        required:'Level is required',
                    },
                    description:{
                        required:'Description is required',
                    },
                    date:{
                        required:'Date is required',
                    },
                },

            });

            $('#reportEditForm').validate({
                rules: {
                    employee_id:{
                        required:true,
                    },
                    level:{
                        required:true,
                    },
                    description:{
                        required:true,
                    },
                    date:{
                        required:true,
                    },

                },
                messages: {
                    employee_id:{
                        required:'Employee field is required',
                    },
                    level:{
                        required:'Level is required',
                    },
                    description:{
                        required:'Description is required',
                    },
                    date:{
                        required:'Date is required',
                    },
                },

            });

        });

    </script>
@endpush
