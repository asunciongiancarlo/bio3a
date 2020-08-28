@extends('home_page/default')
@section('content')
<?php extract($data); ?>
<div class="container marketing">
<br/><br/><br/><br/>
 <!-- SIGN UP -->
  <div class="panel panel-primary fl fifty_percent">
      <div class="panel-heading">
        <h3 class="panel-title">Sign Up: New Customer</h3>
      </div>
      <div class="panel-body">
      <div class="modal-body">
        {{ Form::open(array('id'=>'signUpfrm')) }}
        <div class="form-group">
				{{ Form::label('name','Username:') }}
				{{ Form::text('user_name','',array('class'=>'form-control', 'id'=>'user_name', 'data-parsley-required'=>'true', 'data-parsley-type'=>'alphanum', "data-parsley-maxlength"=>"50")) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Password:') }}
				{{ Form::password('password',array('class'=>'form-control', 'id'=>'password', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"50")) }}
		</div>
		 <div class="form-group">
				{{ Form::label('name','Full Name:') }}
				{{ Form::text('full_name','',array('class'=>'form-control', 'id'=>'full_name', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"50")) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Email Address:') }}
				{{ Form::text('email_address','',array('class'=>'form-control', 'id'=>'email_address', 'data-parsley-required'=>'true','data-parsley-type'=>'email', "data-parsley-maxlength"=>"50")) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Mobile Number:') }}
				{{ Form::text('mobile_number','',array('class'=>'form-control', 'id'=>'mobile_number', 'data-parsley-required'=>'true',  'data-parsley-type'=>'integer',"data-parsley-maxlength"=>"11")) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Delivery Address:') }}
				{{ Form::textarea('delivery_address','',array('class'=>'form-control', 'id'=>'delivery_address', 'data-parsley-required'=>'true','rows'=>'5',"data-parsley-maxlength"=>"255")) }}
		</div>
      </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="sign_up">Sign Up</button>
       </div>
       {{ Form::close() }} 
      </div>
</div>
<!-- SIGN UP -->

<!-- LOG IN -->
    <div class="panel panel-success fl fifty_percent">
      <div class="panel-heading">
        <h3 class="panel-title">Log in: Returning Customer</h3>
      </div>
      <div class="panel-body">
        <div class="panel-body">
      <div class="modal-body">
        {{ Form::open(array('id'=>'LogInfrm')) }}
        <div class="form-group">
				{{ Form::label('name','Username:') }}
				{{ Form::text('user_name1','',array('class'=>'form-control', 'id'=>'user_name1', 'data-parsley-required'=>'true', 'data-parsley-type'=>'alphanum', "data-parsley-maxlength"=>"50")) }}
		</div>
		<div class="form-group">
				{{ Form::label('name','Password:') }}
				{{ Form::password('password1',array('class'=>'form-control', 'id'=>'password1', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"50")) }}
		</div>
      </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="log_in">Log In</button>
       </div>
       {{ Form::close() }} 
      </div>
      </div>
    </div>
    
</div>
<!-- LOG IN -->
@stop
