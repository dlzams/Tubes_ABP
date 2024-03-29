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
    <style>
        /* Your styles here */
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
            overflow-y: scroll;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .list-group-item.active {
            background-color: rgba(232, 236, 238, 255) !important;
            color: black;
        }
    </style>
    <div class="container">

        @if (Session::has('message'))
            <p class=" pb-3 alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
                {{ Session::get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </p>
        @endif

        @if (Session::has('delete'))
            <p class=" pb-3 alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismissible fade show">
                {{ Session::get('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </p>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif

        <div class="row">
            <div class="col-md-3 col-sm-12 p-3">
                <div class="list-group">
                    <a href="/home/admin" class="list-group-item list-group-item-action mb-3 border"
                        id="dashboardLink">Dashboard</a>
                    <a href="{{ route('cars') }}" class="list-group-item list-group-item-action mb-3 border active"
                        id="CarsLink">Cars</a>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 p-1">
                <!-- Dashboard Content -->
                <div class="card">
                    <div class="card-header">
                        <h5>
                            Your Cars List
                            <a href="{{ route('add_cars') }}" class="btn btn-sm btn-primary float-end">Add Cars</a>
                        </h5>
                    </div>
                    <div class="card-body row" style="float: inline-end">
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
                                    <th>Edit</th>
                                    <th>Delete</th>
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
                                            <td><a href="{{ url('/home/cars/edit_cars/' . $key) }}"
                                                    class="btn btn-sm btn-success">Edit</a></td>
                                            <td>
                                                <form action="{{ route('delete_cars', ['id' => $key]) }}" method="post"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
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
            </div>
        </div>
    </div>
@endsection
