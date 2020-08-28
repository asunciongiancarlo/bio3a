<?php 

use Illuminate\Routing\Controller;

class ThemesController extends BaseController {


	public function index()
	{
		$data['themes']   = Theme::all();
		return View::make('themes.index')->with('data',$data);
	}

	
	public function update($id)
	{
		//UPDATE THEMES
		Theme::updateThemes();
		return Redirect::to('themes'); 
	}

	
	public function destroy($id)
	{
		//
	}

}