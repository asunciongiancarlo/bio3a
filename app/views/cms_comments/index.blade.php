@extends('layouts/default')
@section('content')
	
	<h3>Comments</h3>
	<ul>
	@if(count($data)>0)
	<table id='messageTable'>
		<thead>
		 <tr>
			<td> Item				</td> 
			<td> Commentator		</td>
			<td> Email 				</td>
			<td> Comments			</td>
			<td> Status				</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($data as $com)
		 <tr>
			<td>  {{ $com->blog_title }}  </td>		 	
			<td>  {{ $com->commentator	}}  </td>
			<td>  {{ $com->email	}}  </td>		 		 		 	
			<td>  {{ $com->comment	}}  </td>		 		 		 	
			<td>  {{  Form::select('status', 
									array('Pending'     => 'Pending',
										  'Approve'		      => 'Approve',
										   'Disapprove'		  => 'Disapprove'										  
										   ), $com->status,
									array('onchange'=>'updateMessage(this)', 'data-msg-id'=>$com->cID)) 			
				   }}  
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
	function updateMessage(me)
	{
		var value = $(me).val();
		var id    = $(me).attr('data-msg-id');
		//UPDATE MESSAGE
		$.ajax({
		type: 'PUT',
		url: "{{ URL() }}"+"/cms_comments/"+id,
		dataType: 'json',
		data: {message_status: value },
		success: (function(data){
		 alert('Status has been updated to: '+value+'!');
		 })
		});
	}
	$(document).ready(function(){
        $('#messageTable').DataTable({"aaSorting": []});
	});
</script>
@stop



