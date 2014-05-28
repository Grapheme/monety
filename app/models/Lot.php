<?php

class Lot extends \Eloquent {
	
	protected $guarded = array();

	protected $table = 'lots';
	
	public static $rules = array(
	
		'user_id' => 'required|numeric',
		'product_id' => 'required|numeric',
		
		'title' => 'required|between:3,255',
		'type_lot' => 'required|numeric',
		'quantity' => 'required|numeric',
	);
	
	protected $fillable = array();
	
	public function user(){

		return $this->belongsTo('User');
	}
	
	public function product(){

		return $this->belongsTo('Product');
	}
	
	public function images(){

		return $this->hasMany('Image','item_id','id');
	}
}