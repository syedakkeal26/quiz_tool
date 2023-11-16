<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Create Category</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/category') }}">Quiz Categories</a></li>
              <li class="breadcrumb-item">Create Category</li>

            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/category') }}" class="btn btn-primary">Back</a>
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

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Quiz Category</h3>
                    </div>
                     <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="department">Department Name</label>
                                        <select name="department" id="department" class="col-12 form-control">
                                            <option value="">--- Select Department ---</option>
                                            @foreach ($department as $data)
                                            <option value="{{$data->id}}">{{ $data->department_name }}</option>
                                        @endforeach
                                        </select>
                                        @if($errors->has('department'))
                                        <div class="error" style="color: red;">{{ $errors->first('department') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" placeholder="Enter Category Name">
                                        @if($errors->has('category_name'))
                                        <div class="error" style="color: red;">{{ $errors->first('category_name') }}</div>
                                    @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="parent_name">Parent Name</label>
                                        <select name="parent_name" id="parent_name" class="col-12 form-control">
                                            <option value="">--- Select Parent ---</option>
                                            @foreach ($parent_category as $parent)
                                                <option value="{{$parent->id}}">{{$parent->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="level">Level</label>
                                        <select name="level" id="level_filter" class="col-12 form-control">
                                            <option value="">--- Select Level ---</option>
                                            <option value="Common">Common</option>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Expert">Expert</option>
                                        </select>
                                        @if($errors->has('level'))
                                        <div class="error" style="color: red;">{{ $errors->first('level') }}</div>
                                    @endif
                                    </div> --}}



                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection
