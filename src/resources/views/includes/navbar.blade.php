<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mynav sticky-top">
    <div class="container">
        <button type="button" class="modals-toggler" data-toggle="modal" data-target="#exampleModal">
            <img src="/storage/Ruang Curhat.jpg" alt="" style="width: 6rem;">
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">


            </ul>

            <form>
                <div class="searchbar">
                    <input class="search_input" type="text" name="search" placeholder="Search...">
                    <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                </div>
            </form>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="/storage/avatar/{{Auth::user()->profile_image}}" alt="" style="width:40px; height:40px; position: relative; top: 0px; right: 10px; border-radius: 50%;">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Modal Starts Here  --}}
<div class="container">
    <div class="modal left fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    @if(!\Illuminate\Support\Facades\Auth::guest())
                        <img src="/storage/avatar/{{auth()->user()->profile_image}}" style="border-radius: 50%; width: 15rem; height: 15rem;" class="mb-5 mt-3 ml-3">
                        <h3 class="mb-5" style="align-items: center">Hello, {{auth()->user()->name}}</h3>
                    @else
                        <img src="/storage/Ruang Curhat2.jpg" style="width: 15rem;" class="mb-2 mt-3 ml-3">
                        <div class="ml-5 wrapper">
                            <a class="nav-link btn-outline-primary" href="{{ url('/register') }}">
                                Register
                            </a>
                            <a class="nav-link btn-outline-secondary" href="{{ url('/login') }}">
                                Login
                            </a>
                        </div>
                    @endif
                    <form class="form-inline md-form form-sm justify-content-center mb-3 mt-3">
                        <input class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search"
                               aria-label="Search" name="search">
                        <a href="#"><i class="fas fa-search"></i></a>
                    </form>
                    <div class="nav flex-sm-column flex-row">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link btn-outline-secondary" href="{{ url('/') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    Home
                                </a>
                            </li>
                            @if(!\Illuminate\Support\Facades\Auth::guest())
                                <li class="nav-item">
                                    <a class="nav-link btn-outline-secondary" href="/profile/{{auth()->id()}}">
                                        @include('includes.person')
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-outline-secondary" href="/chat" style="display: flex; flex-direction: row;">
                                        @include('includes.chatBox')
                                        <div class="ml-1">Chat Room</div>
                                        @if(\App\Message::where('to',auth()->id())->where('read',false)->count() > 0)
                                            <span class="requestNotif ml-1">{{\App\Message::where('to',auth()->id())->where('read',false)->count()}}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-outline-secondary" href="/friends" style="display: flex; flex-direction: row;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        <div class="ml-1">Friend Request</div>
                                        @if(Auth::user()->friendsBis()->where('accepted',false)->count() > 0)
                                            <span class="requestNotif ml-1">{{Auth::user()->friendsBis()->where('accepted',false)->count()}}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link btn-outline-primary float-right" href="{{ route('logout') }}" style="display: flex; flex-direction: row;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <div class="mr-2">Logout</div>
                                        <i class="fas fa-sign-out-alt align-self-center"></i>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
{{-- Modal Ends Here --}}
