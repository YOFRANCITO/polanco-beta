@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="{{url('/')}}" class="app-brand-link">
        <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 44])</span>
    </a>
</div>
@endif

<!-- ! Not required for layout-without-menu -->
@if(!isset($navbarHideToggle))
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="icon-base bx bx-search icon-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Portal de Socios Link -->
        <li class="nav-item me-3">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('portal.login') }}" target="_blank" title="Abrir Portal de Socios">
                <i class="bx bx-id-card me-1"></i> <span class="d-none d-sm-inline">Portal Socios</span>
            </a>
        </li>

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <div class="avatar-initial rounded-circle bg-label-primary fw-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item" href="{{ route('usuarios.perfil') }}">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <div class="avatar-initial rounded-circle bg-label-primary fw-bold">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">{{ Auth::user()->name ?? 'Usuario' }}</h6>
                                <span class="badge {{ (Auth::user()->role ?? '') === 'admin' ? 'bg-label-danger' : 'bg-label-info' }} rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                    {{ Auth::user()->role ?? 'operador' }}
                                </span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('usuarios.perfil') }}">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>Mi Perfil</span>
                    </a>
                </li>
                @if(Auth::user() && Auth::user()->isAdmin())
                <li>
                    <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                        <i class="icon-base bx bx-user-circle icon-md me-3"></i><span>Gestión de Usuarios</span>
                    </a>
                </li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('portal.login') }}" target="_blank">
                        <i class="icon-base bx bx-window-open icon-md me-3"></i><span>Vista Portal Socio</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Cerrar Sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>