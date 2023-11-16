<?php
$page="department";
?>
@extends('layouts.main')

@section('content')
<style>
    .clone
    {
        display: none;
    }
    /* .card.card-primary {
    margin-left: -42%;
    margin-right: -33%;
} */
</style>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Edit Department</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/department')}}">Quiz Departments</a></li>
              <li class="breadcrumb-item">Edit Department</li>
            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/department')}}" class="btn btn-primary">Back</a>
                  </li>
              </ol>
        </div>
    </div>
</div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @if(session('danger'))
                    <div class="alert alert-success">
                    {{ session('danger') }}
                    </div>
                 @endif

                 @if(Session::has('warning'))
                    <div class="alert alert-danger">
                    {{Session::get('warning')}}
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
    <!-- Main content -->
    <section class="content">


        <div class="container-fluid">

            <div class="row">
            <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary form">
                        <div class="card-header">
                            <h3 class="card-title">Edit Quiz Department</h3>
                        </div>
                         <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{route('department.update', $department->id)}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="department_name">Department Name</label>
                                            <input type="text" class="form-control" name="department_name" value="{{$department->department_name}}" placeholder="Enter Department Name">
                                            @if($errors->has('department_name'))
                                                <div class="error" style="color: red;">{{ $errors->first('department_name') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection
