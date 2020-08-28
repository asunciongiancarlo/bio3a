@extends('layouts/default')
@section('content')
<?php extract($data); ?>

<h3>Statistics</h3>
@if(count($sales)>0)
<table id='myTable'>
	<thead>
	<tr>
		<th> Product Name				</th>
		<th> Category					</th>
		<th> Price						</th>
		<th> Number of Sales			</th>
	</tr>
	</thead>
	<tbody>	
	@foreach ($sales as $sale)
	 <tr> 		 	
	 	<td>  {{ $sale->blog_title 						}}  </td>
	 	<td>  {{ $sale->category_name 					}}  </td>
	 	<td>  {{ $sale->price 						 	}}  </td>
	 	<td>  {{ $sale->sale_ctr 						}}  </td>
	 </tr>
	@endforeach
	</tbody>	 
</table>
@else 
	<li> No data! </li>
@endif

<script type="text/javascript">
 $(document).ready( function () {
    $('#myTable').dataTable( {
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
        	}
    	} );
	} );

</script>
@stop