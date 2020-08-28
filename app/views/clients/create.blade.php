@extends('layouts/default')

@section('content')
	<h3> CREATE USER </h3>

	@if($errors->any())
	<div class="alert alert-danger">
		<ul>
		@foreach($errors->all() as $error)
			<li> {{ $error }} </li>
		@endforeach
		</ul>
	</div>
	@endif
	
	
	<?php
	extract($data);
    if(!$userData){
        echo 	Form::open(array('url'=>'users/store','files'=>true));
    }else{
        echo 	Form::model($userData,array('url'=>'users/update/','files'=>true));
    } 	        
            
	echo	Form::hidden('id');
	echo	Form::label('username', 'Username: ');
	echo	Form::text('username');
        
	echo    "<br/>";
	echo	Form::label('password', 'Password: ');
	echo	Form::password('password');
	
	echo    "<br/>";
	echo 	Form::file('image');
	echo    "<br/>";
	echo 	Form::submit('Create User');
	echo 	Form::close();
	?>
@stop

