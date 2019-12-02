<!DOCTYPE html>
<html>
    <head>
        <title>Broiler Farm Optimization</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css')}}">

    </head>
    <body>
    	
    	@include('layouts.nav')

	  	<div id="app">
        	@yield('content')
    	</div>

    </body>

    <script src="{{ mix('js/app.js')}}"></script>

    @yield('scripts')

</html>
