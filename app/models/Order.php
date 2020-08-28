<?php 

class Order extends \Eloquent {

	protected $fillable = [''];

	public static function updateOrder($id)
	{
		$order = Order::find($id);
		$order->status = Input::get('message_status');
		$order->save();
	}


	public static function updateDeliveryDate($orderID)
	{
		$order = Order::find($orderID);
		$order->delivery_date = Input::get('delivery_date');
		$order->save();
	}

	public static function customerOrders($customer_id='')
	{
		//ADMIN VIEW
		if(!$customer_id){ 
			return DB::table('orders')
				->select(DB::raw('full_name, order_code, email_address, mobile_number, delivery_address, orders.id as orderID, count(item_id) as itm_ctr, status, orders.created_at as oDate, customers.id as customer_id, delivery_date'))
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				->leftjoin('customers','customers.id','=','order_details.customer_id')
				->groupBy('order_code')
				->orderBy('oDate','DESC')
				->get();
		}else{
			return DB::table('orders')
				->select(DB::raw('full_name, order_code, email_address, mobile_number, delivery_address, orders.id as orderID, count(item_id) as itm_ctr, status, orders.created_at as oDate, customers.id as customer_id, delivery_date'))
				->leftjoin('order_details','orders.id','=','order_details.order_id')
				->leftjoin('customers','customers.id','=','order_details.customer_id')
				->where('customers.id','=',Session::get('customer_info')['active_customerID'])
				->groupBy('order_code')
				->orderBy('oDate','DESC')
				->get();
		}
	} 

	public static function storeOrder()
	{
		$cart_items = Session::get('cart_items');
		$customer_info = Session::get('customer_info');

		$order           = New Order;
		$order->customer_id = $customer_info['active_customerID'];
		$order->status 		= 'On Hold';
		$order->save();

		//SAVE ALL ITEMS FROM CART
		foreach ($cart_items as $cart_item) 
		{
			$order_details           	= New OrderDetails;
			$order_details->order_id 	= $order->id;
			//GENERATE ORDER CODE
			$order_details->order_code 	= Order::genCode($order->id);
			$order_details->customer_id = $customer_info['active_customerID'];
			$order_details->item_id     = $cart_item;
			$order_details->save();
		}
		
		return $order_details->order_code;
	}

	public static function genCode($ctr)
	{
		$coding = "%08d";
		if($ctr>9999)
			$coding = "%0".strlen($ctr)."d";

		return sprintf($coding, $ctr);
	}
}