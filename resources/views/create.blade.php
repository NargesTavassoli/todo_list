@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">TO Do List</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-white">
                                        <div class="card-body">
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach($errors->all() as $error)
                                                            <li>{{$error}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form action="create" method="post">
                                                @csrf
                                                <input type="text" name="task" class="form-control add-task" placeholder="New Task...">
                                            </form>
                                            <ul class="nav nav-pills todo-nav">
                                                <li role="presentation" class="nav-item all-task active"><a href="#" class="nav-link">All</a></li>
                                                <li role="presentation" class="nav-item active-task"><a href="#" class="nav-link">Active</a></li>
                                                <li role="presentation" class="nav-item completed-task"><a href="#" class="nav-link">Completed</a></li>
                                            </ul>
                                            <div class="todo-list">
                                                <div class="todo-item">
                                                    @foreach($task as $task)
                                                        @if( $task->user_id == Auth::user()->id)
                                                        <div class="container">
                                                            <div class="row">

                                                                    <div class="col-sm-8">
                                                                        <span class="">
                                                                        <input type="checkbox" name="checked"></span>
                                                                        <span>{{ $task->name }}</span>
                                                                    </div>
                                                                    <a href="#" class="float-right remove-todo-item"><i class="icon-close"></i>
                                                                    </a>
                                                                    <div class="col-sm-2">
                                                                        <form action="{{$task->id}}" method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button class="btn btn-danger"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <form action="{{$task->id}}/edit" method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <button class="btn btn-primary"></button>
                                                                        </form>
                                                                    </div>


                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
