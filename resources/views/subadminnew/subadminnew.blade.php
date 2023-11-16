<?php
 $page = 'subadminnew';
?>
@extends('layouts.main')
@section('content')
<link rel="stylesheet" type="text/css"
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
    .verror{
    color: red;
    font-size: 15px;
}.modal-confirm {
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
    font-size: 13px;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
	color: #999;
}
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>
<section class="content-header">
    <script>
        @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("{{ session('message') }}");
        @endif
        @if(Session::has('messages'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("{{ session('messages') }}");
        @endif
        </script>
    {{ Session::forget('message')}}
    {{ Session::forget('messages')}}
    <div class="container-fluid">

      <div class="row mb-2">
        <div class="col-sm-6 prod_head">
          <h1>Sub-Admin List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="" class='btn btn-primary' data-toggle="modal" data-target=".add_admin_popup" data-whatever=""><i class='fas fa-user-plus'></i>&nbsp;Sub Admin</a>
              </li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
                </div>
            @endif
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content" >
<div class="container-fluid">
    <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sub-Admin Details listed Below</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>SL.No.</th>
                {{-- <th>CIPL</th> --}}
                <th>Name</th>
                <th>Email</th>
                {{-- <th>Department</th> --}}
                <th>Reset Password</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
                <?php $i = $subadmin->perPage() * ($subadmin->currentPage() - 1)?>
                @if(count($subadmin)>0)
                @foreach($subadmin as $data)
                    <tr>
                    <td>{{++$i}}</td>
                    {{-- <td>{{$data->cipl}}</td> --}}
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    {{-- <td>{{$data->department}}</td> --}}
                    <td><a href="" class='btn btn-info' data-toggle="modal" data-target=".send_req{{$data->id}}" data-whatever=""value="{{$data->id}}">Send New Password</a>
                    </td>
                    <td>
                        <?php $id=Crypt::encryptString($data->id);?>
                        <a href="{{route('subadminnew.edit',$id)}}"><i class='fas fa-pen'></a></td>
                    <td>
                        <form action="{{route('subadminnew.destroy',$id)}}"  method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="subadmin_id" value={{$data->id}}>
                        <button type="submit" onclick="return confirm('Are you sure?')"  style="border: hidden; background-color: Transparent;"><i class='fas fa-trash-alt' style="color: red;"></i></button>
                        </form>
                    </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10" style="text-align: center">{{'NO DATA FOUND'}}</td>
                </tr>
                @endif
            </tbody>
            </table>
            <div class="table-footer pagination-alignment">
                {{  $subadmin->appends($_GET)->links() }}
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
@foreach($subadmin as $data)
<!-- Send Password-Start -->
<div id="myModal" class="modal fade send_req{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-confirm" modal-dialog-centered role="document">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="fa fa-question-circle" aria-hidden="true"></i>
				</div>
				<h4 class="modal-title w-100">Are you sure?</h4>
                <button type="button" class="close login_close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to send Login Credentials to<b> {{$data->name}}</b>? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger send_reset" data-id="{{$data->id}}">Yes</button>
			</div>
		</div>
	</div>
</div>
<!-- Send Password-End -->
@endforeach
<!-- Adding SubAdmin-start -->
<div class="modal fade add_admin_popup"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" id="test">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Register Form</h5>
          <button type="button" class="close login_close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form class="loginformapi" data-type="1">
         @csrf
         <input type="hidden" class="col-form-label" name="device_id" value="">
         <input type="email" class="form-control @error('email') is-invalid @enderror vemail" id="recipient-email" name="email" placeholder="ENTER EMAIL">
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary add_admin">ADD</button>
        </div>
        </form>
    </div>
      </div>
    </div>
  </div>
<!-- Adding SubAdmin-end -->
</section>
<script type="text/javascript">
 $(document).ready(function() {
    // <!-- Adding SubAdmin-Start -->

    $('.loginformapi').submit(function(e){
            e.preventDefault();
            data = $(this).serialize();
            var reg_form_element = $(this);
            $.ajax({
                url:"{{ route('regformapis') }}",
                type:'get',
                data: data,
                beforeSend:function(){
                    reg_form_element.find('.verror').remove();
                    reg_form_element.find('.add_admin').attr("disabled", true).html("Please wait...");
                },
                success: function(data) {
                        if(data.success=="true"){
                            $("#test").hide();
                            window.location.href='{{ route('subadminnew.index') }}'

                    }else{
                        reg_form_element.find('.add_admin').attr("disabled", false).html("ADD");
                        for(let index in data.error)
                        {
                            reg_form_element.find('input[name='+index+']').after(`<span  role="alert" class="verror">
                                <strong>`+data.error[index][0]+`</strong>
                            </span>`);
                        }
                        if(data.success=="trues"){
                            alert();
                         }
                    }
                }
            });
        });
        // <!-- Adding SubAdmin-end -->
    // <!-- Send Reset Password-Start -->
    $('.send_reset').click(function(e){
            e.preventDefault();
            data = $(this).attr("data-id");
            reg_form_element=$(this);
            $.ajax({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                url:"{{ route('sendpassword') }}",
                type:'POST',
                data: {data : JSON.stringify(data)},
                datatype: 'json',
                beforeSend:function(){
                    reg_form_element.attr("disabled", true).html("Sending...<i class='fa fa-spinner fa-pulse fa-3x fa-fw' style='font-size:15px;'></i>");
                    $('.login_close').attr("disabled", true);
                },
                success: function(data) {
                        if(data.success=="true"){
                            reg_form_element.find('.login_close').attr("disabled", false);
                            window.location.href='{{ route('subadmin.index') }}'

                    }

                }

                });
            });
    // <!-- Send Reset Password-end -->

    $(".login_close").click(function(){
        location.reload();
            $(".verror").remove();
        });
});
</script>
@endsection
