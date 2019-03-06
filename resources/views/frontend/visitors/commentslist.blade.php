@extends('frontend.visitors.template')

@section('profileContainer')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Posts title</th>
            <th>Comments</th>
            <th>link</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{substr($comment->posts->title,0,10).".."}}</td>
                <td>{{substr($comment->comment,0,10)."...."}}</td>
                <td><a href="{{route('post',['slug'=>$comment->posts->slug])}}">Link</a></td>
            </tr>
        @endforeach
        </tbody>

    </table>
    {{$comments->links()}}
@endsection
