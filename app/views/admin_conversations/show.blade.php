@extends('layouts/default')
@section('content')
<?php 
extract($data);
?>

<h3>View Customer Inquiries</h3>
  <div class="panel panel-primary" style='width:80%;margin-left:10%;'>
      <div class="panel-heading">
        <h3 class="panel-title">Reply To Customer</h3>
      </div>
      <div class="panel-body">
      <div class="modal-body align-left">
       @foreach ($conversations as $conversation)
       <!-- CUSTOMER -->
       @if($conversation->user_type=='Customer')
       <div class="alert alert-info align-left bottom-zero" role="alert">
         @if($conversation->attachment)
         {{ HTML::image('/img/attachment/'.$conversation->attachment, $conversation->message, array('class'=>'img-rounded','style'=>'max-width:50%;'))       }}
         {{ HTML::link('/conversations/'.$conversation->conversationID.'/edit', 'Download Attachment', array('target'=>'_blank'), null); }}
         <br/>
        @endif
         <b>{{ $conversation->full_name }}:</b> {{ $conversation->message }}
       </div>
       <!-- CUSTOMER -->
       @else
       <div class="alert alert-success align-left bottom-zero" role="alert">
         <b>Admin:</b> {{ $conversation->message }}
       </div>
       @endif
       <label class='comment-label'> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($conversation->cdate))->diffForHumans(); }}</label>
      @endforeach
      </div>
       {{ Form::open(array('id'=>'MsgAdminfrm')) }}
       <div class="modal-footer">
         <div class="form-group">
          {{ Form::hidden('reply_to',$customerIDNumber) }}
          {{ Form::label('name','Message:') }}
          {{ Form::textarea('message','',array('class'=>'form-control', 'id'=>'message', 'data-parsley-required'=>'true','rows'=>'5')) }}
        </div>
         <button type="button" class="glyphicon glyphicon-refresh btn btn-primary" id="message_refresh"> Refresh </button>
         <button type="button" class="btn btn-primary" id="message_admin">Send Message</button>
       </div>
       {{ Form::close() }} 
      </div>
</div>
<!-- SIGN UP -->
</div>
<script type="text/javascript">
   $('#message_refresh').on('click',function(){
    location.reload();
  });

  $("html, body").animate({ scrollTop: $(document).height() }, 500); 

  $('#message_admin').on('click',function(){
		if($('#MsgAdminfrm').parsley().validate()){
			//VALIDATE IF USER IS ALREADY EXIST
			$.ajax({
				type: 'POST',
				url: '{{ URL() }}/'+'admin_conversations',
				data: $('form#MsgAdminfrm').serialize(),
				dataType:'json',
				success: (function(data){
					console.log(data);
					if(data=='send')
						alert('Message has been send!');
					
					location.reload();
				}),
				complete: (function(){
				})
			});
		}
	});

</script>

@stop



