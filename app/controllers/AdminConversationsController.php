<?php 

use Illuminate\Routing\Controller;

class AdminConversationsController extends BaseController {

	public function index()
	{
		$data['messages']   = AdminConversation::allMessages();
		return View::make('admin_conversations.index')->with('data',$data);
	}


	public function create()
	{
		//
	}


	public function store()
	{
		Conversation::adminReplyMessage();		
		return Response::json(array('send'));	
	}

	//VIEW SPECIFIC COMMENTS
	public function show($customerID)
	{
		$data['conversations']    = Conversation::getMessagesCustomerSide($customerID);
		$data['customerIDNumber'] = $customerID; 
		return View::make('admin_conversations.show')->withData($data);
	}

	public function edit($id)
	{
		//
	}


	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		DB::table('conversation')->where('client_id', '=', $id)->delete();
		DB::table('conversation')->where('reply_to', '=', $id)->delete();

		return Response::json('ok');
	}

}