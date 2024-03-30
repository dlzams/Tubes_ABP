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
        @if ($user->customClaims['admin'])
            <li class="nav-item">
                <a class="nav-link text-dark" href="/home/admin">{{ __('Seller') }}</a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-dark" href="/home/profile">{{ __('Profile') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('logout') }}"
                onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        @if ($user->customClaims['admin'] == false)
            <li class="nav-item">
                <a class="nav-link text-dark" href="/home/iamadmin">Become Seller</a>
            </li>
        @endif
        </div>
    @endguest
    @endsection @section('content')
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <h4 class="alert alert-warning mb-2"> {{ session('status') }} </h4>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Cars List
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
                                <th>Email Penjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reference as $key => $item)
                                <tr>
                                    <td>{{ $item['merk'] }}</td>
                                    <td>{{ $item['model'] }}</td>
                                    <td>{{ $item['tahun_pembuatan'] }}</td>
                                    <td>{{ $item['kondisi'] }}</td>
                                    <td>{{ $item['bahan_bakar'] }}</td>
                                    <td>{{ $item['warna'] }}</td>
                                    <td>{{ $item['harga'] }}</td>
                                    <td>{{ $item['deskripsi'] }}</td>
                                    <td>{{ $item['kontak_penjual'] }}</td>
                                    <td> {{ $item['email_penjual'] }} </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">No Record Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    </div>
@endsection
