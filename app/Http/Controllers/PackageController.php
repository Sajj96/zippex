<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::get();
        return view('pages.packages.index', [
            'packages' => $packages
        ]);
    }

    public function add(Request $request)
    {
        if ($request->method() == "GET") {
            return view('pages.packages.add');
        }

        try {
            $this->validate($request, [
                'name'        => 'required|string',
                'price'       => 'required|numeric',
                'commission'  => 'required|numeric',
                'level_one'   => 'required|numeric',
                'level_two'   => 'required|numeric',
                'level_three' => 'required|numeric'
            ]);

            Package::create([
                'name' => $request->name,
                'price' => $request->price,
                'commission' => $request->commission,
                'level_one' => $request->level_one,
                'level_two' => $request->level_two,
                'level_three' => $request->level_three
            ]);

            return redirect('/packages')->withSuccess('Package added successfully!');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Request $request, $id = null)
    {
        if (empty($id) && $request->has('id')) {
            $id = $request->id;
        }

        $package = Package::find($id);
        if (!$package) {
            return back()->withError('Package not found');
        }

        if ($request->method() == 'GET') {
            return view('pages.packages.edit', [
                'package' => $package
            ]);
        }

        try {

            $this->validate($request, [
                'name'        => 'required|string',
                'price'       => 'required|numeric',
                'commission'  => 'required|numeric',
                'level_one'   => 'required|numeric',
                'level_two'   => 'required|numeric',
                'level_three' => 'required|numeric'
            ]);

            $package->name = $request->name;
            $package->price = $request->price;
            $package->commission = $request->commission;
            $package->level_one = $request->level_one;
            $package->level_two = $request->level_two;
            $package->level_three = $request->level_three;
            if($package->update()) {
                return redirect('/packages')->with('success', 'Package updated successfully');
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $package = Package::find($request->input('package_id'));
            if ($package) {
                $package->delete();
                return redirect('/packages')->withSuccess('Package deleted successfully!');
            } else {
                return back()->withError('Package not found');
            }
        } catch (\Exception $exception) {
            return redirect('/packages')->withError('Package could not be deleted');
        }
    }
}
