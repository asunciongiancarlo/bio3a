<?php 

use Illuminate\Routing\Controller;

class SearchController extends BaseController {


	public function findBlogs()
	{
		$data['active_page'] = 'Home';	

		//SEARCH FOR ITEMS
		$data['blogs'] = Search::findBlogs();
		$data['key']   = Input::get('search_key');
		return View::make('search.index')->withData($data);
	}

}