@extends('frontend.visitors.template')

@section('profileContainer')
    @include('frontend.partials.errors')
    <form action="{{route('visitors.editnamedb')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input name="name" type="text" class="form-control" value="{{Auth::guard('visitor')->user()->name}}" id="name">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
