<?php

class GroupsTableSeeder extends Seeder{

	public function run(){
		
		DB::table('templates')->truncate();
		Group::create(array(
			'name' => 'default',
			'content' => '',
		));
		Group::create(array(
			'name' => 'catalog',
			'content' => '',
		));
		Group::create(array(
			'name' => 'news',
			'content' => '',
		));
		Group::create(array(
			'name' => 'articles',
			'content' => '',
		));
		Group::create(array(
			'name' => 'category',
			'content' => '',
		));
	}

}