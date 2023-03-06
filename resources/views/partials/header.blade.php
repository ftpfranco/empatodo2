<header class="">
    {{-- <!-- <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a> --> --}}
    <nav class="navbar navbar-expand navbar-light ">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- <li class="nav-item dropdown me-1">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Mail</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">No new mail</a></li>
                        </ul>
                    </li>  --}}
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4 text-gray-600 ' id="notificaciones">  </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header"> <a href="{{ url('notificaciones') }}"
                                        class="text-reset text-decoration-none">Notificaciones </a> </h6>
                            </li>

                            <div class="notificaciones">
                               
                            </div>
                        </ul>
                    </li>
                </ul>

                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">
                                    {{ auth()->check() ? ucfirst(auth()->user()->nombre) : 'Usuario' }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ ucfirst(  auth()->user()->getRoleNames()[0] ) }}

                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ !empty(auth()->user()->path_thumbnail) ? asset(auth()->user()->path_thumbnail) : asset('images/profile/man_160.jpg') }}"
                                        class="profile-logo">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow"  aria-labelledby="dropdownMenuButton">
                        {{-- <li>
                            <h6 class="dropdown-header">Hola,
                                {{ auth()->check() ? auth()->user()->nombre : 'Usuario' }}!</h6>
                        </li> --}}
                        @hasanyrole("administrador|vendedor")
                        <li><a class="dropdown-item" href="{{url("mostrador")}}"> Mostrador </a></li>  
                        @endrole
                        <li> 
                            <hr class="dropdown-divider">
                        </li>

                        @role("administrador|vendedor")
                        <li><a class="dropdown-item" href="{{url("cajas")}}">   Caja </a></li>  
                        @endrole
                        @role("administrador")
                        <li><a class="dropdown-item" href="{{url("articulos")}}">   Articulos </a></li>  
                        {{-- <li><a class="dropdown-item" href="{{url("categorias")}}">   Categorias </a></li>  --}}
                        <li> 
                            <hr class="dropdown-divider">
                        </li>
                        @endrole

                        @hasanyrole("administrador|vendedor")
                        <li><a class="dropdown-item" href="{{url("ventas-diarias")}}">   Ventas del dia</a></li>  
                        <li><a class="dropdown-item" href="{{url("ventas/nuevo")}}">   Nueva venta </a></li> 
                        @endrole

                        @role("administrador")
                        <li><a class="dropdown-item" href="{{url("listado")}}">   Listado de ventas </a></li> 
                        {{-- <li><a class="dropdown-item" href="{{url("clientes")}}">  Clientes </a></li>  --}}
                        <li> 
                            <hr class="dropdown-divider">
                        </li>
                        @endrole
                        @role("administrador")
                        <li><a class="dropdown-item" href="{{url("egresos")}}"> Egresos </a></li>
                        <li><a class="dropdown-item" href="{{url("ingresos")}}"> Ingresos </a></li> 
                        <li> 
                            <hr class="dropdown-divider">
                        </li>
                        @endrole  
                        @role("administrador")
                        
                        <li><a class="dropdown-item" href="{{route('estadisticas.articulos')}}"> Estadisticas </a></li> 
                        @endrole
                        <li> 
                            <hr class="dropdown-divider">
                        </li>
                        @hasanyrole("administrador|vendedor")
                        <li>
                            <a class="dropdown-item" href="{{ url('notificaciones') }}">
                                {{-- <i class="icon-mid bi bi-bell me-2"></i>  --}}
                                Notificaciones
                            </a>
                        </li>
                        <li> 
                            <hr class="dropdown-divider">
                        </li>
                        @endrole

                        <li>

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                {{ __('Salir') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>





                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
