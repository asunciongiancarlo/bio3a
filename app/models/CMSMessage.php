<?php 

class CMSMessage extends \Eloquent {

	protected $fillable = ['message_status'];
	protected $table 	= 'messages';
	
	public static function listAllMessages()
	{
		return DB::table('messages')->orderBy('created_at','DESC')->get();
	}


	public static function updateMessage($id)
	{
		$msg = CMSMessage::find($id);
		$msg->message_status = Input::get('message_status');
		$msg->save();
	}
}