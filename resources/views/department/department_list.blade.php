<?php
 $page = 'department';
?>
@extends('layouts.main')

@section('content')

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
</style>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 prod_head">
            <h1>Quiz Department List</h1>
          </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Quiz Departments</li>
            </ol>
        </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{route('department.create')}}" class="btn btn-primary">Create Department</a>
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
                <h3 class="card-title">All Quiz Departments Listed Below</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SL.No.</th>
                    <th>Department Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php //echo "<pre>"; print_r($quiz); exit();?>
                  <?php $i = $department->perPage() * ($department->currentPage() - 1)?>
                      @foreach($department as $row)

                        <tr>
                          <td class='sn'>{{ ++$i }}</td>
                          <td class='title'>{{$row->department_name}}</td>
                          <td class='edit'><a href="{{route('department.edit', $row->id)}}"><i class='fas fa-pen'></a></a></td>
                          <td >
                            <form action="{{route('department.destroy', $row->id)}}" method="POST">

                            @csrf
                            @method('DELETE')
                              <input type="hidden" name="title" value="{{$row->department_name}}">
                              <button type="submit" class="" onclick="return confirm('Are you sure?')" id='{{$row->id}}' style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>
                            </form>
                          </td>
                        </tr>

                      @endforeach
                  </tbody>
                </table>


                <div class="table-footer pagination-alignment">
                    {{ $department->links() }}
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


@endsection
