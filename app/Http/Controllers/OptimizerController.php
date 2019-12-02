<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Company;
use App\Contract;
use App\ResultHeader;
use App\ResultDetail;
use App\ResultFee;

include 'Helpers/Algorithms/algorithms.php';

class OptimizerController extends Controller
{
    public function input_feeds()
    {
    	$companies = Company::all();
    	$contracts = Contract::all();

    	//return $companies;

    	$algorithms = array();
    	array_push($algorithms, ['id' => 1, 'name' => 'LR, +002-, Non-Queued','n_farms' => [2, 3, 4]]);
    	array_push($algorithms, ['id' => 2, 'name' => 'LR, +002-, Queued','n_farms' => [5]]);
    	$algorithms = json_encode($algorithms);

    	return view('optimizers.input_feeds', compact('companies','contracts','algorithms'));
    }

    public function optimize_feeds(Request $request)
    {
        $contract = Contract::findOrFail($request->contract_id);
        $contract_rates = json_decode(Storage::get($contract->filepath), true);

        $header = ResultHeader::create([
            'n_farms' => $request->n_farms,
        ]);

        for($y = 0; $y < $request->n_farms; $y++)
        {
            $detail = ResultDetail::create([
                'header_id' => $header->id,
                'farm' => $y,
            ]);

            foreach(['alw'] as $rate_category)
            {
                foreach(array_keys($contract_rates[$rate_category]) as $rate_name)
                {
                    $rate_value = 0;
                    foreach($contract_rates[$rate_category][$rate_name] as $x)
                    {
                        if($x['limit_left'] <= $request[$rate_category][$y] && 
                            $x['limit_right'] >= $request[$rate_category][$y])
                        {
                            $rate_value = $x['rate'];
                            break;
                        }
                    }

                    ResultFee::create([
                        'detail_id' => $detail->id,
                        'rate_category' => $rate_category,
                        'rate_name' => $rate_name,
                        'rate_value' => $rate_value,
                    ]);
                }
            }
        }

        return "true";

    	if($request->algorithm_id == 1)
    	{
    		return one($request);
    	}
    }
}
