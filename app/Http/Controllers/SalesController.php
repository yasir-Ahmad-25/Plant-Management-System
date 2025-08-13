<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSales;
use App\Models\ProductSalesDetails;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class SalesController extends Controller
{
    public function index()
    {
        // get sales data
        $sales = ProductSales::join('product_sales_details','product_sales.sale_id' ,'=','product_sales_details.sale_id')
        ->select('product_sales.*','product_sales_details.*')->get();

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
}
