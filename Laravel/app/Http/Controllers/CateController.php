<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CateRequest;
use App\Cate;
class CateController extends Controller {
	public function checkName(){
		echo "Show what?";
		return redirect()->route("taolaobidao");
	}

	public function getList(){
		$data= Cate::select('id','name','parent_id')->orderBy('id','DESC')->get()->toArray();
		return view('admin.cate.list',compact('data'));
		//Dùng compact để truyền dữ liệu sang trang view. ví dụ: @foreach ($data as $item)
		
	}
	public function getAdd(){
		$parent= Cate::select('id','name','parent_id')->orderBy('id','DESC')->get()->toArray();
		return view('admin.cate.add',compact('parent') );
	}
	public function getDelete($id){
		$parent = Cate::where('parent_id', $id)->count(); //Đếm xem có phần tử nào có parent_id bằng id hiện tại muốn xóa hay không. Nếu có 1 thì $parent =1...
		if($parent==0){
			$cate = Cate::find($id);
			$cate ->delete($id);
		return redirect()->route('admin.cate.list')->with(['flash_level'=>'success','flash_message'=>' Delete Successfully']);
		} else {
			// echo "<script type='text/javasript'>
			// alert('Sorry! You Can Not Delete This Category');
			// window.location='";
			// echo route('admin.cate.list');
			// echo "'
			// </script>"; // Không biết dùng javascript nên dùng flash message để thông báo -_-
			return redirect()->route('admin.cate.list')->with(['flash_message_delete'=>'Sorry! You can not delete this category!']);

	}
		
	}
	// Phải truyền vào $id
	public function getEdit($id){
		$data = Cate::findOrFail($id)->toArray();
		$parent = Cate::select('id','name','parent_id')->orderBy('id','DESC')->get()->toArray();
		return view('admin.cate.edit',compact('parent','data') );
		
	}

	public function postEdit(Request $request, $id){
		$this->validate($request,
			["txtCateName" => "required"],
			["txtCateName.required"=>"Please Enter Category Name"]
			);
		$cate = Cate::find($id);
		$cate ->name=$request->txtCateName;
		$cate->alias=changeTittle($request->txtCateName);
		$cate->order=$request->txtOrder;
		$cate->parent_id=$request->sltParent;
		$cate->keywords=$request->txtKeywords;
		$cate->description=$request->txtDescription;
		$cate->save();
		return redirect()->route('admin.cate.list')->with(['flash_level'=>'success','flash_message'=>'Completed Edit Category' ]);

		
	}
	public function postAdd(CateRequest $request){
		//print_r($request->txtCateName);
		
		$cate= new Cate;
		$cate->name=$request->txtCateName;
		$cate->alias=changeTittle($request->txtCateName);
		$cate->order=$request->txtOrder;
		$cate->parent_id=$request->sltParent;
		$cate->keywords=$request->txtKeywords;
		$cate->description=$request->txtDescription;
		$cate->save();
		return redirect()->route('admin.cate.list')->with(['flash_level'=>'success','flash_message'=>'Add Successfully' ]);
		// return redirect()->route('admin.category.list')->with(['flash_success'=>'success','flash_message'=>'Success']);
	}

}
