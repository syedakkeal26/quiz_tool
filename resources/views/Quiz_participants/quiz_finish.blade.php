<!DOCTYPE html>
<html>
{{-- @include('layouts.partitions.header') --}}
<head>
  <title>Finished</title>
  <style type="text/css">
    .thank{
      text-align: center;
      padding: 12%;
      margin: 5% 0px;
      height: 100%;
      font-size: 25px;
    }
    .main-footer{
      bottom: 0;
      left: 0;
      margin: unset !important;
    }
    #completed{
      display: block;
    }
    #illegal{
      display: block;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="thank">
                  @if ($sess!='sess')
                  @if ($mail_split[1]=="colanonline.com" || $mail_split[1]=="colaninfotech.net" || $mail_split[1]=="colaninfotech.in")
                  <h1 id="completed"><span style="color: #008000">Thank You!</span> <br>
                    Your Quiz has been Completed<br>
                    please use below link to view result..
                    <a href="https://skill-tracking.colanapps.in/emp_skills">Click</a>
                  </h1>
                    {{Session::forget('sess');}}
                    @else
                        <h1 id="completed"><span style="color: #008000">Thank You!</span> <br>
                            Your Quiz has been Completed<br>
                            Please wait result will be declared soon...
                          </h1>
                          {{Session::forget('sess');}}
                    @endif
                  @else
                        <h1 id="illegal">OOPS!<br>
                          YOU HAVE BEEN DISQUALIFIED FOR<br>
                           UNUSUAL ACTIVITIES...
                           {{Session::forget('sess');}}
                          </h1>

                    @endif
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

</div>

</body>
{{-- @include('layouts.partitions.footer') --}}
</html>

