@extends('home_page/default')
@section('content')
<?php 
extract($data);
?>
<div class="container marketing">
<br/><br/><br/><br/>
<h4>View your Cart</h4>

@if( $customer_info['active_customerStatus'] == true )
	<div class="alert alert-success" role="alert">
  		Welcome <b>{{ $customer_info['active_customerFullName'] }}</b>! You can now check out and save your cart. Thank you!!!
	</div>
@else
	<div class="alert alert-warning" role="alert">
  		Please <b>{{ HTML::link(URL().'/customers', 'Sign Up or Log in', array("class"=>"alert-link"), ''); }}!</b> So you can check out and save your cart. Thank you!!!
	</div>
@endif

<table class='table table-striped'>
	<thead>
	<tr>
		<th> No.						</th>
		<th> Image						</th>
		<th> Item Name					</th>
		<th> Category					</th>
		<th> Short Description			</th>
		<th> Quantity (Price per Unit)					</th>
		<th> Price						</th>
		<th> Options Add/Remove Product					</th>
	</tr>
	</thead>
	<tbody>	
	{{ $PreviewCartItems }}
	</tbody>	 
</table>

</div>



<!-- Modal -->
<div class="modal fade" id="myTermsandConditions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
      </div>
      <div class="modal-body">
        {{ $terms_and_conditions->static_page_content }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="acceptTermsandConsitionsButton">Accept Terms and Conditions</button>
      </div>
    </div>
  </div>
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