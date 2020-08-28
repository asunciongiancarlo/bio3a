<?php 

use Illuminate\Routing\Controller;

class CategoriesController extends BaseController {

	public function index()
	{
		$data = Category::index();
		return View::make('categories.index')->withCategories($data);
	}

	public function getCategoryChild($parent_id)
	{
		//PARENT ID | UNDERSCORE | TYPE: DROP-DOWN or VIEW
		return Category::list_all_child_categories($parent_id,15);
	}
	
	public function create()
	{
		//GET ALL CATEGORIES
		$data['category_lists'] = Category::list_all_categories();
		return View::make('categories.create')->withData($data);
	}

	public function store()
	{
		Category::store();
		return Redirect::to('categories');
	}

	public function show($id)
	{
		
	}

	public function edit($id)
	{
		$data['category_lists'] = Category::list_all_categories();
		$data['form_data']      = Category::edit($id);
		return View::make('categories.create')->withData($data);
	}

	public function update($id)
	{
		Category::updateCategory($id);
		return Redirect::to('categories');
	}


	public function destroy($id)
	{
		Category::destroy($id);
		return Response::json(array('ok'));
	}

}