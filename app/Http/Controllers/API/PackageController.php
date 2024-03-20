<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function getAll()
    {
        $packages = Package::get();
        return response()->json([ 
            'packages' => $packages 
        ]);
    }
}
