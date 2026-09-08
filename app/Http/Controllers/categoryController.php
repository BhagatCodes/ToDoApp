<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class categoryController extends Controller
{
    function addCategory(Request $request){
        $request->validate([
            'category-title' => 'required|min:3|max:20',
        ],
        [
            'category-title.required' => 'category name is required',
            'category-title.min' => 'category name must be greater than 3 characters',
            'category-title.max' => 'category name must be less than 20 characters'
        ]);
        $category_title = $request->input('category-title');
        if($category_title)
        $results = category::create([
            'user_id'=>'1',
            'name'=>"$category_title",
        ]);
        return redirect('/');
    }
}
