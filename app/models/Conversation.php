<?php 

class Conversation extends \Eloquent {

	protected $fillable = ['client_id', 'admin_id', 'message', 'user_type'];
	protected $table = 'conversation';

	public static function downloadFile($conversationID)
	{
		return Conversation::find($conversationID)->attachment;
	}

	public static function customerSendMessage()
	{
		$message            = New Conversation;
		$message->client_id = Session::get('customer_info')['active_customerID'];
		$message->admin_id  = 0;
		$message->seen      = 'yes';
		$message->message   = Input::get('message');
		$message->user_type = 'Customer';

		//SEND IMAGE
		//SAVE IMAGE
		$file            = Input::file('image');
		$destinationPath = 'img/attachment/';
		$filename        = '';
		if (Input::hasFile('image'))
		{
			$filename        = $file->getClientOriginalName();
    		$file->move($destinationPath, $filename);
		}
		$message->attachment = $filename;
		$message->save();
	}

	public static function adminReplyMessage()
	{
		$message            = New Conversation;
		$message->client_id = 0;
		$message->admin_id  = Auth::id();
		$message->reply_to  = Input::get('reply_to');
		$message->seen      = 'no';
		$message->message   = Input::get('message');
		$message->user_type = 'Admin';
		$message->save();
	}

	public static function getMessagesCustomerSide($customerID='')
	{
		if($customerID==NULL)
			$customerID = Session::get('customer_info')['active_customerID'];


		return DB::table('conversation')
			 ->select('user_type','message','customers.full_name','conversation.created_at as cdate','client_id','attachment', 'conversation.id as conversationID')
			 ->leftjoin('customers','customers.id','=','conversation.client_id')
			 ->where('conversation.client_id','=',$customerID)
			 ->Orwhere('conversation.reply_to','=',$customerID)
			 ->orderBy('conversation.created_at','ASC')
			 ->get();
	}

	public static function showMessageCounter()
	{
		if(Session::get('customer_info'))
		{
			$customerID = Session::get('customer_info')['active_customerID'];

			return DB::table('conversation')
				 ->select(DB::raw('count(message) as message_ctr'))
				 ->where('conversation.reply_to','=',$customerID)
				 ->where('conversation.seen','=','no')
				 ->get();
		}
		
	}
}