<?php
 $page = 'participant';
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
            <h1>Participant List </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Quiz Participants</li>
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
                <h3 class="card-title">All Participant Listed Below</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SL.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone_No</th>
                    <th>View</th>
                    {{-- <th>Delete</th> --}}
                  </tr>
                  </thead>
                  <tbody>
                  <?php //echo "<pre>"; print_r($quiz); exit();?>
                  <?php
                   $i = $participant_list->perPage() * ($participant_list->currentPage() - 1)
                    ?>
                      @foreach($participant_list as $row)

                        <tr>
                          <td class='sn'>{{ ++$i }}</td>
                          <td class='title'>{{$row->name}}</td>
                          <td class='email'>{{$row->email}}</td>
                          <td class='mobile'>{{$row->Phone_no}}</td>
                          <td class='view'><a href="{{ url('/member_search?name=&email=&mobile='.$row->Phone_no.'&date=&submit=Search') }}"><i class='fas fa-eye'></a></td>
                          {{-- <td >
                            <form action="" method="POST">

                            @csrf
                            @method('DELETE')

                                <input type="hidden" name="title" value="">
                                <button type="submit"  onclick="return confirm('Are you sure?')" id='' style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>

                            </form>
                          </td> --}}
                        </tr>

                      @endforeach
                  </tbody>
                </table>
                <div class="table-footer pagination-alignment">
                    {{ $participant_list->links() }}
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
