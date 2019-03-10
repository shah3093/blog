<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller {
    public function index() {
        $data['questions'] = Question::with('questiontypes')->where('show', 1)->orderBy('id', 'desc')->paginate(15);
        
        return view('frontend.question.index', $data);
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
    
    public function getQuestionTypes($slug) {
        try {
            $type = $data['type'] = $data['typename'] = QuestionType::where('slug', $slug)->first();
            $data['questions'] = Question::whereHas('questiontypes', function($query) use ($type) {
                $query->where('questionable_id', '=', $type->id);
            })->paginate(15);
            
            return view('frontend.question.questiontypes', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
    
    public function getQuestionDetails($id) {
        try {
            $data['question'] = Question::with('answer')->where('id', $id)->first();
            
            return view('frontend.question.questiondetails', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
}
