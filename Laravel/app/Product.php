<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $table = 'products';
	protected $fillable = ['product_name', 'alias', 'price', 'intro','content', 'image', 'keywords', 'product_description' ];
	//public $timestamps = false ;
	
	public function cate(){
		return $this->belongTo('App\Cate');
	}

	public function user(){
		return $this->belongTo('App\User');
	}

	public function pimages(){
		return $this-> hasMany('App\ProductImages');
	}
}
