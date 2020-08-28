<?php 

class PaymentLog extends Eloquent {

	protected $fillable = [];
	protected $table = "payment_logs";

	public static function store()
	{
		$payment                = New PaymentLog;
		$payment->payment_date  = Input::get('payment_date');
		$payment->payment_type  = Input::get('payment_type');
		$payment->payment_value = Input::get('payment_value');
		$payment->order_id 		= Input::get('order_id');
		$payment->save();

		$order = Order::find(Input::get('order_id'));
		$order->status = Input::get('payment_type');
		$order->save();
	}
}