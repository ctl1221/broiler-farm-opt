<?php  

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Contract;
use App\OptimizerRun;
use App\ResultHeader;
use App\ResultDetail;
use App\ResultFee;

function calculate_current_input($run, $input)
{
	$contract = Contract::findOrFail($input->contract_id);
    $contract_rates = json_decode(Storage::get($contract->filepath), true);

    $birds = json_decode($input->birds);
    $feeds_consumed = json_decode($input->feeds_consumed);
    
    foreach(array_keys($contract_rates) as $x)
    {
        $rate_categories[$x] = json_decode($input[$x]);
    }

    $header = ResultHeader::create([
        'run_id' => $run->id,
    ]);

    $total_income = 0;

    for($y = 0; $y < $input->n_farms; $y++)
    {
        $detail = ResultDetail::create([
            'header_id' => $header->id,
            'farm' => $y,
            'birds' => $birds[$y],
            'feeds_consumed' => $feeds_consumed[$y]
        ]);

        $current_farm_rate = 0;
        foreach(array_keys($contract_rates) as $rate_category)
        {
            foreach(array_keys($contract_rates[$rate_category]) as $rate_name)
            {
                $rate_value = 0;
                foreach($contract_rates[$rate_category][$rate_name] as $x)
                {
                    if($x['limit_left'] <= $rate_categories[$rate_category][$y] && 
                        $x['limit_right'] >= $rate_categories[$rate_category][$y])
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

                $current_farm_rate += $rate_value;
            }
        }
        $total_income += $current_farm_rate * $birds[$y];
    }

    $header->income = round($total_income,2);
    $header->save();

    return $header->income;
}

?>