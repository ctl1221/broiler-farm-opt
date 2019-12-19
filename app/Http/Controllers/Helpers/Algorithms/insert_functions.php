<?php

use App\ResultHeader;
use App\ResultDetail;
use App\ResultFee;

function insert_to_db($run, $input, $index, $birds, $farms, $contract_rates, $current_income)
{
    $header = ResultHeader::create([
        'run_id' => $run->id,
        'optimized' => 1,
    ]);

    for($q = 0; $q < $input->n_farms; $q++)
    {
        switch($q)
        {
            case 0: $p = $index[0]; break;
            case 1: $p = $index[1]; break;
            case 2: $p = $index[2]; break;
            case 3: $p = $index[3]; break;
            case 4: $p = $index[4]; break;
            case 5: $p = $index[5]; break;
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
    return $current_income;
}