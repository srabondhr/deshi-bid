<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Deshi Bid Logo" class="img-fluid" style="max-height: 70px;">
        </a>

        <!-- Single Toggler Button for Small Screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register') 
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @if (Route::has('register'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.view') }}">Profile</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>

    <!-- Mobile Navigation Links Inside Toggler -->
    <div class="collapse d-md-none" id="navbarNav">
        <div class="bg-dark p-3">
            @if (Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register') 
                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                @endif
            @else
                <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                <a class="nav-link text-white" href="{{ route('products.index') }}">Products</a>
                @auth
                    <a class="nav-link text-white" href="{{ route('profile.view') }}">Profile</a>
                    <a class="nav-link text-white" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        Logout
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>