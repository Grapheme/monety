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
			$parent_category_id = getItemIDforURL($category_url);
			if(!$categories = DB::table('categories')->select('id','title','seo_url')->where('category_group_id',$category_group_id)->where('category_parent_id',$parent_category_id)->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->get()):
				if($parent_category = self::getParentCategory($category_group_id,$category_url)):
					$categories = DB::table('categories')->select('id','title','seo_url')->where('category_group_id',$category_group_id)->where('category_parent_id',$parent_category->id)->where('publication',1)->orderBy('sort','asc')->orderBy('title','asc')->get();
				endif;
			endif;
		endif;
		return $categories;
	}
	
	public static function getParentCategory($category_group_id,$sub_category_url){
		
		$category_id = getItemIDforURL($sub_category_url);
		if($current_category = Category::find($category_id)):
			return Category::find($current_category->category_parent_id);
		else:
			return NULL;
		endif;
	}
	
	public function categoryGroup(){

		return $this->belongsTo('CategoryGroup');

	}

	public function products(){
		
		return $this->belongsToMany('Product','category_product');
	}

	/*public function getChildrenCategories($parentCategoryID){
		
		return Category::
	}*/
}