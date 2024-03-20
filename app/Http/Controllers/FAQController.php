<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::get();
        return view('pages.faq.index', [
            'faqs' => $faqs
        ]);
    }

    public function add(Request $request)
    {
        if($request->method() == "GET") {
            return view('pages.faq.add');
        }

        try {
            $this->validate($request, [
                'question' => 'required|string',
                'answer'   => 'required|string'
            ]);

            FAQ::create([
                'question' => $request->question,
                'answer' => $request->answer
            ]);

            return redirect('/faqs')->withSuccess('Question added successfully!');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(Request $request, $id=null)
    {
        if (empty($id) && $request->has('id')){
            $id = $request->id;
        }

        $faq = FAQ::find($id);
        if (!$faq) {
            return back()->withErrors('Question not found!');
        }

        if($request->method() == "GET") {
            return view('pages.faq.edit', [
                'faq' => $faq,
            ]);
        }

        try {
            $this->validate($request, [
                'question' => 'required|string',
                'answer'   => 'required|string'
            ]);

            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->update();

            return back()->withSuccess('Question updated successfully!');
        } catch (\Exception $th) {
            return back()->withErrors('Something went wrong while updating question!');
        }
    }

    public function delete(Request $request) 
    {
        try {
            $faq = FAQ::find($request->input('faq_id'));
            if ($faq){
                $faq->delete();
                return redirect('/faqs')->withSuccess('Question deleted successfully!');
            } else {
                return back()->withError('Question not found');
            }
        } catch(\Exception $exception) {
            return redirect('/faqs')->withError('Question could not be deleted');
        }
    }
}
