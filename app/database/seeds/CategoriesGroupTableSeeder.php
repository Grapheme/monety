<?php

class CategoriesGroupTableSeeder extends Seeder {

	public function run(){
		
		DB::table('categories_group')->truncate();
	}

}