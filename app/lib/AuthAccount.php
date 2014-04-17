<?php

class AuthAccount {
	
	public static function getStartPage($url = NULL){
		
		$StartPage = '';
		if(Auth::check()):
			$StartPage = Auth::user()->groups()->first()->dashboard;
		endif;
		if(!is_null($url)):
			return $StartPage.'.'.$url;
		else:
			return $StartPage;
		endif;
	}
	
	public static function isAdminLoggined(){
		
		if(Auth::check()):
			if(Auth::user()->groups()->first()->id == 1):
				return TRUE;
			endif;
		endif;
		return FALSE;
	}
}
?>