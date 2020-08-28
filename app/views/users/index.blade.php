@extends('layouts/default')
@section('content')
	<?php 
	extract($data);
	if(isset($message)) echo $message;
	?>

	<h3>Users</h3>
	{{ link_to('users/create', 'Add User') }}
	<ul>

	@if(count($users)>0)
	<table id='myTable' class="table-striped table-bordered">
		<thead>
		 <tr>
			<td> Image			</td>
			<td> Username		</td>
			<td> Options		</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($users as $user)
		 <tr> 
		 	<td>  {{ HTML::image('/img/'.$user->image, $user->username, array('class'=>'thumb')) 			}}  </td>
		 	<td>  {{$user->username 						 												}}  </td>		 	
		 	<td>  
		 		{{ link_to("/users/{$user->userID}/edit", 'Edit') 							 				    }}  |
		 	    {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($user->userID)")) 	}} 	
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
	function delOption(id)
	{
	 	if(confirm('Are you sure you want to delete this user?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("users.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}

	$(document).ready(function(){
        $('#myTable').DataTable();
	});
</script>
@stop



