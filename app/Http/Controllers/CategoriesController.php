<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categories(){
        $categories = Category::all();
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
}
