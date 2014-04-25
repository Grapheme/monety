<?php

class TemplatesSeeder extends Seeder{

	public function run(){
		
		DB::table('templates')->truncate();
		Template::create(array(
			'name' => 'default',
			'content' => '',
		));
		Template::create(array(
			'name' => 'catalog',
			'content' => '',
		));
		Template::create(array(
			'name' => 'news',
			'content' => '',
		));
		Template::create(array(
			'name' => 'articles',
			'content' => '',
		));
		Template::create(array(
			'name' => 'category',
			'content' => '',
		));
		Template::create(array(
			'name' => 'product',
			'content' => '',
		));
		Template::create(array(
			'name' => 'manufacturer',
			'content' => '',
		));
	}

}