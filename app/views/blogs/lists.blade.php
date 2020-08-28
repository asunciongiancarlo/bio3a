{{ link_to(URL().'/blogs/create','Add Item') }}

@if(count($blogs)>0)
<table id='myTable'>
	<thead>
	<tr>
		<th> Icon						</th>
		<th> Title						</th>
		<th> Publish					</th>
		<th> Featured					</th>
		<th> Sale						</th>
		<th> Old Price					</th>
		<th> Price						</th>
		<th> Options					</th>
	</tr>
	</thead>
	<tbody>	
	@foreach ($blogs as $blog)
	<?php $blog->blog_publish  = ($blog->blog_publish=='y')  ? 'Yes' : 'No' ?>
	<?php $blog->blog_featured = ($blog->blog_featured=='y') ? 'Yes' : 'No' ?>
	<?php $blog->blog_sale     = ($blog->blog_sale=='y')     ? 'Yes' : 'No' ?>
	 <tr> 
	 	<td>  {{ HTML::image('/img/resize/'.$blog->blog_image,null, array('class'=>'thumb')) 			}}  </td>
	 	<td>  {{ Str::limit($blog->blog_title, 50) 						 		}}  </td>		 	
	 	<td>  {{ $blog->blog_publish 						 	}}  </td>
	 	<td>  {{ $blog->blog_featured 						 	}}  </td>
	 	<td>  {{ $blog->blog_sale 						 		}}  </td>
	 	<td>  {{ number_format($blog->price_before, 2, '.', '') 		}}  </td>
	 	<td>  {{ number_format($blog->price, 2, '.', '') 		}}  </td>
	 	<td>  
	 		  {{ link_to("#", 'Edit', array('class'=>'editBlog1', 'data-field-id'=>$blog->id, 'onclick'=>"editBlog('$blog->id')")) 		}} |  
	 	  	  {{ link_to("#", 'Delete', array('class'=>'deleteBlog', 'data-field-id'=>$blog->id, 'onclick'=>"delOption('$blog->id')")) 	}} 	
	 	</td>
	 </tr>
	@endforeach
	</tbody>	 
</table>
@else 
	<li> No data! </li>
@endif