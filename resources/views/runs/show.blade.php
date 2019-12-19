@extends('layouts.master')

@section('content')

	{{ $run->id }}
	{{ $run->original->income}} => 

	Original
	<table border="1">
		<tr>
			<td>Birds</td>
			<td v-for="x in t_original.headers.birds">@{{ x }}</td>
		</tr>

		<template v-for="x, x_key in t_original" v-if="x_key !== 'headers'">
			<tr>
				<th>@{{ x_key }}</th>
			</tr>
			<tr v-for="y, y_key in x">
				<td>@{{ y_key }}</td>
				<td v-for="z, i in y">
					@{{ z }}
					<span v-if="selected_index !== -1">
						=> @{{ t_selected_result[x_key][y_key][i]}}
					</span>
				</td>
			</tr>
		</template>
		
{{-- 		<tr>
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
		</tr> --}}

{{-- 		<tr>
			<td>Feeds</td>
			<td>{{ $x->feeds_consumed }} => </td>
		</tr>  --}}
		
	</table>

	Optimizations

	<table border="1">
		<tr v-for="(row, index) in results" :bgcolor="index === selected_index ? 'red' : 'white'">
			<td>@{{ row.income }}</td>
			<td v-for="x in row.details">@{{ x.feeds_consumed }}</td>
			<td><span @click=selectResult(index)>Select</span></td>
		</tr>
	</table>

@endsection

@section('scripts')

	<script>

		var app = new Vue({

			el: '#app',
			data: {
				'results':{!! $run->top_k(5) !!},
				't_selected_result':null,
				't_original':null,				
				'selected_index':-1,
			},

			methods: {
			  
			  	db_to_farm_array(items)
			  	{
			  		var array = {
			  						'headers':{
			  							'birds':[]
			  						}
			  					}
			  		var detail_ids = []

			  		//Get Detail IDs
			  		for(var i = 0; i < items.details.length; i++)
			  		{
			  			array['headers']['birds'][i] = items.details[i].birds
			  			detail_ids[i] = items.details[i].id
			  		}

			  		for(var i = 0; i < items.fees.length; i++)
			  		{

			  			farm_index = detail_ids.indexOf(items.fees[i].detail_id)
			  			rate_category = items.fees[i]['rate_category']
			  			rate_name = items.fees[i]['rate_name']
			  			rate_value = items.fees[i]['rate_value']

			  			if(array[rate_category] == null)
			  			{
			  				array[rate_category] = {}
			  			}

			  			if(array[rate_category][rate_name] == null)
			  			{
			  				array[rate_category][rate_name] = []
			  			}

			  			array[rate_category][rate_name][farm_index] = rate_value
			  		}

			  		return array
			  	},

			  	selectResult(index)
			  	{
			  		if(this.selected_index == index)
			  		{
			  			this.selected_index = -1
			  			this.t_selected_result = null
			  		}
			  		else
			  		{
			  			this.selected_index = index
			  			this.t_selected_result = this.db_to_farm_array(this.results[index])
			  		}
			  	},	
			},

			created () {
				this.t_original = this.db_to_farm_array({!! $run->original !!});
			}
		});

	</script>
@endsection
