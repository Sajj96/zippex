<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        $testimonies = Testimony::get();
        return view('pages.testimonies.index', [
            'testimonies' => $testimonies
        ]);
    }

    public function delete(Request $request) 
    {
        try {
            $testimony = Testimony::find($request->input('testimony_id'));
            if ($testimony){
                $testimony->delete();
                return redirect('/testimonies')->withSuccess('Testimonial deleted successfully!');
            } else {
                return back()->withError('Testimonial not found');
            }
        } catch(\Exception $exception) {
            return redirect('/testimonies')->withError('Testimonial could not be deleted');
        }
    }
}
