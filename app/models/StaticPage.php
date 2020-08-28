<?php 

class StaticPage extends Eloquent {

	protected $fillable = ['static_page_content'];

	public static function index()
	{
		return StaticPage::all();
	}

	public static function edit($id)
	{
		return StaticPage::find($id);
	}

	public static function updatePage($id)
	{
		$page = StaticPage::find($id);
		$page->static_page_content = Input::get('static_page_content');
		$page->save();
	}
}