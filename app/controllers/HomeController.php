<?php

class HomeController extends BaseController {


	public function index()
	{
		//GET ALL PUBLISH BANNERS
		$data['active_page'] = 'Home';	
		$data['banners'] = DB::table('banners')
							 ->where('banner_publish', '=', 'y')
							 ->orderBy('xOrder', 'DESC')
							 ->get();
		//SLIDER VARIABLES
		$data['x']		  = 1;
		$data['active']	  = '';

		//GET TOP 3 FEATURED ITEMS
		$data['featured_items'] = DB::table('blogs')
							->leftjoin('blog_images', 'blog_images.blog_id', '=', 'blogs.id')
							->where('blog_publish', '=', 'y')
							->where('blog_featured', '=', 'y')
							->where('blog_images.primary_image', '=', 1)
							->groupBy('blogs.id')
							->get();
		$data['active_page'] = 'home';

		return View::make('hello')->withData($data);
	}

}
