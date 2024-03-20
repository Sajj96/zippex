<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function getAll()
    {
        $post_categories = BlogCategory::get();
        return response()->json([ 
            'post_categories' => $post_categories 
        ]);
    }

    public function getOne(Request $request, $id)
    {
        if (empty($id)) {
            return response()->json("Post Category was not selected");
        }

        $post_category = BlogCategory::with('posts')->find($id);
        if (!$post_category) {
            return response()->json('Post Category not found');
        }

        return response()->json([
            'post_category' => $post_category
        ]);
    }
}
