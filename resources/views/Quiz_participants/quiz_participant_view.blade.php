<?php
$page = '';
?>
@extends('layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/stackoverflow.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/materia/bootstrap.min.css"
        rel="stylesheet">
    <script src="{{ asset('assets/dist/js/script.js') }}"></script>

    {{-- @if (Cookie::get('id1') === '')
  {{ Redirect::to('/finished') }}
@endif --}}

    <style type="text/css">
        .table th,
        .table td {
            border-top: none !important;
            text-align: left;
        }

        .rigth {
            float: right;
        }

        .table thead th {
            border-bottom: none;
        }

        .quiz_button {
            border: none;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
        }

        .button_color {
            background-color: green;
        }

        .jst-timeout {
            color: red
        }

        div.countdown-bar {
            width: 0;
            height: 20px;
            margin-bottom: 40px;
            border: 1px solid rgb(233, 8, 8);
            background-color: rgba(189, 184, 184, 0.788);
            border-radius: 3px;
            margin-left: 34%;
        }

        /* Loader */
        div.countdown-bar div:nth-of-type(1) {
            width: 0;
            height: 100%
        }

        /* Timer */
        div.countdown-bar div:nth-of-type(2) {
            width: 100%;
            height: 100%
        }

        #blink {
            margin-top: 19px;
            font-size: 12px;
            font-weight: bold;
            font-family: sans-serif;
        }

        .fa-solid {
            color: red;
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 22px;
        }

        #blink img {
            width: 18%;
            vertical-align: middle;
            border-style: none;
            margin-top: -7px;
            margin-left: -5px;
        }

        div#countdownA {
            margin-left: 29%;
        }

        .iframe {
            position: absolute;
            top: 62px;
            left: 149px;
            width: 74%;
            height: 78%;
            border: 1px solid black;
        }

        iframe#main {
            height: 99%;
            width: 99%;
        }

        .arrowbtn {
            padding: 3px;
        }

        .container {
            width: 100%;
            /* border:1px solid #d3d3d3; */
            /* text-align: center; */
        }

        .container div {
            width: 100%;
        }

        .container .header {
            background-color: #d3d3d3;
            padding: 2px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-left: 45px;
            text-align: center;
        }

        .container .content {
            display: block;
            /* padding : 5px;
                margin-top: -76%; */
            /* margin-top: -76%; */
            position: absolute;
            bottom: 18px;
            left: 45px;
        }

        .option-heading:before {
            content: "\25bc";
        }

        .option-heading.is-active:before {
            content: "\25b2";
        }

        .active {
            background-color: #007bff9e;
        }

        /* @media only screen and (max-width: 1363px) {
                .container .content {
                    margin-top: -102%;
                }
                .container .header {
                    margin-left:13px;
                }
            } */
        .parent {
            position: relative;
            /* width: 376px; */
        }

        /* code {
                background-color: #eee;
                border-radius: 3px;
                font-family: courier, monospace;
                padding: 0 3px;
                color: black;
            } */
        section.content {
            overflow: scroll;
            height: calc(100vh - 98px);
        }

        .option {
            display: flex;
            align-items: baseline;
        }

        /* The Modal (background) */
        .modal_popup {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 5;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content_popup {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
        }

        /* The Close Button */
        .close_popup {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close_popup:hover,
        .close_popup:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        }
    </style>
    <script>
        var myHeaders = new Headers();
        myHeaders.append('pragma', 'no-cache');
        myHeaders.append('cache-control', 'no-cache');
        var url = '{{ url('/') }}';
        var myInit = {
            method: 'GET',
            headers: myHeaders,
        };
        fetch(url + '/check-finished', myInit)
            .then((data) => {
                return data.json()
            })
            .then((data) => {

                if (data.finished == true) {
                    window.location.href = '{{ url('/finished') }}'
                }
            })
    </script>
    <div class="container-fluid">
        <div class="row">
            <div>
                {{ Session::put('started', 'started') }}
                @if (Session::has('message'))
                    <div class='popup_2'>
                        <div id='main_popup_2'>
                            <div id='mssg_popup_2'>

                                <p class='but'><button class='hide_popup_2 hide_popup'
                                        id='cancel'><label>X</label></button></p>
                                <h3 class='success'>{{ Session::get('message') }}</h3>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <section class="content-header" id="fullscreen">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 prod_head">
                    <h1>Quiz View</h1>
                </div>
                <div class="countdown-bar" id="countdownA">
                    <div></div>
                    <div></div>
                    <div id="blink">
                        <img src="{{ asset('assets/dist/img/screen_recorder.png') }}" alt="">
                        SCREEN IS RECORDING
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid view_page">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="POST" action="{{ url('/quiz') }}" enctype="multipart/form-data"
                                id="finish_test">
                                @csrf
                                <b>
                                    <h2 class="float-left">Quiz Questions : </h2>
                                </b>
                                {{-- <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target=".login_popup" data-whatever="">Add Link</button> --}}
                                {{-- <input class="float-right" type="" name="quiz_submit" id="quiz_submit" value="Finish" style="margin-left:50%;padding: 10px 20px;border:none;background-color: green;color: white;border-radius: 4px;"> --}}
                                <a class="float-right btn btn-success" name="quiz_submit" id="quiz_submit">Finish</a>
                                <input type="hidden" name="participant" value="{{ $participator->id }}">
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                @if ($audio_status == 'enable')
                                    <div class="col-12">
                                    @else
                                        <div class="col-12">
                                @endif

								
                                {{-- <input type="hidden"  name="cat_id" value="{{$participator->quiz_main->category_id}}"> --}}
                                <input type="hidden" name="dept_id" value="{{ $participator->quiz_main->id }}">
                                <input type="hidden" name="sess" id="sess" value="">

                                <?php
                                $new_arr = [];
                                $answer = '';
                                $id = '';
                                ?>

                                <table id="example2" class="table">
                                    <thead>
                                        <tr>
                                            {{-- <th><h4>List of Quiz Questions</h4></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                @php
                                                    $i = 0;
                                                    $TotalCount = count($quiz1);
                                                @endphp

                                                @foreach ($quiz1 as $key => $question)
                                                    <div id="question_{{ ++$i }}" class="questions">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <h2 class="category" style="color:#007bff;margin-top:-100px;margin-left:180px">
                                                                       ({{ App\Models\Category::where('id', $question['category_id'])->value('category_name') }})
                                                                    </h2>
                                                                </td>
                                                            </tr>
                                                            @if ($question['question'])
                                                                <tr>
                                                                    <td>
                                                                        <pre class="lang-php s-code-block"><code class="hljs language-php"><h1 style="white-space: break-spaces;font-size: 22px;">{{ $i.". ".$question['question'] }}</h1></code></pre>
                                                                    </td>
                                                                    <input type="hidden" name="ques_{{ $key }}"
                                                                        value="{{ $question['id'] }}">
                                                                </tr>
                                                            @endif

                                                            @foreach ($question['options'] as $option)
                                                                <tr>
                                                                    <td>
                                                                        <h3 class="option"><input type="radio"
                                                                                id="{{ $option['id'] }}"
                                                                                style="transform: scale(2);margin-right: 20px;"
                                                                                name="answer_{{ $key }}"
                                                                                value="{{ $option['id'] }}">
                                                                            <label
                                                                                for="{{ $option['id'] }}">{{ $option['option'] }}</label>
                                                                        </h3>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </table>
                                                    </div>
                                                @endforeach


                                            </td>
                                        <tr>
                                    </tbody>
                                </table>

                                {{-- <input type="submit" name="quiz_submit" id="quiz_submit" value="Finish" style="margin-left:50%;padding: 10px 20px;border:none;background-color: green;color: white;border-radius: 4px;">
                  <input type="hidden" name="participant" value="{{$participator->id}}"> --}}

                                </form>
                            </div>

                            {{-- @if ($audio_status == 'enable')
            <div class="col-6">
                <div class="iframe" >
                    <iframe name="main" id="main" src="{{route('test_video',$link_id)}}" scrolling="no" frameborder="0" ></iframe>
                </div>
              </div>
            @endif --}}

                            <div class="col-3 float-left">
                                <button id="prevBtn" style="" class="btn btn-primary float-left">Previous</button>
                            </div>

                            <div class="col-6" style="text-align: center">
                                @if ($audio_status == 'enable')
                                    <div class="container parent float-left">
                                        <div class="header option-heading"><span>Close Meeting</span>
                                        </div>
                                        <div class="content">
                                            <div class="">
                                                <div class="">
                                                    <iframe style="height: 70vh;width:98%" name="main" id=""
                                                        src="{{ route('test_video', $link_id) }}" scrolling="no"
                                                        frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-3">
                                <div class="">
                                    <button id="nextBtn" class="btn btn-primary float-right">Next</button>
                                    <button id="completeBtn" class="btn btn-success float-right">Complete</button>
                                </div>
                            </div>
                            <div class="row">
                                <div style="display:flex;visibility: hidden;">
                                    <button id='prevbtn' class="arrowbtn"
                                        style="border:none;padding: 5px 10px;background-color: #007bff9e;color: white;border-radius: 4px;height:30px">
                                        <<< /button>
                                            <div id='app' class="arrowbtn">
                                            </div>
                                            <button id='nextbtn' class="arrowbtn"
                                                style="border:none;padding: 5px 10px;background-color: #007bff9e;color: white;border-radius: 4px;height:30px">>></button>
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

            <!--Modal: modalPush-->
            <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <!--Content-->
                    <div class="modal-content text-center">
                        <!--Header-->
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading">Be always on Time</p>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                            <i class="fas fa-bell fa-2x animated rotateIn"></i>

                            <p>TIME IS THE KEY THAT CAN OPEN THE DOOR TO THE BETTER ROOM OF YOUR FUTURE</p>
                            {{-- @if ($audio_status == 'enable')
                <div class="">
                    <div class="" >
                        <iframe style="height: 257px" name="main" id="" src="{{route('test_video',$link_id)}}" scrolling="no" frameborder="0" ></iframe>
                    </div>
                </div>
            @endif --}}

                        </div>

                        <!--Footer-->
                        <div class="modal-footer flex-center">
                            <a href="#" onclick="openFullscreen();" class="btn btn-info">CLOSE</a>

                        </div>
                    </div>
                    <!--/.Content-->
                </div>
            </div>

    </section>
    </div>
    <!-- The Modal -->
    <div id="myModal_popup" class="modal_popup">

        <!-- Modal content -->
        <div class="modal-content_popup">
            <span class="close_popup">&times;</span>
            <h2>Are you sure Finish Quiz</h2>
            <button id="confirm" class="btn btn-success">Yes</button>
            <button onclick="openFullscreen();" class="btn btn-danger">No</button>
        </div>

    </div>
    {{-- ADD Link POPUP --}}
    {{-- <div class="modal fade login_popup"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Link Form</h5>
          <button type="button" class="close login_close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($audio_status == 'enable')
            <div class="col-6">
                <div class="iframe" >
                    <iframe name="main" id="main" src="{{route('test_video',$link_id)}}" scrolling="no" frameborder="0" ></iframe>
                </div>
              </div>
            @endif
        </div>
      </div>
    </div>
  </div>
 </div> --}}
    <script type="text/javascript">
        function openFullscreen() {
            //preventing keys
            document.onkeydown = function(e) {
                e.preventDefault();
                return false;
            }
            var currentw = document.getElementById("fullscreen");
            window.addEventListener('blur', function(e) {
                if (document.activeElement == document.querySelector('iframe')) {
                    // alert();
                    //    setTimeout(function(){
                    // $('#fs').click();
                    // },5000) // used 1 second to show the effect

                } else {
                    $('#sess').val('sess');
                    $('#finish_test').submit();
                }
            });
            $('.modal').modal('hide');
            $(".card").show();
            $("#blink").show();
            var elem = document.getElementById('fullscreen');
            countdown('countdownA', 0, {{ $diff_hrs }}, {{ $diff_min }}, {{ $diff_sec }});
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE11 */
                elem.msRequestFullscreen();
            }
        }


        function closeFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                /* IE11 */
                document.msExitFullscreen();
            }
        }
        //screen recording UI
        var blink = document.getElementById('blink');
        setInterval(function() {
            blink.style.opacity =
                (blink.style.opacity == 0 ? 1 : 0);
        }, 1000);
    </script>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#modalPush').modal('show');
            // $('.login_popup').modal('show');
            $(".card").hide();
            $("#blink").hide();
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#prevBtn").hide();
            $('.view_page').attr('unselectable', 'on')
                .css('user-select', 'none')
                .on('selectstart', false);
        });
    </script>

    <script>
        let total = {{ $TotalCount }};
        let numbers = [];
        let set = [];
        let count = 0;
        for (let i = 1; i <= total; i++) {
            set.push(i);
            if (i % 5 == 0) {
                numbers.push(set);
                set = [];
            } else if (total == i) {
                numbers.push(set);
            }
        }
        const div = document.getElementById("app");
        let buttonshtml = "";

        function showButtons(set) {
            buttonshtml = "";
            set.forEach((number, index) => {
                buttonshtml +=
                    `<button class="button btn btn-sm" data-id="${number}" id="button_${number}" onclick="btnClicked(${number})"> ${number} </button>`;
            });
            div.innerHTML = buttonshtml;
        }

        showButtons(numbers[count]);
        btnClicked(numbers[count][0]);

        document.getElementById("nextbtn").addEventListener("click", function() {
            if (count + 1 == numbers.length) {} else {
                count++;
                showButtons(numbers[count]);
                btnClicked(numbers[count][0]);
            }
        });
        document.getElementById("prevbtn").addEventListener("click", function() {
            if (count == 0) {} else {
                count--;
                showButtons(numbers[count]);
                btnClicked(numbers[count][numbers[count].length - 1]);
            }
        });

        function btnClicked(id) {
            const questions = document.getElementsByClassName('questions');
            const buttons = document.getElementsByClassName('button');

            for (const question of questions) {
                // 👇️ Remove element from DOM
                question.style.display = 'none';
                var next = {{ $TotalCount }};
                var previous = document.getElementById("button_1");
                if (id == 1) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "block";
                }
                if (id == next) {
                    document.getElementById("nextBtn").style.display = "none";
                    document.getElementById("completeBtn").style.display = "block";
                } else {
                    document.getElementById("completeBtn").style.display = "none";
                    document.getElementById("nextBtn").style.display = "block";
                }
                if (previous) {
                    document.getElementById("prevbtn").style.display = "none";
                    //  document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevbtn").style.display = "block";
                    // document.getElementById("prevBtn").style.display = "block";
                }
                var next = {{ $TotalCount }};
                var next_val = document.getElementById("button_" + next);
                if (next_val) {
                    document.getElementById("nextbtn").style.display = "none";
                    //  document.getElementById("nextBtn").style.display = "none";
                } else {
                    document.getElementById("nextbtn").style.display = "block";
                    // document.getElementById("nextBtn").style.display = "block";
                }
                // var c_count=document.querySelector(".active").getAttribute(data-id);
                console.log(id);
            }
            for (const button of buttons) {
                // 👇️ Remove element from DOM
                button.classList.remove("active");
                // button.style.backgroundColor = '';
            }
            let div = document.getElementById("question_" + id);
            let button = document.getElementById("button_" + id);
            if (div != undefined) {
                div.style.display = "block";
                button.classList.add("active");
                //   button.style.backgroundColor  = "#007bff9e";
            }

        }
    </script>
    <script>
        $(".header").click(function() {
            $header = $(this);
            //getting the next element
            $content = $header.next();
            $header.toggleClass('is-active')
            //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
            $content.slideToggle(500, function() {
                //execute this after slideToggle is done
                //change text of header based on visibility of content div
                $header.text(function() {
                    //change text based on condition
                    return $content.is(":visible") ? "Close Meeting" : "Open Meeting";
                });
            });
        });
    </script>
    <script>
        // Single Next Button
        $("#nextBtn").click(function() {
            var total_count = '{{ $TotalCount }}';
            // var Ele=$(".active").val("");
            var cid = $("button.active").attr("data-id");
            var valid_count = total_count - cid;
            // console.log(valid_count);
            if (valid_count == 1) {
                $("#nextBtn").hide();
                $("#prevBtn").show();
            } else {
                $("#nextBtn").show();
                $("#prevBtn").show();
            }
            // var cid=Ele.slice(Ele.length - 1);
            var nid = +cid + 1;
            var a = cid / 5;
            console.log(a);

            if (typeof a === 'number') {
                if (a % 1 === 0) {
                    // int
                    console.log("int");
                    $("#nextbtn").trigger("click");
                } else {
                    // float
                    console.log("float");
                }
            } else {
                // not a number
            }
            btnClicked(nid);
        });

        // Single Previous Button
        $("#prevBtn").click(function() {
            var total_count = '{{ $TotalCount }}';
            var cid = $("button.active").attr("data-id");
            // var valid_count=total_count-cid;
            if (cid == 2) {
                $("#prevBtn").hide();
                $("#nextBtn").show();
            } else {
                $("#prevBtn").show();
                $("#nextBtn").show();
            }
            var nid = cid - 1;
            console.log(nid);
            var a = nid / 5;
            // console.log(a);

            if (typeof a === 'number') {
                if (a % 1 === 0) {
                    // int
                    console.log("int");
                    $("#prevbtn").trigger("click");
                } else {
                    // float
                    console.log("float");
                }
            } else {
                // not a number
            }
            btnClicked(nid);
        });


        // Finish button trigger from Complete Button
        $("#completeBtn").click(function() {
            $('#finish_test').submit();
        });

        $("#confirm").click(function() {
            $('#finish_test').submit();
        });
    </script>
    <script>
        // Get the modal
        var modal_popup = document.getElementById("myModal_popup");

        // Get the button that opens the modal
        var btn_popup = document.getElementById("quiz_submit");

        // Get the <span> element that closes the modal
        var span_popup = document.getElementsByClassName("close_popup")[0];

        // When the user clicks the button, open the modal
        btn_popup.onclick = function() {
            closeFullscreen();
            modal_popup.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span_popup.onclick = function() {
            modal_popup.style.display = "none";
            openFullscreen();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal_popup) {
                modal_popup.style.display = "none";
            }
        }
    </script>
@endsection
