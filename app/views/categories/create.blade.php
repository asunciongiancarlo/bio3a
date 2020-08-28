@extends('layouts/default')
@section('content')
	<?php 
	if(isset($message)) echo $message;
	extract($data);
	?>
	<h1>Create Category</h1>
	
	@if(!isset($form_data->id))
		{{ Form::open(array('id'=>'categoryForm','url'=>'categories','files'=>'true')) 								}}
	@else
		{{ Form::model($form_data,array('method'=>'PUT','id'=>'blogForm','url'=>'categories/'.$form_data->id,'files'=>'true')) 	}}
	@endif

	{{ Form::label('Order:') 																		}}
	{{ Form::text('xOrder',null, array('data-parsley-required'=>'true')) 							}}
	<br/>
	{{ Form::label('Category Name:') 																}}
	{{ Form::text('category_name',null, array('id'=>'blog_title','data-parsley-required'=>'true')) 	}}
	<br/>
	{{ Form::label('Parent:') 																		}}
	{{ Form::select('parent_id', $category_lists) 
	}}
	<br/>
	{{ Form::label('Publish:') 																		}}
	{{ 
		Form::select('category_publish', 
					array(''=>'select', 
						  'y' => 'Yes', 
						  'n' => 'No'), 
					null, 
					array(
						'id'=>'category_publish',
						'data-parsley-required'=>'true', 
						'data-parsley-trigger'=>"change"))			
	}}
	<br/>
	{{ Form::label('Icon:') 																		}}
	{{ Form::submit('Save', array('id'=>'btnSave','class'=>'addBtnFireUp')) 						}}
	{{ Form::close() 																				}}	

<script type="text/javascript">
	$('#categoryForm').parsley();
	CKEDITOR.replace('blog_content');
</script>	

@stop