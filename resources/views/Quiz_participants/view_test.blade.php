<?php
$page="result";
?>
@extends('layouts.main')

@section('content')
<style>
    .iframe
         {
            position: absolute;
            /* top: 62px; */
            left: 149px;
            width: 74%;
            height: 150%;
            border: 1px solid black;
        }
        iframe#main {
    height: 99%;
    width: 99%;
}
.back-btn
{
    margin-left: 111%;
}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Participant Details</h1>
          </div>
          <div class="col-sm-4">
            <a href="{{ url()->previous() }}" class="btn btn-primary back-btn">Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card" style="padding-bottom: 15%;">
        <div class="card-header">
          <h3 class="card-title">Participant Details</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-6" style="margin-top: 5%;">

                <h4>Name:{{$details->participator->name}}</h4>
                {{-- <h4>Department:{{$details->quiz_main->department->department_name}}</h4> --}}
                <h4>Email:{{$details->participator->email}}</h4>
                <h4>Mobile:{{$details->participator->Phone_no}}</h4>

            </div>
            <div class="col-6">
                <div class="iframe" >
                    <iframe name="main" id="main" src="{{route('test_video',$details->id)}}" scrolling="no" frameborder="0" ></iframe>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
    </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->



@endsection
