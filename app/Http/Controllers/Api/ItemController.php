<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
     public function showByBarcode(Request $request)
    {
        $barcode = $request->get('barcode');
        $item = Item::with('category')->where('barcode', $barcode)->first();

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'barcode' => $item->barcode,
            'category' => $item->category,
            'hsn_code' => $item->hsn_code,
            'current_stock' => $item->current_stock,
            'price' => $item->price,
            'unit' => $item->unit,
        ]);
    }
}
