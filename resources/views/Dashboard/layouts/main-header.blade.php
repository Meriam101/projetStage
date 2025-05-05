<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left">
            <div class="responsive-logo">
                <a href="{{ url('/index') }}">
                    <img src="{{ URL::asset('Dashboard/img/brand/logo.png') }}" class="logo-1" alt="logo">
                    <img src="{{ URL::asset('Dashboard/img/brand/logo-white.png') }}" class="dark-logo-1" alt="logo">
                    <img src="{{ URL::asset('Dashboard/img/brand/favicon.png') }}" class="logo-2" alt="logo">
                    <img src="{{ URL::asset('Dashboard/img/brand/favicon.png') }}" class="dark-logo-2" alt="logo">
                </a>
            </div>

            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

            <div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                <input class="form-control" placeholder="Search for anything..." type="search">
                <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
            </div>
        </div>

        <div class="main-header-right">
            <ul class="nav">
                <li>
                    <div class="dropdown nav-item d-none d-md-flex">
                        <a href="#" class="d-flex nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
                            @php
                                $locale = App::getLocale();
                                $flag = match($locale) {
                                    'ar' => 'egypt_flag.jfif',
                                    'fr' => 'french_flag.jpg',
                                    default => 'us_flag.jpg'
                                };
                            @endphp
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                                <img src="{{ URL::asset('Dashboard/img/flags/' . $flag) }}" alt="img">
                            </span>
                            <strong class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                        </a>

                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    @if($properties['native'] === 'English')
                                        <i class="flag-icon flag-icon-us"></i>
                                    @elseif($properties['native'] === 'العربية')
                                        <i class="flag-icon flag-icon-eg"></i>
                                    @elseif($properties['native'] === 'Français')
                                        <i class="flag-icon flag-icon-fr"></i>
                                    @endif
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>

            <div class="nav nav-item navbar-nav-right ml-auto">
                <div class="nav-link">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i></button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                        </svg>
                    </a>
                </div>

                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="#"><img alt="" src="{{ URL::asset('Dashboard/img/faces/6.jpg') }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="" src="{{ URL::asset('Dashboard/img/faces/6.jpg') }}"></div>
                                <div class="mr-3 my-auto">
                                    {{-- <h6>{{ auth()->user()->name }}</h6><span>{{ auth()->user()->email }}</span> --}}
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="#"><i class="bx bx-user-circle"></i> Profile</a>
                        <a class="dropdown-item" href="{{ auth()->guard('admin')->check() ? route('admin.profile.edit') : route('profile.edit') }}">
                            <i class="bx bx-cog"></i> Edit Profile
                        </a>
                        <form method="POST" action="{{ auth('web')->check() ? route('logout') : route('logout.admin') }}">
                            @csrf
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bx bx-log-out"></i> Logout
                            </a>
                        </form>
                    </div>
                </div>

                <div class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{ asset('js/app.jsx') }}"></script>
<!-- /main-header -->
