<?php 

class Message extends Eloquent {

	protected $fillable = ['name, email_address, contact_number, comment_message'];


	public static function storeMessage()
	{
		$message                  = New Message;
		$message->name            = Input::get('name');
		$message->email_address   = Input::get('email_address');
		$message->contact_number  = Input::get('contact_number');
		$message->comment_message = Input::get('comment_message');
		$message->save();
	}

	


}