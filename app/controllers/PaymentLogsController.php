<?php 

class PaymentLogsController extends BaseController {


	public function store()
	{
		PaymentLog::store();
		return Response::json(array('ok'));
	}


}