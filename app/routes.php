<?php

$prefix = '';
if(Auth::check()):
	$prefix = Auth::user()->groups()->first()->dashboard;
endif;

Route::group(array('before'=>'admin.auth','prefix'=>$prefix),function(){
	Route::get('/', 'AdminController@mainPage');
	Route::controller('users', 'UsersController');
	Route::controller('languages', 'LangController');
	Route::controller('templates', 'TempsController');
	Route::controller('groups', 'GroupsController');
	Route::controller('settings', 'SettingsController');
});

Route::group(array('before'=>'auth'),function(){
	Route::get('logout','GlobalController@logout');
});

Route::group(array('before'=>'guest','prefix'=>Config::get('app.local')),function(){
	Route::get('login',array('before'=>'login','uses'=>'GlobalController@loginPage'));
	Route::post('signin',array('as'=>'signin','uses'=>'GlobalController@signin'));
	Route::post('signup',array('as'=>'signup','uses'=>'GlobalController@signup'));
	Route::get('activation',array('as'=>'activation','uses'=>'GlobalController@activation'));
});

Route::group(array('prefix'=>Config::get('app.local')),function(){
	Route::get('/news/{news_url}','HomeController@showNews');
	Route::get('/articles/{article_url}','HomeController@showArticle');
	Route::get('/{url}','HomeController@showPage');
	Route::get('/','HomeController@showPage');
});

Route::group(array('before'=>'auth','prefix'=>$prefix),function(){
	Route::controller('pages', 'PagesController');
	Route::controller('galleries', 'GalleriesController');
	Route::controller('downloads', 'DownloadsController');
	Route::controller('news', 'NewsController');
	Route::controller('articles','ArticlesController');
});

Route::get('image/{image_group}/{id}', 'ImageController@showImage');

Route::get('redactor/get-uploaded-images', 'DownloadsController@redactorUploadedImages');
Route::post('redactor/upload','DownloadsController@redactorUploadImage');