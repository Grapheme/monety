<?php

class UserCabinetController extends BaseController {
	
	public function __construct(){
		
		parent::__construct();
	}
	
	public function mainPage(){
		
		return View::make('user-cabinet.dashboard');
	}
	
	/*
	* Функции по управлению лотами
	*/
	
	public function getRegisterLot($products = array()){
		
		$categoryGroup = CategoryGroup::findorFail(1);
		$categories = Category::getTreeCategories($categoryGroup->id);
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::all() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		return View::make('user-cabinet.register-lot.index',compact('categories','productsExtendedAttributes','products'));
	}
	
	public function getRegisterLotNewProduct(){
		
		return 'YES';
	}
	
	public function postRegisterLot(){
		
		dd(Input::all());
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
				$products = Product::where('title','LIKE',"%$product_name%")->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->orderBy('price','desc')
					->with('categories')->paginate(Config::get('app-default.catalog_count_on_page'));
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
					$json_request['responseText'] = View::make('user-cabinet.register-lot.products-search-result',compact('products'))->render();
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

}