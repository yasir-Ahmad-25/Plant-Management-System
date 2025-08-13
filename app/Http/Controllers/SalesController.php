<?php

namespace App\Http\Controllers;

use App\Models\ProductSales;
use App\Models\ProductSalesDetails;
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

        // store the essentail in product_sales table and store the details like each product and quantity and price and total in product_sale_details table
        // Assuming you have a Sale model and ProductSaleDetail model
        $sale = ProductSales::create([
            'customer_name' => $request->customer_name,
            'customer_number' => $request->customer_number,
            'customer_address' => $request->customer_address,
            'sales_date' => $request->sales_date,
            'discount' => $request->discount,
            'delivery' => $request->delivery,
            'paid' => $request->paid,
            'balance' => $request->balance,
        ]);
        foreach ($request->products as $product) {
            ProductSalesDetails::create([
                'sale_id' => $sale->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        if(!$sale) {
            return redirect()->back()->with('error', 'Failed to create sale. Please try again.');
        }
        
        // Return response or redirect
        return redirect()->route('admin.sales')->with('success', 'Sale created successfully.');
    }
}
