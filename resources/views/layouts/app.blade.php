<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=drivce-width,initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title','laraBBS')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">

	@include('layouts._header')

	<div class="container">

		@yield('content')

	</div>
	
	@include('layouts._footer')
</div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>