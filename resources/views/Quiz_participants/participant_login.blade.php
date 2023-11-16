@extends('layouts.app')
@section('content')
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>  
<link rel="shortcut icon" href="https://mycipl.in//images/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QUIZ</title>
<!-- JAVASCRIPT CODE START -->
<!-- SCRIPT FOR LOGIN FORM VALIDATION START-->
<style>
    @charset "utf-8";
*{ margin:0; padding:0;}

html, body, div, span, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
    border: 0 none;
    font-family: inherit;
    font-size: 100%;
    margin: 0;
    padding: 0;
}

@font-face{
font-family:"SSStandard";
src:url("../fonts/ss-standard.eot");
src:url("../fonts/ss-standard.eot?#iefix") format("embedded-opentype"),
url("../fonts/ss-standard.woff") format("woff"),
url("../fonts/ss-standard.ttf") format("truetype"),
url("../fonts/ss-standard.svg#SSStandard") format("svg");
font-style:normal;
font-weight:normal;
}

.lft{ float:left;}
.rght{ float:right;}
.brdr_btm{ border-bottom:1px solid #D5D5D5}


body#signin { background: #F6F6F6; text-align: center;}
body { background: #FFFFFF;
    color: #222222;
    font-family: "Helvetica Neue",Arial,Verdana,"Nimbus Sans L",sans-serif;
    font-size: 12px;
    font-weight: normal;
    height: 100%;
    line-height: normal;
    text-rendering: optimizelegibility;
}

img{
    width: 100%;
}
#signin-container {
    height: auto;
    line-height: 1.63em;
    min-height: 180px;
    min-width: 486px;
    position: relative;
    text-align: center;
	background: #FFFFFF;
    border: 1px solid #D4D4D4;
    border-radius: 8px 8px 8px 8px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.15);
    display: inline-block;
    margin: 100px auto 30px;
    padding: 30px;
   
}


#signin-container h2#company-logo {
	padding-top:20px;
    display: block;
    float: left;
    min-height: 150px;
    margin: 0;
    width: 160px;
    
}


#signin-container #signin-form {
    border-left: 1px solid #DDDDDD;
    float: right;
    margin-left: 30px;
    min-height: 180px;
    padding-left: 30px;
    text-align: left;
    width: 240px;
}	

#signin-form ul { float:left; width:230px; padding-top:8px;}

#signin-form ul li { list-style:none; margin-bottom: 10px; float:left; width:268px;}
#signin-form ul li label { display: block; font-weight: bold; width:230px;}
#signin-form ul li input[type="text"], 
input[type="email"], 
input[type="password"] { width:203px; height:24px;}

#signin-form .remember{ margin-bottom:10px; float:left; width:100px;}
#signin-form .remember input{ float:left;}
#signin-form .remember p{ margin-left:5px; float:left;}
#signin-form .forgot a{ color:#1495c7; float:right;}
#signin-form  .btn_signin_bx{margin-top: 0px; float: left; width: 230px;}

input[type="text"], 
input[type="email"], 
input[type="password"],
input[type="textarea"], textarea {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
    outline: medium none;
	background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #AAAAAA;
    border-radius: 3px 3px 3px 3px;
    font-family: "Helvetica Neue",Arial,Verdana,"Nimbus Sans L",sans-serif;
    margin: 0; font-size:13px;
}
.btn-primary {
	background:#1496c8;background:-webkit-gradient(linear, 0% 100%, 0% 0%, color-stop(0, #1496c8), color-stop(0.7, #05abed));
	background:-moz-linear-gradient(center bottom, #1496c8 0%, #05abed 70%) repeat scroll 0 0;
	filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#05abed', endColorstr='#1496c8');
	-ms-filter:"progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#05abed', endColorstr='#1496c8')";
	box-shadow:inset 0 1px 0 rgba(255,255,255,0.3);
	border: 1px solid #0688b9;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.4) inset;
    color: #fff;
    font-weight: bold;
    padding: 0px 15px;
	overflow: visible;
   	text-align: center;
    text-decoration: none;
    width: auto;
	border-radius: 5px;
   	cursor: pointer;
}

input.btn-submit {
    height: 27px;
    padding-bottom: 2px;
   	float: left;
	font-family: "Helvetica Neue",Arial,Verdana,"Nimbus Sans L",sans-serif;
    font-size: 12px;
    line-height: 25px;
   	outline: medium none;
}

/****************************/
.wrapper {
    margin: 0 auto;
    padding: 0 20px;
    width: 970px;
}
#signin-container .it-validates-flag {
    right: 3px;
    top: 22px;
}
.it-validates-flag {
    background-color: #AA0707;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    color: white;
    font-size: 11px;
    line-height: 10px;
    margin-left: 1px;
    padding-bottom: 5px;
    padding-left: 6px;
    padding-right: 6px;
    padding-top: 5px;
    position: absolute;
    white-space: nowrap;
    z-index: 1000;
}

.checkbox_remember { margin-top:3px; }
.back_link      {  color:#1495C7; text-decoration:none;}
.back_link a:hover { color:#1495C7; text-decoration:underline;}
.forgot_form a:hover,.btn-register:hover { color:#1495C7; text-decoration:underline;}
.forgot a:hover {  color:#00FF66;text-decoration:underline;}
.invalid_user{ margin-bottom: -15px;margin-right:-10px;}
.invalid_user1 {margin-right:74px; margin-top: 8px;}
.new_user{ margin-right:-53px; margin-top: -10px;  margin-bottom: -10px;}
a.view_icon1 {
    margin-left: 10px;
}
.btn-register{
  color: #1495c7;
     margin-left: -12px;
    width: 105px;
    margin-top: -6px;
    font-size:100%;
}
</style>
</head>
<body id="signin">
	<div id="signin-container">
        <div class="row">
            <div class="col-6">
    	<h2 id="company-logo">
    	<a href="index.php">
    	    	<img src="{{ URL::asset('assets/dist/img/colan-logo.png') }}"  border="0" style="margin-top:45px;"/>
    	    	</a></h2>  		
            </div>
            <div class="col-6">
              @if(Session::has('error'))
              <p class="alert alert-info">{{ Session::get('error') }}</p>
              @endif
              @if(session()->has('success'))
              <div class="alert alert-success">
                  {{ session()->get('success') }}
              </div>
              @endif
              <form action="{{route('participantLogin')}}" method="post">
                @csrf         
                <input type="hidden" name="slug" value="{{ $slug }}">

      <div id="signin-form">
   		  <ul>
            	 <li style="position:relative"><label>Mobile Number</label> 
                <input id="mobile" type="text" class="@error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}"  autocomplete="mobile" autofocus required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            		 <div id="user_alert"></div>
            	 </li>
                <li style="position:relative"><label>Password</label>
                  <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" autocomplete="current-password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
               	 <div id="pass_alert"></div>
                </li>
            </ul>  
            
            <div class="remember">
                @if (Route::has('register'))
                <a class="btn btn-link btn-register back_link"  href="{{ route('p-register-v',$slug) }}">{{ __('New Register!') }}</a>
          @endif
            </div>
              <div class="forgot">
                <a href="{{ route('forget_password',$slug) }}"  class="back_link">Forgot Password?</a>
              </div>          
              <div class="btn_signin_bx">
                <input type="submit"  id="login_submit" name="login_submit" value="Sign In" class="btn-submit btn-primary"></a>
              </div>     
  		 </div>
  		 </form>
        </div>
        </div>
	</div>
</body>
</html>
@endsection