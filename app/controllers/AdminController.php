<?php

class AdminController extends BaseController {
	
	public function __construct(){
		
		parent::__construct();
	}
	
	public function mainPage(){
		
		return View::make('admin.dashboard');
	}

}