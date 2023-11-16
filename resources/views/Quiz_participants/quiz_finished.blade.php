{{-- @dd(Session::get('key')); --}}
<!DOCTYPE html>
<html>
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

                  <h1 id="completed"><span style="color: red">Sorry.. <img src="{{ asset('assets/images/sademoji.png') }}" alt="" width="30"> </span><br>
                    Please Contact Admin...
                  </h1>

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
{{Session::forget('audio_status')}}
</body>
</html>

