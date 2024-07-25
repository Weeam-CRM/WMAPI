<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::all();
        return response()->json($bankAccounts);
    }

    public function store(Request $request)
    {
        $bankAccount = BankAccount::create($request->all());
        return response()->json($bankAccount, 201);
    }

    public function show($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        return response()->json($bankAccount);
    }

    public function update(Request $request, $id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->update($request->all());
        return response()->json($bankAccount, 200);
    }

    public function destroy($id)
    {
        BankAccount::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
