<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller {
    public function index() {
        
        return view('frontend.question.index');
    }
    
    public function createQuestion() {
        return view('frontend.question.createQuestion');
    }
    
    public function storeQuestion(Request $request) {
        $validatedData = $request->validate([
            'details' => 'required'
        ]);
        try {
            
            $question = new Question();
            $question->title = $request->title;
            $question->details = $request->details;
            $question->visitor_id = \Auth::guard('visitor')->id();
            $question->save();
            $request->session()->flash('successMsg', "Your question is submitted . Please wait for answer. You can check your answer in your profile , we will also send your answer into your e-mail.");
            
            return redirect()->back();
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
