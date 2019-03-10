@extends('frontend.question.template')

@section('q-content')
    <div class="bio mb-3">
        <div class="bio-body">
            <h3>{{$question->title}}</h3>
            <p style="color: black">{{$question->details}}</p>
            <hr/>
            <div class="row">
                <div class="col">
                    <div class="pull-left">
                        @foreach($question->questiontypes as $type)
                            <a href="{{route('question.questiontype',['type'=>$type->slug])}}">
                                <span class="badge badge-info p-2">{{$type->type}}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>


    @isset($question->answer->answer )
        <div class="bio mb-3">
            <div class="bio-body">

                {!! $question->answer->answer !!}

            </div>
        </div>
    @endisset
@endsection
