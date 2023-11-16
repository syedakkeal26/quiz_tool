<?php
 $page = 'category';
?>
@extends('layouts.main')

@section('content')
<style type="text/css">
  .table th,.table td{
        border-top: none !important;
        text-align: left;
  }
  .rigth{
    float:right;
  }
  .table thead th{
    border-bottom: none;
  }
</style>
<div class="container-fluid">
      <div class="row">

        <div>

            @if (Session::has('message'))

            <div class='popup_2'>
              <div id = 'main_popup_2'>
                <div id='mssg_popup_2'>

                  <p class='but'><button class='hide_popup_2 hide_popup' id='cancel'><label>X</label></button></p>
                  <h3 class='success'>{{ Session::get('message') }}</h3>

                </div>
              </div>
            </div>

          @endif

        </div>
      </div>
   </div>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 prod_head">
            <h1>Quiz Question View</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Q&A list</a></li>
              <li class="breadcrumb-item active">Question view</li>
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Quiz Question with Options and Answer</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <table id="example2" class="table">
                  <tbody>
                  @php
                        $i= 0;
                        $answer = "";
                      @endphp
                  @foreach($new_quiz_view as $key => $rows)
                    @foreach($rows as $row)
                      @if($key == "answer")
                        @php
                          $answer = $row
                        @endphp
                      @endif
                    @endforeach
                  @endforeach
                  {{-- {{$answer}} --}}
                  @foreach($new_quiz_view as $key => $rows)
                  @foreach($rows as $row)

                  @if(($key != "answer") && ($key != "option"))
                    <tr>
                        <th style="font-size: 20px;text-transform: capitalize;"><h3>{{$key}}</h3></th>
                        <td style="font-size: 20px;"> > </td>
                        <td class='{{$key}}'><h3>{{$row}}</h3></td>
                    </tr>
                  @endif

                      @if(($key == "option"))
                      @php

                        $i++;
                      @endphp
                      @if($answer == $row)

                        <tr>
                          <th style="font-size: 20px;text-transform: capitalize;">{{$key}}_{{$i}}</th>
                          <td style="font-size: 20px;"> > </td>
                           <td class='addres '><span class="alert alert-success">{{$row}}</span> </td>

                        </tr>
                        @else
                          <tr>
                              <th style="font-size: 20px;text-transform: capitalize;">{{$key}}_{{$i}}</th>
                              <td style="font-size: 20px;"> > </td>
                              <td class='{{$key}}'>{{$row}}</td>
                          </tr>
                        @endif

                     @endif

                   @endforeach
                @endforeach
                  </tbody>
                </table>



               {{--<form action="{{url('customer',$row->customer_id)}}" method="put">
                                                 @csrf

                                                   <input type="submit" name="submit" value="Complete" class="btn btn-success rigth">
                                                 </form>--}}

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
    <!-- Delete popup -->

    {{--<div class="popup_1">

            <div id = "main_popup">
              <div id="event_popup_1">
                <h3>Delete Conformation</h3>
                <p>Are You Sure to delete the product</p>
                <button type="button" class="hide_popup_1 hide_popup" id="yes"><label>Yes</label></button>
                <button class="hide_popup_1 hide_popup" id="no"><label>No, Thanks</label></button>
              </div>
            </div>
          </div>--}}


  </div>
 {{-- <?php

    $deleteid = isset($_GET['uid'])?$_GET['uid']:"";

    //echo $deleteid;

    $sql = "DELETE from event_tb WHERE event_id = $deleteid";

    if(mysqli_query($con, $sql)){

      header('Location: ?message=Product deleted successfully...');
    }

  ?>

  <?php

    include '../includepages/footer.php';
  ?> --}}



@endsection
