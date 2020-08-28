<?php 
use Illuminate\Routing\Controller;

class CartController extends BaseController {

	//RECEIVE ITEM ID
	//RETURN NUMBER OF ITEMS UNDER A CART
	public function update($itemID)
	{
		//ADD ITEMS TO ARRAY 
		Session::push('cart_items', $itemID);
		$data['cart_items'] = count(Session::get('cart_items'));
		$data['item']       = Blog::find($itemID)->toArray();
		return Response::json(array($data));
	}

	//REMOVE ITEM AT THE CART
	public function destroy($itemID)
	{
		//SET CART ITEMS TO A SESSION
		$array = Session::get('cart_items');
		foreach (array_keys($array, $itemID) as $key) {
		    unset($array[$key]);
		}

		$data['cart_items'] = count($array);
		$data['item']       = Blog::find($itemID)->toArray();
		
		//SET NEW SESSION VARIABLE
		Session::put('cart_items', $array);

		return Response::json(array($data));
	}

	//CLEAR CURRENT ITEMS
	//RECIEVE NUMBER OF ITEMS FROM DROP DOWN LIST
	public function inputFromSelectOption($itemID, $qty)
	{
		//CLEAR CURRENT ITEMS INSIDE AN ARRAY
		$array = Session::get('cart_items');
		foreach (array_keys($array, $itemID) as $key) {
		    unset($array[$key]);
		}

		//SET NEW SESSION VARIABLE
		Session::put('cart_items', $array);

		//APPEND NUMBER OF ITEMS BASED ON QTY
		for($x=0;$x<=$qty;$x++)
		{
			Session::push('cart_items', $itemID);
		}

		$data['cart_items'] = count(Session::get('cart_items'));
		$data['item']       = Blog::find($itemID)->toArray();
		$data['qty']        = $qty+1;
		return Response::json(array($data));
	}

}