<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact Lodenian's Woodworks</h4>
        <h5 class="modal-title" id="myModalLabel">We love to hear from you.</h5>
      </div>
      <div class="modal-body">
        {{ Form::open(array('id'=>'addfrm')) }}
        <div class="form-group">
				{{ Form::label('name','Name:') }}
				{{ Form::text('name','',array('class'=>'form-control', 'id'=>'addMsgName', 'data-parsley-required'=>'true')) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Email Address:') }}
				{{ Form::text('email_address','',array('class'=>'form-control', 'id'=>'addMsgEmail', 'data-parsley-required'=>'false','data-parsley-type'=>'email')) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Cellphone Number:') }}
				{{ Form::text('contact_number','',array('class'=>'form-control', 'id'=>'addMsgCPNum', 'data-parsley-required'=>'true')) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Message:') }}
				{{ Form::textarea('comment_message','',array('class'=>'form-control', 'id'=>'addMsgCommentMsg', 'data-parsley-required'=>'true','rows'=>'5')) }}
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Send Message</button>
      </div>
       {{ Form::close() }} 
    </div>
  </div>
  </div>