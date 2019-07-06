<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>BeauList</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
	<div class="container">
		<h1 style="padding-top:40px;">BeauList</h1>
		<hr>
		@yield('main')
	</div>
	<script src="{{ asset('js/app.js') }}"></script>
	@yield('javascript')
</body>
</html>