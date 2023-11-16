<?php
 $page = 'profile';
?>
@extends('layouts.main')
@section('content')
<style>
    .alert-success{
    color: #fff;
    background-color: #28a745;
    border-color: #23923d;
    width: 50%;
    margin: auto;
    top: 10px;
    text-align: center;
}
.alert-danger{
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
    width: 50%;
    margin: auto;
    top: 10px;
    text-align: center;
}
    </style>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Profile Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item">Profile</li>

            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/home')}}" class="btn btn-primary">Back</a>
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

                @if(Session::has('warning'))
                    <div class="alert alert-danger">
                    {{Session::get('warning')}}
                    </div>
                 @endif

            </div>
        </div>
    </div>
</section>

<!-- Change profile details -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Change Profile Details</h3>
                    </div>
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form method="POST" action="{{route('user.update', $datas['id'])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">User Name</label>
                                        <input type="hidden" class="form-control" name="id" value="{{$datas['id']}}" placeholder="">
                                        <input type="text" class="form-control" name="name" value="{{$datas['name']}}" placeholder="">
                                @if($errors->has('name'))
                                    <div class="error" style="color: red;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{$datas->email}}" placeholder="">
                                @if($errors->has('email'))
                                    <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route('user.update', $datas->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="opassword">Old Password</label>
                                <input type="password" class="form-control" name="opassword" value="{{old('opassword')}}" placeholder="Enter Old Password">
                                <input type="hidden" class="form-control" name="id" value="{{$datas->id}}" placeholder="">
                                <input type="hidden" class="form-control" name="form" value="password" placeholder="">
                                @if($errors->has('opassword'))
                                    <div class="error" style="color: red;">{{ $errors->first('opassword') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" value="{{old('password')}}" placeholder="Enter New Password">
                                        @if($errors->has('password'))
                                    <div class="error" style="color: red;">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="cpassword">Re-enter Password</label>
                                        <input type="password" class="form-control" name="cpassword" value="{{old('cpassword')}}" placeholder="Re-Enter Password">
                                @if($errors->has('cpassword'))
                                    <div class="error" style="color: red;">{{ $errors->first('cpassword') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
