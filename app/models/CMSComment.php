<?php 

class CMSComment extends \Eloquent {

	protected $fillable = ['status'];
	protected $table 	= 'comments';
	// public $timestamps = false;
	
	public static function listAllComments()
	{
		return DB::table('comments')
				->select('comments.id as cID','blog_title','commentator','email','comment','status')
				->leftJoin('blogs','comments.item_id', '=', 'blogs.id')
				->get();
	}

	public static function updateComment($id)
	{
		$com         = CMSComment::find($id);
		$com->status = Input::get('message_status'); 
		$com->save();
	}

	public static function Comment($blog_id)
	{
		return DB::table('comments')
				->where('status', '=', 'Approve')
				->where('item_id','=', $blog_id)
				->get();
	}
}