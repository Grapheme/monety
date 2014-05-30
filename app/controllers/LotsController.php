<?php

class LotsController extends \BaseController {
	
	protected $lot;
	
	public function __construct(Lot $lot){
		
		$this->lot = $lot;
	}
	
	public function getRegisterLot(){
		
		$product = ''; $product_id = 0;
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::whereUserGroup(AuthAccount::getGroupID())->get() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		ImageController::deleteLotImages(0);
		if(Input::has('product_id')):
			if(Product::whereId(Input::get('product_id'))->wherePublication(1)->get()):
				$product = self::createProductsCategoriesList(Product::whereId(Input::get('product_id'))->wherePublication(1)->with('categories')->get());
				$product_id = Input::get('product_id');
			else:
				return Redirect::to(slink::createAuthLink('register-lot'),301);
			endif;
		endif;
		return View::make('user-cabinet.register-lot.index',compact('productsExtendedAttributes','product','product_id'));
	}

	public function postRegisterLotSearchProducts(){
		
		if(!Allow::enabled_module('catalogs')):
			return App::abort(404);
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','found'=>TRUE);
		if(Request::ajax()):
			$validator = Validator::make(Input::all(),array('product_name' => 'required'));
			if($validator->passes()):
				$product_name = mb_strtolower(Input::get('product_name'));
				$products = Product::where('title','LIKE',"%$product_name%")->orderBy('sort','asc')->orderBy('title','asc')->orderBy('price','desc')
					->with('categories')->take(Config::get('app-default.catalog_count_on_page'))->get();
				if($products->count()):
					$products_count = Product::where('title','LIKE',"%$product_name%")->count();
					$json_request['responseText'] = self::createProductsCategoriesList($products,$products_count);
				else:
					$list_empty_title = 'Результаты поиска';
					$list_empty_content = 'По вашему запросу ничего не найдено. Попробуйте изменить запрос.';
					$json_request['responseText'] = View::make('templates.list-empty',compact('list_empty_title','list_empty_content'))->render();
					$json_request['found'] = FALSE;
				endif;
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Поиск товарных позиций';
				$json_request['responseErrorText'] = 'Не указано название товарной позиции';
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function postRegisterLotStore(){
		
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'');
		if(Request::ajax()):
			if(Lot::validate(Input::all(),Lot::$rules,Lot::$rules_messages)):
				self::saveLotModel();
				if(Input::get('type_lot') == 1):
					$json_request['responseText'] = 'Лот выставлен на продажу в магазине';
				elseif(Input::get('type_lot') == 2):
					$json_request['responseText'] = 'Лот выставлен на продажу в аукционе';
				endif;
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode(Lot::$errors,'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function createProductsCategoriesList($products,$products_count = 1){
		
		if($products->count()):
			$catalogTranslit = BaseController::stringTranslite(Catalog::findOrFail(1)->title);
			foreach($products as $product):
				if(!empty($product->categories)):
					foreach($product->categories as $key => $category):
						if($category->category_parent_id == 0):
							$product->categories[$key] = array('link1'=>$catalogTranslit.'/'.$category->seo_url.'-'.$category->id,'name1'=>$category->title,'link2'=>'','name2'=>'');
						else:
							if($parent_category = Category::find($category->category_parent_id)):
								$product->categories[$key] = array('link1'=>$catalogTranslit.'/'.$parent_category->seo_url.'-'.$parent_category->id,'name1'=>$parent_category->title,'link2'=>$catalogTranslit.'/'.$category->seo_url.'-'.$category->id,'name2'=>$category->title);
							endif;
						endif;
					endforeach;
				endif;
			endforeach;
			return View::make('user-cabinet.register-lot.products-search-result',compact('products','products_count'))->render();
		else:
			return '';
		endif;
	}
	
	private function saveLotModel($lot = NULL){
		
		if(is_null($lot)):
			$lot = $this->lot;
		endif;
		
		$lot->user_id = Auth::user()->id;
		$lot->product_id = Input::get('product_id');
		
		$lot->title = Input::get('title');
		$lot->description = Input::get('description');
		$lot->attributes = json_encode(Input::get('attribute'));
		
		$lot->language = App::getLocale();
		$lot->template = 'lot';
		
		$lot->publication = 1;
		$lot->type_lot = Input::get('type_lot');
		$lot->quantity = Input::get('quantity');
		if(Input::get('type_lot') == 1):
			$lot->shop_price = Input::get('shop_price');
		elseif(Input::get('type_lot') == 2):
			$lot->auction_start_price = Input::get('auction_start_price');
			$lot->auction_blitc_price = Input::get('auction_blitc_price');
			$lot->auction_period = Input::get('auction_period');
		endif;
		
		$lot->seo_url = $this->stringTranslite(Input::get('title'));
		$lot->seo_title = Input::get('title');
		$lot->seo_description =$lot->seo_keywords = $lot->seo_h1 = '';

		$lot->save();
		$lot->touch();

		/*
		* Присвоение ранее загруженных файлов к лоту
		*/
		
		if(Session::has('lot_images')):
			Lot_image::where('user_id',Auth::user()->id)->whereIn('id',Session::get('lot_images'))->update(array('lot_id' => $lot->id,'title' => $lot->title));
			Session::forget('lot_images');
		endif;
		return $lot->id;
	}
}