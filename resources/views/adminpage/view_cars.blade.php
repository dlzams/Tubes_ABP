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

    <div class="card">
        <div class="card-header">
            <h4>Your Cars List <a href="{{ route('add_cars') }}">Add Cars</a>
            </h4>

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun Pembuatan</th>
                        <th>Kondisi</th>
                        <th>Bahan Bakar</th>
                        <th>Warna</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Kontak Penjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reference as $key => $item)
                        <tr>
                            @if ($item['email_penjual'] == $email_penjual)
                                <td> {{ $item['merk'] }} </td>
                                <td> {{ $item['model'] }} </td>
                                <td> {{ $item['tahun_pembuatan'] }} </td>
                                <td> {{ $item['kondisi'] }} </td>
                                <td> {{ $item['bahan_bakar'] }} </td>
                                <td> {{ $item['warna'] }} </td>
                                <td> {{ $item['harga'] }} </td>
                                <td> {{ $item['deskripsi'] }} </td>
                                <td> {{ $item['kontak_penjual'] }} </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No Record Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
