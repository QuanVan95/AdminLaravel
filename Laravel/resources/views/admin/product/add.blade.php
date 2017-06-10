@extends('admin.master')
@section('controller','Product')
@section('action','add')
@section('content')

<form action="{!! url('/admin/product/add') !!}" method="POST" enctype="multipart/form-data"> <!--  Lúc Edit cần dùng enctype ?? -->
    <div class="col-lg-7" style="padding-bottom:120px">
        @include('admin.blocks.error')
        <!--enctype Để lấy hình -->
  <!-- Có thể dùng <form action="{!! route('admin.cate.getAdd') !!}" method="POST">
  ủa? xử lý nút submit ở mô?    -->  

  <input type ="hidden" name="_token" value="{!! csrf_token()!!}"/>
  <div class="form-group">
    <label>Category Parent</label>
    <select class="form-control" name ="sltParent">
        <option value="" >Please Choose Category</option>
        <?php cate_parent($cate); ?> 
    </select>
</div>
<div class="form-group">
    <label>Name</label>
    <input class="form-control" name="txtName" value="{!!old('txtName')!!}" placeholder="Please Enter Product Name" />
</div>
<div class="form-group">
    <label>Price</label>
    <input class="form-control" name="txtPrice" value="{!!old('txtPrice')!!}" placeholder="Please Enter Price" />
</div>
<div class="form-group">
    <label>Intro</label>
    <textarea class="form-control" rows="3" name="txtIntro">{!!old('txtIntro')!!}</textarea>
    <!-- <script type="text/javascript">ckeditor("txtIntro")</script> -->
    <!-- Chèn ckeditor vào. Tên hàm ckeditor trong file func.ckfinder.js(public/admin/js) -->
</div>
<div class="form-group">
    <label>Content</label>
    <textarea class="form-control" rows="3" name="txtContent">{!!old('txtContent')!!}</textarea>
    <!-- <script type="text/javascript">ckeditor("txtContent")</script> -->
</div>
<div class="form-group">
    <label>Images</label>
    <input type="file" name="fImages" value="{!!old('fImages')!!}"/>
</div>
<div class="form-group">
    <label>Product Keywords</label>
    <input class="form-control" name="txtKeywords" value="{!!old('txtKeywords')!!}" placeholder="Please Enter Category Keywords" />
</div>
<div class="form-group">
    <label>Product Description</label>
    <textarea class="form-control" name="txtDescription" rows="3">{!!old('txtDescription')!!}</textarea>
</div>

<button type="submit" class="btn btn-default">Product Add</button>
<button type="reset" class="btn btn-default">Reset</button>


</div>


<div class = "col-md-1"></div>
<div class = "col-md-4">
    @for($i=1; $i<=10; $i++)
    <div class="form-group">
        <label>Product Detail Image {!! $i !!}</label>
        <input type="file" name="fProductDetail[]" />  <!-- Mảng để lấy hình -->
    </div>
    @endfor
</div>
</form>

@endsection('content')