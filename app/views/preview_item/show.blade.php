	@extends('home_page/default')
@section('content')
<style>
.commentBox{
	height:400px;
	width:400px;
	background-color: #FFDEDE;
}

</style>
<?php 
extract($data);
extract($product);
?>


<section id="blog" class="container">
	<div class="center">
		<h2>Blog  </h2>
	</div>
	<?php print_r($breadCrumbs); ?>

	<div class="blog">
		<div class="row">
			<div class="col-md-8">
				<div class="blog-item">
					<div class="row">
						<div class="col-xs-12 col-sm-12 blog-content">
							<h2>
								{{ $form_data['blog_title']   }}
							</h2>
							<p>
								<i>{{ $form_data['blog_intro']   }}</i>
							</p>
							{{ $form_data['blog_content'] }}

						</div>
					</div>
				</div><!--/.blog-item-->
				<br/>
				<div class="addthis_inline_share_toolbox"></div>

				<!-- Comments -->
				@if(count($comment)>0)
					<h1 id="comments_title"> Comments</h1>
					@foreach ($comment as $com)

						<div class="media comment_section">
							<div class="pull-left post_comments">
								 <a> {{ HTML::image('/images/h/blog/avatar3.png',null, array('class'=>'img-circle')) }}</a>
							</div>
							<div class="media-body post_reply_comments">
								<h3> {{ $com->commentator }} </h3>
								<h4>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($com->created_at))->diffForHumans(); }}</h4>
								<p>{{$com->comment}}</p>
							</div>
						</div>
					@endforeach
				@endif

				<hr>
				<div id="contact-page clearfix">
					<div class="status alert alert-success" style="display: none"></div>
					<div class="message_heading">
						<h4>Leave a Reply</h4>
						<p>Make sure you enter the(*)required information where indicate.HTML code is not allowed</p>
					</div>


					{{ Form::open(array('id'=>'CommentItemfrm','class'=>'contact-form')) }}
					{{ Form::label('name','*Name:') }}
					{{ Form::text('name',null,['class' => 'form-control', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"50"]) }}
					{{ Form::label('email','*Email:') }}
					{{ Form::text('email',null,['class' => 'form-control', 'data-parsley-required'=>'true', 'data-parsley-maxlength'=>'50','data-parsley-type'=>'email']) }}
					{{ Form::label('comment','*Comment:') }}
					{{ Form::textarea('comment',null,['class' => 'form-control', 'data-parsley-required'=>'true', "data-parsley-maxlength"=>"255"]) }} <br/>
					{{ Form::button('Submit',['class' => 'btn btn-primary btn-lg','id'=>'CommentfrmBtn']) }}
					<input type = "hidden" name = "id" value = "{{ $form_data['id'] }}">
					{{ Form::close() }}

				</div><!--/#contact-page-->
			</div><!--/.col-md-8-->

			<aside class="col-md-4">
				<div class="widget categories">
					<h3>Categories</h3>
					<div class="row">
						<div class="col-sm-6">
							<?php  print_r($categories); ?>
						</div>
					</div>
				</div><!--/.categories-->



			</aside>

		</div><!--/.row-->

	</div><!--/.blog-->

	@if($related_products)
		<hr class="featurette-divider ">
		<h3> Related Articles </h3>
		@foreach($related_products as $blog)
			<div class="col-sm-6 col-md-4 width-100-percent">
				<div class="thumbnail {{ ($blog->created_at) }} thumbnailForGallery">
					<!-- ADD NEW LABEL -->

					{{ HTML::image('img/thumbnail/'.$blog->blog_image, null , array('class'=>'fl imgOfGallery')) }}
							<!-- <img data-src="holder.js/100%x200" alt="100%x200" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxkZWZzLz48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjkzIiB5PSIxMDAiIHN0eWxlPSJmaWxsOiNBQUFBQUE7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6MTFwdDtkb21pbmFudC1iYXNlbGluZTpjZW50cmFsIj4yNDJ4MjAwPC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
	          -->
					<div class="caption">
						<h3 title='{{ $blog->blog_title }}'>{{ Str::limit($blog->blog_title,50) }}</h3>
						<p> {{ Str::limit($blog->blog_intro,50) }} </p>
						<p class='fr'>
							{{ link_to('/preview_item/'.$blog->id, 'Read More', array("class"=>"btn btn-primary", "role"=>"button")) }}
						</p>
					</div>
				</div>
			</div>
		@endforeach
	@else
		<p> No uploaded items yet. </p>
	@endif

</section><!--/#blog-->

	
	<script>
		$('document').ready(function(){
			$('#CommentfrmBtn').on("click",function(){
				if($('#CommentItemfrm').parsley().validate()){
					$.ajax({
						method : "POST",
						url : '{{ action("cms_comments.store") }}',
						dataType : "JSON",
						data : $('form#CommentItemfrm').serialize(),
						success: function(){
							alert('Comment has been submitted to the admin, Thank you!');
							$('form#CommentItemfrm').reset();
						}

					});
				}
			});
		});

 	</script>
@stop



