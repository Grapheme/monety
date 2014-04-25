<?php

class shortcode {

	public static function view($options, $data = NULL){

		if(isset($options['path'])):
			if(View::exists($options['path'])):
				if(!is_null($data) && is_array($data)):
					return View::make($options['path'],$data);
				else:
					return View::make($options['path']);
				endif;
			else: 
				return "Отсутсвует шаблон: ".$options['path'];
			endif;
		else:
			return "Путь к представлению не указан";
		endif;
	}

	public static function news($options = NULL, $data = NULL){
		
		//Настройки по-умолчанию
		$config['view'] = Config::get('app-default.news_template');
		$config['limit'] = Config::get('app-default.news_count_on_page');
		$config['order'] = BaseController::stringToArray(News::$order_by);
		//Настройки переданные пользователем
		if(!is_null($options) && !empty($options)):
			if(isset($options['field']) && !empty($options['field'])):
				$config['order'] = array();
				$config['order'][0] = array($options['field'],'asc');
				if(isset($options['direction']) && !empty($options['direction'])):
					$config['order'][0] = array($options['field'],$options['direction']);
				endif;
			endif;
			unset($options['field']);
			unset($options['direction']);
			foreach($options as $option => $value):
				$config[$option] = $value;
			endforeach;
		endif;
		if(Allow::enabled_module('news')):
			$selected_news = News::where('publication',1)->where('language',Config::get('app.locale'));
			if(!empty($config['order'])):
				foreach($config['order'] as $order):
					if(isset($order[1])):
						$selected_news = $selected_news->orderBy($order[0],$order[1]);
					else:
						$selected_news = $selected_news->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			$news = $selected_news->paginate($config['limit']);
			if($news->count()):
				if(View::exists('templates.'.$config['view'])):
					return View::make('templates.'.$config['view'],compact('news'));
				else: 
					return "Отсутсвует шаблон: templates.".$config['view'];
				endif;
			endif;
		else:
			return '';
		endif;
	}
	
	public static function articles($options = NULL, $data = NULL){
		
		//Настройки по-умолчанию
		$config['view'] = Config::get('app-default.articles_template');
		$config['limit'] = Config::get('app-default.articles_count_on_page');
		$config['order'] = BaseController::stringToArray(Article::$order_by);
		//Настройки переданные пользователем
		if(!empty($options)):
			if(isset($options['field']) && !empty($options['field'])):
				$config['order'] = array();
				$config['order'][0] = array($options['field'],'asc');
				if(isset($options['direction']) && !empty($options['direction'])):
					$config['order'][0] = array($options['field'],$options['direction']);
				endif;
			endif;
			unset($options['field']);
			unset($options['direction']);
			foreach($options as $option => $value):
				$config[$option] = $value;
			endforeach;
		endif;
		if(Allow::enabled_module('articles')):
			$selected_articles = Article::where('publication',1)->where('language',Config::get('app.locale'));
			if(!empty($config['order'])):
				foreach($config['order'] as $order):
					if(isset($order[1])):
						$selected_articles = $selected_articles->orderBy($order[0],$order[1]);
					else:
						$selected_articles = $selected_articles->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			$articles = $selected_articles->paginate($config['limit']);
			if($articles->count()):
				if(View::exists('templates.'.$config['view'])):
					return View::make('templates.'.$config['view'],compact('articles'));
				else: 
					return "Отсутсвует шаблон: templates.".$config['view'];
				endif;
			endif;
		else:
			return '';
		endif;
	}

	public static function gallery($options = NULL, $data = NULL){
		
		if(isset($options['name'])){
			$name = $options['name'];
	        if(gallery::where('name', $name)->exists()){
	        	$gall = gallery::where('name', $name)->first();
	        	$photos = $gall->photos;
	        	$str = "";
	        	foreach($photos as $photo)
	        	{
	        		$str .= "<li><img src=\"{$photo->path()}\" alt=\"\" style=\"max-width: 150px;\"></li>";
	        	}
	        	return "<ul>".$str."</ul>";

	        } else {
	        	return "Error: Gallery {$name} doesn't exist";
	        }
	    } else {
			return "Error: name of gallery is not defined!";
		}
	}

	public static function map($options){
		if(!isset($options['width'])) 	$options['width'] = '500';
		if(!isset($options['height'])) 	$options['height'] = '500';
		if(!isset($options['zoom'])) 	$options['zoom'] = '5';
		//Default options

		if(!isset($options['title'])) 	{ $title = null; } 		else { $title = "hintContent: '{$options['title']}'"; }
		if(!isset($options['preview']))	{ $preview = null; }	else { $preview = "balloonContent: '{$options['preview']}'"; }
		
		if( $title == null && $preview == null)
		{
			$placemark = null;
		} else {
			$placemark = 	'myPlacemark = new ymaps.Placemark(['.$options['position'].'], {
			                '.$title.'
			                '.$preview.'
			            	});
							myMap.geoObjects.add(myPlacemark);';
		}

		$map = '<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
			    <script type="text/javascript">
			        ymaps.ready(init);
			        var myMap, 
			            myPlacemark;

			        function init(){ 
			            myMap = new ymaps.Map ("map", {
			                center: ['.$options['position'].'],
			                zoom: '.$options['zoom'].'
			            }); 
			            '.$placemark.'
			        }
			    </script>';
		$div = '<div id="map" style="width: '.$options['width'].'px; height: '.$options['height'].'px;"></div>';
		return $map.$div;
	}
}