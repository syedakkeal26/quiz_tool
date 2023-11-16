<?php
 $page = 'import';
?>
@extends('layouts.main')

@section('content')
<style type="text/css">

  .success{
    background-color: green;
    color: white;
    padding: 10px;
  }
  .card.card-primary .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-body::after, .card-footer::after, .card-header::after {
    display: none;
}

</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quiz Import</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Quiz Import</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
<div class="container-fluid">
      <div class="row">

        <div class="col-12">

            @if (Session::has('message'))

            <div class='card'>
              <div id = 'message'>


                  {{--<p class='but'><button class='hide_popup_2 hide_popup' id='cancel'><label>X</label></button></p>--}}
                  <h3 class='success'>{{ Session::get('message') }}</h3>

              </div>
            </div>
          @endif
          @if (is_array(Session::get('skip')) || is_object(Session::get('skip')))
          <p style="background-color:red;height:30px;color:white;"><b>Repeated Questions We have Skipped</b></p>
          @foreach(Session::get('skip') as $link)
          <h5 class='p-1 mb-1 bg-warning text-dark'>{{$link}}</h5>
          {{Session::flash('skip')}}
         @endforeach
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

                    {{-- SAMPLE EXCEL SHEET VIEW PAGE BUTTON --}}
                        <h3 class="card-title">Quiz File Import</h3>
                    <a href="{{ asset('assets/sample_sheet/sample quiz.xlsx') }}" open class="btn btn-danger sample" target="_blank" id="sample_sheet" >Sample File</a>
              </div>
              <!-- /.card-header -->
              {{-- @echo $_SESSION['skip']['question']; --}}
              <!-- form start -->
              <form  method="POST" action="{{ url('/home') }}"  enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">Import Here!</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="quiz_import">

                        @if(Session::has('failed'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{Session::get('failed')}}
                            </div>
                        @endif
                        <p class="err" id="fileerr"></p>
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit" id="submit">Import</button>
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
