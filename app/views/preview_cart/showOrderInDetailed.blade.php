@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>
<div class="container marketing">
<br/><br/><br/><br/>
<h4>Order Details</h4>
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

</div>
<style type="text/css">
	.add-to-cart-button, .remove-to-cart-button, .go-to-check-out, .inputFromSelectOption 
	{
		display: none;
	}
</style>
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