<?php

/*Event::listen ('illuminate.query',function($query){var_dump($query);});*/

$prefix = 'guest';
if(Auth::check()):
	$prefix = AuthAccount::getStartPage();
endif;

	/*
	| Общие роутеры независящие от условий
	*/

Route::get('image/{image_group}/{id}', 'ImageController@showImage')->where('id','\d+');
Route::get('redactor/get-uploaded-images', 'DownloadsController@redactorUploadedImages');
Route::post('redactor/upload','DownloadsController@redactorUploadImage');

	/*
	| Роутеры доступные для всех групп авторизованных пользователей
	*/
	
Route::group(array('before'=>'auth','prefix'=>$prefix),function(){
	
	Route::get('image/uploaded/{file_name}', 'ImageController@showUserUploadedFile');
	Route::get('image/uploaded_thumbnail/{file_name}', 'ImageController@showUserUploadedFile');
	Route::get('image/uploaded_thumbnail/{file_name}', 'ImageController@showUserUploadedThumbnailFile');
	
	Route::controller('pages', 'PagesController');
	Route::controller('galleries', 'GalleriesController');
	Route::controller('downloads', 'DownloadsController');
	Route::controller('news', 'NewsController');
	Route::controller('articles','ArticlesController');
	
	Route::delete('image/destroy/{id}', 'ImageController@deleteImage')->where('id','\d+');
	Route::post('catalogs/products/upload-product-photo', 'DownloadsController@postUploadCatalogProductImages');
	Route::post('catalogs/products/upload-product-photo/product/{product_id}', 'DownloadsController@postUploadCatalogProductImages')->where('product_id','\d+');
	Route::get('catalogs/products/search-catalog-category/{category_group_id}', 'CategoriesController@getSugestSearchCategory')->where('category_group_id','\d+');
	Route::post('catalogs/products/publication/{product_id}','ProductsController@postCatalogProductPublication')->where('product_id','\d+');
	Route::controller('catalogs/products', 'ProductsController');
});

	/*
	| Роутеры доступные для группы Администраторы
	*/
	
Route::group(array('before'=>'admin.auth','prefix'=>'admin'),function(){
	Route::get('/','AdminCabinetController@mainPage');
	Route::controller('users', 'UsersController');
	Route::controller('languages', 'LangController');
	Route::controller('templates', 'TempsController');
	Route::controller('groups', 'GroupsController');
	Route::controller('settings', 'SettingsController');
	Route::controller('catalogs/categories', 'CategoriesController');
	Route::controller('catalogs/manufacturers', 'ManufacturersController');
	
	Route::get('catalogs/category-group/{category_group_id}/categories', 'CategoriesController@getCategoryList')->where('category_group_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/categories/create', 'CategoriesController@getCategoryCreate')->where('category_group_id','\d+');
	Route::post('catalogs/category-group/{category_group_id}/categories/store', 'CategoriesController@postCategoryStore')->where('category_group_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/categories/edit/{category_id}', 'CategoriesController@getCategoryEdit')->where('category_group_id','\d+')->where('category_id','\d+');
	Route::post('catalogs/category-group/{category_group_id}/categories/update/{category_id}', 'CategoriesController@postCategoryUpdate')->where('category_group_id','\d+')->where('category_id','\d+');
	Route::delete('catalogs/category-group/{category_group_id}/categories/destroy/{category_id}', 'CategoriesController@postCategoryDestroy')->where('category_group_id','\d+')->where('category_id','\d+');
	
	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories', 'CategoriesController@getCategoryList')->where('category_group_id','\d+')->where('parent_category_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories/create', 'CategoriesController@getCategoryCreate')->where('category_group_id','\d+')->where('parent_category_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories/edit/{category_id}', 'CategoriesController@getSubCategoryEdit')->where('category_group_id','\d+')->where('parent_category_id','\d+')->where('category_id','\d+');
	
	Route::controller('catalogs', 'CatalogsController');
});
	
	/*
	| Роутеры доступные для группы Пользователи
	*/
	
Route::group(array('before'=>'user.auth','prefix'=>'dashboard'),function(){
	Route::get('/','UserCabinetController@mainPage');
	
	Route::get('register-lot','LotsController@getRegisterLot');
	Route::post('register-lot/store','LotsController@postRegisterLotStore');
	Route::post('register-lot/search-products','LotsController@postRegisterLotSearchProducts');
	
	Route::get('register-lot/upload-lot-photo', 'DownloadsController@postUploadLotImages');
	
	Route::post('register-lot/upload-lot-photo', 'DownloadsController@postUploadLotImages');
	Route::post('register-lot/upload-lot-photo/lot/{lot_id}', 'DownloadsController@postUploadLotImages')->where('lot_id','\d+');
	
	Route::get('register-lot/new-catalog-product','UserCabinetController@getNewCatalogProduct');
	Route::post('register-lot/request-new-product/store','UserCabinetController@postRegisterLotRequestNewProductStore');
	Route::post('register-lot/new-catalog-product/upload-product-photo','UserCabinetController@postUploadCatalogProductImages');
	
	
	Route::get('sales/active-lots','LotsController@getSalesActiveLots');
});

	/*
	| Роутеры доступные только для не авторизованных пользователей
	*/

Route::group(array('before'=>'guest','prefix'=>Config::get('app.local')),function(){
	Route::post('signin',array('as'=>'signin','uses'=>'GlobalController@signin'));
	Route::post('signup',array('as'=>'signup','uses'=>'GlobalController@signup'));
	Route::get('activation',array('as'=>'activation','uses'=>'GlobalController@activation'));
});

	/*
	| Роутеры доступные для гостей и авторизованных пользователей
	*/
Route::get('login',array('before'=>'login','as'=>'login','uses'=>'GlobalController@loginPage'));
Route::get('logout',array('before'=>'auth','as'=>'logout','uses'=>'GlobalController@logout'));

Route::get('news/{news_url}','HomeController@showNews');
Route::get('articles/{article_url}','HomeController@showArticle');

Route::get('product/{url}','HomeController@getShowProduct');
Route::get('auction/{url}','HomeController@getShowProductLot');
Route::get('{catalog_title_translit}/{category_url}','HomeController@getShowCatalogProduct');
Route::get('{url}','HomeController@showPage');
Route::get('/','HomeController@showPage');