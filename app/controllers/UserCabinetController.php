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
	
	public function getRegisterLot(){
		
		$categoryGroup = CategoryGroup::findorFail(1);
		$categories = Category::getTreeCategories($categoryGroup->id);
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::all() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		return View::make('user-cabinet.register-lot',compact('categories','productsExtendedAttributes'));
	}
	
	public function postRegisterLot(){
		
		dd(Input::all());
	}

}