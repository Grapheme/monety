<?php

class Catalog extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'catalogs';

	public static $rules = array(
	
		'title' => 'required',
	);

	protected $fillable = array();
	
	public function products(){

		return $this->hasMany('Product');

	}
	
	/*
	* Функия формирует транслит имен всех существующих каталогов продукции 
	* так же добавляет зарезервированные имена которые относятся к каталогам
	* Используется для определения находится ли пользователь в ветке (URL) каталога
*	*/
	
	public static function getCatalogsTranslitNames(){
		
		$catalogsNames = array('catalog');
		if($catalogs = Catalog::select('title')->where('language',Config::get('app.locale'))->where('publication',1)->get()):
			foreach($catalogs as $key => $value):
				$catalogsNames[] = BaseController::stringTranslite($value->title);
			endforeach;
		endif;
		return $catalogsNames;
	}
}