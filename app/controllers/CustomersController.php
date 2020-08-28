<?php 

use Illuminate\Routing\Controller;

class CustomersController extends BaseController {

	
	public function index()
	{
		$data['active_page']     = 'Sign-up/Log-in';	
		return View::make('customers.index')->withData($data);
	}

	//LOG OUT
	public function logOut()
	{
		Session::forget('customer_info');
		Session::forget('cart_items');	

		return Redirect::to('preview_cart');
	}

	//LOG IN
	public function logIn()
	{
		//CHECK IF USERNAME AND PASSWORD ARE CORRECT
		if(Customer::checkUserNamePassword() == 'ok')
		{
			//SET IN SESSION
			//LOG IN USER
			$arr = array('active_customerStatus'  => true,
						'active_customerFullName' => Customer::getCustomerInfo('full_name'),
						'active_customerID'       => Customer::getCustomerInfo('id'));
			Session::put('customer_info', $arr);

			return Response::json(array('ok'));
		}else{
			return Response::json(array('not ok'));
		}
	}

	//SIGN UP
	public function store()
	{
		//CHECK IF USERNAME ALREADY EXIST ON THE DB
		if(Customer::checkUserName(Input::get('user_name')) == 'do not exist')
		{
			//SAVE USER SUPPLIED PARAMETERS
			$active_customerID = Customer::storeCustomer();

			//LOG IN USER
			$arr = array('active_customerStatus'  => true,
						'active_customerFullName' => Input::get('full_name'),
						'active_customerID'       => $active_customerID);
			Session::put('customer_info', $arr);
			
			return Response::json(array('ok'));
		}else{
			return Response::json(array('exist'));
		}
	}


}