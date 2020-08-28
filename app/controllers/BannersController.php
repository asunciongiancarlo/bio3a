<?php 

use Illuminate\Routing\Controller;

class BannersController extends BaseController {


	public function index()
	{
		return View::make('banners.index')->withBanners(Banner::index());
	}

	
	public function create()
	{
		return View::make('banners.create')->withData([]);	
	}


	public function store()
	{
		Banner::store();
		return Redirect::to('banners');		
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$data['formData'] = Banner::edit($id);
		return View::make('banners.create')->withData($data);	
	}


	public function update($id)
	{
		Banner::updateBanner($id);	
		return Redirect::to('banners');	
	}

	public function destroy($id)
	{
		Banner::destroy($id);
		return Response::json(array('ok'));	
	}

}