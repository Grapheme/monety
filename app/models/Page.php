<?php

class Page extends Eloquent {
	
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'seo_url' => 'alpha_dash'
	);

	public static function getMainMenu($template = 'default'){
		
		if(View::exists('templates.'.$template)):
			$menu = array();
			if($pages = self::orderBy('sort_menu','asc')->where('in_menu',1)->get()):
				foreach($pages as $page):
					$menu[$page->url] = $page->name;
				endforeach;
			endif;
			return View::make('templates.'.$template.'.menu',compact('menu'))->render();
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$template.'/menu');
		endif;
		
	}
	
}
