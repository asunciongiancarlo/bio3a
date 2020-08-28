@extends('layouts/default')
@section('content')
	{{ link_to('categories/create','Add Category') }}
	<?php if(isset($message)) echo $message; ?>
	<h3>Categories</h3>
	@if(count($categories)>0)
	<table id='myTable'>
		<thead>
		<tr>
			<th> xOrder						</th>
			<th> Category Name				</th>
			<th> Publish					</th>
			<th> Options					</th>
		</tr>
		</thead>
		<tbody>	
		@foreach ($categories as $category)
		<?php  $category->category_publish = ($category->category_publish=='y') ? 'Yes' : 'No'; ?>
		 <tr>
		 	<td>  {{  $category->xOrder 						 											}}  	</td>		 	
		 	<td>  {{  $category->category_name 						 										}}  	</td>		 	
		 	<td>  {{  $category->category_publish 					    									}}      </td>
		 	<td>  
		 		  {{ link_to('categories/'.$category->id.'/edit', 'Edit') 									}} | 
		 		  {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($category->id)")) 			}} 
		 	</td>
		 </tr>
		 <?php $child_categories = App::make('CategoriesController')->getCategoryChild($category->id); ?>
		
		 <!--GET CHILD OF CATEGORIES-->
		 <?php print_r($child_categories); ?>
		
		@endforeach
		</tbody>	 
	</table>
	@else 
		<li> No data! </li>
	@endif

<script type="text/javascript">
$(document).ready(function(){
	var table = $('#myTable').DataTable();
});

function delOption(id)
{
 	if(confirm('Are you sure you want to delete this item?'))
	{
		$.ajax({
		type: 'Delete',
		url: '{{ action("categories.destroy",'') }}'+"/"+id,
		dataType: 'json',
		success: (function(data){
				location.reload();
			})
		});
	}			
}	

</script>
@stop
