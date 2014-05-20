<?php namespace Illuminate\Pagination;

class PaginationClass extends Presenter {

	
	public function getPageLinkWrapper($url, $page){
		
		return '<li><a href="'.$url.'">'.$page.'</a></li>';
	}

	public function getDisabledTextWrapper($text){
		return '<li class="disabled"><a href="javascript:void(0);">'.$text.'</a></li>';
	}

	public function getActivePageWrapper($text){
		return '<li class="active"><a href="javascript:void(0);">'.$text.'</a></li>';
	}

}
