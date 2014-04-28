<?php

class GroupsTableSeeder extends Seeder{

	public function run(){
		
		Group::create(array(
			'name' => 'admin',
			'desc' => 'Администраторы',
			'dashboard' => 'admin'
		));
		Group::create(array(
			'name' => 'user',
			'desc' => 'Пользователи',
			'dashboard' => 'dashboard'
		));
		Group::create(array(
			'name' => 'moderator',
			'desc' => 'Модераторы',
			'dashboard' => 'moderator'
		));
	}

}