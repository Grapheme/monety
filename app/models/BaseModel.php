<?php

class BaseModel extends Eloquent {
	
	public static $errors = array();

	public static function validate($data,$rules = NULL){
		
		if(is_null($rules)):
			$rules = static::$rules;
		endif;
		$validation = Validator::make($data,$rules);
		if($validation->fails()):
			static::$errors = $validation->messages()->all();
			return FALSE;
		endif;
		return TRUE;
	}

}