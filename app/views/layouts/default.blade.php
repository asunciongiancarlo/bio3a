<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>3A BIO</title>
	
	{{ HTML::style('css/style.css') }}
	{{ HTML::style('css/jquery.dataTables.css') }}
	{{ HTML::style('css/dataTables.tableTools.css') }}

	{{ HTML::script('js/jquery-2.1.0.min.js') 		}}
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/buttons.dataTables.min.css') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/DataTables1_3.js')  }}
	{{ HTML::script('js/numeric-comma.js')  }}
	{{ HTML::script('js/moment.js')  }}
	{{ HTML::script('js/datetime-moment.js')  }}
	{{ HTML::script('js/currency.js')  }}
	{{ HTML::script('js/signed-num.js')  }}
	{{ HTML::script('js/dataTables.buttons.min.js')  }}

	{{ HTML::script('js/parsley.js') 		}}
	{{ HTML::script('js/parsley.remote.js') }}


	{{ HTML::script('js/dataTables.tableTools.js') 	}}
{{--	{{ HTML::script('js/ckeditor.js') 	}}--}}

{{--	{{ HTML::script('js/geoPosition.js') 	}}--}}
{{--	{{ HTML::script('js/geoPosition.js') 	}}--}}

	<!-- COLOR PICKER -->
{{--    {{ HTML::script('js/colorpicker.js') }}--}}
{{--    {{ HTML::style('css/colorpicker.css') }}--}}
    <!-- COLOR PICKER -->

	{{ HTML::style('css/jquery-ui.css') }}
	{{ HTML::script('js/jquery-ui.js') 		}}


	{{ HTML::script('js/select2.min.js') 		}}
	{{ HTML::style('css/select2.min.css') 		}}


	{{ HTML::script('js/pdfmake-master/build/pdfmake.js') 		}}
	{{ HTML::script('js/pdfmake-master/build/vfs_fonts.js') 		}}
	{{ HTML::script('js/buttons.html5.min.js') 		}}
	{{ HTML::script('js/jszip.min.js') 		}}
	<style type="text/css">


	.navbar-brand:hover
	{
		text-decoration: underline!important;
	}
	body {
		background: url('images/login-bg.jpg') no-repeat top center;
		background-color: #ebebeb;
	}
	</style>
</head>
@include('layouts.navigation_header')
	<div class="container marketing cms-container">
		@yield('content')
	</div>
	@yield('footer')

</body>
</html>