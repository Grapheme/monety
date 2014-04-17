<?php

class GroupsTableSeeder extends Seeder{

	public function run(){
		
		DB::table('templates')->truncate();
		Group::create(array(
			'name' => 'default',
			'content' => '',
		));
	}

}