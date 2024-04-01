@extends('layouts.app')
@section('navbar_home')
    @if (Route::has('login'))
        @auth
            <li class="nav-item">
                <a class="nav-link text-dark" href="{{ url('/home') }}">Home</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('login') }}">Login</a>
            </li>

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('register') }}">Register</a>
                </li>
            @endif
        @endauth
    @else
    @endif
@endsection

@section('content')
    <div class="container">
        <div class="row justify-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Welcome') }}</div>

                    <div class="card-body">
                        <div class="container text-center mt-5">
                            <h1 class="text-5xl font-bold mb-5">Welcome to <a href="https://barocars.up.railway.app/"
                                    class="text-primary hover:text-secondary">BaroCars Web</a>
                                <span>&#127881;</span>
                            </h1>
                            <div>
                                <img src="{{ URL('..\admin_assets\img\image1.jpg') }}">
                            </div>
                            <p class="text-lg leading-relaxed mb-5">We've seamlessly integrated Firebase into our platform,
                                enabling powerful
                                features like <span class="text-danger">Realtime Database</span>, <span
                                    class="text-danger">Authentication</span>, <span class="text-danger">Email
                                    Verification</span>, and an <span class="text-danger">Admin Panel</span>. With Firebase,
                                we ensure real-time data updates, secure user authentication, and efficient administration.
                                Lets go Explore!</p>
                            <p class="text-lg">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP
                                v{{ PHP_VERSION }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
