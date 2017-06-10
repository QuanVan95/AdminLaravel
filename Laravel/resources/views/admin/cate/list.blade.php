@extends('admin.master')
@section('controller','Category')
@section('action','List')
@section('content')

<!-- /.col-lg-12 -->
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Name</th>
            <th>Category Parent</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php $stt = 0  ?>
        @foreach ($data as $item)   <?php //$data là dữ liệu lấy bên CateController.  ?>
        <?php $stt += 1 ?>
        <tr class="odd gradeX" align="center">
            <td>{!! $stt !!}</td>
            <td>{!! $item["name"] !!}</td>
            <td>
                @if ($item["parent_id"] == 0) 
                {!! "None" !!}
                @else
                <?php 
                $parent = DB::table('cates')->where('id',$item["parent_id"])->first();       echo  $parent->name;
                            //Delete sai-> không hiển thị được. Xem lại phần parent_id
                ?>
                @endif
            </td>
            <td class="center"><i class="fa fa-trash-o fa-fw "></i><a onclick="return xacNhanXoa('Are You Sure To Delete?')" href="{!! URL::route('admin.cate.getDelete',$item['id']) !!}"> Delete</a></td>
            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.cate.getEdit',$item['id']) !!}">Edit</a></td>
        </tr>
        @endforeach 
    </tbody>
</table>
<!-- /.row -->
@endsection()         