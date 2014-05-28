<?php

class DownloadsController extends BaseController {
	
	public function __construct(){
		
		$this->beforeFilter('downloads');
	}
	
	public function getIndex(){
		
		$dir = public_path().Config::get('app-default.upload_dir')."/";

		if (!file_exists($dir) or !is_dir($dir)):
			mkdir($dir);
		endif;

		$req_path = Input::get('path');
		$path = $dir.$req_path;
		$directories_array = File::directories($path);
		$files_array = File::files($path);
		if($req_path != "")
		{
			$ex_path = explode("/", $req_path);
			unset($ex_path[count($ex_path)-1]);
			$back_link = implode("/", $ex_path);
		}
		foreach($directories_array as $dir)
		{
			$url = $req_path."/".basename($dir);
			$dirs[$url] = basename($dir);
		}
		foreach($files_array as $file)
		{
			$url = URL::to(Config::get('app-default.upload_dir').$req_path."/".basename($file));
			$files[$url] = array('name' => basename($file), 'size' => round(File::size($file)/1024, 2));
		}

		return View::make('modules.downloads.index', compact('dirs','files','back_link'));
	}

	public function postUpload(){
		
		$file = Input::file('file');
		$path = Input::get('path');
 
		$destinationPath = public_path().Config::get('app-default.upload_dir').$path;
		$extension =$file->getClientOriginalExtension();
		$filename = time()."_".str_random(40).".".$extension; 
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}
	}
	
	public function redactorUploadedImages(){
		
		if(AuthAccount::isAdminLoggined()):
			$dirPath = 'public/uploads';
		elseif(AuthAccount::isUserLoggined()):
			$dirPath = 'usersfiles/account-'.Auth::user()->id;
		else:
			$dirPath = 'usersfiles/temporary';
		endif;
		$dirFullPath = base_path($dirPath);
		if(!file_exists($dirFullPath)):
			return stripslashes(Response::json(array(),200));
		endif;
		$fullList = array();
		if($listDir = scandir($dirFullPath)):
			$index = 0;
			$fileList = array('thumb'=>'','image'=>'','title'=>'Изображение','folder'=>'Миниатюры');
			foreach($listDir as $number => $file):
				if(is_file($dirFullPath.'/'.$file)):
					$thumbnail = $dirFullPath.'/thumbnail/thumb_'.$file;
					if(file_exists($thumbnail) && is_file($thumbnail)):
						$fileList['thumb'] = slink::createAuthLink('image/uploaded_thumbnail/thumb_'.$file);
					endif;
					$fileList['image'] = slink::createAuthLink('image/uploaded/'.$file);
					$fullList[$index] = $fileList;
					$index++;
				endif;
			endforeach;
		endif;
		return Response::json($fullList,200);
	}
	
	public function redactorUploadImage(){
		
		if(AuthAccount::isAdminLoggined()):
			$dirPath = 'public/uploads';
		elseif(AuthAccount::isUserLoggined()):
			$dirPath = 'usersfiles/account-'.Auth::user()->id;
		else:
			$dirPath = 'usersfiles/temporary';
		endif;
		$dirFullPath = base_path($dirPath);
		if(!File::isDirectory($dirFullPath.'/thumbnail')):
			File::makeDirectory($dirFullPath.'/thumbnail',0777,TRUE);
		endif;
		if(Input::hasFile('file')):
			$fileName = str_random(16).'.'.Input::file('file')->getClientOriginalExtension();
			if(!File::exists($dirFullPath.'/thumbnail')):
				File::makeDirectory($dirFullPath.'/thumbnail',0777,TRUE);
			endif;
			ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save($dirFullPath.'/thumbnail/thumb_'.$fileName);
			ImageManipulation::make(Input::file('file')->getRealPath())->resize(600,300,TRUE)->save($dirFullPath.'/'.$fileName);
			$file = array('filelink'=>slink::createAuthLink('image/uploaded_thumbnail/thumb_'.$fileName));
			echo stripslashes(json_encode($file));
		else:
			exit('Нет файла для загрузки!');
		endif;
	}
	
	public function postUploadCatalogProductImages($product_id = NULL){
		
		if(Input::hasFile('file')):
			$this->moduleActionPermission('catalogs','download');
			if(!is_null($product_id)):
				$product = Product::where('user_id',Auth::user()->id)->find($product_id);
			else:
				$product = NULL;
			endif;
			if(AuthAccount::isAdminLoggined()):
				$dirPath = 'public/uploads/catalogs';
			elseif(AuthAccount::isUserLoggined()):
				$dirPath = 'usersfiles/account-'.Auth::user()->id.'/catalogs';
			else:
				$dirPath = 'usersfiles/temporary/catalogs';
			endif;
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
	
	public function postUploadLotImages($lot_id = NULL){
		
		if(!AuthAccount::isUserLoggined()):
			return Response::make('Ошибка 403 (Forbidden, доступ запрещен)',403);
		endif;
		if(Input::hasFile('file')):
			if(!is_null($lot_id)):
				$lot = Lot::where('user_id',Auth::user()->id)->find($lot_id);
			else:
				$lot = NULL;
			endif;
			$dirPath = 'usersfiles/account-'.Auth::user()->id.'/lots';
			$dirFullPath = base_path($dirPath);
			if(!File::isDirectory($dirFullPath.'/thumbnail')):
				File::makeDirectory($dirFullPath.'/thumbnail',0777,TRUE);
			endif;
			$fileName = str_random(24).'.'.Input::file('file')->getClientOriginalExtension();
			ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save($dirFullPath.'/thumbnail/'.$fileName);
			Input::file('file')->move($dirFullPath,$fileName);
			
			$lotID = (!is_null($lot)) ? $lot->id : 0;
			$lotTitle = (!is_null($lot)) ? $lot->title : '';
			$maxSortValue = (int)Lot_image::where('lot_id',$lotID)->max('sort')+1;
			
			$newImageData = array('lot_id' => $lotID,'user_id'=>Auth::user()->id,'sort' => $maxSortValue,'title' => $lotTitle,'description' => '','attributes' => '[]','publication' => 1,
				'paths' => json_encode(array('image' => $dirPath.'/'.$fileName,'thumbnail'=> $dirPath.'/thumbnail/'.$fileName)));
			$newImage = Lot_image::create($newImageData);
			if(is_null($lot)):
				$FreeImagesIDs = Lot_image::where('user_id',Auth::user()->id)->where('lot_id',0)->lists('id');
				Session::put('lot_images',$FreeImagesIDs);
			endif;
			return Response::json(array('status'=>TRUE,'responseText'=>'Файл загружен'),200);
		else:
			return Response::json(array('status'=>FALSE,'responseText'=>'Файл не загружен'),400);
		endif;
		
	}
	
}