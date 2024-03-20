<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BlogController extends Controller
{
    public function __construct()
    {
        $path = storage_path('/app/public/posts/');
        if(!File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
    }

    public function index()
    {
        $posts = Blog::get();
        return view('pages.posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Request $request, $id)
    {
        if (empty($id)) {
            return redirect('/posts')->withWarning("Post was not selected");
        }

        $post = Blog::find($id);
        if (!$post) {
            return redirect('/posts')->withError('Post not found');
        }

        return view('pages.posts.view', [
            'post' => $post
        ]);
    }

    public function add(Request $request)
    {
        if($request->method() == "GET") {
            $post_categories = BlogCategory::get();
            return view('pages.posts.add', [
                'post_categories' => $post_categories
            ]);
        }

        try {
            $this->validate($request, [
                'title'       => 'required|string',
                'category'    => 'required|integer',
                'description' => 'required|string'
            ]);

            $product = Blog::create([
                'blog_category_id' => $request->category,
                'title' => $request->title,
                'description' => $request->description
            ]);

            if($request->hasFile('image')) {
                $fileName = $request->image->getClientOriginalName();
                $extension = $request->file('image')->extension();
                $generated = uniqid()."_".time().date("Ymd")."_IMG";

                $fileName = $generated.'.'.$extension;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image')->getRealPath());
                $image->scale(width: 1024, height: 640);
                $image->toPng()->save(storage_path('/app/public/posts/' . $fileName));
                $fileLink = url('storage/posts/'.$fileName);

                $product->update([
                    'image_path' => $fileLink
                ]);
            }

            return redirect('/posts')->withSuccess('Post added successfully!');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Request $request, $id=null)
    {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $post = Blog::find($id);
        if (!$post) {
            return back()->withErrors('Post not found!');
        }

        if($request->method() == "GET") {
            $post_categories = BlogCategory::get();
            return view('pages.products.edit', [
                'post' => $post,
                'post_categories' => $post_categories
            ]);
        }

        try {
            $this->validate($request, [
                'title'    => 'required|string',
                'category' => 'required|integer',
                'description' => 'required|string'
            ]);

            $post->title = $request->title;
            $post->blog_category_id = $request->category;
            $post->description = $request->description;
            $post->update();

            if($request->hasFile('image')) {
                $fileName = $request->image->getClientOriginalName();
                $extension = $request->file('image')->extension();
                $generated = uniqid()."_".time().date("Ymd")."_IMG";

                $fileName = $generated.'.'.$extension;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image')->getRealPath());
                $image->scale(width: 1024, height: 640);
                $image->toPng()->save(storage_path('/app/public/posts/' . $fileName));
                $fileLink = url('storage/posts/'.$fileName);

                $post->update([
                    'image_path' => $fileLink
                ]);
            }

            return back()->withSuccess('Post updated successfully!');
        } catch (\Exception $th) {
            return back()->withErrors('Something went wrong while updating product!');
        }
    }

    public function delete(Request $request) 
    {
        try {
            $post = Blog::find($request->input('post_id'));
            if ($post){
                $post->delete();
                return redirect('/posts')->withSuccess('Post deleted successfully!');
            } else {
                return back()->withError('Post not found');
            }
        } catch(\Exception $exception) {
            return redirect('/posts')->withError('Post could not be deleted');
        }
    }
}
