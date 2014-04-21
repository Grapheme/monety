<?php

class Catalog extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'catalogs';

	public static $rules = array(
	
		'title' => 'required',
	);

	protected $fillable = array();

}