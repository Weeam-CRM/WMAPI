<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // $invoices = auth()->user()->invoices()->orderBy('created_at', 'desc')->get();
        // return response()->json(['invoices' => $invoices], 200);

        $invoiceItems = Invoice::where('id','!=',null)->get();
        return response()->json(['invoice_items' => $invoiceItems], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        /*$invoice = auth()->user()->invoices()->create($request->all());

        return response()->json(['invoice' => $invoice], 201);*/

        // Create a new invoice using only the request data
        $invoice = Invoice::create([
            'user_id' => 1,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'total_amount' => $request->total_amount,
            'notes' => $request->notes,
            // Add more fields as needed
        ]);

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
