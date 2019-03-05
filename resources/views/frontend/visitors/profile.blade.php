@extends('frontend.visitors.template')

@section('profileContainer')
    <h2 style="text-align: center">Welcome {{Auth::guard('visitor')->user()->name}}</h2>

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p>{{Session::get('message')}}</p>
        </div>
    @endif
@endsection
