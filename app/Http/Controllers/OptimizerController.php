<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\Contract;
use App\OptimizerRun;

include 'Helpers/Algorithms/algorithms.php';
include 'Helpers/helpers.php';

class OptimizerController extends Controller
{
    public function input_feeds()
    {
    	$companies = Company::all();
    	$contracts = Contract::all();

    	$algorithms = array();
    	array_push($algorithms, ['id' => 1, 'name' => 'LR, +002-, Non-Queued','n_farms' => [2, 3, 4]]);
    	array_push($algorithms, ['id' => 2, 'name' => 'LR, +002-, Queued','n_farms' => [5]]);
        array_push($algorithms, ['id' => 3, 'name' => 'All Combinations','n_farms' => [2]]);
    	$algorithms = json_encode($algorithms);

    	return view('optimizers.input_feeds', compact('companies','contracts','algorithms'));
    }

    public function optimize_feeds(Request $request)
    {  
        $run = OptimizerRun::create([
            'contract_id' => $request->contract_id,
            'n_farms' => $request->n_farms
        ]);
        
        $original_income = calculate_current_input($run, $request);
        
    	if($request->algorithm_id == 1)
    	{
    		one($request, $run, $original_income);
            return redirect('/runs/' . $run->id);
    	}
    }
}
