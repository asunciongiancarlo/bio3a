<?php 

use Illuminate\Routing\Controller;

class PreviewCartController extends BaseController {


	public function index()
	{
		//SORT ITEMS
		$array = Session::get('cart_items');
		$array = array_values(array_sort($array, function($value)
		{
		    return $value;
		}));

		$array 					  = array_count_values($array);
		$data['active_page'] 	  = 'Cart';
		$data['cart_items']  	  = $array;
		$data['PreviewCartItems'] = $this->PreviewCartItems($array);
		$data['terms_and_conditions'] = DB::table('static_pages')->whereId(5)->first();		

		return View::make('preview_cart.show')->withData($data);	
	}

	//VIEW ALL ORDERS FROM CUSTOMER
	public function show($customer_id)
	{
		$data['active_page'] 	  = 'Cart';
		$data['orders']  	  	  = Order::customerOrders($customer_id);		

		return View::make('preview_cart.showAllOrders')->withData($data);
	}
	//VIEW ALL ORDERS FROM CUSTOMER

	//VIEW ALL ORDERS IN DETAILS FROM CUSTOMER
	public function edit($order_id)
	{
		$data['active_page'] 	  = 'Cart';

		//GET ALL ORDER ITEMS 
		$items = DB::table('order_details')
					->select('item_id')
					->where('order_id','=',$order_id)
					->get();

		//convert obj to array
		$result = array();
		foreach ($items as $key => $value) {
		    $result[] = $value->item_id;
		}

		$array = array_count_values($result);	
		$data['PreviewCartItems'] = $this->PreviewCartItems($array);		
		return View::make('preview_cart.showOrderInDetailed')->withData($data);	
	}
	//VIEW ALL ORDERS IN DETAILS FROM CUSTOMER

	public function viewThankYouPage()
	{
		$data['active_page'] 	  = 'Cart';
		$data['reference_number'] = Order::storeOrder();
		//CLEAR CART AFTER CHECK OUT
		Session::forget('cart_items'); 
		return View::make('preview_cart.viewThankYouPage')->withData($data);
	}

	public function previewCartItems($cart_items)
	{
		$table="";
		$total_num_items = 0;
		$total_value_items = 0;
		$x = 1;

		//DROP DOWN VALUE
		$arr=[];
		for($select=1;$select<=100;$select++){
			$arr[] = $select;
		}

		foreach($cart_items as $item_id=>$qty)
		{
			$items = DB::table('blogs')
			 ->select('blogs.id as blog_id','blog_title','blog_publish','image_name as blog_image','blog_intro','blog_featured','price','blog_sale')
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
						<td> $blog_intro </td> 
						<td> $blog_title </td> 
						<td class='cntr'> $qty (".number_format($price, 2, '.', ',').")		 </td> 
						<td> ". number_format($price * $qty, 2, '.', ',') 			." </td> 
						<td class='cntr'> ".
							Form::select('qty', $arr , ($qty-1) , array("class"=>"inputFromSelectOption form-control fl", "data-item-id"=>$item_id)).  	
							link_to('#', '&nbsp;X&nbsp;', array("class"=>"btn btn-danger fl remove-to-cart-button", "role"=>"button", "onclick"=>"removeItemfromCart($blog_id)", "title"=>"Remove Item", "style"=>"margin:10px;"))
						." </td> 
					</tr>";
			$total_num_items += $qty;	
			$total_value_items += $price * $qty;
		}

		//IF THERE IS AN EMPTY CART
		$checkOutButton = "";
		if(empty($cart_items))
		{
			$table .= "<tr> <td colspan='8' class='emptyCartClass'>  Sorry your cart is empty :( </td> </tr>";		
		}else{
			$checkOutButton = "<button type='button' class='btn btn-warning fl go-to-check-out'>Check out</button>";
		}

		if(!Session::get('customer_info')) 
			$checkOutButton = "<button type='button' class='btn btn-warning fl go-to-customer-sign-up'>Sign Up / Log In</button>";		

		return $table .= "<tr> 
						<td> <b>Total</b> </td> 
						<td>  </td> 
						<td>  </td> 
						<td>  </td> 
						<td>  </td> 
						<td class='cntr'> 	<b>$total_num_items</b>	 </td> 
						<td> <b>". number_format($total_value_items, 2, '.', ',') 			."</b> </td> 
						<td class='cntr'> $checkOutButton </td> 
					</tr>";
	}
}