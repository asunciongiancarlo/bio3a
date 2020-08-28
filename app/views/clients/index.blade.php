@extends('layouts/default')
@section('content')
	<?php 
	extract($data);
	?>

	<h3>Clients</h3>
	<?php
	if(Session::get('message')){
		echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ". Session::get('message') ."
             </div>";
	}
	?>

	<?php
	extract($data);
	if(isset($userData))
        echo 	Form::model($userData,array('url'=>'clients/update/','files'=>true,'class'=>'myForm'));
	else
        echo 	Form::open(array('url'=>'clients/store','files'=>true,'class'=>'myForm'));

	echo	Form::hidden('id');
	echo    "<div class='form-group'>";
	echo	Form::label('client_name', 'Client Name:');
	echo	Form::text('client_name', null,array('class'=>'form-control','data-parsley-required'=>'true'));
	echo    "<br/>";
	echo 	Form::submit('Submit',array('class'=>'btn btn-primary'));
	echo 	Form::close();
    echo    "<div/>";
	?>
	<br/>

	<ul>
	@if(count($users)>0)
	<table id='myTable' class="table-striped table-bordered">
		<thead>
		 <tr>
			<td> Client Name		</td>
			<td> Options		</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($users as $user)
		 <tr>
		 	<td>  {{$user->client_name 						 												}}  </td>
		 	<td>  
		 		{{ link_to("/clients/{$user->id}/edit", 'Edit') 							 				    }}  |
		 	    {{ link_to('#', 'Delete', array('class'=>'delOption','onclick'=>"delOption($user->id)")) 	}}
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
	 	if(confirm('Are you sure you want to delete this item?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("clients.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}

	$(document).ready(function(){
        $('#myTable').DataTable();

		$('.myForm').parsley();
	});
</script>
@stop



