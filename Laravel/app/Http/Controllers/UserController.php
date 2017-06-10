<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Auth;
use App\User;
use Hash; //Dùng cho password
class UserController extends Controller {

	//

	public function getAdd(){
		return view('admin.user.add');

	}
	public function postAdd(UserRequest $request){
		$user = new User;
		$user->username = $request->txtUser;
		$user->password =Hash::make($request->txtPass); //Dùng Hash mã hóa password trong laravel
		$user->email =$request->txtEmail;
		$user->level = $request->rdoLevel;
		$user->remember_token = $request->_token;
		$user->save();
		return redirect()->route('admin.user.getList')->with(['flash_level'=>'success', 'flash_message'=>'Add User Successfully!' ]); //route:: admin.user.phươngThức # view:admin.user.trang -_-
	}

	public function getList(){
		$user = User::select('id','username','level')->orderBy('id','DESC')->get()->toArray();
		return view('admin.user.list',compact('user'));

	}
	public function getDelete($id){
		$user_current_login = Auth::user()->id;
		$user = User::find($id);
		// 1. $id=2 Đó là SA, không được xóa.
		// 2. $user_current_login!=2 user hiện tại ko phải SA, $user["level"]=1, người này là admin, Admin thường chỉ có thể xóa member.
		if(($id == 2) || ($user_current_login!=2 && $user["level"] == 1 )){
			return redirect()->route('admin.user.getList')->with(['flash_level'=>'danger', 'flash_message'=>'Sorry You Can\'t Delete This User!' ]);
		}else{
			$user->delete($id);
			return redirect()->route('admin.user.getList')->with(['flash_level'=>'success', 'flash_message'=>'Delete User Successfully!' ]);
		}
		
		
	}
	
	
	public function getEdit($id){
		$data = User::find($id);
		//1.Admin thường không được edit superAdmin
		// 2.Admin thường không được edit admin khác. ($data["level"] == 1 && Auth::user()->id != $id
		if((Auth::user()->id !=2 && ($id==2 || ($data["level"] == 1 && Auth::user()->id != $id)))){
			return redirect()->route('admin.user.getList')->with(['flash_level'=>'danger', 'flash_message'=>'Sorry You Can\'t Edit This User!' ]);
		}
		return view('admin.user.edit',compact('data'));

	}
	public function postEdit($id, Request $request){
		$user = User::find($id);
			$this->validate($request,
			['txtPass'=>'required','txtRePass' => 'required|same:txtPass'],
			['txtPass.required'=>'Please Enter Password','txtRePass.required' => 'Please Enter Password','txtRePass.same' => 'Two Password Don\'t Match']);
		

	
		$pass = $request->input('txtPass');
		$user->password = Hash::make($pass);
		$user->email = $request->txtEmail;
		$user->level = $request->rdoLevel;
		$user->remember_token = $request->input('_token');
		$user->save();
		return redirect()->route('admin.user.getList')->with(['flash_level'=>'success', 'flash_message'=>'Edit User Successfully!' ]);
	}
	




}
