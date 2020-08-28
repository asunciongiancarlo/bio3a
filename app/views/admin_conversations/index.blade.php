@extends('layouts/default')
@section('content')
<?php 
extract($data);
?>

<h3>Customer Inquiries</h3>
<ul>

@if(count($messages)>0)
<table id='myTable'>
	<thead>
	 <tr>
		<td> Customer			</td>
		<td> Email Address		</td>
		<td> Mobile				</td>
		<td> Delivery Address	</td>
		<td> Option				</td>
	 </tr>
	</thead>
	<tbody>
	@foreach ($messages as $message)
	 <tr> 
			<td>  {{$message->full_name				}}  </td>		 	
			<td>  {{$message->email_address			}}  </td>		 	
			<td>  {{$message->mobile_number			}}  </td>		 	
			<td>  {{$message->delivery_address		}}  </td>		 	
	 	<td>  
	 		{{ link_to("/admin_conversations/{$message->customerID}", 'Open') }}  |
	 		{{ link_to("#", 'Delete', array('class'=>'deleteConversation', 'data-field-id'=>$message->customerID, 'onclick'=>"delOption('$message->customerID')"))}}	

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
	 	if(confirm('Are you sure you want to delete this message?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("admin_conversations.destroy",'') }}'+"/"+id,
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



