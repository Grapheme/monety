<?php
class myDateTime {
	
	public static function swapDotDateWithoutTime($date_string,$zerro = FALSE){
			
		$list = explode("-",$date_string);
		if(!$zerro):
			$list[2] = (int)$list[2];
		endif;
		$date_string = implode("-",$list);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5.$3.\$1";
		return preg_replace($pattern, $replacement,$date_string);
	}
	
	public static function SwapDotDateWithTime($date_time) {
		$list = preg_split("/-/",$date_time);
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$5.$3.\$1 \$6:\$8";
		return preg_replace($pattern, $replacement,$date_time);
	}
	
	public static function months($field,$months = NULL){
		
		if(is_null($months)):
			$months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
		endif;
		$list = explode("-",$field);
		$list[2] = (int)$list[2];
		$field = implode("-",$list);
		$nmonth = $months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г.";
		return preg_replace($pattern, $replacement,$field);
	}
	
	public static function monthsTime($field,$months = NULL){
		
		if(is_null($months)):
			$months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
		endif;
		$list = explode("-",$field);
		$list[2] = (int)$list[2];
		$time = substr($field,11);
		$field = implode("-",$list).' '.$time;
		$nmonth = $months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+) (\d+)(:)(\d+)(:)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 в \$6:\$8";
		return preg_replace($pattern, $replacement,$field);
	}

	public static function getFutureDays($days = 1,$date = NULL){
		
		if(is_null($date)):
			return (time()+($days*24*60*60));
		else:
			return (strtotime($date)+($days*24*60*60));
		endif;
	}
	
	public static function getConvertCurrentDate($diffDay = 0) {
		
		return date("d.m.Y",mktime(0,0,0,date("m"),date("d")-$diffDay,date("Y")));
	}
	
	public static function convertDateFormat($date_string) {
		
		return preg_replace("/(\d+)\.(\w+)\.(\d+)/i","\$3-\$2-\$1",$date_string);
	}

	public static function daysLeftFull($date_start = NULL,$days = NULL){
		
		if(is_null($date_start) || is_null($days)):
			return 'Ошибка подсчета';
		endif;
		
		$dateTimeNow = new DateTime(date('Y-m-d H:i:s'));
		$dateTimeCreated = new DateTime($date_start);
		$dateTimeFuture = $dateTimeCreated->add(new DateInterval('P'.$days.'D'));
		$daysLeft = $dateTimeFuture->diff($dateTimeNow);
		return $daysLeft->format('%a д. %h ч. %i м.');
	}
	
	public static function daysLeftShort($date_start,$days){
		
		if(is_null($date_start) || is_null($days)):
			return 'Ошибка подсчета';
		endif;
		
		$dateTimeNow = new DateTime(date('Y-m-d H:i:s'));
		$dateTimeCreated = new DateTime($date_start);
		$dateTimeFuture = $dateTimeCreated->add(new DateInterval('P'.$days.'D'));
		$daysLeft = $dateTimeFuture->diff($dateTimeNow);
		return $daysLeft->format('%a д.');
	}
}