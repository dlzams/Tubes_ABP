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
                Edit Cars
                <a href="{{ route('cars') }}" class="btn btn-sm btn-danger float-end">Back</a>
            </h5>
        </div>
        <div class="card-body">
            <!-- New Car Form -->
            <form method="POST" action="{{ url('/home/cars/update_cars/' . $key) }}">
                @csrf
                @method('PUT')
                <!-- Field untuk Email Penjual -->
                <input type="hidden" name="email_penjual" value="{{ auth()->user()->email }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="merk">Merk:</label>
                            <input type="text" name="merk" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input type="text" name="model" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="tahun_pembuatan">Tahun Pembuatan:</label>
                            <input type="text" name="tahun_pembuatan" value="{{ $editdata['merk'] }}"
                                class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="kondisi">Kondisi (Baru/Bekas):</label>
                            <input type="text" name="kondisi" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="bahan_bakar">Bahan Bakar:</label>
                            <input type="text" name="bahan_bakar" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="transmisi">Transmisi:</label>
                            <input type="text" name="transmisi" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="warna">Warna:</label>
                            <input type="text" name="warna" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga:</label>
                            <input type="text" name="harga" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Tambahan (Jika tidak, isi "-" saja):</label>
                            <input type="text" name="deskripsi" value="{{ $editdata['merk'] }}" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="kontak_penjual">Kontak Penjual (WA):</label>
                            <input type="text" name="kontak_penjual" value="{{ $editdata['merk'] }}"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg" onclick="return confirmSubmission()">Update
                        Cars</button>
                </div>

                <div class="form-group text-center">
                    <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
                </div>
            </form>

        </div>
    </div>
@endsection
