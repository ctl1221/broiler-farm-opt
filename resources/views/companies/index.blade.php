@extends('layouts.master')

@section('content')
	
	<a href="/companies/create">Create Company</a><br/>

	@foreach($companies as $company)
		<a href="/companies/{{ $company->id }}">
			{{ $company->name }}
		</a><br/>
	@endforeach

@endsection
