@extends('frontend.question.template')

@section('q-content')
    <h3>Ask your question</h3>
    <form action="{{route('question.store')}}" method="post" autocomplete="off">
        @csrf
        @include('frontend.partials.errors')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" name="details" rows="7"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
