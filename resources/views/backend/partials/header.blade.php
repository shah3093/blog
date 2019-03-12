<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="#">
                <!-- Logo icon -->
                <b class="logo-icon p-l-10">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{URL::asset('backend/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo"/>

                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="{{URL::asset('backend/assets/images/logo-text.png')}}" alt="homepage" class="light-logo"/>

                        </span>
                <!-- Logo icon -->
                <!-- <b class="logo-icon"> -->
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <!-- <img src="backend/assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                <!-- </b> -->
                <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                </li>
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->

                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item search-box">
                    <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search &amp; enter">
                        <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="font-24 mdi mdi-comment-alert"></i>
                        <span class="badge badge-light">{{$nNCommentscnt==0?"":$nNCommentscnt}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                        <ul class="list-style-none">
                            <li>
                                <div class="">
                                    @foreach($nNComments as $nNComment)
                                        <a target="_blank" href="{{route('post',['slug'=>$nNComment->posts->slug,'commentid'=>$nNComment->id])}}" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <div class="m-l-10">
                                                    <p class="m-b-0">Someone commented on post - {{$nNComment->posts->title}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="font-24 mdi mdi-comment-question-outline"></i>
                        <span class="badge badge-light">{{$nPQuestionscnt==0?"":$nPQuestionscnt}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                        <ul class="list-style-none">
                            <li>
                                <div class="">
                                    @foreach($nPQuestions as $nPQuestion)
                                        <a href="{{route('backend.questions.edit',['questions'=>$nPQuestion->id])}}" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">{{$nPQuestion->title}}</h5>
                                                    <span class="mail-desc">{{substr($nPQuestion->details,0,20)."...."}}</span>
                                                </div>
                                            </div>
                                        </a>
                                @endforeach
                                <!-- Message -->
                                    <a href="{{route('backend.questions.index')}}" class="link border-top">
                                        <div class="d-flex no-block align-items-center p-10">
                                            <div class="m-l-10">
                                                <h5 class="m-b-0">See all</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{URL::asset('backend/assets/images/users/1.jpg')}}" alt="user" class="rounded-circle" width="31"></a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <a class="dropdown-item" href="{{route('backend.profile')}}"><i class="ti-user m-r-5 m-l-5"></i>
                            My
                            Profile</a>
                        <a class="dropdown-item" href="{{route('backend.updatepasswordform')}}"><i class="ti-wallet m-r-5 m-l-5"></i>
                            Update
                            password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('backend.logout')}}"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                            Logout</a>
                        <div class="dropdown-divider"></div>
                        <div class="p-l-30 p-10">
                            <a href="{{route('backend.profile')}}" class="btn btn-sm btn-success btn-rounded">View
                                Profile</a>
                        </div>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
