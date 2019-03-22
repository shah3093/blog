@extends('frontend.question.template')

@section('q-content')
    <h3>Search : {{$searchkeyword}}</h3>
    @foreach($questions as $question)
        <div class="bio mb-3">
            <div class="bio-body">
                <a href="{{route('question.questiondetails',['id'=>$question->id])}}">
                    <h3>{{$question->title}}</h3>
                    <p style="color: black">{{$question->details}}</p>
                </a>
                <hr/>
                <div class="row">
                    <div class="col">
                        <div class="pull-right">
                            @if($question->status =="PENDING")
                                <span class="badge badge-secondary p-2">Pending</span>
                            @elseif($question->status =="ANSWERD")
                                <span class="badge badge-success p-2">Answered</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    {{$questions->links('frontend.partials.template-paginate')}}

@endsection