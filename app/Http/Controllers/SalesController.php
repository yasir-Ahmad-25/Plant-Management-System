<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSales;
use App\Models\ProductSalesDetails;
use DB;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class SalesController extends Controller
{
    public function index()
    {
        // get sales data
        $detailCounts = DB::table('product_sales_details')
        ->select('sale_id', DB::raw('COUNT(*) as number_of_products'))
        ->groupBy('sale_id');

        $sales = ProductSales::leftJoinSub($detailCounts, 'dc', function ($join) {
            $join->on('product_sales.sale_id', '=', 'dc.sale_id');
        })
        ->select(
            'product_sales.sale_id',
            'product_sales.invoice_number',
            'product_sales.sales_date',
            'product_sales.customer_name',
            'product_sales.customer_number',
            'product_sales.customer_address',
            'product_sales.discount',
            'product_sales.paid',
            'product_sales.delivery',
            'product_sales.balance',
            'product_sales.grand_total',
            DB::raw('COALESCE(dc.number_of_products, 0) as number_of_products')
        )
        ->get();

        $data = [
            'page_title' => 'Sales Management',
            'sales' => $sales,
        ];
        // Logic to display sales page
        return view('sales.index', $data);
    }

    public function create_sale_view(){
        $products = Product::all()->sortDesc();
        $data = [
            'page_title' => 'Add New Sale - Plant Products',
            'products' => $products,
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
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'delivery' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
        ]);

        // store the essentail in product_sales table and store the details like each product and quantity and price and total in product_sale_details table
        // generare random invoice number make it like 5 digits
        $invoice_number = 'INV-' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        // Assuming you have a Sale model and ProductSaleDetail model
        $sale = ProductSales::create([
            'invoice_number' => $invoice_number,
            'customer_name' => $request->customer_name,
            'customer_number' => $request->customer_number,
            'customer_address' => $request->customer_address,
            'sales_date' => $request->sales_date,
            'discount' => $request->discount,
            'delivery' => $request->delivery,
            'paid' => $request->paid,
            'balance' => $request->balance,
            'grand_total' => $request->grand_total,
        ]);
        
        if(!$sale) {
            // return redirect()->back()->with('error', 'Failed to create sale. Please try again.');
            return response()->json([
                'status' => false,
                'message' => "Failed to create sale. Please try again."
            ]);
        }else{
            foreach ($request->products as $product) {
                ProductSalesDetails::create([
                    'sale_id' => $sale->sale_id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }
            // Return response
            return response()->json([
                'status' => true,
            ]);

            
            // return redirect()->route('admin.sales')->with('success', 'Sale created successfully.');
        }
        
    }

    public function get_product_price(Request $request){
        $product_id = $request->input('product_id');
        // Get the product price from the database based on posted product id
        $product = Product::where('product_id',$product_id)->first();
        
        // if product is found return the price otherwise return error message
        if($product){
            return response()->json([
                'status' => true,
                'price' => $product->product_price
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Product Price Not Found !"
            ]);

        }
        
    }


    # ===== Edit Section ====== #
    public function edit_sale_view($sale_id){

        // get sales data based on sale_id
        $saleData = ProductSales::join('product_sales_details','product_sales.sale_id','=','product_sales_details.sale_id')
        ->select('product_sales.*','product_sales_details.*')
        ->where('product_sales.sale_id','=',$sale_id)
        ->first();

        $sale_id = $saleData->sale_id;
        $selected_products = ProductSalesDetails::join('products' ,'products.product_id' , '=' ,'product_sales_details.product_id')
        ->select('product_sales_details.*','products.*')
        ->where('sale_id',$sale_id)->get();

        $products = Product::all();

        $data = [
            'page_title' => "Edit Sale",
            'saleData' => $saleData,
            'selected_products' => $selected_products,
            'products' => $products
        ];
        return view('sales.edit',$data);
    }

    public function update_sale(Request $request, $sale_id){
        // Validate and update the sale data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_number' => 'required|string|max:15',
            'customer_address' => 'required|string|max:255',
            'sales_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'delivery' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
        ]);

        // Update the sale
        $sale = ProductSales::find($sale_id);
        if(!$sale) {
            return response()->json([
                'status' => false,
                'message' => "Sale not found."
            ]);
        }

        $invoice_number = 'INV-' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $isSaleUpdated = $sale->update([
            'invoice_number' => $invoice_number,
            'customer_name' => $request->customer_name,
            'customer_number' => $request->customer_number,
            'customer_address' => $request->customer_address,
            'sales_date' => $request->sales_date,
            'discount' => $request->discount,
            'delivery' => $request->delivery,
            'paid' => $request->paid,
            'balance' => $request->balance,
            'grand_total' => $request->grand_total,
        ]);

        if(!$isSaleUpdated) {
            return response()->json([
                'status' => false,
                'message' => "Failed to update sale. Please try again."
            ]);
        }

        // Update the sale details
        ProductSalesDetails::where('sale_id', $sale_id)->delete();
        
        foreach ($request->products as $product) {
            ProductSalesDetails::create([
                'sale_id' => $sale_id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Sale updated successfully."
        ]);
    }

    # ====== Delete Section  ====== #
    public function delete_sale($sale_id){
        // Delete The Product Sale Data
        $product_sale = ProductSales::find($sale_id);
        if(!$product_sale) {
            return response()->json([
                'status' => false,
                "message" => "Sale not Found !"
            ]);
        }

        $sale_id = $product_sale->sale_id;
        // then delete all associated details to this sale_id
        ProductSalesDetails::where('sale_id', $sale_id)->delete();
        // then delete the product sale
        $isDeleted = $product_sale->delete();
        if(!$isDeleted) {
            return response()->json([
                'status' => false,
                "message" => "Failed to delete sale. Please try again."
            ]);
        }
    }

    # ==== Get Sale Data For Printing ===== #
    public function get_sale_data($sale_id){
        $saleData = ProductSales::where('product_sales.sale_id','=',$sale_id)
        ->select(
            'product_sales.sale_id',
            'product_sales.invoice_number',
            'product_sales.sales_date',
            'product_sales.customer_name',
            'product_sales.customer_number',
            'product_sales.customer_address',
            'product_sales.discount',
            'product_sales.paid',
            'product_sales.delivery',
            'product_sales.balance',
            'product_sales.grand_total',
        )
        ->first();

        if(!$saleData) {
            return response()->json([
                'status' => false,
                'message' => "Sale not found."
            ]);
        }

        $sale_id = $saleData->sale_id;
        $selected_products = ProductSalesDetails::join('products' ,'products.product_id' , '=' ,'product_sales_details.product_id')
        ->select('product_sales_details.*','products.*')
        ->where('sale_id',$sale_id)->get();

        return response()->json([
            'status' => true,
            'sale' => $saleData,
            'products' => $selected_products
        ]);
    }

    ## ==== View Sale Details ===== ##
    public function view_sale($sale_id){
        $saleData = ProductSales::where('product_sales.sale_id','=',$sale_id)
        ->select(
            'product_sales.sale_id',
            'product_sales.invoice_number',
            'product_sales.sales_date',
            'product_sales.customer_name',
            'product_sales.customer_number',
            'product_sales.customer_address',
            'product_sales.discount',
            'product_sales.paid',
            'product_sales.delivery',
            'product_sales.balance',
            'product_sales.grand_total',
        )
        ->first();
        if(!$saleData) {
            return redirect()->back()->with('error', 'Sale not found.');
        }
        $sale_id = $saleData->sale_id;
        $selected_products = ProductSalesDetails::join('products' ,'products.product_id' , '=' ,'product_sales_details.product_id')
        ->select('product_sales_details.*','products.*')
        ->where('sale_id',$sale_id)->get();
        $data = [
            'page_title' => "View Sale Details - Plant Products",
            'sale' => $saleData,
            'selected_products' => $selected_products,
        ];
        return view('sales.view', $data);
    }
}
