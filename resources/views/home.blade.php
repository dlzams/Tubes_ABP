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
    @endguest
@endsection

<style>
    .card-2 {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-2:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }
</style>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-warning mb-2">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-1">
                    <div class="card-header">
                        <h4 class="text-lg font-semibold" style="margin-left: 3rem; margin-right: 3rem;">Cars List
                            <p class="float-end">Hello, {{ $user->displayName }}</p>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Section -->

        <div class="row mt-4">
            @forelse($pagedPaginator->items() as $key => $item)
                <div class="col-md-4 mb-4">
                    <div class="card-2 bg-white shadow-lg rounded-lg overflow-hidden">
                        <figure>
                            <img src="{{ $item['image'] }}" alt="car!" class="object-cover w-full h-56">
                        </figure>
                        <div class="card-body">
                            <h2 class="text-xl font-semibold">{{ ucwords($item['merk']) }} {{ $item['model'] }}
                                ({{ $item['tahun_pembuatan'] }}) 
                                @if($item['kondisi'] == 'Baru')
                                    <div class="badge badge-secondary">NEW</div>
                                @else
                                    <div class="badge badge-accent">USED</div>
                                @endif
                            </h2>
                            <p class="text-sm text-black">Harga : Rp. {{ $item['harga'] }}</p>
                            <div class="flex justify-end mt-1">
                                <a href="{{ url('/home/product_details/' . $key) }}" class="btn btn-sm btn-ghost">Details</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p class="text-center">No Record Found</p>
                </div>
            @endforelse

        </div>
        <!-- pagination nih -->
        <div class="join col-md-12 justify-center">
            {{-- Previous Page Link --}}
            @if ($pagedPaginator->onFirstPage())
                <button class="join-item btn">&laquo;</button>
            @else
                <button class="join-item btn" onclick="window.location='{{ $pagedPaginator->previousPageUrl() }}'">&laquo;</button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($pagedPaginator->getUrlRange(1, $pagedPaginator->lastPage()) as $page => $url)
                @if ($page == $pagedPaginator->currentPage())
                    <button class="join-item btn btn-active">{{ $page }}</button>
                @else
                    <button class="join-item btn" onclick="window.location='{{ $url }}'">{{ $page }}</button>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($pagedPaginator->hasMorePages())
                <button class="join-item btn" onclick="window.location='{{ $pagedPaginator->nextPageUrl() }}'">&raquo;</button>
            @else
                <button class="join-item btn">&raquo;</button>
            @endif
        </div>

    </div>
@endsection
