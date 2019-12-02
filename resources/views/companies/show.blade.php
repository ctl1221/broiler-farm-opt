@extends('layouts.master')

@section('content')
	
	{{ $company->name }}

	Active Contracts
	@foreach($company->active_contracts as $x)
		<li>{{ $x->id }} {{ $x->name }}</li>
	@endforeach

	Expired Contracts
	@foreach($company->expired_contracts as $x)
		<li>{{ $x->id }} {{ $x->name }}</li>
	@endforeach

@endsection
