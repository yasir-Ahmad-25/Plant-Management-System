<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // fetch categories
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories')->with('no_categories', 'No categories found. Please add categories first.');
        }

        $products = Product::join('product_categories', 'products.product_category_id', '=', 'product_categories.product_category_id')
            ->select('products.*', 'product_categories.category_name')
            ->get(); 

        $data = [
            'page_title' => 'Products',
            'categories' => $categories,
            'products' => $products,
        ];
        return view('products.index',$data);
    }

    public function store_product(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,product_category_id',
            'product_description' => 'nullable|string',
        ]);

        $productData = [
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_category_id' => $request->input('category_id'),
            'product_description' => $request->input('product_description', null),
        ];

        $product = new Product();
        $saveProduct = $product::create($productData);
        if ($saveProduct) {
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add product.',
            ]);
        }
    }

    public function update_product(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,product_category_id',
            'product_description' => 'nullable|string',
        ]);

        $productData = [
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_category_id' => $request->input('category_id'),
            'product_description' => $request->input('product_description', null),
        ];

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }
        $product->update($productData);
        if ($product) {
            return response()->json(['status' => true, 'message' => 'Product updated successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update product']);
        }
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        $product->delete();
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Failed to delete product']);
        }

        // Logic to delete a product
        return response()->json(['status' => true, 'message' => 'Product Deleted Successfully']);
    }

    public function get_product($id){
        $product = Product::where('product_id',$id)->first();
        if($product){
            return response()->json([
                'status' => true,
                'data' => $product,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.',
            ]);
        }
    }
}
