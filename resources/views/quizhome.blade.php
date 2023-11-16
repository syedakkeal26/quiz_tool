<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')
 <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
        toastr.success("{{ session('message') }}");
  @endif
  </script>
  {{Session::forget('message')}}
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
            <h1>Quiz Q&A List</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Q&A list</li>
            </ol>
          </div>
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                  <a href="{{url('/category')}}" class='btn btn-primary'> Back</a>
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
                <h3 class="card-title">Quiz Questions Listed Below</h3>
                 <div style="float:right">
                        @php
                        $dummy1=1;
                        $dummy2=2;
                        @endphp
                 <a href="{{ url('/archive_question/'.$dummy1.'/'.$quiz_id) }}"><button class="btn btn-info">ARCHIVE</button></a> 

                 <a href="{{ url('/archive_question/'.$dummy2.'/'.$quiz_id) }}"><button class="btn btn-danger">GET ALL</button></a>
                 </div>
                        
              </div>
                        
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SL.No.</th>
                    <th>Department</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Score</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php //echo "<pre>"; print_r($quiz); exit();?>
                    <?php $i = $quiz->perPage() * ($quiz->currentPage() - 1)?>

                      @foreach($quiz as $row)

                        <tr>
                          <td class='sn'>{{ ++$i}}</td>
                          <td class='title'>{{$row->department->department_name}}</td>
                          <td class='question'>{{$row->question}}</td>
                          <td class='opt_ans'>{{$row->option}}</td>
                          <td class='minscore'>{{$row->score}}</td>
                          <td class='view'><a href="{{ url('/question_view',$row->question_id) }}"><i class='fas fa-eye' style="color: green;"></i></a></td>
                          <td class='edit'><a href="{{ url('/question_edit',$row->question_id) }}"><i class='fas fa-pen'></a></a></td>
                          <td >
                            <form action="{{ route('home.destroy',$row->question_id) }}" id="delete_quiz_{{$row->question_id}}" method="POST">

                            @csrf
                            @method('DELETE')
                              <input type="hidden" name="quiz_id" value="{{$row->quiz_id}}">
                              <input type="hidden" name="dept" value="{{$row->department->department_name}}">
                              <button type="submit" class="" onclick="return confirm('Are you sure?')" id='{{$row->question_id}}' style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>


                <div class="table-footer pagination-alignment">
                    {{ $quiz->links() }}
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
