<?php 

use Illuminate\Routing\Controller;

class ContactUsController extends BaseController {

	public function index()
	{
		//GET ALL PUBLISH BANNERS
		$data['active_page']     = 'Contact Us';	
		$data['page_data']	 	 = DB::table('static_pages')->whereId(5)->first();
		$data['active_page']	 = "healthcard_comparison_table";
		return View::make('contact_us.index')->withData($data);
	}

}