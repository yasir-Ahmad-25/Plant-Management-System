<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categories(){
        $categories = DB::table('product_categories')
                    ->leftJoin('products', 'products.product_category_id', '=', 'product_categories.product_category_id')
                    ->select(
                        'product_categories.product_category_id',
                        'product_categories.category_name',
                        'product_categories.category_description',
                        'product_categories.created_at',
                        DB::raw('COUNT(products.product_id) as products_count')
                    )
                    ->groupBy(
                        'product_categories.product_category_id',
                        'product_categories.category_name',
                        'product_categories.category_description',
                        'product_categories.created_at'
                    )
                    ->orderByDesc('product_categories.product_category_id')
                    ->get()
                    ->map(function ($item) {
                        $item->created_at = $item->created_at ? Carbon::parse($item->created_at) : null;
                        return $item;
                    });

        $data = [
            'page_title' => 'Categories',
            'categories' => $categories,
        ];

        return view('categories.index',$data);
    }

    public function storeCategory(Request $request){
        // validate the request
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string|max:1000',
        ]);

        $requestedData = [
            'category_name' => $request->input('category_name'),
            'category_description' => $request->input('category_description'),
        ];


        // create a new category
        $category = new Category();
        $saveCategory = $category::create($requestedData);
        if($saveCategory){
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create category.',
            ]);
        }
    }

    public function get_category($id){
        $category = Category::where('product_category_id',$id)->first();
        if($category){
            return response()->json([
                'status' => true,
                'data' => $category,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.',
            ]);
        }
    }

    public function updateCategory(Request $request, $id){
        // validate the request
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string|max:1000',
        ]);

        $requestedData = [
            'category_name' => $request->input('category_name'),
            'category_description' => $request->input('category_description'),
        ];

        // find the category and update it
        $category = Category::where('product_category_id',$id)->first();
        if($category){
            $category->update($requestedData);
            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found.',
            ]);
        }
    }

    public function deleteCategory($id){
        // first fetch the category data based on the id
        $category = Category::where('product_category_id',$id)->first();
        if($category){
            // delete the category
            $category->delete();
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found.',
            ]);
        }

    }
}
