<?php

/*
* Функиця возвращает ID из URL. ID должен быть последним элементом в строке
*/

function getItemIDforURL($string_url = NULL){
	
	if(!is_null($string_url)):
		$url = explode('-',$string_url);
		$id = array_pop($url);
		if(!is_numeric($id)):
			return App::abort(404);
		else:
			return $id;
		endif;
	endif;
}

?>