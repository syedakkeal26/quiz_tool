<?php
$page = 'dashboard';
?>
@extends('layouts.main')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <style type="text/css">
        .redcol {
            color: red;
        }

        .greencol {
            color: #17a2b8;
        }

        #message {
            background-color: red;
            color: white;
            padding: 10px;
        }

        .modal-body div {
            float: left;
        }

        .modal-body button {
            float: right;
        }

        .copied {
            background-color: green;
        }

        #filter {
            padding-top: 4%;
        }

        .filter-icon {
            cursor: pointer;
        }

        .modal-content {
            width: 111%;
        }

        .verror {
            color: red;
            font-size: 14px;
        }

        .form-row.align-items-end {
            float: left;
            width: 50%;
            margin-left: 8%;
        }

        #groupemail{
  float:left;
  border:1px solid #ccc;
  padding:5px;
  font-family:Arial;
}
#groupemail > span{
  cursor:pointer;
  display:block;
  float:left;
  color:#fff;
  background:#789;
  padding:5px;
  padding-right:25px;
  margin:4px;
}
#groupemail > span:hover{
  opacity:0.7;
}
#groupemail > span:after{
 position:absolute;
 content:"×";
 border:1px solid;
 padding:2px 5px;
 margin-left:3px;
 font-size:11px;
}
#groupemail > textarea{
  background:#eee;
  border:0;
  margin:4px;
  padding:7px;
  width:auto;
}
#send {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 30px;
  font-size: 17px;
}
#send.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}
@-webkit-keyframes fadein {
  from {top: 0; opacity: 0;} 
  to {top: 30px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 30px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 30px; opacity: 1;}
  to {top: 0; opacity: 0;}
}

    </style>
    <!--Generate Test link Modal -->
    @foreach ($quiz_list as $row)
        <div class="modal fade" id="url_modal{{ $row->id }}" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title parti" align="left" oncopy="return false" oncut="return false"
                            onpaste="return false"><b>Participant Test Link</b></h4>
                        <button type="button" class="close back_link" id="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div id="url" class="url">

                        </div><br>
                        <div id="audio_req">

                            <form class="audio_req_form">
                                <input type="checkbox" class="audio_req" value="" name="audio_req" id="audio_req_id">
                                <span class="ad_vd"> Check this box to enable Audio and Video for Participant
                                    <i class='fa fa-microphone-slash' aria-hidden='true'></i>
                                </span>
                                <input type="hidden" class="gene_id" name="gene_id" id="gene_id"
                                    value="{{ $row->id }}">
                            </form>
                        </div>
                        <button class='btn btn-primary copy' id='copy'>COPY</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade quicklink" id="quicklink" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title parti" align="left" oncopy="return false" oncut="return false"
                            onpaste="return false"><b>Quick Meeting Link</b></h4>
                        <button type="button" class="close back_link" id="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="qcklink" class="url">
                        </div><br>
                        <button class='btn btn-primary copy' id='copy'>COPY</button>
                    </div>
                </div>
            </div>
        </div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 prod_head">
                    <h1 style="float: left">Quiz Main Dashboard</h1>

                    <form action="{{ route('search_title') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col">
                                <?php $title = isset($_GET['search']) ? htmlentities($_GET['search']) : ''; ?>
                                <input type="text" name="search" class="form-control" placeholder="Search Title"
                                    value="<?= $title ?>" />
                            </div>
                            <div class="form-group col-auto">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                     @if (Auth::user()->role == 'admin' || Auth::user()->role == 'subadmin')       
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target=".login_popup"
                        data-whatever="">Create Quiz</button>
                            @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('customers/all') }}"></a>
                        </li>
                    </ol>
                </div>
            </div>
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
                            <h3 class="card-title">Quiz Details Listed Below</h3>
                                <button type="button" class="btn btn-primary qlink" value="quick" data-toggle="modal"
                                    data-target=".quicklink" style="float:right">
                                    Quick Meeting Link
                                </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>SL.No.</th>
                                        <th>Title</th>
                                        <th>Total Questions</th>
                                        <th>Link Generate</th>
                                        <th>Group Link</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'subadmin')
                            			<th>Delete</th>
                            @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    ?>
                                    <?php $i = $quiz_list->perPage() * ($quiz_list->currentPage() - 1); ?>
                                    @if (count($quiz_list) > 0)
                                        @foreach ($quiz_list as $row)
                                            <tr>
                                                <td class='sn'>{{ ++$i }}</td>
                                                <td> {{ $row->title }}<br>
						@php 
                        $quiz_section_id = \App\Models\QuizSection::where('asset_master_id',$row->id)->pluck('quiz_main_id');
							foreach($quiz_section_id as $quiz){
                           $category_id = \App\Models\quiz_main::whereIn('id',$quiz_section_id)->pluck('category_id');

        					$category_name = \App\Models\Category::whereIn('id',$category_id)->pluck('category_name');
                            }  
							
 						foreach($category_name as $key => $cat_name){
                        if ($key === array_key_first($category_name->all()) && $key === array_key_last($category_name->all())) {
                               echo  '<span style="color:red">['.$cat_name.']</span>';
                               continue;
                             }
                          if ($key === array_key_first($category_name->all())) {
                                   echo  '<span style="color:red">['.$cat_name.',</span>';
                                  continue;
                            }
 
                          if ($key === array_key_last($category_name->all())) {
                             echo  '<span style="color:red">'.$cat_name.']</span>';
                              }
                        else{
                     	 echo  '<span style="color:red">'.$cat_name.',</span>';
                        }
                            
                        }
                        @endphp
                       
						</td>
                            
                         
                                                <td> {{ $row->total_questions }}</td>
                                                <td>
                                                    <button value="{{ $row->id }}"
                                                        class="generate btn btn-primary">Generate Link</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary grplink"
                                                        value="{{ $row->id }}" data-toggle="modal"
                                                        data-target=".group_popup">
                                                        Group Link
                                                    </button>
                                                </td>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'subadmin')
                            					<td>
                            						<form action="{{route('quizdelete',$row->id)}}"  method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="quizid" value={{$row->id}}>
                        <button type="submit" onclick="return confirm('Are you sure?')"  style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>
                        </form>
                            					</td>
                            @endif

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>

                                            <td colspan="10" style="text-align: center">{{ 'NO DATA FOUND' }}</td>

                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="table-footer pagination-alignment">
                                {{ $quiz_list->appends(request()->all())->links() }}
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

    {{-- ADD Link POPUP --}}
    <div class="modal fade login_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Link Form</h5>
                    <button type="button" class="close login_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="loginformapi" data-type="1">
                        @csrf
                        <div class="form-group" style="width: 100%">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="" name="title"
                                placeholder="Enter Title">
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label for="total_questions">Total Questions</label>
                            <input type="number" class="form-control" id="" name="total_questions"
                                placeholder="Enter Total Questions">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Add Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade group_popup" id="group_popup" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Email ID</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="width: 100%">
                        <textarea class="form-control groupemail" id="groupemail" name="groupemail" rows="4" cols="50"
                            placeholder="Enter Email" ></textarea>
                    </div>
                    <div class="err_span" style="color:red"></div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary groupclose" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary groupbtn" >Send</button>
                    <p id="send">Your test link is send to your email</p>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
                  function myFunction() {
             //        var message = $('textarea#groupemail').val();
             //        if(message)
             //        {
             //       var x = document.getElementById("send");
             //    x.className = "show";
             // setTimeout(function(){ x.className = x.className.replace("show", ""); }, 8000);
             //        }
}  
        $(document).ready(function() {
            $('.qlink').on('click',function() {
                var id = $(this).val();
                if(id == 'quick'){
                    let r = (Math.random() + 1).toString(36).substring(2);
                    let link ="{{asset('/')}}";
                    // let link ="https://meet.jit.si/";
                    let quicklink =link +"meeting/"+ r;
                    $('.url').empty();
                    $('.url').append("<h4>"+quicklink+"</h4>");
                }
            })
          
            //CLICK EVENTS WHEN COPYING LINK
            $('.copy').on('click', function() {
                $(".url").css("background-color", "#007bff");
                $(".url").css("color", "#fff");
                $('.copy').text('COPIED');
            });

            //CLICK EVENTS WHEN CLOSING POPUP
            $('.close').on('click', function() {
                $(".url").css("background-color", "#fff");
                $(".url").css("color", "black");
                $('.copy').text('COPY');
                $('.verror').remove();
            });
        
          $('.grplink').on('click', function() {
                var grplink = $(this).val();
                $('.groupbtn').val(grplink);
            });
        
            $('.groupbtn').on('click', function(e) {
                e.preventDefault();
                const group_email = $('.groupemail').val();
                const groupbtn = $('.groupbtn').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('groupmail') }}",
                    data: {
                        group_email,groupbtn
                        
                    },
                    beforeSend: function(data){
                        $('.verror').remove();
                        $('.groupbtn').html('<i class="fas fa-spinner fa-pulse"></i>');
                    },
                    success: function(data) {
                        $('.groupbtn').html('send');
                        if(data.success == false){
                        $(".err_span").append("<span class='label label-important verror'>"+data.errors+'</span>');
                        }else{
                        toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': false,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            }
                        toastr.success('MAIL SENDED SUCCESSFULLY');
                            $('#groupemail').val('');
                            $('#group_popup').modal('hide');

                        }
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".back_link").click(function() {
                $('.ad_vd').html(
                    " Check this box to enable Audio for Participant <i class='fa fa-microphone-slash' aria-hidden='true'></i>"
                    );
                $('.audio_req').prop('checked', false);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.audio_req').val('no');
            $('.audio_req').click(function() {
                var value = $(this).val('yes');
                var data = $(this).closest('.audio_req_form').serialize();
                var audio_req = $(this).closest('.audio_req_form');
                $.ajax({
                    url: "{{ route('audio_req') }}",
                    type: "POST",
                    data: data,
                    success: function(data) {
                        if (data.success == "true") {
                            audio_req.find('.ad_vd').html(
                                " Check this box to enable Audio for Participant <i class='fa fa-microphone' aria-hidden='true'></i>"
                                );
                            audio_req.find('.audio_req').val('no');
                            audio_req.find('.copy')
                        }
                        if (data.success == "false") {
                            audio_req.find('.ad_vd').html(
                                " Check this box to enable Audio for Participant <i class='fa fa-microphone-slash' aria-hidden='true'></i>"
                                );
                            audio_req.find('.audio_req').val('no');
                        }
                    },
                    error: function() {
                        alert('error');
                    },
                });
            });

            // ADD Link Popup submition

            $('.loginformapi').submit(function(e) {
                e.preventDefault();
                data = $(this).serialize();
                let url = "{{ route('custom_link') }}";
                $.ajax({
                    url,
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        $('.loginformapi').find('.verror').remove();
                    },
                    success: function(data) {
                        if (data.success == "false") {
                            for (let index in data.error) {
                                $('.loginformapi').find('input[name=' + index + ']').after(`<span  role="alert" class="verror">
                                <strong>` + data.error[index][0] + `</strong>
                            </span>`);
                            }
                        } else {
                            window.location.href = '{{ route('fetch_data') }}'
                        }
                    }
                });

            });


            $(".login_close").click(function() {
                location.reload();
                $(".verror").remove();
            });
        });
    </script>
@endsection
