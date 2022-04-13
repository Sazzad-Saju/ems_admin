@extends('layouts.app')
@section('title', trans('trans.tasks'))
@push('css')
    <link rel="stylesheet" href="{{asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <style>
        .todo-list > li .tools {
            display: inline-block !important;
        }
    </style>
@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row no-gutters mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('trans.tasks')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">@lang('trans.home')</a></li>
                        <li class="breadcrumb-item active">@lang('trans.tasks')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card vCard">
                    <div class="card-header shadow">
                        <form id="taskCreateForm" action="{{route('tasks.store')}}" method="post">
                            @csrf()
                            <div class="row my-4">
                                <div class="col-sm-11 ">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" name="title" id="title"
                                               placeholder="Please enter task">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center">
                                    <button type="submit" class="btn btn-sm vBtn " data-toggle="modal"
                                            data-target="#leaveRegisterModal"><i class="fa fa-plus"></i>
                                        @lang('trans.add_new')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="content">

        <!-- Default box -->
        <div class="card">
            {{--            <div class="card-header">
                            <h3 class="card-title">@lang('trans.todo')</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        @if(!$task->status)
                                            <td style="width: 0%">
                                                <form action="{{route('tasks.update',['task'=>$task->id])}}" method="post"
                                                      id="taskComplete{{$task->id}}">
                                                    @csrf
                                                    @method('put')
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="status" onclick="document.getElementById('taskComplete{{$task->id}}').submit()">
                                                    </div>
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="todo3" id="todoCheck3">
                                                        <label for="todoCheck3"></label>
                                                    </div>
                                                    <input type="checkbox" name="status"
                                                           onclick="document.getElementById('taskComplete{{$task->id}}').submit()">
                                                </form>
                                            </td>
                                            <td>
                                                {{$task->title}}
                                            </td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-info btn-sm" href="#" onclick="taskUpdate({{$task->id}})">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>

                                                <a class="btn btn-danger btn-sm" href="#" onclick="document.getElementById('taskDelete{{$task->id}}').submit()">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a>
                                                <form action="{{route('tasks.destroy',['task'=>$task->id])}}" method="post"
                                                      id="taskDelete{{$task->id}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        @else
                                            <td style="width: 0%">
                                                <input type="checkbox" name="status" checked disabled>

                                            </td>
                                            <td>
                                               <s>{{$task->title}}</s>
                                            </td>
                                            <td class="project-actions text-right">
                                                <form action="{{route('tasks.update',['task'=>$task->id])}}" method="post"
                                                      id="taskUndo{{$task->id}}">
                                                    @csrf
                                                    @method('put')
                                                </form>
                                                <a class="btn btn-info btn-sm" href="#" onclick="document.getElementById('taskUndo{{$task->id}}').submit()">
                                                    <i class="fas fa-undo"></i>
                                                </a>

                                                <a class="btn btn-danger btn-sm" href="#" onclick="document.getElementById('taskDelete{{$task->id}}').submit()">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a>
                                                <form action="{{route('tasks.destroy',['task'=>$task->id])}}" method="post"
                                                      id="taskDelete{{$task->id}}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>--}}

            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    @lang('trans.todo_list')
                </h3>

            </div>
            <div class="card-body">
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                    @foreach($tasks as $task)
                        @if(!$task->status)
                            <li>
                                <form action="{{route('tasks.update',['task'=>$task->id])}}" method="post"
                                      id="taskComplete{{$task->id}}">
                                @csrf
                                @method('put')
                                <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="status" id="todoCheck{{$task->id}}"
                                               onclick="document.getElementById('taskComplete{{$task->id}}').submit()">
                                        <input type="hidden" name="status" value="on">
                                        <label for="todoCheck{{$task->id}}"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text">{{$task->title}}</span>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <a class="btn btn-info btn-sm" href="#" onclick="taskUpdate({{$task->id}})">
                                            <i class="fas fa-pencil-alt"> </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#"
                                           onclick="document.getElementById('taskDelete{{$task->id}}').submit()">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </div>
                                </form>
                            </li>
                            <form action="{{route('tasks.destroy',['task'=>$task->id])}}" method="post"
                                  id="taskDelete{{$task->id}}">
                                @csrf
                                @method('delete')
                            </form>
                        @else
                            <li class="done">
                                <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo3" id="todoCheck{{$task->id}}" checked=""
                                           disabled>
                                    <label for="todoCheck{{$task->id}}"></label>
                                </div>
                                <span class="text" style="font-weight: 400"> <s>{{$task->title}}</s></span>
                                <div class="tools">
                                    <form action="{{route('tasks.update',['task'=>$task->id])}}" method="post"
                                          id="taskUndo{{$task->id}}">
                                        @csrf
                                        @method('put')
                                    </form>
                                    <a class="btn btn-info btn-sm" href="#"
                                       onclick="document.getElementById('taskUndo{{$task->id}}').submit()">
                                        <i class="fas fa-undo"></i>
                                    </a>

                                    <a class="btn btn-danger btn-sm" href="#"
                                       onclick="document.getElementById('taskDelete{{$task->id}}').submit()">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                    <form action="{{route('tasks.destroy',['task'=>$task->id])}}" method="post"
                                          id="taskDelete{{$task->id}}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </div>


            <!-- /.card-body -->
        </div>


        <!-- /.card -->

        <div class="modal fade" id="taskUpdateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header vMHeader">
                        <h4 class="modal-title text-white">@lang('trans.edit_task')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form role="form" id="taskUpdateForm" action=""
                          method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="title">Task</label>
                                        <input type="text"
                                               class="form-control @error('title') is-invalid @enderror"
                                               name="title" id="edit_title"
                                               value="{{old('title')}}">
                                        @error('title') <span
                                            class="text-danger float-right">{{$errors->first('title') }}</span> @enderror
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


            $('#taskCreateForm').validate({
                rules: {
                    title: {
                        required: true,
                    },

                },
                messages: {
                    title: {
                        required: 'Title is required',
                    },

                },

            });

        });

        function taskUpdate(id) {

            let tasks = @json($tasks);
            let task = tasks.find(x => x.id === id);
            const appUrl = $('meta[name="app-url"]').attr('content');
            $('#taskUpdateForm').attr('action', appUrl + '/tasks/' + task.id)

            $('#edit_title').val(task.title)


            $('#taskUpdateModal').modal('show')
        }

    </script>
@endpush
