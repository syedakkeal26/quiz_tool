<?php
$page = '';
?>
<html>
<head>
    <style>
        iframe{
 width:80vw !important;
 height:40vw !important;
}
body {
    /* height:100%; */
    background:#040404;
}
.h_iframe iframe {
    /* position:absolute; */
    /* top:0; */
    /* left:40; */
    width:100%;
    /* height:100%; */
}


    .brand-link .brand-image {
        max-height: 44px;
    }
    span.brand-text.font-weight-light {
    color: #fff;
}
    
    div#meetiong_slide {
    position: relative;
    /* left: 7%; */
    /* top: 5%; */
}

    </style>
</head>
    
    <body>
   
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      
      
      <li class="nav-item d-none d-sm-inline-block">
      <a href="" class="brand-link">
        <img src="{{ URL::asset('assets/dist/img/colan-logo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        
    </a>
      </li>
    
    </ul>

    
  </nav>
   

    <div class="col-6" style="text-align: center" id="meetiong_slide">
                                                                    <div class="container parent float-left">
                                        <div class="header option-heading">
                                            <!-- <span>Close Meeting</span> -->
                                        </div>
                                        <div class="content">
                                            <div class="">
                                                <div class="">
                                                    <iframe style="" name="main" id="" src={{route('test_video',$id)}} scrolling="no" frameborder="0"></iframe>
                                                   
                                            </div>
                                        </div>
                                    </div>
                                                            </div>
    </body>
    
   
    </html>