<?php

class Catalog extends \Eloquent {
	
	protected $guarded = array();

	protected $table = 'catalogs';

	public static $rules = array(
	
		'title' => 'required',
	);

	protected $fillable = array();

}