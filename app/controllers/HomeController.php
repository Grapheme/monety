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
		
		$news->original_image = $news->thumbnail_image = FALSE;
		if($newsImages = json_decode($news->image)):
			if(!empty($newsImages->image) && File::exists(base_path($newsImages->image))):
				$news->original_image = TRUE;
			endif;
			if(!empty($newsImages->thumbnail) && File::exists(base_path($newsImages->thumbnail))):
				$news->thumbnail_image = TRUE;
			endif;
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
		
		if(!Allow::enabled_module('catalogs')):
			return App::abort(404);
		endif;
		$product_id = getItemIDforURL($product_url);
		if(AuthAccount::isAdminLoggined()):
			$product = Product::where('language',Config::get('app.locale'))->find($product_id);
		else:
			$product = Product::where('publication',1)->where('language',Config::get('app.locale'))->find($product_id);
		endif;
		if(!$product):
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
			$product->in_auction = $product->lotsInAuction();
			$product->in_shop = $product->lotsInShop();
			foreach($product->in_auction as $index => $lot):
				$product->in_auction[$index]->owner = $lot->user()->first();
			endforeach;
			foreach($product->in_shop as $index => $lot):
				$product->in_shop[$index]->owner = $lot->user()->first();
			endforeach;
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
		$category_id = getItemIDforURL($category_url);
		if($catalogs = Catalog::where('language',Config::get('app.locale'))->where('publication',1)->get()):
			$productsCatalog = NULL;
			foreach($catalogs as $catalog):
				if($this->stringTranslite($catalog->title) == $catalog_title_translit):
					$productsCatalog = $catalog;
				endif;
			endforeach;
			if(!is_null($catalog)):
				if($productsCategory = Category::where('publication',1)->find($category_id)):
					Session::put('products.active_category_url',$category_url);
					if($productsCategory->category_parent_id == 0):
						if($sub_categories_ids = Category::where('publication',1)->where('category_parent_id',$category_id)->orWhere('id',$category_id)->lists('id')):
							$products = Product::select('products.*')->join('category_product','products.id','=','category_product.product_id')
								->whereIn('category_id',$sub_categories_ids)->where('publication',1)->where('catalog_id',$productsCatalog->id)
								->orderBy('sort','asc')->orderBy('title','asc')->orderBy('price','desc')->paginate(Config::get('app-default.catalog_count_on_page'));
						endif;
					else:
						$products = Category::where('publication',1)->find($category_id)->products()->where('publication',1)->where('catalog_id',$productsCatalog->id)
							->orderBy('sort','asc')->orderBy('title','asc')->orderBy('price','desc')->paginate(Config::get('app-default.catalog_count_on_page'));
					endif;
					foreach($products as $index => $product):
						$products[$index]['in_auction'] = $product->lotsInAuction()->count();
						$products[$index]['in_shop'] = $product->lotsInShop()->count();
					endforeach;
					if(!empty($productsCatalog->template) && View::exists('templates.'.$productsCatalog->template)):
						$view_variables = array(
							'page_title'=>$productsCategory->seo_title,'page_description'=>$productsCategory->seo_description,'pege_keywords'=>$productsCategory->seo_keywords,
							'page_author'=>'','page_h1'=>$productsCategory->seo_h1,'menu'=> Page::getMenu(),
							'products'=>$products, 'category_content' => sPage::content_render($productsCategory->description),'content' => sPage::content_render($productsCatalog->description)
						);
						return View::make('templates.'.$productsCatalog->template,$view_variables);
					else:
						return App::abort(404,'Отсутсвует шаблон: templates/'.$productsCategory->template);
					endif;
				else:
					return App::abort(404);
				endif;
			else:
				return App::abort(404);
			endif;
		else:
				return App::abort(404);
		endif;
	}  // Функция для просмотра каталога товаров
	
	public function getShowProductLot($lot_url){
		
		if(!Allow::enabled_module('catalogs')):
			return App::abort(404);
		endif;
		$lot_id = getItemIDforURL($lot_url);
		if(AuthAccount::isAdminLoggined()):
			$lot = Lot::where('language',Config::get('app.locale'))->find($lot_id);
		else:
			$lot = Lot::where('publication',1)->where('language',Config::get('app.locale'))->find($lot_id);
		endif;
		if(!$lot):
			return App::abort(404,'Запрашиваемый лот не найден');
		endif;
		if(!empty($lot->template) && View::exists('templates.'.$lot->template)):
			$lot->attributes = json_decode($lot->attributes);
			$lot->owner = $lot->user()->first();
			$lot->images =  Lot_image::where('lot_id',$lot->id)->get();
			return View::make('templates.'.$lot->template,array('lot'=>$lot,'page_title'=>$lot->seo_title,'page_description'=>$lot->seo_description,
					'pege_keywords'=>$lot->seo_keywords,'page_author'=>'','page_h1'=>$lot->seo_h1,'menu'=> Page::getMenu()));
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$lot->template);
		endif;
	} // Функция для просмотра лота
}