<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function index($invoiceId)
    {
        $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)->get();
        return response()->json(['invoice_items' => $invoiceItems], 200);
    }

    public function store(Request $request, $invoiceId)
    {
        $request->validate([
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $invoiceItem = InvoiceItem::create([
            'invoice_id' => $invoiceId,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
        ]);

        return response()->json(['invoice_item' => $invoiceItem], 201);
    }

    public function show($invoiceId, $itemId)
    {
        $invoiceItem = InvoiceItem::where('invoice_id', $invoiceId)->findOrFail($itemId);
        return response()->json(['invoice_item' => $invoiceItem], 200);
    }

    public function update(Request $request, $invoiceId, $itemId)
    {
        $request->validate([
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $invoiceItem = InvoiceItem::where('invoice_id', $invoiceId)->findOrFail($itemId);
        $invoiceItem->update($request->all());

        return response()->json(['invoice_item' => $invoiceItem], 200);
    }

    public function destroy($invoiceId, $itemId)
    {
        $invoiceItem = InvoiceItem::where('invoice_id', $invoiceId)->findOrFail($itemId);
        $invoiceItem->delete();

        return response()->json(['message' => 'Invoice item deleted successfully'], 200);
    }
}
