<?php

	/*
	| Общие роутеры независящие от условий
	*/

Route::get('image/{image_group}/{id}', 'ImageController@showImage');
Route::get('redactor/get-uploaded-images', 'DownloadsController@redactorUploadedImages');
Route::post('redactor/upload','DownloadsController@redactorUploadImage');

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
});
	
	/*
	| Роутеры доступные для группы Пользователи
	*/
	
Route::group(array('before'=>'user.auth','prefix'=>'dashboard'),function(){
	Route::get('/','UserCabinetController@mainPage');
});

/*
	| Роутеры доступные для всех групп авторизованных пользователей
	*/

$prefix = 'guest';
if(Auth::check()):
	$prefix = AuthAccount::getStartPage();
endif;
	
Route::group(array('before'=>'auth','prefix'=>$prefix),function(){
	Route::controller('pages', 'PagesController');
	Route::controller('galleries', 'GalleriesController');
	Route::controller('downloads', 'DownloadsController');
	Route::controller('news', 'NewsController');
	Route::controller('articles','ArticlesController');
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

Route::get('/news/{news_url}','HomeController@showNews');
Route::get('/articles/{article_url}','HomeController@showArticle');
Route::get('/{url}','HomeController@showPage');
Route::get('/','HomeController@showPage');