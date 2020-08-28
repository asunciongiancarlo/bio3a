<?php 

class Statistic extends \Eloquent {

	protected $fillable = [];

	public static function viewAllProducts()
	{
		return DB::table('blogs')
			 ->select(DB::raw('blog_title, category_name, price, count(item_id) as sale_ctr'))
			 ->leftjoin('order_details','blogs.id','=','order_details.item_id')
			 ->leftjoin('categories','categories.id','=','blogs.category_id')
			 ->orderBy('blog_title','DESC')
			 ->groupBy('blogs.id')
			 ->get();
	}
}