<?php
$page = 'dashboard';
?>
@extends('layouts.main')

@section('content')
<style>
    .clone
    {
        display: none;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-4">
            <h1>Add Link</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">Add Link</li>
            </ol>
        </div>
        <div class="col-sm-2 create">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{url('/home')}}" class="btn btn-primary">Back</a>
                  </li>
              </ol>
        </div>
    </div>
</div>
</section>
<section class="content">
    <div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}}</h3>
                        <span class="float-right">No of Questions: <span id="current_count">0</span>/{{$total_questions}}</span>
                    </div>
                        <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" class="add_form" action="{{route('add_link')}}" enctype="multipart/form-data">
                               @csrf
                               <input type="hidden" name="title" value="{{$title}}">
                               <input type="hidden" name="total_questions" value="{{$total_questions}}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Create Section</label>
                                        <span class="float-right" style="color: blue;font-weight:bold" id="current_total"></span>
                                        <div class="input-group control-group1 increment section">
                                            <select name="dept[]" id="dept" class="form-control" required>
                                                <option value="">Select Department</option>
                                                <option  value="all">All</option>
                                                @foreach($department as $dept)
                                                    <option value="{{$dept->id}}">{{$dept->department_name}}</option>
                                                @endforeach
                                            </select>
                                            <select name="category[]" id="category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach($category as $categories)
                                                    <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                                                @endforeach
                                            </select>
                                            <select name="sub_category[]" id="sub_category" class="form-control" required>
                                                <option value="">Select Category First</option>
                                            </select>
                                            <select name="level[]" id="level" class="form-control" required>
                                                <option value="">Select Level First</option>
                                            </select>
                                            <input type="number" value="" class="form-control count" id="" name="count[]" placeholder="Enter No of Questions" required>
                                            <div id="row_count"></div>
                                            <div class="input-group-btn">
                                                <button class="btn btn-success add_button" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="" style="color: red; font-weight:bold " id="count_error"></span>

                            </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <div class="clone hide">
                                            <div class="control-group input-group section" style="margin-top:10px">
                                                <select name="dept[]" id="dept" class="form-control" required>
                                                    <option value="">Select Department</option>
                                                    <option value="all">All</option>
                                                    @foreach($department as $dept)
                                                        <option value="{{$dept->id}}">{{$dept->department_name}}</option>
                                                    @endforeach
                                                </select>
                                                <select name="category[]" id="category" class="form-control" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($category as $categories)
                                                        <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                                                    @endforeach
                                                </select>
                                                <select name="sub_category[]" id="sub_category" class="form-control" required>
                                                    <option value="">Select Category First</option>
                                                </select>
                                                <select name="level[]" id="level" class="form-control" required>
                                                    <option value="">Select Sub-Category First</option>
                                                </select>
                                                <input type="number" class="form-control count" id="" name="count[]" placeholder="Enter No of Questions" required>
                                                <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $(".clone").hide();
    $(".btn-success").click(function(){
        var html = $(".clone").html();
        $(".increment").append(html);
        // $(".section").removeClass("increment");
        // $(".section:last").addClass("increment");
    });

    $("body").on("click",".btn-danger",function(){
        $(this).parents(".control-group").remove();
    });

//Get Category Based on Department
    $(document).on('change','select[name="dept[]"]',function() {
        var deptID = $(this).val();
        var selectEl = $(this);
        if(deptID) {
            $.ajax({
                url: "{{ url('get_category') }}",
                data: {deptID},
                type: "GET",
                dataType: "json",
                success:function(data) {

                    selectEl.next('select[name="category[]"]').empty();
                    selectEl.next('select[name="category[]"]').append('<option value="">Select Category</option>');
                    $.each(data.categories, function(id,category) {
                        selectEl.next('select[name="category[]"]').append('<option value="'+category.id+'">'+ category.category_name +'</option>');
                    });
                }
            });
        }
    });

//Get Sub-Category Based on Department
    $(document).on('change','select[name="category[]"]',function() {
        var cateID = $(this).val();
        var selectEl = $(this);
        if(cateID) {
            $.ajax({
                url: "{{ url('get_sub_category') }}",
                data: {cateID},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    selectEl.next('select[name="sub_category[]"]').empty();
                    selectEl.next('select[name="sub_category[]"]').append('<option value="">Select Category</option>');
                    $.each(data.categories, function(id,category) {
                        selectEl.next('select[name="sub_category[]"]').append('<option  value="'+category.id+'">'+ category.category_name +'</option>');
                    });
                }
            });
        }
    });

//Get level Based on sub-category name
    $(document).on('change','select[name="sub_category[]"]',function() {
        var subCateID = $(this).val();
        var selectEl = $(this);
        if(subCateID) {
            $.ajax({
                url: "{{ url('get_level') }}",
                data: {subCateID},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    selectEl.next('select[name="level[]"]').empty();
                    selectEl.next('select[name="level[]"]').append('<option value="">Select level</option>');
                    $.each(data.level, function(id,level) {
                        selectEl.next('select[name="level[]"]').append('<option class="'+level.max_number_questions+'" value="'+level.id+'">'+ level.level +'</option>');
                    });
                }
            });
        }
    });
//Get Question Count Based on level name
    $(document).on('change','select[name="level[]"]',function() {
        var q_id = $(this).val();
        var selectEl = $(this);
        if(q_id) {
            $.ajax({
                url: "{{ url('no_questions') }}",
                data: {q_id},
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data.Q_count, function(id,Q_count) {
                        selectEl.next('input[name="count[]"]').attr("placeholder","Available Questions:"+Q_count.max_number_questions);
                        selectEl.next('input[name="count[]"]').attr("id",Q_count.max_number_questions);

                    });
                }
            });
        }
    });


//Question Live count change
    $(document).on('change','.count',function() {
        var count = parseInt($(this).val());
        var Q_count=$(this).attr('id');
        var total_count=`{{$total_questions}}`;
        var current_count=parseInt($('#current_count').text());
        if(isNaN(count)){
            count=0;
            current_count=0;
        }
        var total = 0;
        var inputs = $(".count");
        for(var i = 0; i < inputs.length; i++){
            var a=parseInt($(inputs[i]).val());
            if(isNaN(a)){
                a=0;
            }
            total += a << 0;
        }
        var error_count=total_count-current_count;
        var current_total=total_count-total;
        if(total>total_count){
            // $("#count_error").text("Only "+error_count+" Questions available");
            $("#count_error").text("Questions Limit Exceed");
        }else{
            $("#current_count").text(total);
            $("#count_error").text("");
        }
        if(current_total<0 || total==total_count){
            $("#current_total").text("");
        }
        if(Q_count<count){
            $("#current_total").text("This section have "+Q_count+" Questions Only");
            $("#current_total").css("color", "red");
            $(this).css("border-color", "red");
        }else if(current_total<total_count && current_total>0){
            $("#current_total").text("Available Question Count:"+current_total);
            $("#current_total").css("color", "blue");
            $(this).css("border-color", "");
        }else{
            $(this).css("border-color", "");
        }
    });


    $(".add_form").submit(function(e){
        var error=$("#count_error").text();
        var Current_error=$("#current_total").text();
        if(error){
            e.preventDefault();
        }else if(Current_error){
            e.preventDefault();
            $("#current_total").css("color", "red");
        }
    });
});
</script>
@endsection

