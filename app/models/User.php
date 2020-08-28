<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	protected $table  = 'users';
	protected $hidden = array('password', 'remember_token');


	public static $createRules = [
		'username' => 'required',
		'password' => 'required',
 	];

	public static $updateRules = [
		'username' => 'required'
	];

	public static $error;

	public static function allUsers($field, $order, $keyword)
	{
		$field = ($field=='default') ? 'username'  : $field;
		$order = ($order=='default') ? 'ASC' 	   : $order;

		return DB::table('users')
					->select('*','users.id as userID')
					->where('username','like',"%$keyword%")
					->orderBy($field, $order)
					->get();
		
	}

	public static function showUser($userID)
	{
		return User::find($userID)->first();
	}

	public static function validationStore()
	{
		$validation = Validator::make(Input::all(), User::$createRules);
	 	if($validation->fails())
	 	{
	 		User::$error = $validation->messages();
	 		return true;
	 	}

	 	return false;
	} 

	public static function validationUpdate()
	{
		$validation = Validator::make(Input::all(), User::$updateRules);
	 	if($validation->fails())
	 	{
	 		User::$error = $validation->messages();
	 		return true;
	 	}

	 	return false;
	} 

	public static function storeUser()
	{
		//SAVE IMAGE
		$file            = Input::file('image');
		$destinationPath = 'img/';
		$filename        = $file->getClientOriginalName();
		if (Input::hasFile('image'))
		{
    		$file->move($destinationPath, $filename);
		}

		$user           = New User;
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->image    = $filename;
		$user->save();

	}

	public static function updateUser()
	{
		//SAVE IMAGE
	 	if (Input::hasFile('image'))
		{
			$file            = Input::file('image');
			$destinationPath = 'img/';
			$filename        = $file->getClientOriginalName();

    		$file->move($destinationPath, $filename);
		}

			$user                                           = User::find(Input::get('id'));
			$user->username                                 = Input::get('username');
			if (Input::hasFile('password')) $user->password = Hash::make(Input::get('password'));
			if (Input::hasFile('image')) 	$user->image    = $filename;
			$user->save();
	}

	public static function editUser($userID)
	{
		return User::find($userID);
	}

	public static function destroyUser($userID)
	{
		$user = User::find($userID);
		$user->delete();
	}

}
