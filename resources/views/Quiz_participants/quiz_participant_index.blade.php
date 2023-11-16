<?php
$page="";
?>
@extends('layouts.main')
@section('content')
<script>
    var myHeaders = new Headers();
myHeaders.append('pragma', 'no-cache');
myHeaders.append('cache-control', 'no-cache');
var url = '{{ url('/') }}';
var myInit = {
  method: 'GET',
  headers: myHeaders,
};
    fetch(url+'/check-started',myInit)
    .then((data) => {
      return data.json()

    })
    .then((data) => {
        if(data.started=='started'){
            window.location.href='{{ route('test_start') }}'
        }
    })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- @if (Session::has('started'))
{{ Redirect::to('/test_start') }}

@endif --}}
{{-- @if(Cookie::get('id1')==="")

  {{ Redirect::to('/finish') }}

@endif --}}
<style>
    li.list {
    margin-top: 34px;
    margin-bottom: 21px;
    font-size: 18px;
}
.set{
    font-weight: bolder;
    font-size: 27px;
   line-height: 0.5;
}
footer.main-footer {
    font-size: 20px;
}
.rules {
    margin-top: 46px;
}
.but {
    margin-left: 44%;
    margin-top: 3%;
}

.category {
    background: #494e53;
    color: #fff;
    padding: 1rem;
    width: 100%;
    max-width: 75%;
    /* margin: 1rem auto 0 5rem; */
    border-radius: 14px;
    box-shadow: 0px 0px 10px #5e5e5e;
    margin-left: 15%;
    text-align: center;
}
.cate-cont h6 {
    font-weight: 700;
    letter-spacing: 1px;
    font-size: 20px;
}
.category span{
    color: #fff2df;
}
.ins{
    font-size: 25px;
}
p.list.ins {
    font-size: 35px;
    text-transform: uppercase;
    font-weight: 600;
    color: #0080fff2;
    margin: 0;
    margin-bottom: -20px;
    margin-top: 15px;
}
ul.list-group {
    list-style-type: circle;
    color: #ca2121e0;
}
.rules {
    width: 100%;
    max-width: 90%;
    margin: auto;
}
.dis{
    display: none;
    margin-left: 20%;
    font-size: 30px;
    text-transform: uppercase;
    font-weight: 600;
    color: #41be10f2;
    /* margin: 0; */
}
.instruction{
    width: 100%;
    max-width: 100%;
}
</style>
<input type="hidden" name="audio_status" id="audio_status" value="{{Session::get('audio_status')}}">
<div class="row">
<div class="category mt-3">


            <div class="col-lg-12 cate-cont"><h6>Title:<span> {{Str::upper($title)}}</span></h6> </div>
            {{-- <div class="col-lg-4 cate-cont"><h6>CATEGORY:</h6> <span>{{Str::upper($participator->quiz_main->category->category_name)}}</span></div> --}}
            {{-- <div class="col-lg-4 cate-cont"><h6>LEVEL:</h6><span> {{Str::upper($participator->quiz_main->category->level)}}</span></div> --}}
        </div>
    </div>
<div class="container instruction">


    <div class="row">
        <div class="rules">
            <p class="list ins">Instructions for the test</li>
                <b class="set">
                <ul class="list-group">

                <li class="list">The duration of the test will be {{$time}} mins. The test ends exactly at {{$time}} min.</li>
                <li class="list">Please ensure that you have proper network connectivity and power back up.</li>
                <li class="list">Please use paper and pen for rough works. If you are switching tabs, it will end your test.</li>
                <li class="list">No tolerance for malpractice during the test. It will lead to an immediate disqualification of the candidate.</li>
                <li class="list">Switching to new TAB will leads to end up the Test.</li>
                <li class="list">Screen will be monitored once the test gets started.</li>
                <li class="list">Please Join call after starting the Test</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <p class="dis">PLEASE WEAR HEADSET AND ENABLE MIKE </p>
        </div>
            <a class="btn btn-info but mb-3" id="Timer" title="Read Instructions"> Please wait for 30 seconds</a>
</div>

<script>
    var audio_status=document.getElementById('audio_status').value;
    if(audio_status=='enable')
    {
        document.onkeydown = function (e)
                {
                e.preventDefault();
                return false;
                }
            navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(stream) {
                console.log('You let me use your mic!')
                $(".but").removeClass('disabled')
            })
            .catch(function(err) {
                $(".but").addClass('disabled');
                $(".dis").css("display", "block");

                console.log('No mic for you!')
            });
    }
    </script>

    
    <script>
    var timeLeft = 30;
var elem = document.getElementById('Timer');

var timerId = setInterval(countdown, 1000);

function countdown() {
  if (timeLeft == 0) {
  var base_url = window.location.origin;
  var url=base_url+"/public/test_start";
  $("#Timer").attr("href", url).text('START').attr('title','Click To Start');
    clearTimeout(timerId);
    doSomething();
  } else {
    elem.innerHTML = 'Please wait for '+ timeLeft + ' seconds ';
    timeLeft--;
  }
}
    </script>
@endsection
