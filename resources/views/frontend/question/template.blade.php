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
                            <li><a href="#">Type 1</a></li>
                            <li><a href="#">Type 1</a></li>
                            <li><a href="#">Type 1</a></li>
                            <li><a href="#">Type 1</a></li>
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

