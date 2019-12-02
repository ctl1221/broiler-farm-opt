@extends('layouts.master')

@section('content')

	New Company
	
	<form method="post" action="/companies">
		@csrf

		Name
		<input type="text" name="name">

		<input type="submit">

	</form>

@endsection
