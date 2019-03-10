@extends('frontend.visitors.template')

@section('profileContainer')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Question</th>
            <th>Status</th>
            <th>link</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{substr($question->details,0,50).".."}}</td>
                <td>{{$question->status}}</td>
                <td><a href="{{route('question.questiondetails',['id'=>$question->id])}}">Link</a></td>
            </tr>
        @endforeach
        </tbody>

    </table>
    {{$questions->links('frontend.partials.template-paginate')}}
@endsection
