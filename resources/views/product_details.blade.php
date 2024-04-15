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

<!-- zoom  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var image = document.getElementById('uploadedImage');
        var cardBody = image.closest('.card-body');

        image.addEventListener('mousemove', function (e) {
            var rect = cardBody.getBoundingClientRect();
            var scale = 1.5; // Adjust the zoom level as needed
            var offsetX = (e.clientX - rect.left) / rect.width;
            var offsetY = (e.clientY - rect.top) / rect.height;

            image.style.transformOrigin = (offsetX * 100) + '% ' + (offsetY * 100) + '%';
            image.style.transform = 'scale(' + scale + ')';
        });

        image.addEventListener('mouseleave', function () {
            image.style.transformOrigin = 'center';
            image.style.transform = 'scale(1)';
        });
    });
</script>




@section('content')
    @if (session('status'))
        <h4 class="alert alert-warning mb-2"> {{ session('status') }} </h4>
    @endif
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-8 mb-2">
                <div class="card shadow rounded">
                    <div class="card-body overflow-hidden">
                        <img id="uploadedImage" src="{{ $car['image'] }}" alt="Uploaded Image" class="img-fluid">
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <h4><strong>Car Details</strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Merk:</strong></br> {{ ucwords($car['merk']) }}</p>
                                <p><strong>Model:</strong></br> {{ $car['model'] }}</p>
                                <p><strong>Tahun Pembuatan:</strong></br> {{ $car['tahun_pembuatan'] }}</p>
                                <p><strong>Kondisi:</strong></br> {{ $car['kondisi'] }}</p>
                                <p><strong>Bahan Bakar:</strong></br> {{ $car['bahan_bakar'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Transmisi:</strong></br> {{ $car['transmisi'] }}</p>
                                <p><strong>Warna:</strong></br> {{ $car['warna'] }}</p>
                                <p><strong>Harga:</strong></br> Rp. {{ $car['harga'] }}</p>
                                <p><strong>Deskripsi:</strong></br> {{ $car['deskripsi'] }}</p>
                                <p><strong>Kontak Penjual:</strong></br> {{ $car['kontak_penjual'] }}</p>
                                @if (isset($car['upload_timestamp']))
                                    <p><strong>Waktu Unggah:</strong><br> {{ date('d-m-Y', strtotime($car['upload_timestamp'])) }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('home') }}" class="btn btn-sm btn-ghost">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
