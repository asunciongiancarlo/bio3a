@extends('home_page/default')
@section('content')
<?php extract($data); ?>
<div class="container marketing">
<br/><br/><br/><br/>
<h4>Messages</h4>
 <!-- SIGN UP -->
  <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Message Admin</h3>
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
       {{ Form::open(array('id'=>'MsgAdminfrm', 'url'=>'conversations', 'files'=>true)) }}
       <div class="modal-footer">
         <div class="form-group">
          {{ Form::label('name','Message:') }}
          {{ Form::textarea('message','',array('class'=>'form-control', 'id'=>'message', 'data-parsley-required'=>'true','rows'=>'5')) }}
        </div>
        {{ Form::file('image', array("accept"=>"image/gif, image/jpeg")) }}
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

</script>
@stop
