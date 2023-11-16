<?php
 $page = 'test_request';
?>
@extends('layouts.main')

@section('content')
<link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style type="text/css">
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css');

.bg-faded{background-color:#f3f3f3;max-height:500px}
.btn-round{border-radius:500px}
.btn-round,.btn-round:hover,.btn-round:active{border-color:transparent}
.modal.animate {opacity:0}
.modal.animate.show {opacity:1}
.modal.animate .modal-dialog{-webkit-transform:translate(0,0);-ms-transform: translate(0,0);transform:translate(0,0)}
.modal.animate .a-fadeLeftBig{-webkit-animation:fadeOutLeftBig .5s;animation:fadeOutLeftBig .5s}
    .modal.animate.show .a-fadeLeftBig{-webkit-animation:fadeInLeftBig .5s;animation:fadeInLeftBig .5s}
.modal.animate .a-fadeRightBig{-webkit-animation:fadeOutRightBig .5s;animation:fadeOutRightBig .5s}
    .modal.animate.show .a-fadeRightBig{-webkit-animation:fadeInRightBig .5s;animation:fadeInRightBig .5s}
.modal.animate .a-fadeUpBig{-webkit-animation:fadeOutUpBig .5s;animation:fadeOutUpBig .5s}
    .modal.animate.show .a-fadeUpBig{-webkit-animation:fadeInUpBig .5s;animation:fadeInUpBig .5s}
.modal.animate .a-fadeDownBig{-webkit-animation:fadeOutDownBig .5s;animation:fadeOutDownBig .5s}
	.modal.animate.show .a-fadeDownBig{-webkit-animation:fadeInDownBig .5s;animation:fadeInDownBig .5s}
.modal.animate .a-fadeRight{-webkit-animation:fadeOutRight .5s;animation:fadeOutRight .5s}
	.modal.animate.show .a-fadeRight{-webkit-animation:fadeInRight .5s;animation:fadeInRight .5s}
.modal.animate .a-fadeLeft{-webkit-animation:fadeOutLeft .5s;animation:fadeOutLeft .5s}
	.modal.animate.show .a-fadeLeft{-webkit-animation:fadeInLeft .5s;animation:fadeInLeft .5s}
.modal.animate .a-fadeUp{-webkit-animation:fadeOutUp .5s;animation:fadeOutUp .5s}
	.modal.animate.show .a-fadeUp{-webkit-animation:fadeInUp .5s;animation:fadeInUp .5s}
.modal.animate .a-fadeDown{-webkit-animation:fadeOutDown .5s;animation:fadeOutDown .5s}
    .modal.animate.show .a-fadeDown{-webkit-animation:fadeInDown .5s;animation:fadeInDown .5s}
.modal.animate .a-lightSpeed{-webkit-animation:lightSpeedOut .5s;animation:lightSpeedOut .5s}
    .modal.animate.show .a-lightSpeed {-webkit-animation:lightSpeedIn .5s;animation: lightSpeedIn .5s}
.modal.animate .a-flipX{-webkit-animation:flipOutX .5s;animation:flipOutX .5s}
	.modal.animate.show .a-flipX{-webkit-animation:flipInX .5s;animation:flipInX .5s}
.modal.animate .a-flipY{-webkit-animation:flipOutY .5s;animation:flipOutY .5s}
	.modal.animate.show .a-flipY{-webkit-animation:flipInY .5s;animation:flipInY .5s}
.modal.animate .a-roll{-webkit-animation:rollOut .5s;animation: rollOut .5s}
	.modal.animate.show .a-roll{-webkit-animation:rollIn .5s;animation:rollIn .5s}
.modal.animate .a-bounce{-webkit-animation:bounceOut .5s;animation:bounceOut .5s}
	.modal.animate.show .a-bounce{-webkit-animation:bounceIn .5s;animation:bounceIn .5s}
.modal.animate .a-rotate{-webkit-animation:rotateOut .5s;animation:rotateOut .5s}
	.modal.animate.show .a-rotate{-webkit-animation:rotateIn .5s;animation:rotateIn .5s}
.modal.animate .a-zoom{-webkit-animation:zoomOut .5s;animation:zoomOut .5s}
	.modal.animate.show .a-zoom{-webkit-animation:zoomIn .5s;animation:zoomIn .5s}
.modal.animate .a-zoomUp{-webkit-animation:zoomOutUp .5s;animation:zoomOutUp .5s}
	.modal.animate.show .a-zoomUp{-webkit-animation: zoomInUp .5s;animation:zoomInUp .5s}
.modal.animate .a-zoomRight {-webkit-animation: zoomOutRight .5s;animation:zoomOutRight .5s}
	.modal.animate.show .a-zoomRight{-webkit-animation: zoomInRight .5s;animation:zoomInRight .5s}
.modal.animate .a-zoomDown{-webkit-animation:zoomOutDown .5s;animation:zoomOutDown .5s}
	.modal.animate.show .a-zoomDown{-webkit-animation:zoomInDown .5s;animation:zoomInDown .5s}
.modal.animate .a-zoomLeft{-webkit-animation:zoomOutLeft .5s;animation:zoomOutLeft .5s}
	.modal.animate.show .a-zoomLeft{-webkit-animation:zoomInLeft .5s;animation:zoomInLeft .5s}

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
.fa-envelope-open:before {
    content: "\f2b6";
    color: blue;
}
.fa-envelope-open:before {
    content: "\f2b6";
    color: blue;
}
.fa-envelope:before {
    content: "\f0e0";
    color: red;
}
</style>
<script>
        @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.warning("{{ session('warning') }}");
        @endif
      </script>  
        {{Session::forget('message')}}
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 prod_head">
            <h1>Test Request List </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Test Request</li>
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
                <h3 class="card-title">All Requests Listed Below</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SL.No.</th>                  
                    <th>Email</th>
                    <th>Skill name</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php //echo "<pre>"; print_r($quiz); exit();?>
                  <?php
                   $i = $request_list->perPage() * ($request_list->currentPage() - 1)
                    ?>
                      @foreach($request_list as $row)

                        <tr>
                          <td class='sn'>{{ ++$i }}</td>
                          <td class='title'>{{$row->user_email}}</td>
                          <td class='email'>{{$row->skill_name}}</td>
                          <td class='status {!! ($row->status=="read")?"":"action"!!}' id="{{Crypt::encryptstring($row->id)}}">{!! ($row->status=="read")?"<i title='Not Open' class='fas fa-envelope-open'style=cursor:pointer;font-size:17px;color:#343a40;'>Replied</i>":"<i title='Open' class='fas fa-envelope' style='cursor:pointer;font-size:17px;color:#343a40;'>Not-Replied</i>" !!}</td>
                          </td>                          
                        </tr>
                      @endforeach                  
                  </tbody>
                </table>
                <div class="table-footer pagination-alignment">
                    {{ $request_list->links() }}
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
 <div class="modal reply_modal" tabindex="-1" role="dialog" data-target=".animate" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reply Form</h5>
        <button type="button" class="close pop_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{route('submit_reply')}}" method="post">
          @csrf
          <input type="hidden" id="custom" name="request_id">
        <div class="form-group">
    <label for="exampleFormControlTextarea1">Reply Message</label>
    <textarea name="reply_msg" id="reply_msg" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="send_btn" class="btn btn-primary" disabled>Send</button>
      </div>
            </form>
    </div>
  </div>
</div>
<script>
          
         $( document ).ready(function() {    
    $('.pop_close').click(function() {
         $("#reply_msg").val('');
    });
     $("#reply_msg").on('keyup', function() {
    if($(this).val().length > 1) {
         $('#send_btn').attr('disabled',false);
    } else {
        $('#send_btn').attr('disabled',true);
    }
});    
    
          $('.action').click(function() {
          	var val=$(this).attr('id');
          $('#custom').val(val);
			$('.reply_modal').modal('show');
          
          });   
		});
          
          
          
                $(function(){
	$('[role=dialog]')
	    .on('show.bs.modal', function(e) {
		    $(this)
		        .find('[role=document]')
		            .removeClass()
		            .addClass('modal-dialog ' + $(e.relatedTarget).data('ui-class'))
	})
})
                </script>
@endsection
