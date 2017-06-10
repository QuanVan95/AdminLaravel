<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Http\Request; 
use App\Product;
use App\Cate;
use Auth;
use App\Http\Requests\ProductRequest;
use App\ProductImages;
use Input;
use File;
use Request; //Chỉ cần dùng use request. Dùng ajax xóa ảnh khôg dùng Illuminate

class ProductController extends Controller {

	//
	public function getList(){
		$data = Product::select('id','product_name','price','cate_id','created_at')->orderBy('id','DESC')->get()->toArray();
		return view('admin.product.list',compact('data'));
	}
	public function getAdd(){
		$cate = Cate::select('name','id','parent_id')->get()->toArray();
		return view('admin.product.add',compact('cate'));
	}

	public function postAdd(ProductRequest $product_request){
		$file_name = $product_request->file('fImages')->getClientOriginalName();
		//B1. Lấy tên file.name="fImages" bên trang add product
		$product = new Product();
		$product->product_name = $product_request->txtName;
		$product->alias = changeTittle($product_request->txtName);
		$product->price = $product_request->txtPrice;
		$product->intro = $product_request->txtIntro;
		$product->content = $product_request->txtContent;
		$product->image = $file_name; //B2. Gán Original name vào image
		$product->keywords = $product_request->txtKeywords;
		$product->product_description = $product_request->txtDescription;
		$product->user_id = Auth::user()->id;//Auth trong laravel
		$product->cate_id = $product_request->sltParent;
		$product_request->file('fImages')->move('resources/upload/',$file_name); //B3. Chuyển hình vào mục upload
		$product->save();
		//Upload ảnh detail
		$product_id=$product->id;
		if(Input::hasFile('fProductDetail')){          
			foreach (Input::file('fProductDetail') as $file){
				$product_img = new ProductImages();
				if(isset($file)){
					$product_img -> image = $file -> getClientOriginalName();
					$product_img -> product_id = $product_id;
					$file->move('resources/upload/detail/', $file->getClientOriginalName());
					$product_img->save();
				}
			}
		}
		return redirect()->route('admin.product.getList')->with(['flash_level'=>'success','flash_message'=>'Add Successfully' ]);


	}

	public function getDelete($id){
		$product_detail = Product::find($id)->pimages->toArray(); //Đây là lấy ảnh chi tiết của sản phẩm a
		//Hàm pimages lấy ở trong file Model Product(app/product) function pimages hasMany ProductImages
		foreach($product_detail as $value){
			File::delete('resources/upload/detail/'.$value["image"]); //b1: xóa ảnh detail của sản phẩm
		}
		$product = Product::find($id);
		File::delete('resources/upload/'.$product->image); //b2. xóa ảnh gốc của sp
		$product->delete($id); //b3: Xóa dữ liệu trong bảng product -> xóa luôn trong product_images
		return redirect()->route('admin.product.getList')->with(['flash_level'=>'success','flash_message'=>'Delete Successfully']);
		// var_dump($product->image);
		// var_dump(File::isFile('resources/upload/detail/'.$product->image)); // True
		// File::delete('resources/upload/detail/'.$product->image);
		// var_dump(File::isFile('resources/upload/detail/'.$product->image)); // False
		// exit();
		

	}

	public function getEdit($id){
		$product = Product::findOrFail($id)->toArray();
		// $product=Product::find($id);
		$cate = Cate::select('name','id','parent_id')->get()->toArray();
		$product=Product::find($id);
		$product_image = Product::find($id)->pimages;
		return view('admin.product.edit',compact('cate','product','product_image','product'));
	}

	public function postEdit($id,Request $request){ //Khi dùng thư viện Request, không dùng Illuminate sẽ không sử dụng được $request->txtName như bình thường.
		$product = Product::find($id);  
		$product->product_name = Request::input('txtName');
		$product->alias = changeTittle(Request::input('txtName'));
		$product->price = Request::input('txtPrice');
		$product->intro = Request::input('txtIntro');
		$product->content = Request::input('txtContent');
		$product->keywords = Request::input('txtKeywords');
		$product->product_description = Request::input('txtDescription');
		$product->user_id = Auth::user()->id; //Auth trong laravel
		$product->cate_id = Request::input('sltParent');
		$img_current= 'resources/upload/'.Request::input('img_current');
		if(!empty(Request::file('fImages'))){ //B1. kiểm tra thẻ input name='fImage' có chọn file hay không.
			$file_name=Request::file('fImages')->getClientOriginalName();
			$product->image = $file_name;
			Request::file('fImages')->move('resources/upload/',$file_name);  //B2. gán tên,chuyển hình mới vào
			if (File::exists($img_current)){    //B3. Xóa hình hiện tại
				File::delete($img_current);
			}

		}else{
			echo "No File!";
		}          
		$product->save();
		//Xử lý upload ảnh detail trong trang Edit.
		if(!empty(Request::file('fEditDetail'))){ //fEditDetail nằm trong file myscrip.js. Phần append để add thêm image
			foreach (Request::file('fEditDetail') as $file) {
				$product_img = new ProductImages; //App/ProductImages (Model)
				if(isset($file)){ //Nếu không kiểm tra isset, chọn cách 1 ảnh sẽ lỗi.
					$product_img -> image = $file->getClientOriginalName();
					$product_img -> product_id = $id;
					$file->move('resources/upload/detail/',$file->getClientOriginalName());
					$product_img->save();
				}
			}
			
		}
		
		return redirect()->route('admin.product.getList')->with(['flash_level'=>'success','flash_message'=>'Update Successfully']);

	}

	public function getDelImg ($id){            //Xóa hình khi edit
		if(Request::ajax()) {
			$idHinh = (int)Request::get('idHinh');
			$image_detail = ProductImages::find($idHinh); // Tìm img_dtl trong ProductImages có id=idHinh
			if(!empty($image_detail))
			{
				$img='resources/upload/detail/'.$image_detail->image;
				if(File::exists($img)){
					File::delete($img);			//Xóa file trong upload/detail
				}
				$image_detail->delete(); //xóa image_detail
			}		
			return "Delete";
		}

	}

}
