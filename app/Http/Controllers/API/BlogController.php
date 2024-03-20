<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getAll()
    {
        $posts = Blog::with('blogCategory')->get();
        return response()->json([
            'posts' => $posts
        ]);
    }

    public function getOne(Request $request, $id)
    {
        if (empty($id)) {
            return response()->json("Post was not selected");
        }

        $post = Blog::with('blogCategory')->find($id);
        if (!$post) {
            return response()->json('Post not found');
        }

        return response()->json([
            'post' => $post
        ]);
    }
}
