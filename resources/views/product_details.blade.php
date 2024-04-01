@extends('layouts.app')
@section('navbar_home')
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item">
            <a class="nav-link text-dark" href="/home/profile">{{ __('Profile') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ url('/home') }}">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark active" href="{{ route('logout') }}"
                onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    @endguest
@endsection



@section('content')
    @if (session('status'))
        <h4 class="alert alert-warning mb-2"> {{ session('status') }} </h4>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <img id="uploadedImage" src="{{ $car['image'] }}" alt="Uploaded Image" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Car Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Merk:</strong> {{ $car['merk'] }}</p>
                                <p><strong>Model:</strong> {{ $car['model'] }}</p>
                                <p><strong>Tahun Pembuatan:</strong> {{ $car['tahun_pembuatan'] }}</p>
                                <p><strong>Kondisi:</strong> {{ $car['kondisi'] }}</p>
                                <p><strong>Bahan Bakar:</strong> {{ $car['bahan_bakar'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Transmisi:</strong> {{ $car['transmisi'] }}</p>
                                <p><strong>Warna:</strong> {{ $car['warna'] }}</p>
                                <p><strong>Harga:</strong> {{ $car['harga'] }}</p>
                                <p><strong>Deskripsi:</strong> {{ $car['deskripsi'] }}</p>
                                <p><strong>Kontak Penjual:</strong> {{ $car['kontak_penjual'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('home') }}" class="btn btn-accent">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
