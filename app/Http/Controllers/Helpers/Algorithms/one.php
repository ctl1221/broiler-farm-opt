<?php  

use App\Contract;
use App\OptimizerRun;
use App\ResultHeader;
use App\ResultDetail;
use App\ResultFee;

function one($input, OptimizerRun $run, $original_income)
{

	$contract = Contract::findOrFail($input->contract_id);
    $contract_rates = json_decode(Storage::get($contract->filepath), true);
    $birds = json_decode($input->birds);
    $age = json_decode($input->age);
    $feeds_consumed = json_decode($input->feeds_consumed);

	foreach(array_keys($contract_rates) as $x)
    {
        $rate_categories[$x] = json_decode($input[$x]);
    }

    $fcr_ranges = array();
	foreach($contract_rates['fcr']['fee'] as $x)
	{
		if($x['limit_left'] >= $input->fcr_start && $x['limit_right'] <= $input->fcr_end)
		{
			array_push($fcr_ranges, round($x['limit_left'] + 0.0002, 4));
			array_push($fcr_ranges, round($x['limit_right'] - 0.0002, 4));
		}
	}

	$n = count($fcr_ranges);

	$farms = array();
	for($i = 0; $i < $input->n_farms; $i++)
	{
		for($j = 0; $j < count($fcr_ranges); $j++)
		{
			$farms[$i][$j]['computed_feeds'] = round($fcr_ranges[$j] * $rate_categories['alw'][$i] * $birds[$i] / 50);

			$farms[$i][$j]['fcr']['value'] = $fcr_ranges[$j];

			$farms[$i][$j]['alw']['value'] = $rate_categories['alw'][$i];

			$farms[$i][$j]['hr']['value'] = $rate_categories['hr'][$i];

			$farms[$i][$j]['bpi']['value'] = round($rate_categories['hr'][$i] * $rate_categories['alw'][$i] * 100 / $fcr_ranges[$j] / $age[$i]);

			$farms[$i][$j]['total_fees'] = 0;
			foreach(array_keys($contract_rates) as $rate_category)
	        {
	        	$farms[$i][$j][$rate_category]['subtotal'] = 0;
	            foreach(array_keys($contract_rates[$rate_category]) as $rate_name)
	            {
	                foreach($contract_rates[$rate_category][$rate_name] as $x)
	                {
	                    if($x['limit_left'] <= $farms[$i][$j][$rate_category]['value'] && 
	                        $x['limit_right'] >= $farms[$i][$j][$rate_category]['value'])
	                    {
	                        $farms[$i][$j][$rate_category][$rate_name] = $x['rate'];
	                        $farms[$i][$j][$rate_category]['subtotal'] += $x['rate'];
	                        break;
	                    }
	                }
	            }
	            $farms[$i][$j]['total_fees'] += $farms[$i][$j][$rate_category]['subtotal'];
	        }
		}
	}

	$treshold = $original_income;

	//return $contract_rates;
	//return $farms;

	if($input->n_farms == 2)
	{
		for($a = 0; $a < $n; $a++)
		{
			for($b = 0; $b < $n; $b++)
			{
				$current_income = $farms[0][$a]['total_fees'] * $birds[0];
				$current_income += $farms[1][$b]['total_fees'] * $birds[1];

				$current_feeds = $farms[0][$a]['computed_feeds'];
				$current_feeds += $farms[1][$b]['computed_feeds'];

				if($current_income > $treshold && $current_feeds >= $input->total_feeds_consumed)
				{					
					$header = ResultHeader::create([
				        'run_id' => $run->id,
				        'optimized' => 1,
				    ]);

				    for($q = 0; $q < $input->n_farms; $q++)
				    {
				    	switch($q)
        				{
        					case 0: $p = $a; break;
        					case 1: $p = $b; break;
	            		}

				    	$detail = ResultDetail::create([
				            'header_id' => $header->id,
				            'farm' => 'XXXX',
				            'birds' => $birds[$q],
				            'feeds_consumed' => $farms[$q][$p]['computed_feeds']
				        ]);

				        foreach(array_keys($contract_rates) as $rate_category)
	        			{
	        				foreach(array_keys($contract_rates[$rate_category]) as $rate_name)
	            			{
	            				ResultFee::create([
				                    'detail_id' => $detail->id,
				                    'rate_category' => $rate_category,
				                    'rate_name' => $rate_name,
				                    'rate_value' => $farms[$q][$p][$rate_category][$rate_name],
				                ]);
	        				}
	        			}
				    }
				    $header->income = round($current_income,2);
				    $header->save();
			        $treshold = $current_income;

				}
			}
		}
	}

	if($input->n_farms == 3)
	{
		return "3";
	}

	if($input->n_farms == 4)
	{
		return "4";
	}
}