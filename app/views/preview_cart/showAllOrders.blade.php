@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>
<div class="container marketing">
<br/><br/><br/><br/>
<h4>List of Orders</h4>

	<ul>
	@if(count($orders)>0)
	<table id='myTable' class='table-striped table-bordered'>
		<thead>
		 <tr class='warning'>
			<td> Customer Name		</td>
			<td> Ref. Num.			</td>
			<td> Email Address		</td>
			<td> Mobile				</td>
			<td> Delivery Address	</td>
			<td> Order Date				</td>
			<td> Delivery Date				</td>
			<td> Status				</td>
			<td> Purchased			</td>
			<td> Details			</td>
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
			<td>  {{$order->oDate 						 														}}  </td>
			<td>  {{$order->delivery_date 						 														}}  </td>
			<td>  {{$order->status 						 														}}  </td>
			<td>  {{$order->itm_ctr 						 													}}  </td>	 	
			<td>  {{ link_to("/preview_cart/{$order->orderID}/edit", 'Details') }}  </td>
		  </tr>
		@endforeach
		</tbody>
	</table>
	@else 
		<li> No data! </li>
	@endif
	</ul>

</div>
<script type="text/javascript">
	$(document).ready( function() {
	  $('#myTable').dataTable( {
	    "oLanguage": {
	      "sSearch": "Additional Filter:"
	    }
	  } );
	} );
</script>
@stop