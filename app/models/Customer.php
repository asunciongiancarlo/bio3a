<?php 


class Customer extends \Eloquent {

	protected $fillable = ['user_name', 'password', 'email_address', 'mobile_numner', 'delivery_address'];


	public static function storeCustomer()
	{

		$customer                = New Customer;
		$customer->user_name     = Input::get('user_name');
		$customer->password      = md5(Input::get('password'));
		$customer->full_name     = Input::get('full_name');
		$customer->email_address = Input::get('email_address');
		$customer->mobile_number = Input::get('mobile_number');
		$customer->delivery_address = Input::get('delivery_address');
		$customer->save();

		return $customer->id;
	}

	public static function getCustomerInfo($param)
	{
		$array    = "";
		$customer = DB::table('customers')
				->select("$param")
				->where('user_name','=',Input::get('user_name1'))
				->first();

		$array = (array) $customer;
		extract($array);
		
		if($param=='full_name')
			return $full_name;
		else
			return $id;
	}

	//CHECK IF USER ALREADY EXIST
	public static function checkUserName()
	{
		$customer = DB::table('customers')
				->select('*')
				->where('user_name','=',Input::get('user_name'))
				->get();

		if($customer)
			return 'exist';
		else
			return 'do not exist';
	}

	public static function checkUserNamePassword()
	{
		$customer = DB::table('customers')
					->select('*')
					->where('user_name','=', Input::get('user_name1'))
					->where('password','=',  md5(Input::get('password1')))
					->get();
	
		if($customer)
			return 'ok';
		else
			return 'not ok';
	}
}	