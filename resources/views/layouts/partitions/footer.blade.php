{{-- <?php
  // include_once 'db_con.php';

  if(!isset($_SESSION['uid'])){
    header("Location:../login/login.php");
  }

?> --}}


<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="{{ url('/')}}">ColanInfotech</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 8.0
    </div>
 </footer>
<script src="{{ URL::asset('assets/dist/js/adminlte.min.js')}}"></script>

<script src="{{ URL::asset('assets/dist/js/adminlte.min.js')}}"></script>
<!-- Index1.php js -->

 <script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('assets/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::asset('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ URL::asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ URL::asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{ URL::asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ URL::asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset('assets/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ URL::asset('assets/dist/js/pages/dashboard.js')}}"></script>

<!-- Product list js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>


<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!--  product creation js -->
<script src="{{ URL::asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

{{-- <!-- <script type="text/javascript">

	$(document).ready(function() {

		$('.td_row').click(function(){
			var userid = $(this).attr('id');
			var uid = userid.split('_')[1];
			//console.log(uid);
			$('#conform').attr("href",'index1.php?uid='+uid);

		});

		 $(".show_popup").click(function(){
		 	$('#main_popup_1').fadeIn('slow');
		   //$("#").fadeIn('slow');
		  });
		  $(".hide_popup_1").click(function(){
		   //$(this).parent().fadeOut('slow');
		   $('#main_popup_1').fadeOut('slow');
		  });

	});

</script> -->



<!-- <script type="text/javascript">
  $(document).ready(function(){

      $('.td_row1').click(function(){
      var userid = $(this).attr('id');
      var uid = userid.split('_')[1];
      //console.log(uid);
      $('#yes').attr("href",'event_list.php?uid='+uid);

    });

     $(".show_popup1").click(function(){
      $('#main_popup').fadeIn('slow');
       //$("#").fadeIn('slow');
      });
      $(".hide_popup").click(function(){
       //$(this).parent().fadeOut('slow');
       $('#main_popup').fadeOut('slow');
      });

  });
</script> --> --}}



<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".highlight").click(function() {
      $(".highlight").removeClass("active");
      $(this).toggleClass("active");
    });
  </script>

 <script type="text/javascript">

 $(document).ready(function(){

  $("#select").on('change', function(){
    var val = $(this).val();
    // alert(val);
    window.location.href = "?dbname="+val;
  });

 });


 </script>

 <script type="text/javascript">

  $(document).ready(function() {


      $('#main_popup_2').fadeIn('slow');
       //$("#").fadeIn('slow');

      $(".hide_popup_2").click(function(){
       //$(this).parent().fadeOut('slow');
       $('#main_popup_2').fadeOut('slow');
        var newURL = location.href.split("?")[0];
        window.history.pushState('object', document.title, newURL);
      });

  });

</script>

<script type="text/javascript">
  $(function() {
    $( ".datepicker" ).datepicker({ startDate: new Date()});
 });
</script>

 {{-- <script type="text/javascript">
    $(document).ready(function(){

        function dateval(paradate,mssg){
          console.log(paradate);
           var date = new Date();
            var yyyy = date.getFullYear();
            var mm = date.getMonth()+1;
            var dd = date.getDate();
            var today = yyyy+"-"+mm+"-"+dd;
            var seldate = paradate.split("-");
            console.log(seldate);
            if ((seldate[0]< yyyy) || (seldate[1] < mm) || (seldate[2] < dd)) {
              $(mssg).text("Please Select Upcoming Date");
              return false;
            }
            else{
              $(mssg).empty();
              return true;
            }

        }

      $("#submit").on("click",function(){
        var title = $.trim($("input[name=title]").val());
        var descp = $.trim($("textarea[name=descp]").val());
        var start = $("input[name=start]").val();
        var end = $("input[name=end]").val();
        var location = $.trim($("textarea[name=location]").val());
        var image = $("input[name=image]").val();
        //alert(title+","+descp+","+start+","+end+","+location+","+image);
        // var date = new Date();
        // var yyyy = date.getFullYear();
        // var mm = date.getMonth()+1;
        // var dd = date.getDate();
        // var today = yyyy+"-"+mm+"-"+dd;

       var error = true;
        // console.log(date);
        // console.log(yyyy);
        // console.log(mm);
        // console.log(dd);
        // console.log(today);

        var dateregex = "[0-9A-Za-z]/g";




//        $(function() {
//   $( ".datepicker" ).datepicker({ dateFormat: "yyyy-mm-dd" });
// });




        if (title === "")
        {
          $("#titleerr").text("Please Enter Title");
          error =  false;
        }
        else{
          $("#titleerr").empty();
        }

        if (descp === "")
        {
          $("#descperr").text("Please Fill Description");
          error =  false;
        }
        else if((descp.length)<50){
          $("#descperr").text("Description must have minimum 50 characters");
          error =  false;
        }
        else{
          $("#descperr").empty();
        }

         if (start === "")
        {
          $("#starterr").text("Please Select Start Date");
          error =  false;
        }
        else if(start.match(dateregex)){
          $("#starterr").text("Only given format (dd-mm-yyyy) is allowed ");
          error =  false;
        }
        else{
          $("#starterr").empty();
           //error = dateval(start,"#starterr");
        }

        if (end === "")
        {
          $("#enderr").text("Please Select End Date");
          error =  false;
        }
        else{
          $("#enderr").empty();
           //error = dateval(end,"#enderr");
        }

        if (location === "")
        {
          $("#locaerr").text("Please Fill the Location");
          error =  false;
        }
        else{
          $("#locaerr").empty();
        }

        if (image !== "")
        {
          console.log(image);
          var imgsplit = image.split("\\");
          var imglen = (imgsplit.length)-1;
          var imgnm = imgsplit[imglen];
          console.log(imgnm);
          var imgtype = imgnm.split(".")[1];
          console.log(imgtype);
          if(imgtype != "jpg" && imgtype != "png" && imgtype != "jpeg"
             && imgtype != "gif" && imgtype != "jfif" )
          {
             $("#imageerr").text("Sorry only (JPG, JPEG, PNG & GIF) files are allowed.");
             error =  false;
          }
          else{
             $("#imageerr").empty();
          }
        }
        else
        {
           $("#imageerr").text("Please choose the image file");
           error =  false;
        }
        console.log(error);
        if (error) {
          return true;
        }
        else{
          return false;
        }
      });
    });
  </script> --}}

  {{--<script type="text/javascript">
      $(document).ready(function(){
        var dbname = "<?php echo isset($_SESSION['db'])?$_SESSION['db']:''?>";

        if (dbname == "archive_db") {
          $(".archive").hide();
        }
      });
    </script>--}}

    {{--<script type="text/javascript">
      $(document).ready(function(){

          $('.td_row1').click(function(){
          var userid = $(this).attr('id');
          var uid = userid.split('_')[1];
          //console.log(uid);
          $('#yes').attr("href",'event_list.php?uid='+uid);

        });

         $(".show_popup1").click(function(){
          $('#main_popup').fadeIn('slow');
           //$("#").fadeIn('slow');
          });
          $(".hide_popup").click(function(){
           //$(this).parent().fadeOut('slow');
           $('#main_popup').fadeOut('slow');
          });

      });
</script>--}}

 <script type="text/javascript">
  $(document).ready(function(){

      $(".show_popup1").click(function(e){
          e.preventDefault();
          var i = $(this).attr('id');
          // alert(i);
      $('#main_popup').fadeIn('slow');
          // alert('popup_'+i);
          $('#yes').attr("data-id",i);
      });

      $('#yes').click(function(){

        var id = $(this).attr('data-id');
        $('#delete_quiz_'+id).submit();

      });

      $(".hide_popup_1").click(function(){

       $('#main_popup').fadeOut('slow');

      });

  });
</script>

<script type="text/javascript">

  $(document).ready(function(){
    var availval = "";
    $('.book').click(function(){
      var id = $(this).attr('id');
      var availval = parseInt($('#seat_'+id).text());
      console.log(availval);
      $('#hide').attr('value',availval);
      console.log(id);
      $('.seaterr').empty();

      $('#input_seat').val('');
      $('#idhide').val(id);

    });
    $('#proceed').on('click',function(){
      var seatval = $('#input_seat').val();

      var seat = parseInt($('#hide').val());

      console.log(seat);

      var url = "{{url('/')}}";


      if (seatval == "") {
        $('.seaterr').css({"background-color": "red", "color": "white"});
        $('.seaterr').text("Please Select no.of seats reqiured");
        event.preventDefault();
      }
      else if((seatval > seat) || (seatval <= 0)){
        $('.seaterr').css({"background-color": "red", "color": "white"});
        $('.seaterr').text("Please select available seats only");
        event.preventDefault();
      }
      else{
        $('.seaterr').empty();

        // window.location.href=url+"/bus/booking/"+id;
      }
    });
  });
</script>


<!-- <script type="text/javascript">

  $(document).ready(function(){
    $('.seat_select').on('change',function(){
      var id = $(this).attr('id');
      var opt_val = $('#'+id).val();
      var opt_len = $('#'+id+" "+'option').length -1;
      console.log(id);
      console.log(opt_val);
      console.log(opt_len);
        var sel_id$('.products-combo').attr('id');
        console.log(opt_len);
      for(var i=1 ; i<=opt_len){

      }
    })
  });
</script> -->

<script type="text/javascript">
  $(document).ready(function(){

    // $('body').on("change", ".seat_select", function (evt) {
    //   var fieldValue  = $(this).val();
    //   // console.log(fieldValue);
    //   $(this).siblings('.seat_select').children('option').each(function() {

    //     if ( $(this).val() === fieldValue ) {
    //       $(this).attr('disabled', true);
    //     }

    //   });
    // });

    const $selects = $(".seat_select");
      $selects.on('change', function(evt) {
          // create empty array to store the selected values
          const selectedValue = [];
          // get all selected options and filter them to get only options with value attr (to skip the default options). After that push the values to the array.
          $selects.find(':selected').filter(function(idx, el) {
              return $(el).attr('value');
          }).each(function(idx, el) {
              selectedValue.push($(el).attr('value'));
          });
          // loop all the options
          $selects.find('option').each(function(idx, option) {
              // if the array contains the current option value otherwise we re-enable it.
              if (selectedValue.indexOf($(option).attr('value')) > -1) {
                  // if the current option is the selected option, we skip it otherwise we disable it.
                  if ($(option).is(':checked')) {
                      return;
                  } else {
                      $(this).attr('disabled', true).css({"background-color":"#ccc","color":"white"});
                  }
              } else {
                  $(this).attr('disabled', false).css({"background-color":"unset","color":"unset"});
              }
          });
      });
  });
</script>

<script type="text/javascript">

  $(document).ready(function(){


    $("#book_submit").on("click",function(e){
      var error = true;

      var seat_val = parseInt($("#no_of_book").val());
      //console.log(seat_val);
      for (var i=1 ; i <= seat_val; i++) {

        //console.log(i);
        var sel_val = $("#select_"+i).val();

        //console.log(sel_val);
        if (sel_val == "") {
          $("#err_"+i).text("Please select the seat number");
          error = false;

        }
        else{
          $("#err_"+i).empty();

        }

      }
      //console.log(error);
      if (error) {
        $("#main_popup").fadeIn('slow');
      }
    });

     $("#conf").on('click',function(){

         //$('#book_form').submit();
         $("#main_popup").fadeOut('slow');
    });


  });


</script>

<script type="text/javascript">
  $(document).ready(function(){

      $(".questions").hide();
      $("#question_1").show();
      $(".quiz_button").on("click",function(e){

      var val = $(this).val();
        $(".questions").hide();
        $(".quiz_button").removeClass("button_color");
        $("#q_"+val).addClass("button_color");
        $("#question_"+val).show();

      console.log(val)
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){

      $("#quiz_submit").on("click",function(e){

        window.close();
    });
  });
</script>

<script>
    $(function(){
       $('.generate').click(function() {
        var id = $(this).val();
        console.log(id);
            $.ajax({
                url: 'generate/'+id,
                type: 'GET',

                success: function(response)
                {
                    console.log(response);
                    $(".modal-body #url").html(response);
                    $("#url_modal"+id).modal('show');
                }
            });
       });

    });

</script>
<script type="text/javascript">
  $( document ).ready(function() {
    $('.copy').on('click', function(){
      console.log($('#url').text());
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($('#url').text()).select();
      document.execCommand("copy");
      $temp.remove();
      $('.copy').addClass("copied");

    });
    $('.close').on('click', function(){
      $('.copy').removeClass("copied");
    });
});
</script>
</body>
</html>

