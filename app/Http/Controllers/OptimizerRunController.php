<?php

namespace App\Http\Controllers;

use App\OptimizerRun;
use Illuminate\Http\Request;

include 'Helpers/helpers.php';

class OptimizerRunController extends Controller
{

    public function index()
    {
        $runs = OptimizerRun::all();

        return view('runs.index', compact('runs'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(OptimizerRun $run)
    {
        return view('runs.show', compact('run'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
