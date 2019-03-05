@extends('frontend.visitors.template')

@section('profileContainer')
    @include('frontend.partials.errors')
    <form action="{{route('visitors.editpassworddb')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="oldpassword">Old Password:</label>
            <input name="oldpassword" type="password" class="form-control" id="oldpassword">
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input name="password" type="password" class="form-control" id="password">
        </div>
        <div class="form-group">
            <label for="confPassword">Confirm Password:</label>
            <input name="confPassword" type="password" class="form-control" id="confPassword">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
