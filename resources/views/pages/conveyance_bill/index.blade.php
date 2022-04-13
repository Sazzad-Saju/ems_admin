@extends('layouts.app')
@section('title', trans('trans.conveyance_bills'))
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.conveyance_bills')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.conveyance_bills')</li>
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
                        <h3 class="card-title">@lang('trans.conveyance_bills')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#conveyanceBillRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="conveyanceBillDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Bill type</th>
                                <th>Employee name</th>
                                <th>Employee Id</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Approved</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conveyanceBills as $conveyanceBill)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>{{$conveyanceBill->billType->name}}</td>
                                    <td>{{$conveyanceBill->employee()->exists()? $conveyanceBill->employee->name : "--"}}</td>
                                    <td>{{$conveyanceBill->employee()->exists()? $conveyanceBill->employee->custom_id : "--"}}</td>
                                    <td>{{substr($conveyanceBill->description, 0, 20)}} {{strlen($conveyanceBill->description) > 20 ? '...' : ''}}</td>
                                    <td>{{$conveyanceBill->amount}}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                           class="badge {{$conveyanceBill->is_approved == 1 ? 'badge-success' : 'badge-danger'}}"
                                           onclick="conveyanceBillStatusChange({{json_encode($conveyanceBill->id)}})"
                                           data-toggle="tooltip"
                                           title="Click to change status"

                                           id="conveyanceBill_status_{{$conveyanceBill->id}}"
                                           data-href="{{route('conveyance-bills.status', $conveyanceBill->id)}}"
                                        >
                                            @if($conveyanceBill->is_approved==1)
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-power-off"></i>
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{showDate($conveyanceBill->date)}}</td>
                                    <td>

                                        <button onclick="getConveyanceBillShowInfo({{$conveyanceBill->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getConveyanceBillEditInfo({{$conveyanceBill->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit conveyance_bill"><i class="fa fa-edit"></i>
                                        </button>


                                        <form action="{{route('conveyance-bills.destroy', $conveyanceBill->id)}}"
                                              method="post" id="delete_conveyance_bill_{{$conveyanceBill->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteConveyanceBill({{json_encode($conveyanceBill->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete conveyance_bill"><i class="fa fa-trash"></i>
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
        <div class="modal fade" id="conveyanceBillShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.conveyance_bill_information')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th style="width: 30%">Employee Name:</th>
                                <td id="show_employee_name"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Employee ID:</th>
                                <td id="show_employee_id"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Bill type:</th>
                                <td id="show_bill_type_id"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Description</th>
                                <td id="show_description"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Amount</th>
                                <td id="show_amount"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Date</th>
                                <td id="show_date"></td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Status:</th>
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
        <div class="modal fade" id="conveyanceBillRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_conveyance_bill')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="conveyanceBillRegisterForm" action="{{route('conveyance-bills.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="bill_type_id" class="mandatory">Bill type</label>
                                        <select class="form-control" name="bill_type_id" id="bill_type_id">
                                            <option value="">Choose Bill Type</option>
                                            @foreach($billTypes as $billType)
                                                <option value="{{$billType->id}}"
                                                        @if(old('bill_type_id')==$billType->id) selected @endif>{{$billType->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('bill_type_id') <span
                                            class="text-danger float-right">{{$errors->first('bill_type_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id">Employee</label>
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
                                        <label for="description" class="mandatory">Description</label>
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
                                        <label for="amount" class="mandatory">Amount</label>
                                        <input type="number"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="Enter amount"
                                               name="amount" id="amount"
                                               value="{{old('amount')}}">
                                        @error('amount') <span
                                            class="text-danger float-right">{{$errors->first('amount') }}</span> @enderror
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
                                            class="text-danger float-right">{{$errors->first('date') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="is_approved" class="pr-3">Approved</label>
                                        <input type="checkbox" name="is_approved" id="is_approved"
                                               class="employee_status_switch"
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
        <div class="modal fade" id="conveyanceBillEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_conveyance_bill')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="conveyanceBillEditForm" action=""
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="bill_type_id" class="mandatory">Bill type</label>
                                        <select class="form-control" name="bill_type_id" id="edit_bill_type_id">
                                            <option value="">Choose Bill Type</option>
                                            @foreach($billTypes as $billType)
                                                <option value="{{$billType->id}}"
                                                        @if(old('bill_type_id')==$billType->id) selected @endif>{{$billType->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('bill_type_id') <span
                                            class="text-danger float-right">{{$errors->first('bill_type_id') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id">Employee</label>
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
                                        <label for="description" class="mandatory">Description</label>
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
                                        <label for="amount" class="mandatory">Amount</label>
                                        <input type="number"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="Enter amount"
                                               name="amount" id="edit_amount"
                                               value="{{old('amount')}}">
                                        @error('amount') <span
                                            class="text-danger float-right">{{$errors->first('amount') }}</span> @enderror
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
                                    <div class="form-group">
                                        <label for="is_approved" class="pr-3">Approved</label>
                                        <input type="checkbox" name="is_approved" id="edit_is_approved"
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
    </section>


@endsection


@push('js')

    <script>
        $(function () {
            $("#conveyanceBillDataTable").DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [8]}
                ],
                "pageLength": {{settings('per_page')}}
            });

        });

        function conveyanceBillStatusChange(conveyanceBill_id) {
            let conveyanceBills = @json($conveyanceBills);
            let conveyanceBill = conveyanceBills.find(x => x.id === conveyanceBill_id);
            if (conveyanceBill.is_approved == 1) {
                var action = "cancel"
            } else {
                var action = "approve"
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
                    window.location.href = $('#conveyanceBill_status_' + conveyanceBill_id).data('href');
                }
            })
        }



        function deleteConveyanceBill(conveyance_bill_id, e) {
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

                    $('#delete_conveyance_bill_' + conveyance_bill_id).submit();

                }
            })
        }


        function getConveyanceBillShowInfo(id) {

            let conveyance_bills = @json($conveyanceBills);
            let conveyance_bill = conveyance_bills.find(x => x.id === id);
            let date_format = @json(settings('date_format'));


            $('#show_employee_name').html('--')
            $('#show_employee_id').html('--')
            $('#show_bill_type_id').html(conveyance_bill.bill_type.name)
            $('#show_description').html(conveyance_bill.description)
            $('#show_amount').html(conveyance_bill.amount)
            $('#show_date').html(moment(conveyance_bill.date,'YYYY-MM-DD').format(date_format))
            $('#show_status').html(conveyance_bill.status)

            if(conveyance_bill.employee){
                $('#show_employee_name').html(conveyance_bill.employee.name)
                $('#show_employee_id').html(conveyance_bill.employee.custom_id)
            }

            $('#show_status').html("");
            if (conveyance_bill.is_approved == 1) {
                $('#show_status').append("<span class='badge badge-success'>Approved</span>");
            }else{
                $('#show_status').append("<span class='badge badge-danger'>Not Approved</span>");
            }

            $('#conveyanceBillShowModal').modal('show')
        }

        function getConveyanceBillEditInfo(id) {

            let date_format = @json(settings('date_format'));
            let conveyance_bills = @json($conveyanceBills);
            let conveyance_bill = conveyance_bills.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#conveyanceBillEditForm').attr('action', appUrl + '/conveyance-bills/' + conveyance_bill.id)

            if(conveyance_bill.employee){
                $('#edit_employee_id option[value="'+conveyance_bill.employee.id+'"]').prop("selected", true)
            }

            $('#edit_bill_type_id option[value="'+conveyance_bill.bill_type_id+'"]').prop("selected", true)
            $('#edit_description').val(conveyance_bill.description)
            $('#edit_amount').val(conveyance_bill.amount)
            $('#edit_date').val(moment(conveyance_bill.date,'YYYY-MM-DD').format(date_format))

            if(conveyance_bill.is_approved == 1){
                $('#edit_is_approved').prop("checked", true)
            }




            $('#conveyanceBillEditModal').modal('show')

        }


        //email validation check
        $.validator.addMethod("emailCheck",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
        );

        $(document).ready(function () {


            $('#conveyanceBillRegisterForm').validate({
                rules: {
                    bill_type_id :{
                        required:true,
                    },
                    description :{
                        required:true,
                    },
                    date :{
                        required:true,
                    },
                    amount :{
                        required:true,
                    },

                },
                messages: {
                    bill_type_id :{
                        required:'Bill type is required',
                    },
                    description :{
                        required:'Description field is required',
                    },
                    date :{
                        required:'Date field is required',
                    },
                    amount :{
                        required:'Amount field is required',
                    },
                },

            });

            $('#conveyanceBillEditForm').validate({

                rules: {
                    bill_type_id :{
                        required:true,
                    },
                    description :{
                        required:true,
                    },
                    date :{
                        required:true,
                    },
                    amount :{
                        required:true,
                    },

                },
                messages: {
                    bill_type_id :{
                        required:'Bill type is required',
                    },
                    description :{
                        required:'Description field is required',
                    },
                    date :{
                        required:'Date field is required',
                    },
                    amount :{
                        required:'Amount field is required',
                    },
                },

            });
        });

    </script>
@endpush
