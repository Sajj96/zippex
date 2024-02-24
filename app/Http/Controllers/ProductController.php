<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function __construct()
    {
        $path = storage_path('/app/public/products/');
        if(!File::isDirectory($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
    }

    public function index(ProductsDataTable $datatable)
    {
        return $datatable->render('pages.products.index');
    }

    public function show(Request $request, $id)
    {
        if (empty($id)) {
            return redirect('/products')->withWarning("Product was not selected");
        }

        $product = Product::find($id);
        if (!$product) {
            return redirect('/products')->withError('Product not found');
        }

        return view('pages.products.view', [
            'product' => $product
        ]);
    }

    public function add(Request $request)
    {
        if($request->method() == "GET") {
            $product_categories = ProductCategory::get();
            return view('pages.products.add', [
                'product_categories' => $product_categories
            ]);
        }

        try {
            $this->validate($request, [
                'name'     => 'required|string',
                'category' => 'required|integer',
                'price'    => 'required|numeric',
                'quantity' => 'required|integer'
            ]);

            $product = Product::create([
                'product_category_id' => $request->category,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'quantity' => $request->quantity
            ]);

            if($request->hasFile('image')) {
                $fileName = $request->image->getClientOriginalName();
                $extension = $request->file('image')->extension();
                $generated = uniqid()."_".time().date("Ymd")."_IMG";

                $fileName = $generated.'.'.$extension;

                $manager = new ImageManager(new GdDriver());
                $image = $manager->read($request->file('image')->getRealPath());
                $image->scale(width: 400);
                $image->toPng()->save(storage_path('/app/public/products/' . $fileName));
                $fileLink = url('storage/products/'.$fileName);

                $product->update([
                    'image_path' => $fileLink
                ]);
            }

            return redirect('/products')->withSuccess('Product added successfully!');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Request $request, $id=null)
    {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $product = Product::find($id);
        if (!$product) {
            return back()->withErrors('Product not found!');
        }

        if($request->method() == "GET") {
            $product_categories = ProductCategory::get();
            return view('pages.products.edit', [
                'product' => $product,
                'product_categories' => $product_categories
            ]);
        }

        try {
            $this->validate($request, [
                'name'     => 'required|string',
                'category' => 'required|integer',
                'price'    => 'required|numeric',
                'quantity' => 'required|integer'
            ]);

            $product->name = $request->name;
            $product->product_category_id = $request->category;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->update();

            if($request->hasFile('image')) {
                $fileName = $request->image->getClientOriginalName();
                $extension = $request->file('image')->extension();
                $generated = uniqid()."_".time().date("Ymd")."_IMG";

                $fileName = $generated.'.'.$extension;

                $manager = new ImageManager(new GdDriver());
                $image = $manager->read($request->file('image')->getRealPath());
                $image->scale(width: 300, height: 500);
                $image->toPng()->save(storage_path('/app/public/products/' . $fileName));
                $fileLink = url('storage/products/'.$fileName);

                $product->update([
                    'image_path' => $fileLink
                ]);
            }

            return back()->withSuccess('Product updated successfully!');
        } catch (\Exception $th) {
            return back()->withErrors('Something went wrong while updating product!');
        }
    }

    public function delete(Request $request) 
    {
        try {
            $product = Product::find($request->input('product_id'));
            if ($product){
                $product->delete();
                return redirect('/products')->withSuccess('Product deleted successfully!');
            } else {
                return back()->withError('Product not found');
            }
        } catch(\Exception $exception) {
            return redirect('/products')->withError('Product could not be deleted');
        }
    }
}
