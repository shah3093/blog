<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col social">
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="#"><span class="fa fa-facebook"></span></a>
                    <a href="#"><span class="fa fa-instagram"></span></a>
                    <a href="#"><span class="fa fa-youtube-play"></span></a>
                    <a href="#"><span class="fa fa-vimeo"></span></a>
                    <a href="#"><span class="fa fa-snapchat"></span></a>
                </div>
                <div class="col search-top">
                    <div class="collapse navbar-collapse" id="navbarMenu2">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item dropdown">
                                <a style="color: white;" class="nav-link dropdown-toggle pull-right" href="#"
                                   id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Visitors here <i class="fa fa-user"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdown04">
                                    @guest('visitor')
                                        <a class="dropdown-item" href="{{route('visitors.loginform')}}">Log in</a>
                                        <a class="dropdown-item"
                                           href="{{route('visitors.registrationform')}}">Register</a>
                                    @endguest
                                    @auth('visitor')
                                        <a class="dropdown-item" href="{{route('visitors.profile')}}">Profile</a>
                                        <a class="dropdown-item" href="{{route('visitors.logout')}}">Log out</a>
                                    @endauth
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container logo-wrap">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button"
                   aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
                <h1 class="site-logo site-logo-custom"><a href="{{url('/')}}">Simple Blog</a></h1>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    {!! $header !!}
                </ul>
            </div>
        </div>
    </nav>
</header>
