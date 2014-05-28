<?php

class Lot extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'lots';
	
	public static $rules = array(
	
		'product_id' => 'required|numeric',
		
		'title' => 'required|between:3,255',
		'type_lot' => 'required|numeric',
		'quantity' => 'required|numeric',
	);
	
	public static $rules_messages = array(
		
		'product_id.required' => 'ID товара должено быть определено',
		'product_id.numeric' => 'ID товара должен быть числом',
		
		'title.required' => 'Название лота не должно быть пустым!',
		'title.between' => 'Название лота должно быть от 3 до 255 символов!',
		'type_lot.required' => 'Способ продажи должен быть указан',
		'type_lot.numeric' => 'Способ продажи должен быть числом',
		'quantity.required' => 'Поле количество не должно быть пустым!',
		'quantity.numeric' => 'Значение количества должно быть числом',
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