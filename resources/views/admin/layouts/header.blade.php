<!-- Navbar -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/admin">Dashboard</a></li>
                        @if (!Request::is('admin'))
                            <li class="breadcrumb-item active">@yield('nav_menu')</li>
                        @endif
                    </ol>
                </div>
                @if (Request::is('admin'))
                <h4 class="page-title">
                    Welcome back {{auth()->user()->name}}
                </h3>
                @endif
            </div>

            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#">
                        <span class="image d-flex align-items-center">
                            <img src="{{ getProfile(Auth::user()->image) }}" alt="{{ auth::user()->name }}"
                                 class="rounded-circle shadow bg-secondary" style="padding: 0.1rem;" width="35" height="35">
                            <p style="font-weight: bold" class="mb-0 ms-2">{{ Auth::user()->name }}</p>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  
                                stroke-width="3"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>
                            <span class="ms-2">{{ __('Profile & account') }}</span>
                        </a>
                        <div class="dropdown-divider m-1"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="3"  
                                stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" />
                            </svg>
                           <span class="ms-2">{{ __('Logout') }}</span>
                        </a>
                        <form class="logout" id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>