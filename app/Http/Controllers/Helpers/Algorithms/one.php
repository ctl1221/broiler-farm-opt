<?php  

function one($input)
{
	if($input->n_farms == 2)
	{
		return "2";
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