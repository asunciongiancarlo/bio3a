@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>
<div class="container marketing">
<br/><br/><br/><br/>
<h4>Thank you Message</h4>

@if( $customer_info['active_customerStatus'] == true )
	<div class="alert alert-success" role="alert">
  		Thank you for placing your order kindly take note of your Order ID: <b>{{ $reference_number }}</b> for future reference. <br/>
  		Currently your order has a status is <b>On Hold</b>.<br/>
		Once your order has been processed you will receive a message from admin. <br/>
		Thank you!!!
	</div>
@endif

@stop