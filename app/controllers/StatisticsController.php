<?php 

use Illuminate\Routing\Controller;

class StatisticsController extends BaseController {


	public function index()
	{
		$data['sales'] = Statistic::viewAllProducts();
		return View::make('statistics.index')->withData($data);
	}

}