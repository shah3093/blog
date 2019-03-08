<?php

namespace App\Http\Controllers\Backend;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['questions'] = Question::with('questiontypes', 'visitors')->get();
        
        return view('backend.questions.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $question = $data['question'] = Question::with('questiontypes', 'visitors', 'answer')->where('id', $id)->first();
        $data['tags'] = QuestionType::get();
        
        $typestr = "";
        foreach($question->questiontypes as $type) {
            $typestr .= $type->type.",";
        }
        
        $data['typestr'] = $typestr;
        
        return view('backend.questions.edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'answer' => 'required',
        ]);
        try {
            ///......Question Section.......////
            $question = Question::find($id);
            $q_data = $request->input('Question');
            Question::where('id', $id)->update($q_data);
            ///......Question Section.......////
            
            ///......Answer Section.......////
            $answer = Answer::where('question_id', $question->id)->first();
            if(!isset($answer->question_id)) {
                $answer = new Answer();
                $answer->question_id = $question->id;
            }
            $answer->answer = $request->answer;
            $answer->save();
            ///......Answer Section.......////
            
            
            ///......Types Section.......////
            $types = explode(",", $request->types);
            $typesid = [];
            
            foreach($types as $data) {
                if($data != "") {
                    $type = QuestionType::where("type", $data)->first();
                    if(isset($type->id)) {
                        array_push($typesid, $type->id);
                    } else {
                        $type = new QuestionType();
                        $type->type = strtolower($data);
                        $type->save();
                        array_push($typesid, $type->id);
                    }
                }
            }
            $question->questiontypes()->sync($typesid);
            
            ///......Types Section.......////
            
            return redirect()->route('backend.questions.index');
            
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $question = Question::with('questiontypes')->find($id);
        $question->questiontypes()->detach();
        
        Question::destroy($id);
    
        return redirect()->route('backend.questions.index');
    }
}
