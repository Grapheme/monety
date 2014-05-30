<?php

class Plural{
	
	public static function items($count){
		
		$words = array('предмет','предмета','предметов');
		return self::getWord($count,$words);
	}
	
	public static function itemsAvailable($count){
		
		$words = array('<strong>предмет</strong> доступен','<strong>предмета</strong> доступно','<strong>предметов</strong> доступно');
		return self::getWord($count,$words);
	}
	
	private static function getWord($n,$words){
		
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $words[2];
		if ($n1 > 1 && $n1 < 5) return $words[1];
		if ($n1 == 1) return $words[0];
		return $words[2];
	}
}
?>