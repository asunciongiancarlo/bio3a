@extends('layouts/default')
@section('content')
	<?php 
	extract($data);
	?>

	<h3>Orders</h3>
	<ul>
	@if(count($orders)>0)
	<table id='myTable'>
		<thead>
		 <tr>
			<td> Customer Name		</td>
			<td> Ref. Num.			</td>
			<td> Email Address		</td>
			<td> Mobile				</td>
			<td> Delivery Address	</td>
			<td> Orders				</td>
			<td> Order Date			</td>
			<td> Delivery Date		</td>
			<td> Status				</td>
			<td> Options			</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($orders as $order)
		 <tr> 
			<td>  {{$order->full_name 						 													}}  </td>		 	
			<td>  {{$order->order_code 						 													}}  </td>		 	
			<td>  {{$order->email_address 						 												}}  </td>		 	
			<td>  {{$order->mobile_number 						 												}}  </td>		 	
			<td>  {{$order->delivery_address 						 											}}  </td>		 	
			<td>  {{$order->itm_ctr 						 													}}  </td>
			<td>  {{$order->oDate 						 														}}  </td>
			<td>  {{$order->delivery_date 						 														}}  </td>
			<td>  {{$order->status }}</td>			 	
			<td>
				{{ link_to("/admin_conversations/{$order->customer_id}", 'Messages') 							 				    }} |  
				{{ link_to("/orders/{$order->orderID}", 'Details') 							 				    }} |
				{{ link_to("#", 'Delete', array('class'=>'deleteOrder', 'data-field-id'=>$order->orderID, 'onclick'=>"delOption('$order->orderID')"))						 				    }} 
		 	</td>
		  </tr>
		@endforeach
		</tbody>
	</table>
	@else 
		<li> No data! </li>
	@endif
	</ul>


<script type="text/javascript">
	function updateOrder(me)
	{
		var value = $(me).val();
		var id    = $(me).attr('data-msg-id');
		//UPDATE MESSAGE
		$.ajax({
		type: 'Put',
		url: "{{ URL() }}"+"/orders/"+id,
		dataType: 'json',
		data: {message_status: value },
		success: (function(){
		 alert('Status has been updated to: '+value+'!');
		 })
		});
	}

	function delOption(id)
	{
	 	if(confirm('Are you sure you want to delete this Order?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("orders.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}

	$(document).ready(function(){
        $('#myTable').DataTable({"order": []});
	});
</script>
@stop



