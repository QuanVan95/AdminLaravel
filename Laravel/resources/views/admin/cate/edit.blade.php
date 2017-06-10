@extends('admin.master')
@section('controller','Category')
@section('action','Edit')
@section('content')
<div class="col-lg-7" style="padding-bottom:120px">
@include('admin.blocks.error')
    <form action="" method="POST">
       <input type ="hidden" name="_token" value="{!! csrf_token()!!}"/>
       <div class="form-group">
        <label>Category Parent</label>
        <select class="form-control" name="sltParent"> <!-- Nhớ phải bỏ đặt tên class trùng với request bên $request->parent_id = $request-> select -->
            <option value="0">Please Choose Category</option>
            <?php cate_parent($parent,0,"--",$data["parent_id"]); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Category Name</label>
        <input class="form-control" name="txtCateName" placeholder="Please Enter Category Name" value="{!! old('txtCateName',isset($data) ? $data['name'] : null) !!}"/>
        <!-- kiểm tra data có tồn tại hay không, có thì lấy ra cột name --> 
    </div>
    <div class="form-group">
        <label>Category Order</label>
        <input class="form-control" name="txtOrder" placeholder="Please Enter Category Order" value="{!! old('txtOrder',isset($data) ? $data['order'] : null) !!}"/>
    </div>
    <div class="form-group">
        <label>Category Keywords</label>
        <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{!! old('txtKeywords',isset($data) ? $data['keywords'] : null) !!}"/>
    </div>
    <div class="form-group">
        <label>Category Description</label>
        <textarea class="form-control" name="txtDescription" rows="3" >{!! old('txtDescription',isset($data) ? $data['description'] : null) !!}</textarea>
    </div>
    <div class="form-group">
        <label>Category Status</label>
        <label class="radio-inline">
            <input name="rdoStatus" value="1" checked="" type="radio">Visible
        </label>
        <label class="radio-inline">
            <input name="rdoStatus" value="2" type="radio">Invisible
        </label>
    </div>
    <button type="submit" class="btn btn-default">Category Edit</button>
    <button type="reset" class="btn btn-default">Reset</button>
    <form>
    </div>
    @endsection()              