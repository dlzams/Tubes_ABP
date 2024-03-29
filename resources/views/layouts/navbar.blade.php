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
            <a class="nav-link text-dark" href="/home/admin">{{ __('Admin') }}</a>
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
    </div>
    </li>
@endguest
