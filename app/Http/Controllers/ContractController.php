<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        $companies = Company::all();
        return view('contracts.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $filepath = Storage::put('contracts',$request->json_file);

        $contract = Contract::create($request->all());
        $contract->filepath = $filepath;
        $contract->save();

        return redirect('/contracts/' . $contract->id);
    }

    public function show(Contract $contract)
    {
        $contract_rates = json_decode(Storage::get($contract->filepath), true);

        return view('contracts.show', compact('contract','contract_rates'));
    }

    public function edit(Contract $contract)
    {
        //
    }

    public function update(Request $request, Contract $contract)
    {
        //
    }

    public function destroy(Contract $contract)
    {
        //
    }
}
