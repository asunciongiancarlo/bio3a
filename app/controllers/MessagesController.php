<?php
use Illuminate\Routing\Controller;

class MessagesController extends BaseController {

	public function store()
	{
		Message::storeMessage();
		return Response::json(array('ok'));
	}

}