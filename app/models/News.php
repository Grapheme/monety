<?php

class News extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'news';
	
	public static $order_by = 'sort DESC,date_publication DESC';

	public static $rules = array(
		'title' => 'required',
		'seo_url' => 'alpha_dash',
	);

}