<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="{{ asset('/assets/css/dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/charts-c3/plugin.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/maps-google/plugin.css') }}" rel="stylesheet" />

    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" />
    @stack('css')
</head>
<body class="">
<div class="page">
    <div class="page-main">
        <div class="header py-4">
            <div class="container">
                <div class="d-flex">
                    <a class="header-brand" href="{{ url('/') }}">
                        <img src="{{ asset('/assets/images/logo-black.png') }}" class="header-brand-img" alt="tabler logo">
                    </a>
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="dropdown">
                            <a href="@guest {{ route('login') }} @endguest" class="nav-link pr-0 leading-none" @auth data-toggle="dropdown" @endauth>
                                <span class="avatar" style="background-image: url({{ (Auth::check()) ? Auth::user()->profilePhoto() : \App\User::DEFAULT_PHOTO }})"></span>
                                <span class="ml-2 d-none d-lg-block">
                                    <span class="text-default">
                                        @guest Accedi @endguest
                                        @auth {{ Auth::user()->name }} @endauth
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        @guest o registrati @endguest
                                        @auth {{ Auth::user()->email }} @endauth
                                    </small>
                                </span>
                            </a>
                            @auth
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <i class="dropdown-icon fe fe-user"></i> Profilo
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item logoutCheck" href="#">
                                        <i class="dropdown-icon fe fe-log-out"></i> Esci
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg order-lg-first">
                        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                            <li class="nav-item">
                                <a href="#" class="nav-link" id="sidebarOpen">
                                    <i class="fe fe-git-merge"></i> Tutti i servizi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('shifts.calendar.index') }}" class="nav-link @if(Route::is('shifts.calendar.*')) active @endif">
                                    <i class="fe fe-list"></i> Turni
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('shifts.templates.index') }}"
                                   class="nav-link @if(Route::is('shifts.*') && !Route::is('shifts.calendar.*')) active @endif">
                                    <i class="fe fe-settings"></i> Gestione
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3 my-md-5">
            <div class="container">
                @include('flash::message')
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/vendors/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/selectize.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stack('scripts')
@include('layouts.navigation')

</body>
</html>
