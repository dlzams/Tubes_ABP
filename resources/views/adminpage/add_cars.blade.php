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

    <script>
        function confirmSubmission() {
            // Menggunakan fungsi bawaan JavaScript confirm untuk menampilkan pesan konfirmasi
            var confirmation = confirm("Apakah data yang Anda masukkan sudah benar?");

            // Jika pengguna mengklik "Iya sudah"
            if (confirmation) {
                // Lakukan submit form
                document.getElementById("carForm").submit();
            } else {
                // Jika pengguna mengklik "Masih belum", batalkan submit form
                return false;
            }
        }
    </script>

    <div class="card rounded" id="dummyCarsContent">
        <div class="card-header">
            <h5>
                Add New Cars
                <a href="{{ route('cars') }}" class="btn btn-sm btn-danger float-end">Back</a>
            </h5>
        </div>
        <div class="card-body">
            <!-- New Car Form -->
            {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\Firebase\CarsController@store']) !!}

            <!-- Field untuk Email Penjual -->
            {!! Form::hidden('email_penjual', auth()->user()->email) !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('merk', 'Merk:') !!}
                        {!! Form::text('merk', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('model', 'Model:') !!}
                        {!! Form::text('model', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('tahun_pembuatan', 'Tahun Pembuatan:') !!}
                        {!! Form::text('tahun_pembuatan', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('kondisi', 'Kondisi (Baru/Bekas):') !!}
                        {!! Form::text('kondisi', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('bahan_bakar', 'Bahan Bakar:') !!}
                        {!! Form::text('bahan_bakar', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {!! Form::label('transmisi', 'Transmisi:') !!}
                        {!! Form::text('transmisi', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('warna', 'Warna:') !!}
                        {!! Form::text('warna', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('harga', 'Harga:') !!}
                        {!! Form::text('harga', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('deskripsi', 'Deskripsi Tambahan (Jika tidak, isi "-" saja): ') !!}
                        {!! Form::text('deskripsi', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('kontak_penjual', 'Kontak Penjual (WA):') !!}
                        {!! Form::text('kontak_penjual', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                {!! Form::submit('Add Cars', ['class' => 'btn btn-primary btn-lg', 'onclick' => 'return confirmSubmission()']) !!}
            </div>

            <div class="form-group text-center">
                <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection