<?php 
use Illuminate\Support\Collection;

class UsersController extends BaseController {

	 public function index($field='', $order='', $keyword='')
	 {
		$data['field']        = $field = ($field=='') ? 'default' : $field;
		$data['order']        = $order = ($order=='') ? 'default' : $order;
		$data['keyword']      = $keyword;

		$data['users']   = User::allUsers($field,$order,$keyword);
		$data['message'] = Session::get('message');
		return View::make('users.index')->with('data',$data);
	 }
 
	 public function show($userID)
	 {
		$user = User::showUser($userID);
		return View::make('users.previewUser')->with(['user'=>$user]);
	 }

	 public function create()
	 {
	 	$data['userData'] = array();
	 	return View::make('users.create')->with(['data'=>$data]);
	 }
 
	 function edit($userID)
	 {
	 	$data['userData'] = User::editUser($userID); 
	 	return View::make('users.create')->with(['data'=>$data]);	
	 }

	 public function store()
	 {
		if(User::validationStore(Input::all()))
			return Redirect::back()->withInput()->withErrors(User::$error);
		
		User::storeUser(Input::all());
		
	 	return Redirect::route('users.index'); 
	 }


	public function update()
	{
		if(User::validationUpdate(Input::all()))
			return Redirect::back()->withInput()->withErrors(User::$error);
		
		User::updateUser(Input::all());
	 	return Redirect::route('users.index');
	}

	public function destroy($userID)
	{
		User::destroyUser($userID);
		return Response::json(array('ok'));
	}


	public function sentTo($username, $subject, $view)
	{
		Mail::send($view, array('key' => 'value'), function($message) use($username, $subject)
		{
		    $message->to($username)->subject($subject);
		});

	}


}
?>