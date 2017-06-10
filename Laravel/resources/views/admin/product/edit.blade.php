@extends('admin.master')
@section('controller','Product')
@section('action','Edit')
@section('content')
<style type="text/css">
    .image_current{width: 150px;}
    .image_detail{width: 200px;}
    .icon_del{position:relative; top:-120px;} 
    /*Dùng position:relative rồi margin được*/

</style>
<form action="" method="POST" name="frmEditProduct" enctype="multipart/form-data"> <!-- Công dụng enctype?  Lúc Edit cần bỏ vào -->
    <div class="col-lg-7" style="padding-bottom:120px">
        @include('admin.blocks.error')
        
        <input type ="hidden" name="_token" value="{!! csrf_token()!!}"/>
        <div class="form-group">
           <label>Category Parent</label>
           <select class="form-control" name="sltParent"> <!-- Nhớ phải bỏ đặt tên class trùng với request bên $request->parent_id = $request-> select -->
            <option value="0">Please Choose Category</option>
            <?php cate_parent($cate,0,"--",$product["cate_id"]); ?>
            <!--  Hàm cate_parent nằm bên Laravel/app/bilaravel/functions  -->
        </select>
    </div>


    <div class="form-group">
        <label>Name</label>
        <input class="form-control" name="txtName" placeholder="Please Enter Username" value="{!!old('txtName', isset($product) ? $product['product_name'] : null)!!}" />
         <!-- Toán tử điều kiện: Nếu điều kiện là true ? Gán giá trị là X : Ngược lại là Y
         $result = ($a > $b ) ? $a :$b; -->
     </div>
     <div class="form-group">
        <label>Price</label>
        <input class="form-control" name="txtPrice" placeholder="Please Enter Password" value="{!!old('txtPrice', isset($product) ? $product['price'] : null)!!}"/>
    </div>
    <div class="form-group">
        <label>Intro</label>
        <textarea class="form-control" rows="3" name="txtIntro" >{!!old('txtIntro', isset($product) ? $product['intro'] : null)!!}</textarea>
        <!-- <script type="text/javascript">ckeditor('txtIntro')</script> -->
    </div>
    <div class="form-group">
        <label>Content</label>
        <textarea class="form-control" rows="3" name="txtContent">{!!old('txtContent', isset($product) ? $product['content'] : null)!!} </textarea>
        <!--  <script type="text/javascript">ckeditor('txtContent')</script> -->
    </div>
    <div class="form-group">
        <label>Image Current</label>
        <img src="{!! asset('resources/upload/'.$product['image']) !!}" class="image_current"/>
        <input type="hidden" name="image_current" value="$product['image']" />
    </div>
    <div class="form-group">
        <label>Images</label>
        <input type="file" name="fImages">
    </div>
    <div class="form-group">
        <label>Product Keywords</label>
        <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{!!old('txtKeywords', isset($product) ? $product['keywords'] : null)!!}" />
    </div>
    <div class="form-group">
        <label>Product Description</label>
        <textarea class="form-control" rows="3" name="txtDescription" >{!!old('txtDescription', isset($product) ? $product['product_description'] : null)!!}</textarea>
    </div>

    <button type="submit" class="btn btn-default">Product Edit</button>
    <button type="reset" class="btn btn-default">Reset</button>
    
</div>
<div class="col-md-1"> </div>
<div class="col-md-4">                             <!-- Lấy ra hình ảnh detail khi edit -->
    @foreach($product_image as $key => $item)          <!--  key 0,1,2,3 -->
    <div class="form-group" id="{!! $key !!}"> 
        <img class="image_detail" src="{!! asset('resources/upload/detail/'.$item['image']) !!}" idHinh="{!! $item['id'] !!}" id="{!! $key !!}"/>
        <a href="" id="del_img_demo" type="button" class="btn btn-danger btn-circle icon_del"><i class="fa fa-times"></i></a>
    </div>       
    @endforeach
   <!--  <input type="file" name="fProductDetail[]" /> -->
    <button type="button" class="btn btn-primary" id="addImage">Add Image</button> <!-- Lấy id="" qua bên myscript xử lí -->
    <!-- btn-primary làm cho button thành màu xanh -->
    <div id="insert"></div>     
    
</div>
<form>
    @endsection()   