<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Edit Category</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/category')}}">Quiz Categories</a></li>
              <li class="breadcrumb-item">Edit Category</li>

            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/category')}}" class="btn btn-primary">Back</a>
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
                        <h3 class="card-title">Edit Quiz Category</h3>
                    </div>
                     <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{route('category.update', $category->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="department_id">Department Name</label>
                                        {{-- <select name="department_id" id="department" class="col-12 form-control">
                                            <option value="">--- Select Department ---</option>
                                            @foreach ($department as $data)
                                                <option value="{{$data->id}}" @if($data->id==$category->department_id) selected='selected' @endif>{{ $data->department_name }}</option>
                                            @endforeach
                                        </select> --}}
                                        @foreach ($department as $data)
                                            @if($data->id==$category->department_id)
                                                <input type="text" class="form-control" name="department" value="{{ $data->department_name }}" placeholder="" disabled>
                                                <input type="hidden" class="form-control" name="department_id" value="{{$data->id}}" placeholder="">
                                            @endif
                                        @endforeach
                                        @if($errors->has('department_id'))
                                            <div class="error" style="color: red;">{{ $errors->first('department_id') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        @if ($category->parent_id!=null)
                                            @foreach($parent_category as $parent)
                                            @if($parent->id == $category->parent_id)
                                                <input type="text" class="form-control" name="category_name" value="{{$parent->category_name}}" placeholder="Enter Category Name" disabled>
                                            @endif
                                            @endforeach
                                        @else
                                            <input type="text" class="form-control" name="category_name" value="{{$category->category_name}}" placeholder="Enter Category Name">
                                        @endif
                                        @if($errors->has('category_name'))
                                        <div class="error" style="color: red;">{{ $errors->first('category_name') }}</div>
                                        @endif
                                    </div>
                                    @if($category->parent_id != null)
                                        <div class="form-group">
                                            <label for="category_name">Subcategory Name</label>
                                            <input type="text" class="form-control" name="subcategory_name" value="{{$category->category_name}}" placeholder="Enter Subcategory Name">
                                            @if($errors->has('subcategory_name'))
                                                <div class="error" style="color: red;">{{ $errors->first('subcategory_name') }}</div>
                                            @endif
                                        </div>
                                    @endif
                                    {{-- <div class="form-group">
                                        <label for="level">Level</label>
                                        <select name="level" id="level_filter" class="col-12 form-control">
                                            <option value="">--- Select Level ---</option>
                                            <option value="Common" {{ $category->level == 'Common' ? 'selected':'' }}>Common</option>
                                            <option value="Beginner" {{ $category->level == 'Beginner' ? 'selected':'' }}>Beginner</option>
                                            <option value="Intermediate" {{ $category->level == 'Intermediate' ? 'selected':'' }}>Intermediate</option>
                                            <option value="Expert" {{ $category->level == 'Expert' ? 'selected':'' }}>Expert</option>
                                        </select>
                                        @if($errors->has('level'))
                                        <div class="error" style="color: red;">{{ $errors->first('level') }}</div>
                                        @endif
                                    </div> --}}



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
