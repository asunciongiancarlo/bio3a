<?php 

class AdminConversation extends \Eloquent {

	protected $fillable = ['client_id', 'admin_id', 'reply_to', 'message', 'user_type'];
	protected $table = 'conversation';
	
	public static function allMessages()
	{
		return DB::table('customers')
					->select('full_name','email_address','mobile_number','delivery_address','customers.id as customerID')
					->groupBy('customers.id')
					->get();
		
	}

	public static function deleteMessages($messageID)
	{
		
	}
}