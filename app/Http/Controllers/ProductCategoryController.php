<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_categories = ProductCategory::get();
        return view('pages.products.categories.index', [ 
            'product_categories' => $product_categories 
        ]);
    }

    public function add(Request $request) 
    {
        if($request->method() == "GET") {
            return view('pages.products.categories.add');
        }

        try {
            $this->validate($request, [
                'name' => 'required|string'
            ]);

            ProductCategory::updateOrCreate(
                [ 'name' => $request->name ],
                [ 'name' => $request->name ]
            );

            return back()->withSuccess('Product category added successfully!');

        } catch (\Exception $exception) {
            return back()->withErrors('Something went wrong while adding category!');
        }
    }

    public function edit(Request $request, $id=null)
    {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $product_category = ProductCategory::find($id);
        if (!$product_category) {
            return back()->withErrors('Product Category not found!');
        }

        if($request->method() == "GET") {
            return view('pages.products.categories.edit', [
                'product_category' => $product_category
            ]);
        }

        try {
            $this->validate($request, [
                'name' => 'required|string'
            ]);

            $product_category->name = $request->name;
            $product_category->update();

            return back()->withSuccess('Product category updated successfully!');
        } catch (\Exception $th) {
            return back()->withErrors('Something went wrong while updating category!');
        }
    }

    public function delete(Request $request) {
        try {
                $product_category = ProductCategory::find($request->input('category_id'));
                if ($product_category){
                    $product_category->delete();
                    return redirect('/product-categories')->withSuccess('Product Category Deleted');
                } else {
                    return back()->withError('Product Category not found');
                }
        } catch(\Exception $exception) {
            return redirect('/product-categories')->withError('Product Category could not be deleted');
        }
    }
}
