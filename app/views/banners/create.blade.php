@extends('layouts/default')
@section('content')
	<?php 
	if(isset($message)) echo $message;
	extract($data);
	?>
	<h3>Banner</h3>
	
	@if(!isset($formData['id']))
		{{ Form::open(array('id'=>'bannerForm','url'=>'banners','files'=>'true')) 								}}
	@else
		{{ Form::model($formData,array('method'=>'PUT','id'=>'blogForm','url'=>'banners/'.$formData['id'],'files'=>'true')) 	}}
	@endif

	{{ Form::label('Order:') 																			}}
	{{ Form::text('xOrder',null, array('data-parsley-required'=>'true')) 								}}
	<br/>
	{{ Form::label('Banner Header:') 																	}}
	{{ Form::text('banner_header',null, array('data-parsley-required'=>'true')) 						}}
	<br/>
	{{ Form::label('Banner Sub Header:') 																	}}
	{{ Form::text('banner_sub_header',null, array('data-parsley-required'=>'true')) 						}}
	<br/>
	{{ Form::label('Publish:') 																		}}
		{{ 
		Form::select('banner_publish', 
					array('n'=>'select', 
						  'y' => 'Yes', 
						  'n' => 'No'), 
					null, 
					array(
						'data-parsley-required'=>'true', 
						'data-parsley-trigger'=>"change"))			
	}}
	<br/>
	{{ Form::label('Banner Link:') 																	}}
	{{ Form::text('banner_link',null, array('data-parsley-required'=>'true')) 						}}
	<br/>
	{{ Form::label('Banner Image:') 																}}
	{{ Form::file('banner_image') 																	}}
	{{ Form::submit('Save', array('id'=>'btnSave','class'=>'addBtnFireUp')) 						}}
	{{ Form::close() 																				}}	

<script type="text/javascript">
	$('#bannerForm').parsley();
</script>	

@stop