<?php

class Lot_image extends \Eloquent {
	
	protected $guarded = array();

	protected $table = 'lot_images';

	public static $rules = array(
		
	);

	protected $fillable = array();
	
	public function product(){

		return $this->belongsTo('Lot','lot_id','id');

	}
	
	public function user(){

		return $this->hasOne('User','user_id','id');
	}
}