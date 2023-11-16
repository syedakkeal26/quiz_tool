<?php
 $page = 'subadmin';
?>
@extends('layouts.main')
@section('content')
<style>
</style>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Edit Subadmin</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('subadminnew')}}">Subadmin</a></li>
              <li class="breadcrumb-item">Edit Subadmin</li>
            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/subadminnew')}}" class="btn btn-primary">Back</a>
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
                @if(session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
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
                            <h3 class="card-title">Edit Subadmin</h3>
                        </div>
                         <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{route('subadminnew.update',$subadmin->id)}}" method="POST" >
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <input type="hidden" name="subadmin_id" value="{{$subadmin->id}}">
                                        <div class="form-group">
                                            <label for="subadmin_name">Name</label>
                                            <input type="text" class="form-control" name="subadmin_name" value="{{$subadmin->name}}" placeholder="Enter Name">
                                            @if($errors->has('subadmin_name'))
                                                <div class="error" style="color: red;">{{ $errors->first('subadmin_name') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="subadmin_email">Email</label>
                                            <input type="text" class="form-control subadmin_email" name="subadmin_email" value="{{$subadmin->email}}" placeholder="Enter Email" readonly>
                                            @if($errors->has('subadmin_email'))
                                                <div class="error" style="color: red;">{{ $errors->first('subadmin_email') }}</div>
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
    <script type="text/javascript">
        $('.subadmin_email').attr('readonly', true);
    </script>
@endsection
