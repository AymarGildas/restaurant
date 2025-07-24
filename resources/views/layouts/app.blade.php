<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />



    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}" />



    {{-- Use site name from settings, with a fallback to the .env config --}}

    <title>{{ $settings->site_name ?? config('app.name', 'Laravel') }}</title>



    <!-- Favicon -->

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />



    <!-- Fonts & Icons -->

    <link rel="dns-prefetch" href="//fonts.bunny.net" />

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



    <!-- Scripts -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])



    {{-- Custom Styles for Footer --}}

    <style>
        :root {
            --primary-color: {{ $settings->primary_color ?? '#4F46E5' }};
            --secondary-color: {{ $settings->secondary_color ?? '#FF6B6B' }};
        }
        html, body {

            height: 100%;

        }

        body {

            display: flex;

            flex-direction: column;

        }

        #app {

            flex: 1 0 auto;

        }
        /* Dynamic Navbar Styles */
        .navbar-custom {
            background-color: var(--primary-color) !important;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff !important;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--secondary-color) !important;
        }
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .footer {

            flex-shrink: 0;

            background-color: #212529; /* Dark background */

            color: #adb5bd; /* Light gray text */

            padding-top: 4rem;

            padding-bottom: 2rem;

        }

        .footer h5 {

            color: #ffffff; /* White headings */

            font-weight: 600;

            margin-bottom: 1.5rem;

        }

        .footer a {

            color: #adb5bd;

            text-decoration: none;

            transition: color 0.2s ease-in-out;

        }

        .footer a:hover {

            color: #ffffff;

        }

        .footer .social-icons a {

            font-size: 1.5rem;

            margin-right: 1.25rem;

            color: #adb5bd;

        }

        .footer .social-icons a:hover {

            /* Use dynamic color from settings */

            color: {{ $settings->secondary_color ?? '#FF6B6B' }};

        }

        .footer .newsletter-form .form-control {

            background-color: #343a40;

            border-color: #495057;

            color: #fff;

        }

        .footer .newsletter-form .form-control::placeholder {

            color: #6c757d;

        }

        .footer .bottom-bar {

            border-top: 1px solid #343a40;

            padding-top: 1.5rem;

            margin-top: 2rem;

        }

    </style>



    @stack('styles')

</head>

<body>

    <div id="app">

        <nav class="navbar navbar-expand-md navbar-dark navbar-custom shadow-sm">

            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">

                    {{ $settings->site_name ?? config('app.name', 'Laravel') }}

                </a>

                <button 

                    class="navbar-toggler" 

                    type="button" 

                    data-bs-toggle="collapse" 

                    data-bs-target="#navbarSupportedContent" 

                    aria-controls="navbarSupportedContent" 

                    aria-expanded="false" 

                    aria-label="{{ __('Basculer la navigation') }}">

                    <span class="navbar-toggler-icon"></span>

                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left side of navbar -->

                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ url('/') }}">Accueil</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('landing') }}">Boutique</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.cart.index') }}">
                                Panier
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="badge rounded-pill bg-danger">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        {{-- Added About and Contact links to navbar --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>

                    </ul>



                    <!-- Right side of navbar -->

                    <ul class="navbar-nav ms-auto">

                        @guest

                            @if (Route::has('login'))

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>

                                </li>

                            @endif



                            @if (Route::has('register'))

                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>

                                </li>

                            @endif

                        @else

                            <li class="nav-item dropdown">

                                <a 

                                    id="navbarDropdown" 

                                    class="nav-link dropdown-toggle" 

                                    href="#" 

                                    role="button" 

                                    data-bs-toggle="dropdown" 

                                    aria-haspopup="true" 

                                    aria-expanded="false" 

                                    v-pre>

                                    {{ Auth::user()->name }}

                                </a>



                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a 

                                        class="dropdown-item" 

                                        href="{{ route('logout') }}"

                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                        {{ __('Déconnexion') }}

                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                        @csrf

                                    </form>

                                </div>

                            </li>

                        @endguest

                    </ul>

                </div>

            </div>

        </nav>



        <main class="py-4">

            @yield('content')

        </main>

    </div>



    {{-- DYNAMIC FOOTER --}}

    <footer class="footer">

        <div class="container">

            <div class="row gy-4">

                

                {{-- About Section --}}

                <div class="col-lg-4 col-md-6">

                    <h5>About {{ $settings->site_name ?? 'FoodExpress' }}</h5>

                    <p class="pe-3">{{ $settings->footer_about_text ?? 'Your favorite meals...' }}</p>

                    <div class="social-icons mt-3">

                        @if($settings->social_facebook_url)

                            <a href="{{ $settings->social_facebook_url }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>

                        @endif

                        @if($settings->social_instagram_url)

                            <a href="{{ $settings->social_instagram_url }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>

                        @endif

                        @if($settings->social_twitter_url)

                            <a href="{{ $settings->social_twitter_url }}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>

                        @endif

                    </div>

                </div>



                {{-- Quick Links --}}

                <div class="col-lg-2 col-md-6">

                    <h5>Quick Links</h5>

                    <ul class="list-unstyled">

                        <li><a href="{{ url('/') }}">Home</a></li>

                        <li><a href="{{ route('landing') }}">Menu</a></li>

                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>

                    </ul>

                </div>



                {{-- Contact Info --}}

                <div class="col-lg-3 col-md-6">

                    <h5>Contact Us</h5>

                    <ul class="list-unstyled">

                        @if($settings->footer_address)

                            <li class="d-flex"><i class="fas fa-map-marker-alt mt-1 me-2"></i><span>{{ $settings->footer_address }}</span></li>

                        @endif

                        @if($settings->phone_number)

                            <li class="d-flex"><i class="fas fa-phone mt-1 me-2"></i><span>{{ $settings->phone_number }}</span></li>

                        @endif

                        @if($settings->contact_email)

                            <li class="d-flex"><i class="fas fa-envelope mt-1 me-2"></i><span>{{ $settings->contact_email }}</span></li>

                        @endif

                    </ul>

                </div>



                {{-- Newsletter Signup --}}

                <div class="col-lg-3 col-md-6">

                    <h5>Stay Updated</h5>

                    <p>Subscribe to our newsletter for special offers.</p>

                    <form class="newsletter-form">

                        <div class="input-group">

                            <input type="email" class="form-control" placeholder="Your email address">

                            <button class="btn btn-primary" type="button" style="background-color: {{ $settings->secondary_color ?? '#FF6B6B' }}; border-color: {{ $settings->secondary_color ?? '#FF6B6B' }};">Go</button>

                        </div>

                    </form>

                </div>



            </div>



            {{-- Bottom Bar --}}

            <div class="bottom-bar text-center">

                <p class="mb-0">&copy; {{ date('Y') }} {{ $settings->site_name ?? 'FoodExpress' }}. All rights reserved.</p>

            </div>

        </div>

    </footer>

</body>

</html>