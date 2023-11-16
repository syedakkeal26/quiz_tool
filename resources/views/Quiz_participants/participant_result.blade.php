<?php
 $page = 'result';
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
  input#search
  {
      margin-top: 28%;
  }
  a#clear{
    margin-top: 33%;
  }
  #customSwitches
  {
      width: 5%;
  }
  input[type="checkbox"]
  {
      width: 20%;
  }
  .online_participants {
    margin-left: 16%;
}
.quiz_button{
    border:none;padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border-radius: 4px;
  }
  form#myForm {
    margin-left: 51%;
}
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 prod_head">
                <h1>Quiz Result</h1>
            </div>
            <div class="col-sm-4 online_participants">


            <!-- Default switch -->
            <form method="GET" id="myForm" action="{{url('/result')}}">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="view_online" class="custom-control-input custom-switch-LG" id="customSwitches" value="{{Session('view_online') === 'on' ? 'off' : 'on'}}" {{Session('view_online') === 'on' ? 'checked' : ''}}>
                    <label class="custom-control-label" for="customSwitches"><h4>View Online</h4></label>
                </div>
            </form>

            </div>
        </div>
    </div>
</section>


  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member Search</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{url('/member_search')}}" method="GET">
                  <table id="example2" class="table table-bordered table-hover">
                    <tbody>
                        <?php

                        // if data 'search' posted in POST method, make it safe in HTML then store it in $search. If 'search' data was not posted, fill it with an empty string ('')
                        $name = (isset($_GET['name'])) ? htmlentities($_GET['name']) : '';
                        $title = (isset($_GET['title'])) ? htmlentities($_GET['title']) : '';
                        $email = (isset($_GET['email'])) ? htmlentities($_GET['email']) : '';
                        $mobile = (isset($_GET['mobile'])) ? htmlentities($_GET['mobile']) : '';
                        $date = (isset($_GET['date'])) ? htmlentities($_GET['date']) : '';


                        ?>
                      <tr>
                      <td class='name'><h5>Title</h5><input type="text" name="title" placeholder="Enter Title" class="form-control" value="<?= $title ?>">
                        <td class='name'><h5>Name</h5><input type="text" name="name" placeholder="Enter participant name" class="form-control" value="<?= $name ?>">
                            @if($errors->has('name'))
                            <div class="error" style="color: red;">{{ $errors->first('name') }}</div>
                            @endif
                        </td>
                        <td class='email'><h5>Email</h5><input type="email" name="email" placeholder="Enter participant email" class="form-control" value="<?= $email ?>"></td>
                        <td class='number'><h5>Mobile</h5><input type="text" name="mobile" placeholder="Enter Participant Mobile" class="form-control" value="<?= $mobile ?>">
                            @if($errors->has('mobile'))
                            <div class="error" style="color: red;">{{ $errors->first('mobile') }}</div>
                            @endif
                        </td>
                        <td class='date'><h5>Date</h5><input type="date" name="date" placeholder="participation date" class="form-control" value="<?= $date ?>"></td>
                        <td class='submit'><input type="submit" name="submit" class="btn btn-primary" id="search" value="Search"></td>
                        <td>
                            @if(Session::has('view_online'))
                            <a href="{{url('/result?view_online='.Session('view_online'))}}" class="btn btn-danger" id="clear">Clear</a>
                            @else
                            <a href="{{url('/result')}}" class="btn btn-danger" id="clear">Clear</a>
                            @endif

                        </td>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                @if ($data)
                <h3 class="card-title">Quiz Results Listed Below</h3>
              </div>
              <!-- /.card-header -->

                <div class="card-body">
                    <table id="result" class="table table-bordered table-hover">
                    <thead id="thead">
                    <tr>
                        <th>SL.No.</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Date & Time</th>
                        <th>Score</th>
                        <th>No Of que</th>
                        <!-- <th>Max Score</th> -->
                        <th>Views</th>
                        <th>Reset</th>
                    </tr>
                    </thead>

                        <tbody id="tbody">
                            <?php //echo "<pre>"; print_r($res); exit();?>
                            <?php $i = $data->perPage() * ($data->currentPage() - 1)?>
                            @if(count($data)>0)
                                @foreach($data as $key => $row)

                                    @php
                                        $pass_mark = $row['max_score']/2;
                                    
                        
                                    @endphp

                                    @php
                                  
                                    $maximum_time =$row['max_score']*2;
                                    $count5 = $row['score'] / $row['max_score'];
                                    $count6 = $count5 * 100;
                                    $count7 =ceil($count6);
                                    @endphp

                                    @if($row['score']>=$pass_mark)
                                    <tr>
                                        <td class='sn'>{{ ++$i }}</td>
                                        <td class='name'>{{$row['name']}}</td>
                                        <td class='email'>{{$row['department']}}</td>
                                        <td class='mobile'> {{$row['email']}}</td>
                                        <td class='minscore'> {{$row['mobile']}}</td>
                                        <td class='time'>{{$row['start_time']}}</td>
                                        <td class='minscore'> {{$count7}}</td>
                                        <td class='minscore'> {{$row['total_question']}}</td>
                                     
                                        <td class='view'><a href="{{route('view_report',$key)}}" target="_blank"><i class='fas fa-eye view_level' style="color: green;"></i></a></td>
                                        <td><a href="{{url('reset/'.$row['participant_id'].'/'.$row['id'])}}" >  <i class="fa fa-undo" aria-hidden="true"></i></a></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td class='sn'>{{ ++$i}}</td>
                                        <td class='name'>{{$row['name']}}</td>
                                        <td class='email'>{{$row['department']}}</td>
                                        <td class='mobile'> {{$row['email']}}</td>
                                        <td class='minscore'> {{$row['mobile']}}</td>
                                        <td class='time'>{{$row['start_time']}}</td>
                                        <td class='minscore'>{{$count7}}</td>
                                        <td class='minscore'> {{$row['total_question']}}</td>
                                        <td class='view'><a href="{{route('view_report',$key)}}" target="_blank"><i class='fas fa-eye view_level' style="color: green;" ></i></a></td>
                                        <td><a href="{{url('reset/'.$row['participant_id'].'/'.$row['id'])}}" >  <i class="fa fa-undo" aria-hidden="true"></i></a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>

                                <td colspan="10" style="text-align: center">{{'NO DATA FOUND'}}</td>

                                </tr>
                            @endif
                        </tbody>

                    </table>
                    <div class="table-footer pagination-alignment">
                        {{ $data->appends(request()->all())->links() }}
                    </div>
                    @endif


              @if ($live)
              <h3 class="card-title">Quiz Live Participants</h3>
            </div>


              <div class="card-body">
                <table class="table table-bordered table-hover live" >
                  <thead id="thead">
                  <tr>
                    <th>SL.No.</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Date & Time</th>
                   <th>View</th>
                  </tr>
                  </thead>
                  <tbody id="tbody">
                    <?php //echo "<pre>"; print_r($res); exit();?>

                  <?php $i = 0?>
                    @if(count($live)>0)
                       @foreach($live as $data)
                     

                          <tr>
                            <td class='sn'>{{ ++$i }}</td>
                            <td class='name'>{{$data->participator->name}}</td>
                            <td>{{ $data->title->title}}</td>
                            <td class='email'>{{$data->participator->email}}</td>
                            <td class='mobile'>{{$data->participator->Phone_no}} </td>
                            <td class='time'>{{$data->start_time}}</td>
                            <td class='view'><a href="{{url('view_online',$data->slug)}}"><i class='fas fa-eye' style="color:green;"></i></a></td>
                          </tr>
                        @endforeach
                        @else
                        <tr>

                            <td colspan="10" style="text-align: center">{{'NO DATA FOUND'}}</td>

                        </tr>

                    @endif
                  </tbody>
                </table>
            </div>

            <!-- /.card-body -->
                <div class="table-footer pagination-alignment">
                    {{ $live->appends(request()->all())->links() }}
                </div>
              </div>
              @endif
            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    <script type="text/javascript">

        $( document ).ready(function() {

        $("#customSwitches").change(function() {
               $("#myForm").submit();
        });
        });

        </script>
@endsection
