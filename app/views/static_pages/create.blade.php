@extends('layouts/default')
@section('content')
	<?php 
	if(isset($message)) echo $message;
	extract($data);
	?>
	<h3>Edit Static Page</h3>
	
	@if(!isset($form_data['id']))
		{{ Form::open(array('id'=>'blogForm','url'=>'blogs','files'=>'true')) 				}}
	@else
		{{ Form::model($form_data,array('method'=>'PUT','id'=>'blogForm','url'=>'static_pages/'.$form_data['id'],'files'=>'true')) 		}}
	@endif
	{{ Form::label('Title:') 																		}}
	{{ Form::text('title',null, array('id'=>'blog_title','data-parsley-required'=>'true')) 	}}
	<br/>
	{{ Form::label('Body:') 																		}}
	{{ Form::textarea('static_page_content',null, ['size'=>'30x5'])										}}
	{{ Form::submit('Save', array('id'=>'btnSave','class'=>'addBtnFireUp')) 						}}
	{{ Form::close() 																				}}	

<script type="text/javascript">
	$('#blogForm').parsley();
	CKEDITOR.replace('static_page_content');
</script>	

@stop