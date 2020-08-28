<?php 
use Illuminate\Routing\Controller;

class CMSMessagesController extends BaseController {

	public function index()
	{
		return View::make('cms_messages.index')->withData(CMSMessage::listAllMessages());	
	}

	public function update($id)
	{
		CMSMessage::updateMessage($id);
		return Response::json(array('ok'));
	}
	
	public function store()
	{
		$com = new CMSComment;
		$com->item_id = Input::get('id');
		$com->comment = Input::get('comment');
		$com->commentator = Input::get('name');
		$com->email = Input::get('email');
		$com->status = 'Pending';
		$com->save();
		// $com = CMSComment::all();

		return Response::json(array($com)); 

	}
}