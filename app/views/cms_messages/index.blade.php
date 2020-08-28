@extends('layouts/default')
@section('content')
	<h3>Messages</h3>
	<ul>
	@if(count($data)>0)
	<table id='messageTable'>
		<thead>
		 <tr>
			<td> Name				</td>
			<td> Email Address		</td>
			<td> Contact Number		</td>
			<td> Message			</td>
			<td> Created At			</td>
			<td> Status				</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($data as $msg)
		 <tr>
			<td>  {{{  $msg->name 				}}}  </td>		 	
			<td>  {{{  $msg->email_address 		}}}  </td>		 	
			<td>  {{{  $msg->contact_number     }}}  </td>		 	
			<td>  {{{  $msg->comment_message 	}}}  </td>		 	
			<td>  {{  $msg->created_at 			}}  </td>		 	
			<td>  {{  Form::select('messagestatus', 
									array('Not yet follow up'     => 'Not yet follow up',
										  'Follow Up'		      => 'Follow Up',
										   'Order Recieved'		  => 'Order Recieved',
										   'Transaction completed' => 'Transaction completed'
										   ), $msg->message_status,
									array('onchange'=>'updateMessage(this)', 'data-msg-id'=>$msg->id)) 			
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
		type: 'Put',
		url: "{{ URL() }}"+"/cms_messages/"+id,
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



