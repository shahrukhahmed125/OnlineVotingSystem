<div>
    <header class="app-header top-bar">
        <!-- begin navbar -->
        <nav class="navbar navbar-expand-md">

            <!-- begin navbar-header -->
            <div class="navbar-header d-flex align-items-center">
                <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                <a class="navbar-brand" href="index.html">
                    <x-app-logo/>
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- begin navigation -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navigation d-flex">
                    <ul class="navbar-nav nav-left">
                        <li class="nav-item">
                            <a href="{{ route('voter.dashboard') }}" class="nav-link">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('voter.castVote') }}" class="nav-link">Cast Vote</a>
                        </li>
                        <li class="nav-item full-screen d-none d-lg-block" id="btnFullscreen">
                            <a href="javascript:void(0)" class="nav-link expand">
                                <i class="icon-size-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav nav-right ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown3"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe fe-bell"></i>
                                <span class="notify">
                                    <span class="blink"></span>
                                    <span class="dot"></span>
                                </span>
                            </a>
                            <div class="dropdown-menu extended animated fadeIn" aria-labelledby="navbarDropdown">
                                <ul>
                                    <li class="dropdown-header bg-gradient p-4 text-white text-left">Notifications
                                        <a href="#"
                                            class="float-right btn btn-square btn-inverse-light btn-xs m-0">
                                            <span class="font-13"> Clear all</span></a>
                                    </li>
                                    <li class="dropdown-body min-h-240 nicescroll">
                                        <ul class="scrollbar scroll_dark max-h-240">
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="notification d-flex flex-row align-items-center">
                                                        <div class="notify-icon bg-img align-self-center">
                                                            <div class="bg-type bg-type-md">
                                                                <span>HY</span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-message">
                                                            <p class="font-weight-bold">New registered user</p>
                                                            <small>Just now</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="notification d-flex flex-row align-items-center">
                                                        <div class="notify-icon bg-img align-self-center">
                                                            <div class="bg-type bg-type-md bg-success">
                                                                <span>GM</span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-message">
                                                            <p class="font-weight-bold">New invoice received</p>
                                                            <small>22 min</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="notification d-flex flex-row align-items-center">
                                                        <div class="notify-icon bg-img align-self-center">
                                                            <div class="bg-type bg-type-md bg-danger">
                                                                <span>FR</span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-message">
                                                            <p class="font-weight-bold">Server error report</p>
                                                            <small>7 min</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="notification d-flex flex-row align-items-center">
                                                        <div class="notify-icon bg-img align-self-center">
                                                            <div class="bg-type bg-type-md bg-info">
                                                                <span>HT</span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-message">
                                                            <p class="font-weight-bold">Database report</p>
                                                            <small>1 day</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <div class="notification d-flex flex-row align-items-center">
                                                        <div class="notify-icon bg-img align-self-center">
                                                            <div class="bg-type bg-type-md">
                                                                <span>DE</span>
                                                            </div>
                                                        </div>
                                                        <div class="notify-message">
                                                            <p class="font-weight-bold">Order confirmation</p>
                                                            <small>2 day</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-footer">
                                        <a class="font-13" href="javascript:void(0)"> View All Notifications
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown user-profile">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->images->isNotEmpty() ? asset('storage/' . Auth::user()->images->first()->image_path) : asset('assets/img/avtar/11.png') }}" alt="avtar-img">
                                <span class="bg-success user-status"></span>
                            </a>
                            <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                                <div class="bg-gradient px-4 py-3">
                                    <x-name-condition/>
                                </div>
                                <div class="p-4">
                                    <div class="row mt-2">
                                        <div class="col">
                                            <a class="bg-light p-3 text-center d-block" href="#">
                                                <i class="fa fa-user pr-2 font-20 text-primary"></i>
                                                <span class="d-block font-13 mt-2">Profile</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="bg-light p-3 text-center d-block" href="#">
                                                <i class="ti ti-settings pr-2 font-20 text-primary"></i>
                                                <span class="d-block font-13 mt-2">Settings</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end navigation -->
        </nav>
        <!-- end navbar -->
    </header>
</div>
