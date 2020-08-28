@extends('layouts/default')
@section('content')
	<h3>Banners</h3>
	{{ link_to(URL().'/banners/create','Add Banner') }}
	@if(count($banners)>0)
	<table id='myTable'>
		<thead>
		<tr>
			<th> Order							</th>
			<th> Banners						</th>
			<th> Publish						</th>
			<th> URL							</th>
			<th> Options						</th>
		</tr>
		</thead>
		<tbody>	

		@foreach ($banners as $banner)
		 <tr> 
		 	<td>  {{ $banner->xOrder }} </td>
		 	<td>  {{ HTML::image('/img/banners/'.$banner->banner_image, null, array('class'=>'thumb')) 			}}  </td>
		 	<td>  {{ $banner->banner_publish 																	}}  </td>		 	
		 	<td>  {{ $banner->banner_link 																		}}  </td>		 	
		 	<td>  
	 		  {{ link_to('banners/'.$banner->id.'/edit', 'Edit') 										    		}} |
	 		  {{ link_to('#', 'Delete', array('onclick'=>"delOption($banner->id)")) 		}} 
	 	</td>
		 </tr>
		@endforeach
		</tbody>	 
	</table>
	@else 
		<li> No data! </li>
	@endif
	
<script type="text/javascript">

	function delOption(id)
	{
	 	if(confirm('Are you sure you want to delete this item?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("banners.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}	

	$('#myTable').DataTable();

	</script>
@stop


