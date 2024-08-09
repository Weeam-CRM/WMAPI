<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        //$invoiceItems = Invoice::where('id','!=',null)->get();
        $invoiceItems = Invoice::with(['developer', 'bankAccount'])->orderBy('id', 'desc')->get();
        return response()->json(['invoice_items' => $invoiceItems], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $invoice = Invoice::create($request->all());

        return response()->json(['invoice' => $invoice], 201);
    }

    public function show($id)
    {
        $invoice = auth()->user()->invoices()->findOrFail($id);
        return response()->json(['invoice' => $invoice], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $invoice = auth()->user()->invoices()->findOrFail($id);
        $invoice->update($request->all());

        return response()->json(['invoice' => $invoice], 200);
    }

    public function destroy($id)
    {
        $invoice = auth()->user()->invoices()->findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }
}
