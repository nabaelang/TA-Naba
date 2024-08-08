<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('custom/image/logo.png') }}" alt="" width="40" height="40" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 w-100">
                    <li class="nav-item w-100">
                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                            <input class="form-control w-80" type="search" placeholder="Search" name="query"
                                aria-label="Search" value="{{ request()->input('query') }}">
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="/product">Product</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link fw-bold" href="#">Contact</a>
                    </li> --}}
                    @auth
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/transaction">
                                <i class="fa-regular fa-file-lines"></i>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link fw-bold" href="#">
                                <i class="fa-solid fa-truck-fast"></i>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/profile">{{ Auth::user()->name }}</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a href="/login" class=" btn btn-md button-primary w-100">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
