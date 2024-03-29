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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "order": [
                    [1, "desc"]
                ],
                "searching": false,
                "lengthChange": false,
                "pageLength": 10,
                "paging": false,
                "info": false,
            });

            showDashboard();

        });
    </script>

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
                    <a href="#" class="list-group-item list-group-item-action mb-3 border active"
                        id="dashboardLink">Dashboard</a>
                    <a href="{{ route('cars') }}" class="list-group-item list-group-item-action mb-3 border"
                        id="CarsLink">Cars</a>
                </div>
            </div>

            <div class="col-md-9 col-sm-12 p-3">
                <!-- Dashboard Content -->
                <div class="card rounded content-section" id="dashboardContent">
                    <h5 class="card-header">Dashboard Content</h5>
                    <div class="card-body row">
                        <!-- Example: Total Users Count -->
                        <div class="col-3">
                            <div class="card rounded text-center h-100">
                                <div class="card-header bg-warning">Total Users</div>
                                <div class="card-body display-4">{{ count($users) }}</div>
                            </div>
                        </div>

                        <!-- Example: System Information -->
                        <div class="col-9">
                            <div class="card rounded h-100">
                                <div class="card-header bg-success text-center">System Information</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-left"><strong>Laravel Version</strong></div>
                                        <div class="col-8">: &ThinSpace; {{ Illuminate\Foundation\Application::VERSION }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-left"><strong>PHP Version</strong></div>
                                        <div class="col-8">: &ThinSpace; {{ PHP_VERSION }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-left"><strong>Database</strong></div>
                                        <div class="col-8">: &ThinSpace; Firebase</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example: Recent Active Users Table -->
                        <div class="col-12 pt-3">
                            <div class="card rounded ">
                                <div class="card-header bg-info text-white">Recent Active Users</div>
                                <table id="usersTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Logged-In</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->displayName }}</td>
                                                <td>{{ Carbon\Carbon::parse($user->metadata->lastLoginAt)->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
