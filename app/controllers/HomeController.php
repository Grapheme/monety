<?php

class HomeController extends BaseController {
	
	public function showPage($url = ''){
		
		return sPage::show($url);
	}

	/*
	|--------------------------------------------------------------------------
	| Раздел "Новости"
	|--------------------------------------------------------------------------
	*/
	public function showNews($url){
		
		if(!Allow::enabled_module('news')):
			return App::abort(404);
		endif;
		if(!$news = News::where('seo_url',$url)->where('publication',1)->where('language',Config::get('app.locale'))->first()):
			return App::abort(404);
		endif;
		if(!empty($news->template) && View::exists('templates.'.$news->template)):
			return View::make('templates.'.$news->template,array('news'=>$news,'page_title'=>$news->seo_title,'page_description'=>$news->seo_description,
					'pege_keywords'=>$news->seo_keywords,'page_author'=>'','page_h1'=>$news->seo_h1,'menu'=> Page::getMenu('news')));
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$news->template);
		endif;
	}  // Функция для просмотра одной новости
	
	/*
	|--------------------------------------------------------------------------
	| Раздел "Статьи"
	|--------------------------------------------------------------------------
	*/
	public function showArticle($url){
		
		if(!Allow::enabled_module('articles')):
			return App::abort(404);
		endif;
		if(!$article = Article::where('seo_url',$url)->where('publication',1)->where('language',Config::get('app.locale'))->first()):
			return App::abort(404);
		endif;
		if(!empty($article->template) && View::exists('templates.'.$article->template)):
			return View::make('templates.'.$article->template,array('article'=>$article,'page_title'=>$article->seo_title,'page_description'=>$article->seo_description,
					'pege_keywords'=>$article->seo_keywords,'page_author'=>'','page_h1'=>$article->seo_h1,'menu'=> Page::getMenu('news')));
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$article->template);
		endif;
	}  // Функция для просмотра одной новости
	
	/*
	|--------------------------------------------------------------------------
	| Раздел "Каталог"
	|--------------------------------------------------------------------------
	*/
	public function getShowProduct($product_url){
		
		$url = explode('-',$product_url);
		$product_id = array_pop($url);
		if(!is_numeric($product_id)):
			return App::abort(404,'Запрашиваемый продукт не найден');
		endif;
		if(!Allow::enabled_module('catalogs')):
			return App::abort(404);
		endif;
		if(!$product = Product::where('publication',1)->where('language',Config::get('app.locale'))->find($product_id)):
			return App::abort(404,'Запрашиваемый продукт не найден');
		endif;
		if(!empty($product->template) && View::exists('templates.'.$product->template)):
			if(!empty($product->attributes)):
				$product->attributes = json_decode($product->attributes,TRUE);
			endif;
			if($product->tags = json_decode($product->tags)):
				$product->tags = implode($product->tags,', ');
			endif;
			$data_fields = json_decode($product->catalog->fields);
			$productAttributes = array();
			foreach($data_fields as $field):
				$productAttributes[$field->label] = (isset($product->attributes[$field->name]))? $product->attributes[$field->name] : '';
			endforeach;
			$product->attributes = $productAttributes;
			$product->categories = $product->categories()->get()->toArray();
			
			$module = Modules::where('url','catalogs')->first();
			$product->images = Image::where('module_id',$module->id)->where('item_id',$product->id)->get();
			return View::make('templates.'.$product->template,array('product'=>$product,'page_title'=>$product->seo_title,'page_description'=>$product->seo_description,
					'pege_keywords'=>$product->seo_keywords,'page_author'=>'','page_h1'=>$product->seo_h1,'menu'=> Page::getMenu()));
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$product->template);
		endif;
	}  // Функция для просмотра одного товара
	
	public function getShowCatalogProduct($catalog_title_translit,$category_url){
		
		if(!Allow::enabled_module('catalogs')):
			return App::abort(404);
		endif;
		$url = explode('-',$category_url);
		$category_id = array_pop($url);
		if(!is_numeric($category_id)):
			return App::abort(404,'Запрашиваемая категория не найдена');
		endif;
		if($catalogs = Catalog::where('language',Config::get('app.locale'))->where('publication',1)->get()):
			$productsCatalog = NULL;
			foreach($catalogs as $catalog):
				if($this->stringTranslite($catalog->title) == $catalog_title_translit):
					$productsCatalog = $catalog;
				endif;
			endforeach;
			if(!is_null($catalog)):
				$products = array();
				if($productsCategory = Category::where('publication',1)->findOrFail($category_id)):
					$products = Product::where('category_group_id',$productsCategory->id)->where('catalog_id',$productsCatalog->id)->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->orderBy('price','desc')->get();
					if(!empty($productsCatalog->template) && View::exists('templates.'.$productsCatalog->template)):
						return View::make('templates.'.$productsCatalog->template,array('products'=>$products,'page_title'=>$productsCategory->seo_title,'page_description'=>$productsCategory->seo_description,
								'pege_keywords'=>$productsCategory->seo_keywords,'page_author'=>'','page_h1'=>$productsCategory->seo_h1,'menu'=> Page::getMenu()));
					else:
						return App::abort(404,'Отсутсвует шаблон: templates/'.$productsCategory->template);
					endif;
				endif;
			else:
				return App::abort(404);
			endif;
		else:
				return App::abort(404);
		endif;
	}  // Функция для просмотра каталога товаров

}