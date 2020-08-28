<?php 
use Illuminate\Routing\Controller;

class BlogsController extends BaseController {


	public function index()
	{
		$blogs = Blog::index();
		return View::make('blogs.index')->withBlogs($blogs);
	}


	public function create()
	{
		$data['category_lists'] = Category::list_all_categories();
		return View::make('blogs.create')->withData($data);	
	}

	
	public function store()
	{
		Blog::saveBlog();
		return Redirect::to('blogs');
	}

	public function show($id)
	{
		
	}

	public function edit($id)
	{	
		//LIST DOWN ALL CATEGORIES
		//FORM DATA
		$data['category_lists']	= Category::list_all_categories();
		$data['form_data']	    = Blog::find($id)->toArray();
		$data['images']			= BlogImage::edit($id);
		return View::make('blogs.create')->withData($data);
	}

	//SET DEFAULT IMAGE
	public function set_as_default_image($blogID, $image_id)
	{
		BlogImage::set_as_default_image($blogID, $image_id);
		return Response::json('ok');
	}

	//DELETE IMAGE
	public function delete_image($image_id)
	{
		BlogImage::delete_image($image_id);
		return Response::json('ok');
	}

	public function update($id)
	{
		Blog::updateBlog($id);
		return Redirect::to('blogs');
	}

	public function destroy($id)
	{
		Blog::deleteBlog($id);
		$blogs = Blog::all();

		return Response::json(array($blogs));	
	}

}