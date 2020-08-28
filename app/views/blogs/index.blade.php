@extends('layouts/default')
@section('content')
	<h3>Items</h3>
	@include('blogs.lists')

<script type="text/javascript">
	function editBlog(blogID)
	{
		window.location.href = "{{ URL().'/blogs/' }}"+blogID+"/edit";
	}

	function delOption(id)
	{
	 	if(confirm('Are you sure you want to delete this item?'))
		{
			$.ajax({
			type: 'Delete',
			url: '{{ action("blogs.destroy",'') }}'+"/"+id,
			dataType: 'json',
			success: (function(data){
					location.reload();
				})
			});
		}			
	}

	$('#myTable').DataTable();
</script>
@stop


