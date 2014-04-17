<?php

class GroupsController extends BaseController {

	protected $group;

	public function __construct(Group $group){
		
		$this->model = $group;
		$this->beforeFilter('users');
	}

	public function getIndex(){
		
		$groups = $this->model->all();
		$roles = Role::all();
		return View::make('modules.groups.index', compact('groups', 'roles'));
	}

	public function getEdit($id){
		
		$group = $this->model->find($id);
		$roles = Role::all();

		return View::make('admin.groups.edit', compact('group', 'roles'));
	}

	public function postAttach(){
		
		$group_id = Input::get('group_id');
		$role_id = Input::get('role_id');

		$group = group::find($group_id);
		$group->roles()->attach($role_id);
	}

	public function postDetach(){
		
		$group_id = Input::get('group_id');
		$role_id = Input::get('role_id');
		
		$group = group::find($group_id);
		$group->roles()->detach($role_id);
	}

	public function postCreate(){
		
		$input = Input::all();

		$v = Validator::make($input, group::$rules);
		if($v->passes())
		{
			$this->model->create($input);
			return slink::createLink('admin/groups');
		} else {
			return Response::json($v->messages()->toJson(), 400);
		}
	}

}
