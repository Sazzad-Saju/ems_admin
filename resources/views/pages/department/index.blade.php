@extends('layouts.app')
@section('title', trans('trans.department'))
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.department')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.department')</li>
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
                        <h3 class="card-title">@lang('trans.department')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#departmentRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="departmentDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Department Name</th>
                                <th>Department head</th>
                                <th>Parent Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>{{$department->name}}</td>
                                    <td>{{isset($department->head->name)? $department->head->name : '---'}}</td>
                                    <td>{{isset($department->parentDepartment->name)? $department->parentDepartment->name : '---'}}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                           class="badge {{$department->status == 1 ? 'badge-success' : 'badge-danger'}}"

                                           onclick="departmentStatusChange({{json_encode($department->id)}})"
                                           data-toggle="tooltip"
                                           title="Click to change status"

                                           id="department_status_{{$department->id}}"
                                           data-href="{{route('departments.status', $department->id)}}"
                                        >
                                            @if($department->status == 1)
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-power-off"></i>
                                            @endif
                                        </a>
                                    </td>
                                    <td>

                                        <button onclick="getDepartmentShowInfo({{$department->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getDepartmentEditInfo({{$department->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit department"><i class="fa fa-edit"></i>
                                        </button>


                                        <form action="{{route('departments.destroy', $department->id)}}"
                                              method="post" id="delete_department_{{$department->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteDepartment({{json_encode($department->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete department"><i class="fa fa-trash"></i>
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
        <div class="modal fade" id="departmentShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.department_information')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>Department Name:</th>
                                <td id="show_department_name"></td>
                            </tr>

                            <tr>
                                <th>Department Head:</th>
                                <td id="show_department_head_id"></td>
                            </tr>
                            <tr>
                                <th>Parent Department :</th>
                                <td id="show_parent_department_id"></td>
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

        <div class="modal fade" id="departmentRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_department')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="departmentRegisterForm" action="{{route('departments.store')}}"
                          method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name"  class="mandatory">Department Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Department name"
                                               name="name" id="name"
                                               value="{{old('name')}}">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                        <span class="text-danger float-right" id="departmentTimeError"
                                              style="display: none"></span>
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
                                    id="createDepartmentBtn">@lang('trans.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="departmentEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_department')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="departmentEditForm" action=""
                          method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name" class="mandatory">Department Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter start date"
                                               name="name" id="edit_name"
                                               value="{{old('name')}}">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id">Department Head</label>
                                        <select class="form-control" name="employee_id" id="edit_employee_id">
                                            <option value="">Choose Department head</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}"
                                                        @if(old('employee_id') == $employee->id) selected @endif>{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_id') <span
                                            class="text-danger float-right">{{$errors->first('employee_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="parent_department_id">Parent Department</label>
                                        <select class="form-control" name="parent_department_id"
                                                id="edit_parent_department_id">
                                            <option value="">Choose Parent Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}"
                                                        @if(old('parent_department_id') == $department->id) selected @endif>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_department_id') <span
                                            class="text-danger float-right">{{$errors->first('parent_department_id') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default float-right"
                                    data-dismiss="modal">@lang('trans.close')
                            </button>
                            <button type="submit"
                                    class="btn btn-sm defaultBtn float-right"
                                    id="editDepartmentBtn">@lang('trans.update')</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>


@endsection


@push('js')

    <script>
        let departments = @json($departments);

        $(document).ready(function () {

            $('#totalDepartmentTable').click();
            $('#createTotalDepartmentCollapse').click();

            $('#departmentDataTable').DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [5]}
                ],
                "pageLength": {{settings('per_page')}}
            });

            $('#departmentRegisterForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },

                },
                messages: {
                    name: {
                        required: 'Department name is required',
                    },
                },

            });

            $('#departmentEditForm').validate({
                rules: {
                    name: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Department name is required',
                    },
                },

            });

        });


        function deleteDepartment(department_id, e) {
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

                    $('#delete_department_' + department_id).submit();

                }
            })
        }


        function getDepartmentShowInfo(id) {

            let departments = @json($departments);
            let department = departments.find(x => x.id === id);

            $('#show_department_name').html(department.name)
            $('#show_department_head_id').html(department.head ? department.head.name : '---')
            $('#show_parent_department_id').html(department.parent_department ? department.parent_department.name : '---')


            $('#show_status').html("");
            if (department.status == 1) {
                $('#show_status').append("<span class='badge badge-success'>Active</span>");
            } else {
                $('#show_status').append("<span class='badge badge-danger'>Inactive</span>");
            }

            $('#departmentShowModal').modal('show')
        }


        function getDepartmentEditInfo(id) {

            let departments = @json($departments);
            let department = departments.find(x => x.id === id);

            /* Set Edit Department form action */
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#departmentEditForm').attr('action', appUrl + '/departments/' + department.id)

            $('#edit_name').val(department.name)

            if (department.head) {
                $('#edit_employee_id option[value="' + department.head.id + '"]').prop("selected", true)
            }
            if (department.parent_department) {
                $('#edit_parent_department_id option[value="' + department.parent_department.id + '"]').prop("selected", true)
            }


            $('#departmentEditModal').modal('show')


        }

        function departmentStatusChange(department_id) {
            let departments = @json($departments);
            let department = departments.find(x => x.id === department_id);
            if (department.status == 1) {
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
                    window.location.href = $('#department_status_' + department_id).data('href');
                }
            })
        }


    </script>
@endpush
