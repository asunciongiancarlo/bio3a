@extends('home_page/default')
@section('content')
<?php extract($data); ?>

<section id="blog" class="container">
	<div class="center">
		<h2> Blogs </h2>
	</div>
	<?php print_r($breadCrumbs); ?>

	<div class="blog">
		<div class="row">
			<div class="col-md-8">
				<div class="blog-item">
					<div class="row">
						<div class="col-xs-12 col-sm-12 blog-content">

							@if(count($blogs)>0)
								@foreach($blogs as $blog)
									<div class="col-sm-6 col-md-4 width-100-percent">
										<div class="thumbnail {{ isThisANewItem($blog->created_at) }} thumbnailForGallery">
											<!-- ADD NEW LABEL -->
											@if(isThisANewItem($blog->created_at)=='NEW')
												<span class='newLabel'>NEW ITEM</span>
											@else
												<span class='newLabel'>&nbsp;</span>
												@endif

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
								<p> No blog found, please try other category </p>
							@endif
							<div class="cl"></div>
							{{ $blogs->links(); }}

						</div>
					</div>
				</div><!--/.blog-item-->
			</div><!--/.col-md-8-->

			<aside class="col-md-4">

				<div class="widget categories test">
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

</section><!--/#blog-->




 <?php 
 function isThisANewItem($date_from_user)
 {
 	// Convert to timestamp
	$start_ts = strtotime(date('Y-m-d', strtotime('+5 days', strtotime(date('Y-m-d H:m:s'))))); 
	$end_ts   = strtotime(date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d H:m:s'))))); 
	$user_ts  = strtotime(date('Y-m-d', strtotime('+0 days', strtotime(date($date_from_user))))); 
	
	// Check that user date is between start & end
	if(!($user_ts >= $start_ts) && ($user_ts <= $end_ts)) 
		echo '';
	else 												  
		return 'NEW';	
 } 
 ?>   
@stop



