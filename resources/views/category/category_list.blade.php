<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')
{{-- <head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head> --}}

<style type="text/css">
  .redcol{
    color: red;
  }
  .greencol{
    color: #17a2b8;
  }
  #message{
    background-color: red;
    color: white;
    padding: 10px;
  }
  #filter
  {
      padding-top: 4%;
  }
  .filter-icon
  {
      cursor: pointer;
  }
  a.disabled {
  pointer-events: none;
  cursor: default;
}
.view
{
      cursor: pointer;
}
button.btn.btn-primary {
    margin-top: -40px;
}
a#clear{
 margin-top: -40px;
}
</style>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 prod_head">
            <h1>Quiz Category List</h1>
          </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Quiz Categories</li>
            </ol>
        </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{route('category.create')}}" class="btn btn-primary">Create Category</a>
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            {{-- <div class="card-header">
              <h3 class="card-title">Filter by Department & Category</h3>
            </div> --}}
            <!-- /.card-header -->
            <div class="card-body">

                <form action="{{route('category_filter')}}" method="GET">

                    <table id="example2" class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td class='dept_filter form-group'>
                                <h5>Department</h5>
                                <select name="department_filter" id="department" class="col-12 form-control">
                                    <option value="">--- Select Department ---</option>
                                    @foreach ($department as $data)
                                        <option value="{{$data->id}}" {{ request('department_filter') == $data->id ? 'selected' : ''}}>{{ $data->department_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class='category_filter form-group'>
                                <h5>Category</h5>
                                <select name="category_filter" class="col-12 form-control" id="category_filter">
                                    <option value="">--- Select Department First---</option>
                                    @foreach ($parent_category as $data)
                                        <option value="{{$data->id}}" {{ request('category_filter') == $data->id ? 'selected' : ''}}>{{ $data->category_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class='sub_category_filter form-group'>
                                <h5>Sub Category</h5>
                                <select name="sub_category_filter" class="col-12 form-control" id="sub_category_filter">
                                    <option value="">--- Select Category First---</option>
                                    @foreach ($sub_category as $data)
                                        <option value="{{$data->id}}" {{ request('sub_category_filter') == $data->id ? 'selected' : ''}}>{{ $data->category_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            {{-- <td class='submit' id="filter"><button type="submit" style="border: hidden; background-color: Transparent;"><i class='fas fa-filter fa-lg filter-icon' style="color: rgb(13, 70, 224); size: 15px;"></i></button> --}}
                            {{-- </td> --}}
                            <td class='submit' id="filter"><button type="submit" class="btn btn-primary">Search</button></td>
                            <td class='reset' id="filter"><a href="{{ url('/category') }}" class="btn btn-danger" id="clear">Clear</a></td>
                        </tr>


                    </tbody>
                    </table>
                </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
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

                </div>
                <div class="col-12">

                    @if(session('warning'))
                        <div class="alert alert-danger">
                        {{ session('warning') }}
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Quiz Categories Listed Below</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SL.No.</th>
                    <th>Department Name</th>
                    <th>Category Name</th>
                    <th>SubCategory Name</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php //echo "<pre>"; print_r($quiz); exit();?>
                  <?php $i = $category->perPage() * ($category->currentPage() - 1)?>
                      @foreach($category as $row)

                        <tr>
                          <td class='sn'>{{ ++$i }}</td>
                          <td class='title'>{{$row->department->department_name}}</td>

                          <td class='category_name'>
                            @if($row->parent_id==null)
                            {{$row->category_name}}
                            @else
                                @foreach($parent_category as $parent)
                                    @if($parent->id == $row->parent_id)
                                        {{$parent ->category_name}}
                                    @endif
                                @endforeach
                            @endif
                          </td>
                          <td class='subcategory_name'>
                            @if($row->parent_id !=null)
                            {{$row->category_name}}
                            @else
                            None
                          @endif
                        </td>
                        @if($row->parent_id !=null)
                            <td class='view'><i class='fas fa-eye view_level' style="color: green;" ><input type='hidden' class="cid" value="{{$row->id}}">
                            </i></td>
                        @else
                        <td class='view1'><p  data-toggle="tooltip" data-placement="top" title="Won't have question " ><i class='fa fa-eye-slash' style="color:brown;" class="disabled"></i></p></td>
                        @endif
                          <td class='edit'><a href="{{route('category.edit', $row->id)}}"><i class='fas fa-pen'></i></a></td>
                          <td >
                            <form action="{{route('category.destroy', $row->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                              <input type="hidden" name="title" value="{{$row->category_name}}">
                              <button type="submit" onclick="return confirm('Are you sure?')" id='{{$row->id}}' style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>
                            </form>
                          </td>
                        </tr>

                      @endforeach
                  </tbody>
                </table>

                <div class="table-footer pagination-alignment">
                    {{  $category->appends($_GET)->links() }}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>


{{-- -----------Model popup for  level View in category page --}}

                
<div class="modal quesview" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Level List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
		<select name="select_level" class="col-12 form-control select_level" id="select_level">
        </select>
          <span style="color:red;display:none;" class="list_error">Select category</span>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info submit">View</button>
      </div>
    </div>
  </div>
</div>
{{-- ------------------------------------------------------------ --}}


<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip()

    // ------------------ View icon button in category page------------------
    $('.view_level').on('click', function() {
        var catid = $(this).find('.cid').val();
        if(catid) {
            $.ajax({
                url: "{{ url('get_level_list') }}",
                data:{catid},
                type: "post",
                dataType: "json",
                success:function(data) {
                    $('.quesview').modal('show');
                    $('.list_error').css('display','none');
                    $('select[name="select_level"]').empty();
                    $('select[name="select_level"]').append('<option value="">---Select Category--</option>');
                        $.each(data.get_level,function(index,get_level){
                            $('select[name="select_level"]').append('<option value="'+index+'">' + get_level + '</option>');
                    });
                }
            });
        }
    });

    // ------------------ Model popup for submit button in category page------------------
    $(document).on('click','.submit',function() {
        var id=$(this).closest('.modal-content').find('.select_level').val();
    if(id){
     url ="{{ url('list') }}/" + id;
     window.location.href = url;
    }else{
    $('.list_error').css('display','block');
    }
    });



// DROPDOWN CALL USING AJAX
// Fill Category value
    $('#department').on('change', function() {
        var deptID = $(this).val();
        if(deptID) {
            $.ajax({
                url: "{{ url('get_category') }}",
                data: {deptID},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="category_filter"]').empty();
                    $('select[name="category_filter"]').append('<option value="">---Select Category--</option>');
                    $.each(data.categories, function(id,category) {
                        $('select[name="category_filter"]').append('<option value="'+category.id+'">'+ category.category_name +'</option>');
                    });
                }
            });
        }
    });
// Fill Sub-Category value
    $('#category_filter').on('change', function() {
        var cateID = $(this).val();
        if(cateID) {
            $.ajax({
                url: "{{ url('get_sub_category') }}",
                data: {cateID},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="sub_category_filter"]').empty();
                    $('select[name="sub_category_filter"]').append('<option value="">---Select Sub Category--</option>');
                    $.each(data.categories, function(id,category) {
                        $('select[name="sub_category_filter"]').append('<option value="'+category.id+'">'+ category.category_name +'</option>');
                    });
                }
            });
        }
    });

// Fill Level value
$('#sub_category_filter').on('change', function() {
        var subCateID = $(this).val();
        if(subCateID) {
            $.ajax({
                url: "{{ url('get_level') }}",
                data: {subCateID},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="level_filter"]').empty();
                    $('select[name="level_filter"]').append('<option value="">---Select Level--</option>');
                    $.each(data.level, function(id,level) {
                        $('select[name="level_filter"]').append('<option value="'+level.level+'">'+ level.level +'</option>');
                    });
                }
            });
        }
    });
});
</script>

@endsection
