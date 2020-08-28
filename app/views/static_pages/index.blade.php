@extends('layouts/default')
@section('content')
	<h3>Static Pages</h3>
	@if(count($static_pages)>0)
	<table id='myTable'>
		<thead>
		<tr>
			<th> Title							</th>
			<th> Content						</th>
			<th> Options						</th>
		</tr>
		</thead>
		<tbody>	

		@foreach ($static_pages as $static_page)
		 <tr> 
		 	<td>  {{ $static_page->title 				}} </td>
		 	<td>  {{ $static_page->static_page_content 	}}  </td>		 	
		 	<td>  
	 		  {{ link_to('static_pages/'.$static_page->id.'/edit', 'Edit') 		}}
	 		</td>
		 </tr>
		@endforeach
		</tbody>	 
	</table>
	@else 
		<li> No data! </li>
	@endif

	<script type="text/javascript">
		$('#myTable').DataTable();
	</script>
@stop


