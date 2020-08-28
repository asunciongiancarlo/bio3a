<?php 

class BlogImage extends \Eloquent {

	protected $table    = 'blog_images';
	protected $fillable = ['blog_id','iamge_name','primary_status'];

	public static function edit($id)
	{
		return DB::table('blog_images')
			 ->select('blog_images.id as blog_imagesID', 'blog_id', 'image_name', 'primary_image')
			 ->leftjoin('blogs','blogs.id','=','blog_images.blog_id')
			 ->where('blog_images.blog_id','=',$id)
			 ->orderBy('primary_image','DESC')
			 ->get();
	}

	public static function set_as_default_image($blog_id, $image_id)
	{
		//SET ALL IMAGES AS 0
		DB::table('blog_images')
				->where('blog_id','=',$blog_id)
			    ->update(array('primary_image' => 0));

		//SET DEFAULT IMAGE
		//SET ALL IMAGES AS 0
		DB::table('blog_images')
				->where('blog_id','=',$blog_id)
				->where('id','=',$image_id)
			    ->update(array('primary_image' => 1));
	}

	public static function delete_image($image_id)
	{
		//DELETE IMAGE
		DB::table('blog_images')
				->where('id','=',$image_id)
			    ->delete();
	}
}