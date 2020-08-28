<?php 
use Illuminate\Routing\Controller;

class CMSCommentsController extends BaseController {

	public function index()
	{
		//dd(CMSComment::listAllComments());
		return View::make('cms_comments.index')->withData(CMSComment::listAllComments());	
	}

	public function update($id)
	{
		CMSComment::updateComment($id);
		return Response::json(array($id));
	}
	
	public function store()
	{
		$com              = new CMSComment;
		$com->item_id     = Input::get('id');
		$com->comment     = Input::get('comment');
		$com->commentator = Input::get('name');
		$com->email       = Input::get('email');
		$com->status      = 'Pending';
		$com->save();
		// $com = CMSComment::all();

		return Response::json(array($com)); 

	}
	
}