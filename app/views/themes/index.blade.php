@extends('layouts/default')
@section('content')
	<?php 
	extract($data);
	?>

	<h3>Themes</h3>
	<ul>
	@if(count($themes)>0)
	{{ Form::open(array('method'=>'PUT','id'=>'themesForm','url'=>'themes/update')) 				}}
	<table id='myTable'>
		<thead>
		 <tr>
			<td> End			</td>
			<td> Property		</td>
			<td> Value			</td>
		 </tr>
		</thead>
		<tbody>
		@foreach ($themes as $theme)
		 <tr> 
		 	<td>  {{$theme->end 						 												}}  </td>		 	
		 	<td>  {{$theme->property 						 											}}  </td>		 	
		 	<td> 
		 		{{ Form::hidden('ids[]',$theme->id) }} 
				{{ Form::text('values[]', $theme->value, ['id'=>$theme->end, 'data-theme-id'=>$theme->id]) }}
		 	</td>	
		  </tr>
		@endforeach
		</tbody>
	</table>
	@else 
		<li> No data! </li>
	@endif
	</ul>
	<button type="submit" class="btn btn-primary" id="message_admin" style="float: right;margin-right: 50px;">Save</button>
	{{ Form::close(); }}

<script type="text/javascript">
$('.colorPickerDiv').change(function(){
	//alert(0);
	//console.log(this.val());
});

$('#Front-End-Background-Color, #Back-End-Background-Color').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	},
	onChange: function (hsb, hex, rgb) {
		$(this).ColorPickerSetColor(this.value);
		console.log('ID:'+$(this).attr('data-theme-id')+'#' +hex);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});



	function delOption(id)
	{
	 	if(confirm('Are you sure you want to delete this user?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("users.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}

	$(document).ready(function(){
        $('#myTable').DataTable();
	});
</script>
@stop



