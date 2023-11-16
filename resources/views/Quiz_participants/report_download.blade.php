<?php
 $page = 'download';
?>
@extends('layouts.main')

@section('content')
<!-- include bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<style>

@media (min-width: 768px){

    .content-wrapper{
    margin-left: none!important;
}
}

.logo img{
max-width: 160px;
float: right;
}
.totalscore{
    float: right;
}
.cattitle{
    font-size: 21px;
    font-weight: bold;
    text-transform: uppercase;

}
h4{
    font-size: 20px;
}
h2,h3{
    font-size: 23px;
}
h5{
  font-size: 18px;
}


</style>
<br>
<section class="content">
    <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">

          <!-- /.card-header -->
          <div class="card-body asset">
              <div class="float-left" style="width:50%;margin-top:2%;">
                <h2 style="text-transform: uppercase;">{{$asset[0]->title}} Test Report</h2>
              </div>
                <div class="logo float-right">
                <img src="{{  asset('assets/images/logo1.png') }}" alt="" >
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
</section>

<section class="content ">
    <div class="container-fluid">
    <div class="row ">
      <div class="col-12 ">
          <!-- /.card-header -->
          <div class="card-body name">
            @foreach ($linkgen as $name )
            <?php
            $maximum_time =$asset[0]->total_questions*2;
            $count5 = $score / $maxscore;
            $count6 = $count5 * 100;
            $count7 =ceil($count6);

            ?>
              <div style="float: left;width: 70%;">
                    <h5>Passed by: <b>{{$name->participator->name}}</b></h5>
                    <h5>Email: <b>{{$name->participator->email}}</b></h5>
                    <h5>Total Time:<b> {{$maximum_time}} mins</b></h5>
                    <h5>Time Taken:<b> {{$taken_time}}</b></h5>
                    <h5>Number of Questions :<b>{{$asset[0]->total_questions}} </b></h5>
                    <div class="" style="margin-top: 40px">
                        <h2 class="">Details :</h2>
                    </div>
              </div>
             <div class="card totalscore" style="width: 10rem;text-align:center;height: 125px">
                <div style="padding: 0; margin:0%" class="">
                  <h6 class="">Total Score</h6>
                  <p class="" style="font-size: 35px">{{$count7}}/100 <span id="t_score"></span></p>
                  @if($count6<=20)     
                   <h5><span id="badge" class="badge badge-danger">Below Average</span></h5>
                   @elseif($count6<=40)
                   <h5><span id="badge" class="badge" style="background-color:#FFA726;">Average</span></h5>
                   @elseif($count6<=50)
                   <h5><span id="badge" class="badge badge-warning">Above Average</span></h5>
                   @elseif($count6<=70)
                   <h5><span id="badge" class="badge badge-success">Good</span></h5>
                   @elseif($count6>=71)
                   <h5><span id="badge" class="badge" style="background-color:#358f4c;color:#fff">Excellent</span></h5>
                    @endif
                </div>
              </div>
              @endforeach
          </div>
          <hr style="margin-top: 0rem;margin-bottom: 1rem;">
          <!-- /.card-header -->
          <!-- /.card-body -->
        {{-- </div> --}}
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</section>


<section class="content">
    <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        @foreach($category as $key => $quiz)
        <div class="card">
          <div class="card-header" style="background-color:#f8f9fa">

                    <?php
                    $result_score2=0;
                    $result_maxscore2=0;
                    ?>
                        @foreach($sections as $key7 => $section1)
                        <?php
                        $result_score1=0;
                        $result_maxscore1=0;
                        $count3=0;

                        $questions1= \App\Models\quiz_participant::where('quiz_main_id',$section1->quiz_main_id)
                                                                    ->where('linkgen_id',$id)->get();
                        ?>

                        @foreach($questions1 as $key6 => $ques1)
                            <?php
                                $result_score1 = $result_score1 + $ques1->score;
                                $result_maxscore1 = $result_maxscore1 + $ques1->max_score;
                            ?>
                        @endforeach

                            @foreach($section1->quiz_main as $key8 => $quiz_main1)
                                @if(\App\Models\Category::where('id',$quiz_main1->category_id)
                                ->where('parent_id',$quiz[0]['id'])->value('category_name'))
                                    <?php
                                         $result_score2 = $result_score2 + $result_score1;
                                         $result_maxscore2 = $result_maxscore2 + $result_maxscore1;
                                    ?>
                                    @endif
                            @endforeach
                        @endforeach
                            <?php
                                $count3 = $result_score2 / $result_maxscore2;
                                $count44 = $count3 * 100;
                                $count4 = ceil($count44);
                            ?>
                             <div class="col-5 card-title">
                                <h3 style="float: left; font-size:22px;" class="cattitle">{{$quiz[0]['category_name']}}</h3>
                                <span style="float: left; margin-left:10px;margin-top: 7px;" class="badge badge-secondary">score:{{$count4}}/100</span>
                            </div>

                             @if($count4 >= 60 )
                             <div class="progress" style="height: 25px;"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$count4}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$count4}}%</div></div>
                             @elseif($count4 >= 40)
                             <div class="progress " style="height: 25px;"><div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{$count4}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$count4}}%</div></div>
                             @elseif($count4 < 40)
                             <div class="progress " style="height: 25px;"><div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{$count4}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$count4}}%</div></div>
                             @endif

          </div>

          <!-- /.card-header -->
          <div class="card-body">
            @foreach($sections as $key3 => $section)
                <?php
                $result_score=0;
                $result_maxscore=0;?>
                <?php
                 $questions= \App\Models\quiz_participant::where('quiz_main_id',$section->quiz_main_id)
                                                            ->where('linkgen_id',$id)->get();
                ?>
                    @foreach($questions as $key4 => $ques)
                        <?php
                            $result_score = $result_score + $ques->score;
                            $result_maxscore = $result_maxscore + $ques->max_score;
                        ?>
                    @endforeach
                         <?php
                            $count1 = $result_score / $result_maxscore;
                            $count22 = $count1 * 100;
                            $count2 = ceil($count22);
                         ?>
                    @foreach($section->quiz_main as $key5 => $quiz_main)
                        <div class="row">
                            @if(\App\Models\Category::where('id',$quiz_main->category_id)
                                ->where('parent_id',$quiz[0]['id'])->value('category_name'))
                                <div class="col-6"> <h4>{{$quiz_main->category->category_name}}</h4> </div>
                                <div class="col-6">
                                    @if($count2 >= 60 )
                                    <div class="progress "><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$count2}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$count2}}%</div></div>
                                    @elseif($count2 >= 40)
                                    <div class="progress "><div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{$count2}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$count2}}%</div></div>
                                    @elseif($count2 < 40)
                                    <div class="progress "><div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{$count2}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$count2}}%</div></div>
                                    @endif
                                </div>
                                @endif
                        </div>
                    @endforeach
            @endforeach
          </div>
          <!-- /.card-body -->
        </div>
        @endforeach
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>

</section>

@endsection

