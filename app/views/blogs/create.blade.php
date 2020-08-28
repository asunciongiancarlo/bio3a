@extends('layouts/default')
@section('content')
	<?php 
	extract($data);
	?>
	<h3>Items</h3>
	
	@if(!isset($form_data['id']))
		{{ Form::open(array('id'=>'blogForm','url'=>'blogs','files'=>'true')) 				}}
	@else
		{{ Form::model($form_data,array('method'=>'PUT','id'=>'blogForm','url'=>'blogs/'.$form_data['id'],'files'=>'true')) 		}}
	@endif
	{{ Form::hidden('blod_id',null, array('id'=>'blog_id')) 										}}
	{{ Form::label('Title:') 																		}}
	{{ Form::text('blog_title',null, array('id'=>'blog_title','data-parsley-required'=>'true')) 	}}
	<br/>
	{{ Form::label('Item Intro:') 																		}}
	{{ Form::text('blog_intro',null, array('id'=>'blog_intro','data-parsley-required'=>'true')) 	}}
	<br/>
	{{ Form::label('Categories:') 																		}}
	{{ Form::select('category_id', $category_lists) 													}}
	<br/>
	{{ Form::label('Body:') 																		}}
	{{ Form::textarea('blog_content',null, ['size'=>'30x5'])										}}
	<br/>
	{{ Form::label('Publish:') 																		}}
	{{ Form::select('blog_publish', 
					array(''=>'select', 
						  'y' => 'Yes', 
						  'n' => 'No'), 
					null, 
					array(
						'id'=>'blog_publish',
						'data-parsley-required'=>'true', 'data-parsley-trigger'=>"change"))			}}
	<br/>

	{{ Form::label('Feature:') 																		}}
	{{ Form::select('blog_featured', 
					array(''=>'select', 
						  'y' => 'Yes', 
						  'n' => 'No'), 
					null, 
					array(
						'id'=>'blog_featured',
						'data-parsley-required'=>'true', 'data-parsley-trigger'=>"change"))			}}
	<br/>
	{{ Form::label('Sale:') 																		}}
	{{ Form::select('blog_sale', 
					array(''=>'select', 
						  'y' => 'Yes', 
						  'n' => 'No'), 
					null, 
					array(
						'data-parsley-required'=>'true', 'data-parsley-trigger'=>"change"))			}}
	<br/>
	{{ Form::label('Old Price:') 																		}}
    {{ Form::text('price_before',null, array('data-parsley-required'=>'true')) 							}}
    <br/>
	{{ Form::label('Price:') 																		}}
    {{ Form::text('price',null, array('data-parsley-required'=>'true')) 							}}
	{{ Form::label('Image:') 																		}}
	{{ Form::file('blog_images[]',array('multiple'=>'true')) 										}}

	<br/>
	<label>Images:</label><br/>
	@if(isset($images))
	 @foreach($images as $image)
	 <div class='blogImages'>
	  {{ HTML::image('img/thumbnail/'.$image->image_name) }}
	  <!-- MANIPULATE IMAGES -->
	  @if($image->primary_image == 1)
	   {{ "<p> Default </p>" }}
	  @else
		{{ "<p onclick='set_as_default_image(".$image->blog_id .", ". $image->blog_imagesID .")'> Set as Default </p>" }}
	   {{ "<p onclick='delete_image(". $image->blog_imagesID .")'> Delete </p>"  }}
	  @endif
	  </div>
	 @endforeach
	@endif

	{{ Form::submit('Save', array('id'=>'btnSave','class'=>'addBtnFireUp')) 						}}
	{{ Form::close() 																				}}	

<script type="text/javascript">
	$('#blogForm').parsley();
	CKEDITOR.replace('blog_content');

	//SET AS DEFAULT IMAGE
	function set_as_default_image(blogID, imageID)
	{
		if(confirm('Set as default image?'))
		{
			$.ajax({
			 type: "GET",
			 url: "{{ URL().'/blogs/set_as_default_image/' }}" + blogID +'/'+ imageID,
			 dataType: "json",
			 async: false,
			 cache: false,
			 contentType: false,
			 processData: false, 
			 success:function(data)
			 {
			 	alert('Primary has been set! click save to view changes.');
			 },
			 error: function(msg)
			 {
			 	console.log('Error message: '+msg);
			 }
		  });
		}
	}

	//DELETE IMAGES
	function delete_image(imageID)
	{
		if(confirm('Delete this image?'))
		{
			$.ajax({
			 type: "GET",
			 url: "{{ URL().'/blogs/delete_image/' }}" + imageID,
			 dataType: "json",
			 async: false,
			 cache: false,
			 contentType: false,
			 processData: false, 
			 success:function(data)
			 {
			 	alert('Image has been delete, click save to view changes.');
			 },
			 error: function(msg)
			 {
			 	console.log('Error message: '+msg);
			 }
		  });
		}
	}
</script>	

@stop