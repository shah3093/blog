<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Models\QuizQuestion;
use Symfony\Component\Console\Question\Question;
use App\Models\QuizAnswer;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quizzes'] = Quiz::with("posts")->orderBy('id', 'desc')->get();
        return view('backend.quiz.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['posts'] = Post::all();
        return view('backend.quiz.create', $data);
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
            'name'  => 'required|unique:quizzes,name',
            'image' => 'required|image',
            'post' => 'required'
        ]);

        $image = $request->file('image');

        if ($image->isValid()) {
            try {
                $path = $image->store('quiz');
                $quiz = new Quiz();
                $quiz->name = $request->name;
                $quiz->post_id = $request->post;
                $quiz->created = \Auth::user()->id;
                $quiz->description = $request->description;
                $quiz->featuredImage = $path;
                $quiz->homepageTop = $request->homepageTop;
                $quiz->status = $request->status;
                $quiz->seo_descriptions = $request->seo_descriptions;
                $quiz->seo_keywords = $request->seo_keywords;
                $quiz->save();

                return redirect()->route('backend.quizzes.index');
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors([$exception->getMessage()]);
            }
        }

        return redirect()->back()->withErrors(["Image is not valid"]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['quiz'] = Quiz::find($id);
        $data['posts'] = Post::all();
        return view("backend.quiz.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'  => 'required|unique:quizzes,name,'.$id,
            'post' => 'required'
        ]);

        $quiz = Quiz::find($id);

        $image = $request->file('image');
        $path = "";
        if ($image != null) {
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(["Image is not valid"]);
            } else {
                $path = $image->store('quiz');
                Storage::delete($quiz->featuredImage);
            }
        }

        try {
            $quiz->name = $request->name;
            $quiz->post_id = $request->post;
            $quiz->description = $request->description;
            $quiz->homepageTop = $request->homepageTop;
            $quiz->status = $request->status;
            $quiz->seo_descriptions = $request->seo_descriptions;
            $quiz->seo_keywords = $request->seo_keywords;
            if ($path != "") {
                $quiz->featuredImage = $path;
            }
            $quiz->save();

            return redirect()->route('backend.quizzes.index');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        Storage::delete($quiz->featuredImage);
        Quiz::destroy($id);
        return redirect()->route('backend.quizzes.index');
    }

    public function getQuestionList($quizid)
    {
        $data['quizid'] = $quizid;
        $data['questions'] = QuizQuestion::with('answers')->where("quiz_id", $quizid)->get();
        return view('backend.quiz.list', $data);
    }

    public function getquestionsection($key)
    {
        $data['key']  = $key;
        return view('backend.quiz.questionsection', $data)->render();
    }

    public function savequizequestion(Request $request, $quizid)
    {
        $questions = $request->input('Question');
        $answer = $request->input('Answer');
        foreach ($questions as $key => $question) {
            if (($question['question'] != null) && ($answer[$key]['answer'] != null) && ($answer[$key]['correct_answer'] != null)) {

                if (isset($question['id'])) {
                    $quizquestion = QuizQuestion::find($question['id']);
                } else {
                    $quizquestion = new QuizQuestion();
                }

                $quizquestion->quiz_id = $quizid;
                $quizquestion->question = $question['question'];
                $quizquestion->save();

                if(isset($answer[$key]['id'])){
                    $quizanswer = QuizAnswer::find($answer[$key]['id']);
                }else{
                    $quizanswer = new QuizAnswer();
                }
                
                $quizanswer->question_id = $quizquestion->id;
                $quizanswer->answer = $answer[$key]['answer'];
                $quizanswer->correct_answer = $answer[$key]['correct_answer'];
                $quizanswer->save();
            }
        }
        return redirect()->route('backend.quizequestionlistlist',['id'=>$quizid]);
    }

    public function deletequestion($questionid)
    {
        try {
            $question = QuizQuestion::find($questionid);
            QuizAnswer::where('question_id', $questionid)->delete();
            QuizQuestion::destroy($questionid);
        } catch (Exception $ex) {
            return response()->json(["ERROR"]);
        }
    }
}
