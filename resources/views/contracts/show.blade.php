@extends('layouts.master')

@section('content')	

	{{ $contract->name }}

	@foreach($contract_rates as $section => $sections)
		{{ $section }}
		@foreach($sections as $type => $types)
			<li>{{ $type }}</li>
			<table border="1">
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Rate</th>
				</tr>	
				@foreach($types as $x)
					<tr>
						<td>{{ $x['limit_left'] }}</td>
						<td>{{ $x['limit_right'] }}</td>
						<td>{{ $x['rate'] }}</td>
					</tr>
				@endforeach
			</table>
		@endforeach
	@endforeach


@endsection