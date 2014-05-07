<?php

class NewsController extends BaseController {
	
	protected $news;
	
	public function __construct(News $news){
		
		$this->news = $news;
		$this->beforeFilter('news');
	}

	public function getIndex(){
		
		$news = $this->news->orderBy('sort','desc')->orderBy('date_publication','desc')->paginate(15);
		return View::make('modules.news.index',compact('news'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('news','create');
		return View::make('modules.news.create',array('templates'=>Template::all(),'languages'=>Language::all()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('news','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(News::validate(Input::all())):
				self::saveNewsModel();
				$json_request['responseText'] = 'Новость создана';
				$json_request['redirect'] = slink::createAuthLink('news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = News::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function getEdit($id){
		
		$this->moduleActionPermission('news','edit');
		$news = $this->news->find($id);
		if(is_null($news)):
			return App::abort(404);
		endif;
		return View::make('modules.news.edit',array('news'=>$news,'templates'=>Template::all(),'languages'=>Language::all()));
	}

	public function postUpdate($id){
		
		$this->moduleActionPermission('news','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(News::validate(Input::all())):
				$news = $this->news->find($id);
				self::saveNewsModel($news);
				$json_request['responseText'] = 'Новость сохранена';
				$json_request['redirect'] = slink::createAuthLink('news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = News::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function deleteDestroy($news_id){
		
		$this->moduleActionPermission('news','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			$news = $this->news->find($news_id);
			if(!is_null($news) && $news->delete()):
				if($newsImages = json_decode($news->image)):
					if(!empty($newsImages->image) && File::exists(base_path($newsImages->image))):
						File::delete(base_path($newsImages->image));
					endif;
					if(!empty($newsImages->thumbnail) && File::exists(base_path($newsImages->thumbnail))):
						File::delete(base_path($newsImages->thumbnail));
					endif;
				endif;
				ImageController::deleteImages('news',$news_id);
				$json_request['responseText'] = 'Новость удалена';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveNewsModel($news = NULL){
		
		if(is_null($news)):
			$news = $this->news;
		endif;
		$news->title = trim(Input::get('title'));
		$news->sort = (int)News::max('sort')+1;
		$news->preview = Input::get('preview');
		$news->content = Input::get('content');
		$news->publication = 1;
		$news->date_publication = myDateTime::convertDateFormat(Input::get('date_publication'));
		if(Allow::enabled_module('languages')):
			$news->language = Input::get('language');
		else:
			$news->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$news->template = Input::get('template');
		else:
			$news->template = 'news';
		endif;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if($newsImages = json_decode($news->image)):
					if(!empty($newsImages->image) && File::exists(base_path($newsImages->image))):
						File::delete(base_path($newsImages->image));
					endif;
					if(!empty($newsImages->thumbnail) && File::exists(base_path($newsImages->thumbnail))):
						File::delete(base_path($newsImages->thumbnail));
					endif;
				endif;
				if(!File::isDirectory(base_path('public/uploads/news/thumbnail'))):
					File::makeDirectory(base_path('public/uploads/news/thumbnail'),777,TRUE);
				endif;
				$fileName = str_random(16).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(250,250,TRUE)->save(public_path('uploads/news/thumbnail/'.$fileName));
				Input::file('file')->move(base_path('public/uploads/news'),$fileName);
				$news->image = json_encode(array('image' => 'public/uploads/news/'.$fileName,'thumbnail'=> 'public/uploads/news/thumbnail/'.$fileName));
			endif;
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$news->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$news->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$news->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$news->seo_title = $news->title;
			else:
				$news->seo_title = trim(Input::get('seo_title'));
			endif;
			$news->seo_description = Input::get('seo_description');
			$news->seo_keywords = Input::get('seo_keywords');
			$news->seo_h1 = Input::get('seo_h1');
		else:
			$news->seo_url = $this->stringTranslite(Input::get('title'));
			$news->seo_title = Input::get('title');
			$news->seo_description =$news->seo_keywords = $news->seo_h1 = '';
		endif;
		$news->save();
		$news->touch();
		return $news->id;
	}
}
