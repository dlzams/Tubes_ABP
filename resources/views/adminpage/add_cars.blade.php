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

    <div class="container">
        <div class="card rounded" id="dummyCarsContent">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-lg font-semibold">Add New Car
                        <a href="{{ route('cars') }}" class="btn btn-sm btn-ghost float-end">Back</a>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <!-- New Car Form -->
                {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\Firebase\CarsController@store']) !!}

                <!-- Field untuk Email Penjual -->
                {!! Form::hidden('email_penjual', auth()->user()->email) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input input-bordered flex items-center gap-2 bg-white">
                                Merk
                                {!! Form::text('merk', null, [  
                                    'required' => 'required',
                                    'class' => 'grow',
                                    'placeholder' => 'Toyota',
                                ]) !!}
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="input input-bordered flex items-center gap-2 bg-white">
                                Model
                                {!! Form::text('model', null, [
                                    'required' => 'required',
                                    'class' => 'grow',
                                    'placeholder' => 'Avanza',
                                ]) !!}
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="input input-bordered flex items-center gap-2 bg-white">
                                Tahun Pembuatan
                                {!! Form::number('tahun_pembuatan', null, [
                                    'required' => 'required',
                                    'class' => 'grow',
                                    'placeholder' => '2020',
                                ]) !!}
                            </label>
                        </div>

                        <div class="form-group">
                            {!! Form::select('kondisi', ['Baru' => 'Baru', 'Bekas' => 'Bekas'], null, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Baru/Bekas',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select(
                                'bahan_bakar',
                                [
                                    'Bensin (Gasoline)' => 'Bensin (Gasoline)',
                                    'Solar (Diesel)' => 'Solar (Diesel)',
                                    'Gas alam (CNG)' => 'Gas alam (CNG)',
                                    'Listrik (Electricity)' => 'Listrik (Electricity)',
                                ],
                                null,
                                ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Bensin/Solar/CNG/Listrik'],
                            ) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::select('transmisi', ['Matic' => 'Matic', 'Manual' => 'Manual'], null, [
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Manual/Matic',
                            ]) !!}
                        </div>

                    <div class="form-group">
                        <label class="input input-bordered flex items-center gap-2 bg-white">
                            Warna
                            {!! Form::text('warna', null, [
                                'required' => 'required',
                                'class' => 'grow',
                                'placeholder' => 'Merah',
                            ]) !!}
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="input input-bordered flex items-center gap-2 bg-white">
                            Harga
                            {!! Form::text('harga', null, [
                                'required' => 'required',
                                'class' => 'grow',
                                'placeholder' => '50.000.000',
                            ]) !!}
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="input input-bordered flex items-center gap-2 bg-white">
                            Deskripsi (Jika tidak, isi "-") 
                            {!! Form::text('deskripsi', null, [
                                'required' => 'required',
                                'class' => 'grow',
                                'placeholder' => 'km 10.000, pajak hidup, service rutin',
                            ]) !!}
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="input input-bordered flex items-center gap-2 bg-white">
                            Kontak Penjual (WA)
                            {!! Form::text('kontak_penjual', null, [
                                'required' => 'required',
                                'class' => 'grow',
                                'placeholder' => '08xxxxxxx',
                            ]) !!}
                        </label>
                    </div>
                </div>

                <div class="form-group text-center">
                    {!! Form::submit('Add Cars', ['class' => 'btn btn-accent btn-wide', 'onclick' => 'return confirmSubmission()']) !!}
                </div>

                <div class="form-group text-center">
                    <button type="reset" class="btn btn-sm btn-outline btn-error ">Reset</button>
                </div>

                {!! Form::close() !!}
            </div>
            <script>
                // Menghapus placeholder saat input field diisi
                document.querySelectorAll('.form-control').forEach(input => {
                    input.addEventListener('input', () => {
                        input.removeAttribute('placeholder');
                    });
                });
            </script>
        </div>
    </div>
@endsection
