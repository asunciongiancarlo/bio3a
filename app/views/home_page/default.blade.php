<!doctype html>
<html lang="en">
@include('home_page.header')

<body>
@include('home_page.navigation_header')
	@yield('content')
@include('contact_us.message_form')
@include('home_page.footer')
	
</body>
</html>