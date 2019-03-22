@extends('frontend.layouts.mastar')

@section('content')

    <section class="site-section py-lg">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    {{--<h2 class="mb-4">Questions</h2>--}}
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-8 main-content">
                    @yield('q-content')
                </div>
                <div class="col-md-4 sidebar">
                    <div class="sidebar-box search-form-wrap  d-none d-sm-none d-md-none d-lg-block">
                        <form action="{{route('question.searchquestion')}}" method="post" class="search-form">
                            @csrf
                            <div class="form-group">
                                <button class="icon fa fa-search btn" type="submit"></button>
                                <input name="searchword" type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ">
                        <div class="bio">
                            <div class="bio-body text-center">
                                @auth('visitor')
                                    <a href="{{route('question.create')}}" class="btn btn-success btn-lg">
                                        Ask Question
                                    </a>
                                @endauth
                                @guest('visitor')
                                    <a href="#" data-toggle="modal" data-target="#loginModal" type="submit" class="btn btn-success btn-lg">
                                        Ask Question
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-box ">
                        <h3 class="heading text-center">Question Types</h3>
                        <ul class="tags">
                            @foreach($questiontypes as $qtype)
                                <li><a href="{{route('question.questiontype',['type'=>$qtype->slug])}}">{{$qtype->type}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('frontend.partials.login')

@endsection

@section('script')
    <script>
        $("body").on('click', '#submitdata', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var email = $("#email").val();
            var pwd = $("#pwd").val();
            var csrf = "{{csrf_token()}}";
            $.post(url, {'email': email, 'password': pwd, '_token': csrf}, function (resp) {
                if (resp != "DONE") {
                    $("#errordiv").html(resp);
                } else {
                    location.reload();
                }
            });
        });
    </script>
@endsection

