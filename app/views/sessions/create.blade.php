<html>
	<head>

	{{ HTML::style('/css/bootstrap.css') }}
	</head>
	<style>
		.form-control{
			width: 270px;
			margin: auto;
			text-align: center;
		}

		body{
		/*	text-align: center;*/
			text-align: center;
			margin-top: 50px;
		}
		label{
			color: white;
		}
		
		.border{
			padding: 35px;
			color: white;
			margin: auto;
			width: 430px;
			text-align: center;
			color: white ;
			background-color: #1db954;
			border-radius: 17px;
		}
		img{
			margin-bottom: 50px;
		}
	</style>
	<body>
		<img src = "images/bio-logo.png" style="
    height: 140px;
">
		<div class = "border"> 
			{{ Form::open(array('url' =>'sessions/store')) }}
			{{ Form::label('username','Username: ') }}
			{{ Form::text('username',null,['class' => 'form-control']) }}<br/>
			{{ Form::label('password','Password: ') }}
			{{ Form::password('password',['class' => 'form-control', 'style' => '']) }}<br/>
			{{ Form::submit('Login',['class' => 'btn btn-primary ']) }}<br><br>
			<span class = "margin">{{ $message }}</span>
			{{ Form::close() }}
		</div>
	</body>
</html>

<style>
	body {
		background: url('images/login-bg.jpg') no-repeat top center;
		background-color: #ebebeb;
	}
</style>