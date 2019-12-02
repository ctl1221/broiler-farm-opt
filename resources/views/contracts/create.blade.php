@extends('layouts.master')

@section('content')
	
	<form method="post" action="/contracts" enctype="multipart/form-data">
		@csrf
		
		Contract Name
		<input type="text" name="name" required>

		Broiler Farm:
		<select name="company_id">
			@foreach($companies as $company)
				<option value="{{ $company->id }}">
					{{ $company->name }}
				</option>
			@endforeach
		</select>

		Date Valid
		<input type="date" name="date_valid" required>

		JSON File
		<input type="file" name="json_file" required>

		<input type="submit">

	</form>

@endsection
