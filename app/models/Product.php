<?php

class Product extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'products';

	public static $rules = array(
	
		'seo_url' => 'alpha_dash',
		'catalog_id' => 'required|integer',
		'category_group_id' => 'required|integer'
	);

	protected $fillable = array();
	
	
	public function catalogProducts(){

		return $this->belongsTo('Catalog');

	}
	
	public function categoryGroup(){

		return $this->belongsTo('CategoryGroup');

	}
	
	
}