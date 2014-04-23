<?php

class ProductsController extends \BaseController {
	
	protected $product;
	
	public function __construct(Product $product){
		
		$this->product = $product;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$products = $this->product->all();
		return View::make('modules.catalogs.products.index', compact('products'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		$catalogs = Catalog::all();
		$category_groups = CategoryGroup::all();
		if(!$catalogs->count()):
			return Redirect::to(slink::createAuthLink('catalogs/products'))
				->with('message','Для добавления продукта предварительно нужно создать каталог продуктов!<p class="margin-top-10"><a class="btn btn-primary" href="'.slink::createAuthLink('catalogs/create').'">Добавить каталог</a>
				</p>');
		endif;
		$data_fields = array();
		if($catalogs->count() == 1):
			if(!empty($catalogs->first()->fields)):
				$data_fields = json_decode($catalogs->first()->fields);
			endif;
		endif;
		return View::make('modules.catalogs.products.create',compact('catalogs','category_groups','data_fields'));
	}

	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Product::validate(Input::all(),Product::$rules,Product::$rules_messages)):
				self::saveProductModel();
				$json_request['responseText'] = 'Продукт создан';
				$json_request['redirect'] = slink::createAuthLink('catalogs/products');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode(Product::$errors,'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function show($id){
		$product = Product::findOrFail($id);

		return View::make('products.show', compact('product'));
	}

	public function edit($id){
		$product = Product::find($id);

		return View::make('products.edit', compact('product'));
	}

	public function update($id){
		
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails()){
			
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$product->update($data);

		return Redirect::route('products.index');
	}

	public function destroy($id){
		
		Product::destroy($id);

		return Redirect::route('products.index');
	}
	
	private function saveProductModel($product = NULL){
		
		if(is_null($product)):
			$product = $this->product;
		endif;
		
		$product->user_id = Auth::user()->id;
		$product->catalog_id = Input::get('catalog_id');
		$product->category_group_id = Input::get('category_group_id');
		
		$product->sort = (int)Product::max('sort')+1;
		$product->title = Input::get('title');
		$product->description = Input::get('description');
		$product->price = Input::get('price');
		$product->attributes = json_encode(Input::get('attribute'));
		$product->tags = json_encode(explode(',',Input::get('tags')));

		$product->publication = 1;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if(AuthAccount::isAdminLoggined()):
					$dirPath = 'uploads/catalogs';
					$dirFullPath = public_path($dirPath);
				elseif(AuthAccount::isUserLoggined()):
					$dirPath = 'usersfiles/account-'.Auth::user()->id.'/catalogs';
					$dirFullPath = base_path($dirPath);
				else:
					$dirPath = 'usersfiles/temporary/catalogs';
					$dirFullPath = base_path($dirPath);
				endif;
				if($productImages = json_decode($product->image)):
					if(!empty($productImages->image) && File::exists($dirFullPath.'/'.$productImages->image)):
						File::delete($dirFullPath.'/'.$productImages->image);
					endif;
					if(!empty($productImages->thumbnail) && File::exists($dirFullPath.'/thumbnail/'.$productImages->thumbnail)):
						File::delete($dirFullPath.'/'.$productImages->thumbnail);
					endif;
				endif;
				if(!File::isDirectory($dirFullPath.'/thumbnail')):
					File::makeDirectory($dirFullPath.'/thumbnail',0777,TRUE);
				endif;
				$fileName = str_random(24).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save($dirFullPath.'/thumbnail/'.$fileName);
				Input::file('file')->move($dirFullPath,$fileName);
				$product->image = json_encode(array('image' => $dirPath.'/'.$fileName,'thumbnail'=> $dirPath.'/thumbnail/'.$fileName));
			endif;
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$product->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$product->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$product->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$product->seo_title = $product->title;
			else:
				$product->seo_title = trim(Input::get('seo_title'));
			endif;
			$product->seo_description = Input::get('seo_description');
			$product->seo_keywords = Input::get('seo_keywords');
			$product->seo_h1 = Input::get('seo_h1');
		else:
			$product->seo_url = $this->stringTranslite(Input::get('title'));
			$product->seo_title = Input::get('title');
			$product->seo_description =$product->seo_keywords = $product->seo_h1 = '';
		endif;
		$product->save();
		$product->touch();
		return $product->id;
	}
	
}