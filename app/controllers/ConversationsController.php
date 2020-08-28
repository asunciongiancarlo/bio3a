<?php

use Illuminate\Routing\Controller;

class ConversationsController extends BaseController {

	public function index()
	{
		//UPDATE ALL MESSAGES
		$customerID = Session::get('customer_info')['active_customerID'];
		DB::table('conversation')
				->where('reply_to', '=', $customerID)
				->update(array('seen' => 'yes'));

		//GET ALL PUBLISH BANNERS
		$data['active_page']   = 'Sign-up/Log-in';
		$data['conversations'] = Conversation::getMessagesCustomerSide(NULL);
		$data['msg_ctr']	   = 0;
		return View::make('conversations.index')->withData($data);	
	}

	public function store()
	{
		Conversation::customerSendMessage();		
		return Redirect::to('conversations');
	}


	public function show($id)
	{	
		$result = '';
		if(Session::get('customer_info'))
		{
			$ctr = Conversation::showMessageCounter();

			$result = array();
			foreach ($ctr as $key => $value) {
			    $result[] = $value->message_ctr;
			}
		}	

		return Response::json(array($result));
	}

	public function edit($conversationID)
	{
		//GET THE FILE
		$attachement = Conversation::downloadFile($conversationID);
		$file = $_SERVER["DOCUMENT_ROOT"].'/img/attachment/'.$attachement;

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
		
	}


}