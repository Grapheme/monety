<?php

class UserCabinetController extends BaseController {
	
	public function __construct(){
		
		parent::__construct();
	}
	
	public function mainPage(){
		
		return View::make('user-cabinet.dashboard');
	}
	
	/*************************** Функции по управлению каталогом продукции **********************/
	
	public function getNewCatalogProduct(){
		
		$catalogs = Catalog::all();
		$category_groups = CategoryGroup::all();
		$categories = Category::getTreeCategories($category_groups->first()->id);
		$data_fields = array();
		if($catalogs->count() == 1):
			if(!empty($catalogs->first()->fields)):
				$data_fields = json_decode($catalogs->first()->fields);
			endif;
		endif;
		ImageController::deleteImages('catalogs',0);
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::whereUserGroup(1)->get() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		return View::make('user-cabinet.register-lot.request-new-product',compact('catalogs','category_groups','data_fields','productsExtendedAttributes','categories'));
	}
	
	public function postRegisterLotRequestNewProductStore(){
		
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Product::validate(Input::all(),Product::$rules,Product::$rules_messages)):
				if(!Product::whereTitle(Input::get('title'))->get()->toArray()):
					self::saveProductModel();
					$json_request['responseText'] = 'Продукт отправлен на модерацию';
					$json_request['status'] = TRUE;
				else:
					$json_request['responseText'] = 'Продукт с таким названием уже существует';
				endif;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode(Product::$errors,'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveProductModel(){
		
		$product = new Product;
		
		$product->user_id = Auth::user()->id;
		$product->catalog_id = Input::get('catalog_id');
		$product->category_group_id = Input::get('category_group_id');
		
		$product->sort = Input::get('sort');
		$product->title = Input::get('title');
		$product->description = Input::get('description');
		$product->price = Input::get('price');
		$product->attributes = json_encode(Input::get('attribute'));
		$product->tags = json_encode(explode(',',Input::get('tags')));

		$product->publication = 0;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				$dirPath = 'public/uploads/catalogs';
				if($productImages = json_decode($product->image)):
					if(!empty($productImages->image) && File::exists(base_path($productImages->image))):
						File::delete(base_path($productImages->image));
					endif;
					if(!empty($productImages->thumbnail) && File::exists(base_path($productImages->thumbnail))):
						File::delete(base_path($productImages->thumbnail));
					endif;
				endif;
				if(!File::isDirectory(base_path($dirPath.'/thumbnail'))):
					File::makeDirectory(base_path($dirPath.'/thumbnail'),0777,TRUE);
				endif;
				$fileName = str_random(24).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save(base_path($dirPath.'/thumbnail/'.$fileName));
				Input::file('file')->move(base_path($dirPath),$fileName);
				$product->image = json_encode(array('image' => $dirPath.'/'.$fileName,'thumbnail'=> $dirPath.'/thumbnail/'.$fileName));
			endif;
		endif;
		$product->language = App::getLocale();
		$product->template = 'product';
		$product->seo_url = $this->stringTranslite(Input::get('title'));
		$product->seo_title = Input::get('title');
		$product->seo_description =$product->seo_keywords = $product->seo_h1 = '';

		$product->save();
		$product->touch();

		/*
		* Присвоение ранее загруженных файлов к товару
		*/
		
		$module = Modules::where('url','catalogs')->first();
		if(Session::has($module->url.'_product')):
			Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->whereIn('id',Session::get($module->url.'_product'))->update(array('item_id' => $product->id,'title' => $product->title));
			Session::forget($module->url.'_product');
		endif;
		
		/*
		* Распределение категорий товара
		*/
		if(Input::get('categories') != ''):
			$categoriesIDs = explode(',',Input::get('categories'));
			$product->categories()->sync($categoriesIDs);
		else:
			$product->categories()->detach();
		endif;
		return $product->id;
	}

	public function postUploadCatalogProductImages($product_id = NULL){
		
		if(Input::hasFile('file')):
			if(!is_null($product_id)):
				$product = Product::where('user_id',Auth::user()->id)->find($product_id);
			else:
				$product = NULL;
			endif;
			$dirPath = 'public/uploads/catalogs';
			$dirFullPath = base_path($dirPath);
			
			if(!File::isDirectory($dirFullPath.'/thumbnail')):
				File::makeDirectory($dirFullPath.'/thumbnail',0777,TRUE);
			endif;
			$fileName = str_random(24).'.'.Input::file('file')->getClientOriginalExtension();
			ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save($dirFullPath.'/thumbnail/'.$fileName);
			Input::file('file')->move($dirFullPath,$fileName);
			
			$productID = (!is_null($product)) ? $product->id : 0;
			$productTitle = (!is_null($product)) ? $product->title : '';
			$module = Modules::where('url','catalogs')->first();
			$maxSortValue = (int)Image::where('item_id',$productID)->where('module_id',$module->id)->max('sort')+1;
			
			$newImageData = array('module_id' => $module->id,'item_id' => $productID,'user_id'=>Auth::user()->id,'sort' => $maxSortValue,'title' => $productTitle,'description' => '','attributes' => '[]','publication' => 1,
				'paths' => json_encode(array('image' => $dirPath.'/'.$fileName,'thumbnail'=> $dirPath.'/thumbnail/'.$fileName)));
			$newImage = Image::create($newImageData);
			if(is_null($product)):
				$FreeImagesIDs = Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->where('item_id',0)->lists('id');
				Session::put($module->url.'_product', $FreeImagesIDs);
			endif;
			return Response::json(array('status'=>TRUE,'responseText'=>'Файл загружен'),200);
		else:
			return Response::json(array('status'=>FALSE,'responseText'=>'Файл не загружен'),400);
		endif;
		
	}
}