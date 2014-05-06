<?php

class Category extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'categories';

	public static $rules = array(
	
		'title' => 'required',
		'seo_url' => 'alpha_dash',
		'category_group_id' => 'required|integer',
		'category_parent_id' => 'required|integer'
	);

	protected $fillable = array();
	
	public static function getCategories($category_group_id,$category_url = NULL){
		
		$categories = array();
		if(is_null($category_url)):
			$categories = DB::table('categories')->select('id','title','seo_url')->where('category_group_id',$category_group_id)->where('category_parent_id',0)->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->get();
		else:
			$url = explode('-',$category_url);
			$parent_category_id = array_pop($url);
			if(!is_numeric($parent_category_id)):
				return App::abort(404,'Запрашиваемая категория не найдена');
			endif;
			$categories = DB::table('categories')->select('id','title','seo_url')->where('category_group_id',$category_group_id)->where('category_parent_id',$parent_category_id)->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->get();
		endif;
		return $categories;
	}
	
	public static function getParentCategory($category_group_id,$sub_category_url){
		
		$url = explode('-',$sub_category_url);
		$category_id = array_pop($url);
		if(!is_numeric($category_id)):
			return App::abort(404,'Запрашиваемая категория не найдена');
		endif;
		return DB::table('categories')->select('id','title','seo_url','category_parent_id')->where('category_group_id',$category_group_id)->where('publication',1)->find($category_id);
	}
	
	public function categoryGroup(){

		return $this->belongsTo('CategoryGroup');

	}
}