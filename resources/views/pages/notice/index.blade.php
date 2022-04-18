@extends('layouts.app')
@section('title', 'Notice')
{{--@push('push-style')--}}

{{--@endpush--}}
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Notice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">Notice</li>
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
                        <h3 class="card-title">Notice</h3>
                        <button type="button" class="btn btn-sm vBtn float-right" data-toggle="modal"
                                data-target="#NewNoticeModal"><i class="fa fa-plus"></i>
                            @lang('trans.add_new')
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="noticeDataTable"
                               class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Message</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notices as $notice)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>{!!$notice->message!!}</td>
                                    <td>{{$notice->created_at->format('d/m/Y')}}</td>
                                    <td>

                                        <button onclick="getNoticeShowInfo({{$notice->id}})"

                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Show details"><i class="fa fa-search-plus"></i>
                                        </button>


                                        <button onclick="getNoticeEditInfo({{$notice->id}})"

                                                class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit notice"><i class="fa fa-edit"></i>
                                        </button>

                                        <form action="{{route('notices.destroy', $notice->id)}}"
                                              method="post" id="delete_notice_{{$notice->id}}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="deleteNotice({{json_encode($notice->id)}}, event)"
                                                    class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                    title="Delete notice"><i class="fa fa-trash"></i>
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

        {{-- Notice Show Modal --}}
        <div class="modal fade" id="noticeShowModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">Notice Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>Message:</th>
                                <td id="show_notice_message"></td>
                            </tr>

                            <tr>
                                <th>Created At:</th>
                                <td id="show_notice_created_at"></td>
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

        {{-- Create Notice Modal --}}
        <div class="modal fade" id="NewNoticeModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">Create New Notice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="noticeRegisterForm" action="{{route('notices.store')}}"
                          method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="message"  class="mandatory">Notice Message</label>
                                        <textarea type="text" rows="5"
                                               class="form-control @error('message') is-invalid @enderror"
                                               placeholder="Enter Notice Message"
                                               name="message" id="enterNotice"> {{old('message')}} </textarea>
                                        @error('message')
                                            <span class="text-danger float-right">{{$errors->first('message') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id">Created At</label>
                                        <input class="ml-2" type="date" name="updated_at" value="{{$date->format('Y-m-d')}}" disabled>
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
                                    id="createNoticeBtn">@lang('trans.create')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Notice Edit Modal --}}
        <div class="modal fade" id="noticeEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">Edit Notice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="noticeEditForm" action=""
                          method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="message" class="mandatory">Notice Message</label>
                                        <textarea type="text"
                                               class="form-control @error('message') is-invalid @enderror"
                                               placeholder="Notice Message"
                                               name="message" id="edit_message" rows="5"> {{old('message')}} </textarea>
                                        @error('message') <span
                                            class="text-danger float-right">{{$errors->first('message') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="employee_id">Updated At</label>
                                        <input class="ml-2" type="date" name="updated_at" value="{{$date->format('Y-m-d')}}" disabled>
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
                                    id="editNoticeBtn">@lang('trans.update')</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="d-flex justify-content-center">
            {{$notices->links()}}
        </div>
    </section>


@endsection

@section('ckeditor')
<script>
    ClassicEditor
        .create( document.querySelector( '#enterNotice' ) )
        .catch( error => {
            console.error( error );
        } );
    // document.getElementById("edit_message").value = "<p>Some other editor data.</p>";
    // CKEDITOR.replace("edit_message");

</script>
@endsection

@push('js')

    <script>
        let notices = @json($notice);

        $(document).ready(function () {

            $('#totalNoticeTable').click();
            $('#createTotalNoticeCollapse').click();

            $('#noticeDataTable').DataTable({
                "responsive": true,
                "autoWidth": false,

                "columnDefs": [
                    {"orderable": false, "targets": [5]}
                ],
                "pageLength": {{settings('per_page')}}
            });

            $('#noticeRegisterForm').validate({
                rules: {
                    message: {
                        required: true,
                    },

                },

            });

            $('#noticeEditForm').validate({
                rules: {
                    message: {
                        required: true,
                    },

                },

            });

        });


        function deleteNotice(notice_id, e) {
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

                    $('#delete_notice_' + notice_id).submit();

                }
            })
        }


        function getNoticeShowInfo(id) {

            // console.log(id);
            let notices = @json($notices);
            let notice = notices.find(x => x.id === id);
            $('#show_notice_message').html(notice.message)
            let date = new Date(notice.created_at);
            // console.log(date.getMonth()+1)
            formattedDate = date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear();
            // console.log(formattedDate );
            // console.log(String(date.getDate()).padStart(2, '0'))
            // console.log(date);
            $('#show_notice_created_at').html(formattedDate)





            $('#noticeShowModal').modal('show')
        }


        function getNoticeEditInfo(id) {

            let notices = @json($notices);
            let notice = notices.find(x => x.id === id);
            // console.log(notice);

            /* Set Edit Notice form action */
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#noticeEditForm').attr('action', appUrl + '/notices/' + notice.id)

            $('#edit_message').val(notice.message)

            $('#noticeEditModal').modal('show')


        }


    </script>
@endpush
