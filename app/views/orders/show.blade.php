@extends('layouts/default')
@section('content')
<?php 
extract($data);
?>

<h3>Orders</h3>

<table class='table table-striped'>
	<thead>
	<tr>
		<th> No.						</th>
		<th> Image						</th>
		<th> Item Name					</th>
		<th> Category					</th>
		<th> Short Description			</th>
		<th> Quantity (Price per Unit)	</th>
		<th> Price						</th>
	</tr>
	</thead>
	<tbody>	
	{{ $PreviewCartItems }}
	</tbody>	 
</table>

<div class="panel panel-primary fl fifty_percent">
      <div class="panel-heading">
        <h3 class="panel-title">Order Information </h3>
      </div>
      <div class="panel-body">
      <div class="modal-body">
        <div class="form-group">
			<label for="name">Last Order Status:</label>
			<input type='text' disabled value="{{ $order_info->status }}" class="form-control"> 
		</div>
        <div class="form-group">
			<label for="name">Delivery Date:</label>
			{{ Form::open(array('id' => 'delivery_dateFrm')) }}
				{{ Form::text('delivery_date', $order_info->delivery_date, array('id' => 'delivery_date', 'class'=>'form-control')); }} 	
			{{ Form::close(); }}
		</div>
      </div>
      </div>
</div>

<div class="panel panel-success fl fifty_percent">
      <div class="panel-heading">
        <h3 class="panel-title">Payment Logs</h3>
      </div>
	  @if(count($payment_logs)>0)
	  <table class="table table-bordered">
  	  <tr>
  	  	<td>No.</td>
  	  	<td>Date</td>
  	  	<td>Type</td>
  	  	<td>Amount</td>
  	  </tr>
  	  @foreach($payment_logs as $payment_log)
	  <tr>
	  	<td> {{ $x++ }} </td>
	  	<td> {{ $payment_log->payment_date }} </td>
	  	<td> {{ $payment_log->payment_type }} </td>
	  	<td> {{ number_format($payment_log->payment_value, 2, '.', ',') }} </td>
	  	<?php @$total += $payment_log->payment_value  ?>
	  </tr>
  	  @endforeach
  	  <tr>
	  	<td> Total Payment </td>
	  	<td>  </td>
	  	<td>  </td>
	  	<td> {{ number_format(@$total, 2, '.', ',') }}  </td>
	  </tr>
	  <tr>
	  	<td> Cart Price </td>
	  	<td>  </td>
	  	<td>  </td>
	  	<td> {{ number_format($cartSummary, 2, '.', ',') }}  </td>
	  </tr>
	  <tr>
	  	<td> Remaining Balance </td>
	  	<td>  </td>
	  	<td>  </td>
	  	<td> {{ number_format($cartSummary - $total, 2, '.', ',') }}  </td>
	  </tr>
	  </table>
	  @endif
	  
      <div class="panel-body">
      <p class="bg-info">Add your transaction here <br/>(Your last transaction will be the status of your order):</p>
      {{ Form::open(array('id' => 'transactionFrm')) }}
      <div class="modal-body">
      	 {{ Form::hidden('order_id', $order_info->id) }}
      	 <div class="form-group">
			<label for="name">Transaction Date:</label>
				{{ Form::text('payment_date', '', array('id' => 'payment_date', 'class'=>'form-control', 'data-parsley-required'=>'true')); }} 	
		</div>
         <div class="form-group">
				<label for="name">Transaction Type:</label>
				{{  Form::select('payment_type', 
									array(
										  'On Hold'     => 'On Hold',
										  'Completed'   => 'Completed',
										  'Failed'      => 'Failed',
										  'Processing'	=> 'Processing',										  
										  'Cancelled'	=> 'Cancelled',										  
										  '25% Paid'	=> '25% Paid',										  
										  '50% Paid'	=> '50% Paid',										  
										  '75% Paid'	=> '75% Paid',										  
										   ), null,
									array('class'=>'form-control')) 			
				   }}  	
		 </div>
		 <div class="form-group">
			<label for="name">Amount:</label>
				{{ Form::text('payment_value', '', array('class'=>'form-control','data-parsley-required'=>'true',"data-parsley-type"=>"integer"
				)); }} 	
		</div>
      </div>
      {{ Form::close(); }}
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="save_transaction">Save Transaction</button>
       </div>
        
      </div>
</div>

<script type="text/javascript">
	//UDPATE DELIVER STATUS
	$('#delivery_date').on('change', function(){
		console.log($(this).val());
		$.ajax({
				type: 'POST',
				url: '{{ URL() }}/'+'orders/updateDeliveryDate/'+{{$order_info->id}},
				data: $('form#delivery_dateFrm').serialize(),
				dataType:'json',
				success: (function(data){
					console.log(data);
						alert('Delivery date has been set');
				}),
				complete: (function(){
				})
			});
	});

	//SAVE TRANSACTION
	$('#save_transaction').on('click', function(){
		if($('#transactionFrm').parsley().validate()){
			$.ajax({
					type: 'POST',
					url: '{{ URL() }}/'+'payment_logs',
					data: $('form#transactionFrm').serialize(),
					dataType:'json',
					success: (function(data){
						console.log(data);
							alert('Transaction has been recorded!');
							location.reload();
					}),
					complete: (function(){
					})
				});
		}
	});

	$(function() {
		$( "#delivery_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#payment_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
 	});
</script>

<style>
.fifty_percent
{
	width: 46%;
	margin: 20px;
}
</style>	
@stop



