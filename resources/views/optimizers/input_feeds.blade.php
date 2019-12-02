@extends('layouts.master')

@section('content')

	Broiler Farm:
	<select v-model="company_id" :required="false">
		<option v-for="company in companies" :value="company.id">
			@{{ company.name }}
		</option>
	</select>

	Contract:
	<select v-model="contract_id" :required="false">
		<option 
			v-for="contract in contracts"  
			v-if="contract.company_id == company_id"
			:value="contract.id">
				@{{ contract.name }}
		</option>
	</select>

	Farms:
	<select v-model="n_farms">
		<option :value="2">2 Farms</option>
		<option :value="3">3 Farms</option>
		<option :value="4">4 Farms</option>
		<option :value="5">5 Farms</option>
	</select>

	Algorithms:
	<select v-model="algorithm_id" :required="false">
		<option 
			v-for="algorithm in algorithms"
			v-if="algorithm.n_farms.indexOf(n_farms) != -1"
			:value="algorithm.id">
				@{{ algorithm.name }}
		</option>
	</select>

	<table>
		<thead>
			<tr>
				<td></td>
				<th v-for="farm in n_farms">@{{ farm }}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
		    	<th class="has-text-right" style="vertical-align: middle">Birds Harvested</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="birds[index]" type="text" :required="false">
		        </td>
			</tr>
			<tr>
		    	<th class="has-text-right" style="vertical-align: middle">Quantity Started</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="qs[index]" type="text" :required="false">
		        </td>
			</tr>

			<tr>
		    	<th class="has-text-right" style="vertical-align: middle">Age</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="age[index]" type="text" :required="false">
		        </td>
			</tr>

	    	<th class="has-text-right" style="vertical-align: middle">Average Live Weight (ALW)</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="alw[index]" type="text" :required="false">
		        </td>
			</tr>

	    	<th class="has-text-right" style="vertical-align: middle">Harvest Recovery (HR)</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="hr[index]" type="text" :required="false">
		        </td>
			</tr>
		</tbody>
	</table>

	<table>
		<tbody>
		    <tr>
		    	<th :colspan="n_farms + 1" class="has-text-centered has-background-light">Variables</th>
		    </tr>
		    	<th class="has-text-right" style="vertical-align: middle">Feeds Conversion Ratio (FCR)</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="fcr[index]" type="text">
		        </td>
			</tr>

	    	<th class="has-text-right" style="vertical-align: middle">Broiler Production Index (BPI)</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="bpi[index]" type="text">
		        </td>
			</tr>

			<th class="has-text-right" style="vertical-align: middle">Feeds Consumed</th>
		        <td v-for="(farm, index) in n_farms">
		        	<input class="input" v-model="feeds_consumed[index]" type="text">
		        </td>
			</tr>

			<tr>
		    	<th class="has-text-right">Total Feeds Consumed</th>
		    	<td class="has-text-centered" :colspan="n_farms + 1">@{{ total_feeds_consumed}}</td>
		    </tr>
		</tbody>
	</table>

	<input type="submit" v-on:click="submitForm">
	
@endsection

@section('scripts')

	<script>

		var app = new Vue({

			el: '#app',
			data: {
				companies: {!! $companies !!},
				contracts: {!! $contracts !!},
				algorithms: {!! $algorithms !!},
				company_id: {!! $companies[0]->id !!},
				contract_id:'',
				algorithm_id:'',

				n_farms:5,

				farm_names: [],
				birds: [],
			  	qs: [],
			  	alw: [],
			  	hr: [],
			  	age: [],

			  	fcr: [],
			  	bpi: [],

			  	feeds_consumed: [0,0,0,0,0],
			},
			computed: {
			  	total_feeds_consumed () {
			  		var total = 0;
			  		for (i = 0; i < this.n_farms; i++) {
			  			total += parseInt(this.feeds_consumed[i]);
					}
					return total;
			  	}
			},

			methods: {
			  	submitForm()
			  	{
			  		axios.post('/optimize/feeds', this.$data)
			  				.then(response => {
			  					console.log(response.data);
			  					// window.location.href = "/";
			  				})
			  				.catch(function (error) {
								console.log(error);
							});
			  	},	
			}
		});

	</script>
@endsection
