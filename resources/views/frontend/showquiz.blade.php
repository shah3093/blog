@extends('frontend.layouts.mastar') 
@section('metatag')
<title>{{$quiz->name}}</title>
<meta name="keywords" content="{{$quiz->seo_keywords}}">
<meta name="description" content="{{$quiz->seo_descriptions}}">
<meta name="author" content="Azad">

<meta name="og:title" content="{{$quiz->name}}" />
<meta name="og:url" content="{{route('quiz',['slug'=>$quiz->slug])}}" />
<meta name="og:image" content="{{$quiz->featuredImage}}" />
<meta name="og:site_name" content="Azad Blogs" />
<meta name="og:description" content="{{$quiz->seo_descriptions}}" />

<meta name="twitter:card" content="{{$quiz->seo_descriptions}}">
@endsection
 
@section('content')
<section class="site-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class="mb-4">Quiz: {{$quiz->name}}</h2>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="row mb-5 mt-5">
                    <div class="col">
                        <div class="modal-dialog" style="max-width: 100%;">
                            <?php $showflag=1; ?> @foreach($questions as $question)
                            <div id="questionid{{$showflag}}" class="modal-content {{$showflag != 1 ? 'hide-div':''}}">
                                <?php  $showflag++;?>
                                <div class="modal-header">
                                    <h3>{{$question->question}}</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="quiz quizid" data-toggle="buttons">
                                        @foreach ($question->answers as $answer)
                                        <?php
                                                            $split_answers = explode(",",$answer->answer);
        
                                                        ?>
                                            @foreach ($split_answers as $singleanswer) @if($singleanswer != NULL)
                                            <label data-resultid="result-details" data-currentquestionid="questionid{{$showflag-1}}" data-nextquestionid="questionid{{$showflag}}"
                                                data-iscorrect='{{trim($singleanswer) == $answer->correct_answer ?"1":"0"}}'
                                                class="element-animation1 btn btn-lg btn-primary btn-block">
                                                                <span class="btn-label">
                                                                <i class="fa fa-4x fa-angle-right"></i>
                                                                </span>
                                                            {{$singleanswer}}
                                                                
                                                        </label> @endif @endforeach
                                            @endforeach

                                    </div>
                                </div>
                            </div>
                            @endforeach


                            <div id="result-details" class="modal-content hide-div">
                                <div class="modal-body text-center">
                                    <p id="answer_corect"></p>
                                    <p id="answer_wrong"></p>
                                    <p>Total question : {{count($questions)}}</p>
                                    <a href="{{route('quiz',['quizslug'=>$quiz->slug])}}" class="btn btn-info">Retry</a>
                                    <button id="showallanswer" class="btn btn-success">All answers</button>
                                </div>
                            </div>

                        </div>
                        <div id="allanswerdiv" class="hide-div">
                                @foreach ($questions as $question)
                                <h4>{{$question->question}}</h4>
                                @foreach ($question->answers as $answer)
                                <p class="ml-4"><strong>Correct answer</strong> :: {{$answer->correct_answer}}</p>
                                @endforeach @endforeach
                                <a href="{{route('quiz',['quizslug'=>$quiz->slug])}}" class="btn btn-info">Retry</a>
                                   
                            </div>
                    </div>
                    
                </div>

            </div>
    @include('frontend.partials.sidebar')
        </div>
    </div>
</section>
@endsection
 
@section('styles')

<link href="{{URL::asset('frontend/css/quiz.css')}}" rel="stylesheet" />
@endsection
 
@section('script')
<script src="{{URL::asset('frontend/js/quiz.js')}}"></script>
@endsection