<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questiontypes'] = QuestionType::orderBy('id', 'desc')->get();
    
        return view('backend.questiontype.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.questiontype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type'  => 'required|unique:question_types,type',
        ]);
    
        try {
            $type = new QuestionType();
            $type->type = strtolower($request->type);
            $type->save();
        
            return redirect()->route('backend.questiontype.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionType $questionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['questiontype'] = QuestionType::find($id);
    
        return view('backend.questiontype.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'type'  => 'required|unique:question_types,type',
        ]);
    
        try {
            $type = QuestionType::find($id);
            $type->type = strtolower($request->type);
            $type->save();
        
            return redirect()->route('backend.questiontype.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionType  $questionType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QuestionType::destroy($id);
        return redirect()->route('backend.questiontype.index');
    }
}
