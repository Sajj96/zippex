<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $post_categories = BlogCategory::get();
        return view('pages.posts.categories.index', [ 
            'post_categories' => $post_categories 
        ]);
    }

    public function add(Request $request) 
    {
        if($request->method() == "GET") {
            return view('pages.posts.categories.add');
        }

        try {
            $this->validate($request, [
                'name' => 'required|string'
            ]);

            BlogCategory::updateOrCreate(
                [ 'name' => $request->name ],
                [ 'name' => $request->name ]
            );

            return back()->withSuccess('Post category added successfully!');

        } catch (\Exception $exception) {
            return back()->withErrors('Something went wrong while adding category!');
        }
    }

    public function edit(Request $request, $id=null)
    {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $post_category = BlogCategory::find($id);
        if (!$post_category) {
            return back()->withErrors('Post Category not found!');
        }

        if($request->method() == "GET") {
            return view('pages.posts.categories.edit', [
                'post_category' => $post_category
            ]);
        }

        try {
            $this->validate($request, [
                'name' => 'required|string'
            ]);

            $post_category->name = $request->name;
            $post_category->update();

            return back()->withSuccess('Post category updated successfully!');
        } catch (\Exception $th) {
            return back()->withErrors('Something went wrong while updating category!');
        }
    }

    public function delete(Request $request) {
        try {
                $post_category = BlogCategory::find($request->input('category_id'));
                if ($post_category){
                    $post_category->delete();
                    return redirect('/post-categories')->withSuccess('Post Category Deleted');
                } else {
                    return back()->withError('Post Category not found');
                }
        } catch(\Exception $exception) {
            return redirect('/post-categories')->withError('Post Category could not be deleted');
        }
    }
}
