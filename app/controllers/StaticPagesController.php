<?php 

use Illuminate\Routing\Controller;

class StaticPagesController extends BaseController {

	public function index()
	{
		return View::make('static_pages.index')->withStatic_pages(StaticPage::index());	
	}

	public function create()
	{
		//
	}

	public function store()
	{
		//
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$data['form_data'] = StaticPage::edit($id);
		return View::make('static_pages.create')->withData($data);	
	}

	public function update($id)
	{
		StaticPage::updatePage($id);	
		return Redirect::to('static_pages');
	}

	public function destroy($id)
	{
		//
	}

}