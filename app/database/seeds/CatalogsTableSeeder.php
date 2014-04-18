<?php

class CatalogsTableSeeder extends Seeder {

	public function run(){
		
		DB::table('catalogs')->truncate();
	}

}