<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<title>Quiz</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="{{ url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{ url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
	{{-- Stackoverflow --}}
    {{-- <link rel="stylesheet" href="{{ url('https://cdn.sstatic.net/Shared/stacks.css?v=047e88ccaeee')}}"> --}}
	{{-- <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/stackoverflow.css')}}"> --}}
    <!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ URL::asset('assets/dist/css/adminlte.min.css')}}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
   <!-- DataTables -->
  <!--<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">-->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" rel="stylesheet')}}"/>

  <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')}}"></script>

 <link rel="stylesheet" href="{{ URL::asset('assets/dist/img/AdminLTELogo.png')}}">

  <style type="text/css">


		#mssg_popup_1,#mssg_popup_2{
			position: relative;
			width:350px;
			height: 150px;
			text-align: center;
			margin:0 auto;
			top:50%;
			transform: translateY(-50%);
			background-color: lightblue;
			border-radius: 10px;
			box-shadow: 1px 10px 19px 9px #484242d6
		}

		#main_popup_1,#main_popup_2{
			position: fixed;
			width:100%;
			height: 787px;
			top:0;
			left:0;
			background-color: rgba(0, 0, 0, 0.2);
			display: none;
		}
		#main_popup_2{
			display: block;
			z-index: 1;
		}
		#mssg_popup_1,#mssg_popup_2{
			height: 200px;
   			width: 375px;
			background-color: #343a40;
			padding-top: 10px;
			color: rgb(255 255 255 / 0.8);
		}
		#mssg_popup_1 p,#mssg_popup_2 p{
			font-size: 20px;
			margin: 25px  0px;
		}
		.hide_popup_1{
			width: 50%;
			padding:10px;
			font-size: 16px;
			border:none;
			outline: unset;
			cursor: pointer;
			background-color: white;
		}
		.hide_popup_2{
			font-size: 16px;
			border:none;
			outline: unset;
			cursor: pointer;
			background-color: unset;
		}
		.hide_popup_2:hover{
			background-color: red;
		}
		#conform{
			position: absolute;
			bottom:0;
			left:0;
			border-right: 1px solid black;
			color: green;
			border-bottom-left-radius: 10px;
		}
		#mssg_popup_2 p{
			margin: unset;
			text-align: right;
			padding: 0px 20px;
		}
		#no_thanks{
			position: absolute;
			bottom:0;
			right:0;
			color: red;
			border-bottom-right-radius: 10px;
		}
		#cancel{
			color: white;
		}
		#mssg_popup_1 h3,#mssg_popup_2 h3{
			margin-top: 22px;
		}
		#mssg_popup_1 label{
			cursor: pointer;
		}
		#mssg_popup_2 label{
			cursor: pointer;
			margin: unset;
		}
		.mssg_popup_2{
	      	height: 150px !important;
	    }
		.td_row{
			border:none;
			outline: unset;
			background-color: unset;
			color: #007bff;
		}
		.opt0{
			cursor: none;
			text-transform: capitalize !important;
		}
		#select{
			padding: 10px 15px;
			border-radius: 5px;
		}
		.err{
  		color:red;
	  	}
	  	.success{
	  		font-size:25px;
	  		font-weight: bold;
	  		color: #32e032;
	  	}
	  	#example2{
	  		text-align: center;
	  	}
	  	#event_popup_1{
			position: relative;
			text-align: center;
			margin:0 auto;
			top:50%;
			transform: translateY(-50%);
			border-radius: 10px;
			box-shadow: 1px 10px 19px 9px #484242d6;
			height: 200px;
   			width: 375px;
			background-color: #343a40;
			padding-top: 10px;
			color: rgb(255 255 255 / 0.8);
		}
		#main_popup{
			position: fixed;
			width:100%;
			height: 787px;
			top:0;
			left:0;
			background-color: rgba(0, 0, 0, 0.2);
			display: none;
		}
		#event_popup_1 p{
			font-size: 20px;
			margin: 25px  0px;
		}
		#yes{
			position: absolute;
			bottom:0;
			left:0;
			border-right: 1px solid black;
			color: green;
			border-bottom-left-radius: 10px;
		}
		#no{
			position: absolute;
			bottom:0;
			right:0;
			color: red;
			border-bottom-right-radius: 10px;
		}
		#event_popup_1 h3{
			margin-top: 22px;
		}
		#event_popup_1 label{
			cursor: pointer;
		}
		.td_row1{
			border:none;
			outline: unset;
			background-color: unset;
			color: #007bff;
		}
		.relative svg{
			display: none;
		}
		.avail{
			display: inline-block;
		    border-radius: 100%;
		    background-color: green;
		    width: 10px;
		    height: 10px;
		}
		.notavail{
			display: inline-block;
		    border-radius: 100%;
		    background-color: red;
		    width: 10px;
		    height: 10px;
		}
		.book{
			padding: 8px 12px;
			border-radius: 5px;
			background-color: #007bff;
			color: white;
		}
		#event_popup_1 h4{
			margin-top: 22px;
		}
		#canc{

			bottom:15px;
			left:15px;
			color: red;
		}
		#proceed{

			bottom:15px;
			right:15px;
			color: green;
			padding: 7px;
		}
		.seatpopup{
			width: 18%;
		    padding: 5px;
		    border-radius: 5px;
			font-size: 16px;
			border:none;
			outline: unset;
			cursor: pointer;
			background-color: white;
		}
		.seatpopup label{
			margin: unset;
		}
		.input{
			margin-bottom: unset !important;
			margin-top: 20px !important
		}
		.errdiv{
			height: 30px;
		}
		.seat{
			height: 215px ​!important;
		}
		.busform{
			display: flex;
			margin: unset;
		}
		.booking{
			margin: unset;
		}
		.datepicker-container{
			display: none;
		}
		#conf{

		}
		#loadgif{
			margin:auto;
			width:100px;
			margin-top: 130px;
		}
		.load h3{
			margin-bottom: 140px;
			text-align: center;
		}
		.load p{
			color:green;
			padding: 15px;
		}
		#finish{
			width:100px;
			border:unset;
			background-color: green;
			padding: 10px 15px;
			margin-bottom: 20px;
			margin-right: 20px;
			border-radius: 5px;
			color: white;
		}
		.finish{
			text-align: end;
		}
        .pagination-alignment
        {
            float: right;
        }

        #url{
            word-break: break-word;
        }

	</style>

</head>
