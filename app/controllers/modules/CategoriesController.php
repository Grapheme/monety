<?php

class CategoriesController extends \BaseController {

	protected $category;
	
	public function __construct(Category $category){
		
		$this->category = $category;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$categories = $this->category->all();
		return View::make('modules.catalogs.categories.index', compact('categories'));
	}
	
	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		return View::make('modules.catalogs.categories.create',array('templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Category::validate(Input::all())):
				self::saveCategoryModel();
				$json_request['responseText'] = 'Категория создана';
				$json_request['redirect'] = slink::createAuthLink('catalogs/categories');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Category::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function getEdit($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$category = $this->category->find($id);
		if(is_null($category)):
			return App::abort(404);
		endif;
		return View::make('modules.catalogs.categories.edit',array('category'=>$category,'templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postUpdate($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Category::validate(Input::all())):
				$category = $this->category->find($id);
				self::saveCategoryModel($category);
				$json_request['responseText'] = 'Категория сохранена';
				$json_request['redirect'] = slink::createAuthLink('catalogs/categories');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Category::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
		
	}
	
	public function deleteDestroy($id){
		
		$this->moduleActionPermission('catalogs','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			$this->category->find($id)->delete();
			$json_request['responseText'] = 'Катагория удалена';
			$json_request['status'] = TRUE;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveCategoryModel($category = NULL){
		
		if(is_null($category)):
			$category = $this->category;
		endif;
		$category->title = Input::get('title');
		$category->description = Input::get('description');
		$category->publication = 1;
		if(Allow::enabled_module('languages')):
			$category->language = Input::get('language');
		else:
			$category->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$category->template = Input::get('template');
		else:
			$category->template = 'category';
		endif;
		$category->save();
		$category->touch();
		return $category->id;
	}
}