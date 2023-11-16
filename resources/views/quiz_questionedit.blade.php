<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')

  <style type="text/css">

  #message{
    background-color: green;
    color: white;
    padding: 10px;
  }
</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quiz Question Edit</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Q&A list</a></li>
              <li class="breadcrumb-item active">Question Edit</li>
            </ol>
          </div>
          <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/list',$id->quiz_id) }}" class="btn btn-primary">Back</a>
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
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quiz Question Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @php
                $i= 0;
                $answer_key = 0;
                $question_id = 0;
                $options_id = "";
              @endphp
              @foreach($new_quiz_edit as $keys => $rows)
                    @foreach($rows as $key => $row)
                      @if($keys == "answer")
                        @php
                        $answer_key = $key;
                        @endphp
                      @endif
                      @if($keys == "question")
                        @php
                        $question_id = $key;
                        @endphp
                      @endif
                      @if($keys == "option")
                        @php
                        $options_id .= $key;
                        $options_id .= "_";

                        @endphp

                      @endif
                    @endforeach
                  @endforeach
              <form  method="POST" action="{{url('/home/'.$options_id)}}"  enctype="multipart/form-data">
              @method('PUT')
              @csrf
                  <table id="example2" class="table">
                  <tbody>


                  @foreach($new_quiz_edit as $keys => $rows)


                  @foreach($rows as $key => $row)

                  @if(($keys != "answer") && ($keys != "option"))
                    <tr>
                        <th style="font-size: 20px;text-transform: capitalize;">{{$keys}}</th>
                        <input type="hidden" name="question" value="{{$key}}">
                        <th class='{{$key}}' ><h2>{{$row}}</h2></th>
                    </tr>
                  @endif

                      @if(($keys == "option"))
                          @if($i==0)
                          <tr style="background-color: #00ff5e61;">
                            <th style="font-size: 20px;text-transform: capitalize;te">Options</th>

                            <th style="font-size: 20px;text-transform: capitalize;">Answer</th>
                        </tr>
                        @endif
                        @php

                          $i++;
                        @endphp

                      @if($key == $answer_key)


                        <tr>


                           <div class="form-group">

                              <td><input type="text" class="form-control" name="{{$keys}}_{{$key}}" value="{{$row}}"></td>
                              <td><input type="radio" class="form-control" name="answer" value="{{$key}}" <?="checked"?>></td>
                              <p class="err" id="{{$keys}}_{{$key}}"></p>
                            </div>

                        </tr>
                        @else
                          <tr>
                              <div class="form-group">

                              <td ><input type="text" class="form-control" name="{{$keys}}_{{$key}}" value="{{$row}}"></td>
                              <td><input type="radio" class="form-control" name="answer" value="{{$key}}"></td>
                              <p class="err" id="{{$keys}}_{{$key}}"></p>
                            </div>
                          </tr>
                        @endif

                     @endif

                   @endforeach
                @endforeach
                  </tbody>
                </table>
                  <div style="text-align: center;margin-bottom: 20px;"><button type="submit" class="btn btn-primary" name="submit" id="submit" >Update</button></div>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      @if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
    </section>



@endsection
