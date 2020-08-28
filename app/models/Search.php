<?php 

class Search extends Eloquent {

	protected $fillable = [];

	//SEARCH FOR ITEMS
	public static function findBlogs()
	{
		$key = Input::get('search_key');
		return DB::table('blogs')
			 ->select('blogs.id as id','blog_title','blog_publish','image_name as blog_image','blog_intro','price','blog_sale','blogs.created_at as created_at','category_name')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->leftjoin('categories','categories.id','=','blogs.category_id')
			 ->where('blog_publish','=','y')
			 ->where('primary_image','=',1)
			 ->where(function($query) use ($key)
			 {
			 	$query
			 	->orWhere('blog_title','like',"%$key%")
			 	->orWhere('blog_intro','like',"%$key%")
			 	->orWhere('price','like',"%$key%")
			 	->orWhere('blog_content','like',"%$key%");
			 })
			 ->orderBy('blog_title','ASC')
			 ->groupBy('blogs.id')
			 ->get();
	}
}