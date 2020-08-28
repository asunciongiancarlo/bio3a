<?php 

use Illuminate\Routing\Controller;

class OrdersController extends BaseController {

	public function index()
	{
		$data['orders'] = Order::customerOrders();
		return View::make('orders.index')->withData($data);
	}

	//update deivery date
	public function updateDeliveryDate($id)
	{
		Order::updateDeliveryDate($id);
		return Response::json(array('ok'));
	}

	public function show($id)
	{
		//GET ALL ORDER ITEMS 
		$items = DB::table('order_details')
					->select('item_id')
					->where('order_id','=',$id)
					->get();

		//convert obj to array
		$result = array();
		foreach ($items as $key => $value) {
		    $result[] = $value->item_id;
		}

		$array = array_count_values($result);	
		$data['PreviewCartItems'] = $this->PreviewCartItems($array,null);	
		$data['order_info'] 	  = DB::table('orders')
									->select('*')
									->where('id','=',$id)
									->first();

		$data['payment_logs'] = DB::table('payment_logs')
									->select('*')
									->where('order_id','=',$id)
									->orderBy('created_at','DESC')
									->get();
		$data['x'] = 1;
		$data['cartSummary'] = $this->PreviewCartItems($array,'summary');
		return View::make('orders.show')->withData($data);
	}



	public function previewCartItems($cart_items,$summary)
	{
		$table="";
		$total_num_items = 0;
		$total_value_items = 0;
		$x = 1;
		foreach($cart_items as $item_id=>$qty)
		{
			$items = DB::table('blogs')
			 ->select('blogs.id as blog_id','blog_title','blog_publish','image_name as blog_image','blog_intro','blog_featured','price','blog_sale','category_name')
			 ->leftjoin('blog_images','blogs.id','=','blog_images.blog_id')
			 ->leftjoin('categories','categories.id','=','blogs.category_id')
			 ->where('primary_image','=',1)
			 ->where('blogs.id','=',$item_id)
			 ->orderBy('blogs.created_at','DESC')
			 ->groupBy('blogs.id')
			 ->first();

			 $array = (array) $items;
			 extract($array);

			 $table .= "<tr> 
						<td> ".$x++." </td> 
						<td> ". HTML::image(URL()."/img/thumbnail/$blog_image", '', array('class'=>'img-rounded')) ." </td> 
						<td> $blog_title </td> 
						<td> $category_name </td> 
						<td> $blog_intro </td> 
						<td class='cntr'> $qty (".number_format($price, 2, '.', ',').")		 </td> 
						<td> ". number_format($price * $qty, 2, '.', ',') 			." </td> 
					</tr>";
			$total_num_items += $qty;	
			$total_value_items += $price * $qty;
		}

		//IF THERE IS AN EMPTY CART
		$checkOutButton = "";
		if(empty($cart_items))
		{
			$table .= "<tr> <td colspan='8' class='emptyCartClass'>  Sorry your cart is empty :( </td> </tr>";		
		}

		if(!Session::get('customer_info')) 
			$checkOutButton = "<button type='button' class='btn btn-warning fl go-to-customer-sign-up'>Sign Up / Log In</button>";		

		if($summary!='summary')
		{
			return $table .= "<tr> 
						<td> <b>Total</b> </td> 
						<td>  </td> 
						<td>  </td> 
						<td>  </td> 
						<td>  </td> 
						<td class='cntr'> 	<b>$total_num_items</b>	 </td> 
						<td> <b>". number_format($total_value_items, 2, '.', ',') 			."</b> </td>  
					</tr>";
		}else{
			return $total_value_items;
		}
		
	}

	//UPDATE DELIVERY DATE
	public function edit($id)
	{
		Order::updateDeliveryDate($id);

		return Response::json(array('ok'));		
	}


	public function update($id)
	{
		Order::updateOrder($id);
		return Response::json(array('ok'));
	}

	public function destroy($id)
	{
		DB::table('orders')->where('id', '=', $id)->delete();
		DB::table('order_details')->where('order_id', '=', $id)->delete();

		return Response::json('ok');
	}

}