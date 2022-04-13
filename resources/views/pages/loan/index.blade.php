@extends('layouts.app')
@section('title', trans('trans.loan'))
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.loan')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.loan')</li>
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
                        <h3 class="card-title">@lang('trans.loan')</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#loanRegisterModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="loanDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Profile Picture</th>
                                <th>Employee name</th>
                                <th>Employee Id</th>
                                <th>Reason</th>
                                <th>Amount</th>
                                <th>Approved date</th>
                                <th>Return date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>
                                        @if($loan->employee->profile_image)
                                            <img src="{{asset($loan->employee->profile_image)}}" class="circle-avatar"
                                                 alt="loan-avatar">
                                        @else

                                            <img src="{{asset('asset/img/loan/default.png')}}" class="circle-avatar"
                                                 alt="loan-default-avatar">
                                        @endif
                                    </td>
                                    <td>{{$loan->employee->name}}</td>
                                    <td>{{$loan->employee->custom_id}}</td>
                                    <td>{{substr($loan->reason, 0, 20)}} {{strlen($loan->reason) > 20 ? '...' : ''}}</td>
                                    <td>{{$loan->amount}}</td>
                                    <td>{{showDate($loan->issue_date)}}</td>
                                    <td>{{$loan->return_date ? showDate($loan->return_date) : "--"}}</td>
                                    <td>

                                        <button onclick="getLeaveShowInfo({{$loan->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getLeaveEditInfo({{$loan->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit loan"><i class="fa fa-edit"></i>
                                        </button>


                                        <form action="{{route('loans.destroy', $loan->id)}}"
                                              method="post" id="delete_loan_{{$loan->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteLoan({{json_encode($loan->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete loan"><i class="fa fa-trash"></i>
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
        <div class="modal fade" id="loanShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.loan_information')</h4>
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
                                <th>Reason</th>
                                <td id="show_reason"></td>
                            </tr>

                            <tr>
                                <th>Amount:</th>
                                <td id="show_amount"></td>
                            </tr>

                            <tr>
                                <th>Approved date</th>
                                <td id="show_issue_date"></td>
                            </tr>

                            <tr>
                                <th>Return date</th>
                                <td id="show_return_date"></td>
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
        <div class="modal fade" id="loanRegisterModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.create_new_loan')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="loanRegisterForm" action="{{route('loans.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id"  class="mandatory">Employee</label>
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
                                        <label for="amount" class="mandatory">Amount</label>
                                        <input type="number"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="Enter loan amount"
                                               name="amount" id="amount"
                                               value="{{old('amount')}}">
                                        @error('amount') <span
                                            class="text-danger float-right">{{$errors->first('amount') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="issue_date" class="mandatory">Approved Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('issue_date') is-invalid @enderror"
                                               placeholder="Enter Approved date"
                                               name="issue_date" id="issue_date"
                                               value="{{old('issue_date')}}">
                                        @error('issue_date') <span
                                            class="text-danger float-right">{{$errors->first('issue_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="return_date">Return Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('return_date') is-invalid @enderror"
                                               placeholder="Enter return date"
                                               name="return_date" id="return_date"
                                               value="{{old('return_date')}}">
                                        @error('return_date') <span
                                            class="text-danger float-right">{{$errors->first('return_date') }}</span> @enderror
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
        <div class="modal fade" id="loanEditModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_loan')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="loanEditForm" action=""
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
                                        <label for="amount" class="mandatory">Amount</label>
                                        <input type="number"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="Enter loan amount"
                                               name="amount" id="edit_amount"
                                               value="{{old('amount')}}">
                                        @error('amount') <span
                                            class="text-danger float-right">{{$errors->first('amount') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="issue_date" class="mandatory">Approved Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('issue_date') is-invalid @enderror"
                                               placeholder="Enter Approved date"
                                               name="issue_date" id="edit_issue_date"
                                               value="{{old('issue_date')}}">
                                        @error('issue_date') <span
                                            class="text-danger float-right">{{$errors->first('issue_date') }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="return_date">Return Date</label>
                                        <input type="text"
                                               class="form-control singleDateRange @error('return_date') is-invalid @enderror"
                                               placeholder="Enter return date"
                                               name="return_date" id="edit_return_date"
                                               value="{{old('return_date')}}">
                                        @error('return_date') <span
                                            class="text-danger float-right">{{$errors->first('return_date') }}</span> @enderror
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
            $("#loanDataTable").DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [8]}
                ],
                "pageLength": {{settings('per_page')}}
            });

        });



        function deleteLoan(loan_id, e) {
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

                    $('#delete_loan_' + loan_id).submit();

                }
            })
        }


        function getLeaveShowInfo(id) {

            let loans = @json($loans);
            let loan = loans.find(x => x.id === id);
            let date_format = @json(settings('date_format'));

            $('#show_employee_name').html(loan.employee.name)
            $('#show_employee_id').html(loan.employee.custom_id)
            $('#show_reason').html(loan.reason)
            $('#show_amount').html(loan.amount)
            $('#show_issue_date').html(moment(loan.issue_date,'YYYY-MM-DD').format(date_format))
            $('#show_return_date').html("--")
            if(loan.return_date){
                $('#show_return_date').html(moment(loan.return_date,'YYYY-MM-DD').format(date_format))
            }

            $('#loanShowModal').modal('show')
        }

        {{--function loanStatusChange(loan_id) {--}}
        {{--        --}}{{--let loans = @json($loans);--}}
        {{--    let loan = loans.find(x => x.id === loan_id);--}}
        {{--    if (loan.is_current_loan == 1) {--}}
        {{--        var action = "deactivate"--}}
        {{--    } else {--}}
        {{--        var action = "activate"--}}
        {{--    }--}}
        {{--    Swal.fire({--}}
        {{--        title: 'Are you sure to ' + action + '?',--}}
        {{--        icon: 'warning',--}}
        {{--        showCancelButton: true,--}}
        {{--        confirmButtonColor: '#3085d6',--}}
        {{--        cancelButtonColor: '#d33',--}}
        {{--        confirmButtonText: 'Yes, ' + action--}}
        {{--    }).then((result) => {--}}
        {{--        if (result.value) {--}}
        {{--            window.location.href = $('#loan_status_' + loan_id).data('href');--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}

        function getLeaveEditInfo(id) {

            let loans = @json($loans);
            let date_format = @json(settings('date_format'));
            let loan = loans.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#loanEditForm').attr('action', appUrl + '/loans/' + loan.id)

            $('#edit_employee_id option[value="'+loan.employee.id+'"]').prop("selected", true)
            $('#edit_reason').val(loan.reason)
            $('#edit_amount').val(loan.amount)
            $('#edit_issue_date').val(moment(loan.issue_date,'YYYY-MM-DD').format(date_format))

            if(loan.return_date){
                $('#edit_return_date').val(moment(loan.return_date,'YYYY-MM-DD').format(date_format))
            }


            $('#loanEditModal').modal('show')

        }


        //email validation check
        $.validator.addMethod("emailCheck",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
        );

        $(document).ready(function () {


            $('#loanRegisterForm').validate({
                rules: {
                    employee_id:{
                        required:true,
                    },
                    reason:{
                        required:true,
                    },
                    amount:{
                        required:true,
                        number:true,
                    },
                    issue_date:{
                        required:true,
                    },

                },
                messages: {
                    employee_id:{
                        required:'Employee is required',
                    },
                    reason:{
                        required:'Reason is required',
                    },
                    amount:{
                        required:'Amount is required',
                        number:'Amount must be number',
                    },
                    issue_date:{
                        required:'Approved date is required',
                    },
                },

            });

            $('#loanEditForm').validate({
                rules: {
                    employee_id:{
                        required:true,
                    },
                    reason:{
                        required:true,
                    },
                    amount:{
                        required:true,
                        number:true,
                    },
                    issue_date:{
                        required:true,
                    },

                },
                messages: {
                    employee_id:{
                        required:'Employee is required',
                    },
                    reason:{
                        required:'Reason is required',
                    },
                    amount:{
                        required:'Amount is required',
                        number:'Amount must be number',
                    },
                    issue_date:{
                        required:'Approved date is required',
                    },
                },

            });

        });

    </script>
@endpush
