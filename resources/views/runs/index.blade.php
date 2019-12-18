@extends('layouts.master')

@section('content')

	@foreach($runs as $run)

		<a href="/runs/{{ $run->id }}">{{ $run->id }}</a>

	@endforeach

@endsection
