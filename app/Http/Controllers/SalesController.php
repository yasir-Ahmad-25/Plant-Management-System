<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Sales Management',
        ];
        // Logic to display sales page
        return view('sales.index', $data);
    }


    public function create_sale_view(){
        $data = [
            'page_title' => 'Create Sale',
        ];
        // Logic to display create sale view
        return view('sales.create', $data);
    }

    public function store_sale(Request $request){
        // Validate and save the sale data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_number' => 'required|string|max:15',
            'customer_address' => 'required|string|max:255',
            'sales_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'delivery' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
        ]);

        // Return response or redirect
        return redirect()->route('admin.sales')->with('success', 'Sale created successfully.');
    }
}
