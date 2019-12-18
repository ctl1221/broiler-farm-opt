<?php  

function three($input)
{
	$fcr = json_decode($input->fcr);
	$alw = json_decode($input->alw);
	$birds = json_decode($input->birds);

	$feeds_consumed = json_decode($input->feeds_consumed);

	for($i = 0; $i < $input->n_farms; $i++)
	{
		$feeds_ranges[$i]['min'] = round($input->fcr_start * $alw[$i] * $birds[$i] / 50);
		$feeds_ranges[$i]['max'] = round($input->fcr_end * $alw[$i] * $birds[$i] / 50);
	}

	if($input->n_farms == 2)
	{
		$z = 0;
		for($a = $feeds_ranges[0]['min']; $a <= $feeds_ranges[0]['max']; $a++)
		{
			for($b = $feeds_ranges[1]['min']; $b <= $feeds_ranges[1]['max']; $b++)
			{
				if($a + $b == $input->total_feeds_consumed)
				{
					$z++;
					break;
				}
			}
		}
		return $z;
	}
}