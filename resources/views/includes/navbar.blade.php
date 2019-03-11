<nav class="navbar navbar-dark navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand" href="#">HiCHART</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-light" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item {{Request::is('home') ? 'active' : ''}}">
                <a class="nav-link" href="{{ url('/home') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            @if(Auth::check() && Auth::user()->hasAnyRole(['admin']))
                <li class="nav-item">
                    <a class="nav-link {{Request::is('branches') ? 'active' : ''}}" href="{{ url('/branches') }}">Branch Setup</a>
                </li>
            @endif
            @if(Auth::check() && Auth::user()->hasAnyRole(['admin']))
                <li class="nav-item">
                    <a class="nav-link {{Request::is('companies') ? 'active' : ''}}" href="{{ url('/companies') }}">Company Setup</a>
                </li>
            @endif
            @if(Auth::check() && Auth::user()->hasAnyRole(['employee','admin']))
                <li class="nav-item">
                    <a class="nav-link {{Request::is('reports') ? 'active' : ''}}" href="{{ url('/reports') }}">Reports</a>
                </li>
            @endif
            @if(Auth::check() && Auth::user()->hasAnyRole(['admin']))
                <li class="nav-item">
                    <a class="nav-link {{Request::is('admin/users') ? 'active' : ''}}" href="{{ url('/admin/users') }}">Manage Users</a>
                </li>
            @endif
        </ul>
        <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->username }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="min-height:60px">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                         <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>