@extends('layouts.master')

@section('content')

	{{ $run->id }} - {{ $run->original->income}}

	<table border="1">
		<tr>
			<td>Birds</td>
			@foreach($run->original->details as $x)
				<td>{{ $x->birds }}</td>
			@endforeach
		</tr>
		
		@foreach($original_fees as $rate_category => $rate_categories)
			<tr>
				<th colspan="{{ $run->n_farms + 1}}">{{ $rate_category}}</th>
			</tr>
			@foreach($rate_categories as $rate_name => $rate_names)
				<tr>
					<td>{{ $rate_name }}</td>
					@foreach($rate_names as $x)
						<td>{{ $x }}</td>
					@endforeach
				</tr>
			@endforeach
		@endforeach

		<tr>
			<td>Subtotal Fees</td>
			@foreach($subtotal['fees'] as $x)
				<td>{{ $x }}</td>
			@endforeach
		</tr>

		<tr>
			<td>Subtotal</td>
			@foreach($subtotal['subtotal'] as $x)
				<td>{{ $x }}</td>
			@endforeach
		</tr>
		
	</table>

@endsection
