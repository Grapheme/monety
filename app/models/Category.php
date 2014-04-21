<?php

class Category extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'categories';

	public static $rules = array(
	
		'title' => 'required'
	);

	protected $fillable = array();

}