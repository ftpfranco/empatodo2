<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header pb-0">
            <div class="d-flex justify-content-center">
                <div class="logo">
                    <a href="{{url('ventas-diarias')}}">
                        <img src="{{asset('images/logo.jpg')}}" class="responsive"   height="1rem" alt="Logo" srcset="">
                    </a>
                </div> 
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">


                {{-- @role("administrador")
                <li class="sidebar-item {{Request::path() == "/" ?'active':''}} ">
                    <a href="{{route("home")}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                @endrole --}}

                @hasanyrole("administrador|vendedor")
                <li class="sidebar-item {{Request::path() == "/" ?'active':''}} ">
                    <a href="{{url("mostrador")}}" class='sidebar-link'>
                        <i class="bi bi-display"></i>
                        <span>Mostrador</span>
                    </a>
                </li>
                @endrole

                @role("administrador|vendedor")
                <li class="sidebar-item   {{Request::path() == "cajas" ?'active':''}} ">
                    <a href="{{ url('cajas') }}" class='sidebar-link'>
                        <i class="bi bi-archive"></i>
                        <span>Caja</span>
                    </a>
                </li>
                @endrole


                
                {{-- @role("administrador") --}}
                @hasanyrole("administrador|vendedor")
                <li class="sidebar-item   {{(Request::path() == "articulos"||Request::path() == "categorias"||Request::path() == "marcas") ?'active':''}} ">
                    <a href="{{ url('articulos') }}" class='sidebar-link'>
                        <i class="bi bi-box"></i>
                        <span>Articulos</span>
                    </a>
                    <ul class="submenu {{(Request::path() == "articulos"||Request::path() == "categorias"||Request::path() == "marcas") ?'active':''}}">
                        {{-- <li class="submenu-item " hidden>
                            <a href="_productos.nuevo.php">Nuevo</a>
                        </li> --}}
                        {{-- <li class="submenu-item {{Request::path() == "articulo" ?'active':''}}">
                            <a href="{{ url('articulos') }}">Articulos</a>
                        </li> --}}
                        {{-- <li class="submenu-item {{Request::path() == "categorias" ?'active':''}}">
                            <a href="{{ url('categorias') }}">Categorias</a>
                        </li> --}}
                        {{-- <li class="submenu-item " hidden>
                            <a href="_productos.subcategorias.php">Sub Categorias</a>
                        </li> --}}
                        {{-- <li class="submenu-item {{Request::path() == "marcas" ?'active':''}}">
                            <a href="{{ url('marcas') }}">Marcas</a>
                        </li> --}}
                        {{-- <li class="submenu-item " hidden>
                            <a href="_productos.listaprecios.php">Lista de precios</a>
                        </li>
                        <li class="submenu-item " hidden>
                            <a href="_productos.actualizarprecios.php">Actualizar precios</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="_productos.combos.php">Combos</a>
                        </li> --}}

                    </ul>
                </li>
                @endrole





                
                @role("administrador")
                <li class="sidebar-item  has-sub {{(Request::path() == "ventas-diarias"||Request::path() == "listado" || Request::path() == "clientes"  ||Request::path() == "clientes/nuevo" ||Request::path() == "ventas/nuevo" || strpos(Request::path(),"ventas/edit") !==false  ) ?'active':''}}  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Ventas</span>
                    </a>
                    <ul class="submenu {{(Request::path() == "ventas-diarias"||Request::path() == "listado"  || Request::path() == "clientes" || Request::path() == "clientes/nuevo" ||Request::path() == "ventas/nuevo" || strpos(Request::path(),"ventas/edit") !==false   )?'active':''}} ">
                        <li class="submenu-item   {{Request::path() == "ventas-diarias"  ?'active':''}}">
                            <a href="{{ url('ventas-diarias') }}">Ventas del dia</a>
                        </li>
                        <li class="submenu-item   {{ Request::path() == "listado" ?'active':''}}">
                            <a href="{{ url('listado') }}">Listado ventas</a>
                        </li>
                        {{-- <li class="submenu-item  {{Request::path() == "clientes" ?'active':''}}">
                            <a href="{{ url('clientes') }}">Clientes</a>
                        </li> --}}
                        
                        {{-- <li class="submenu-item  {{Request::path() == "clientecc" ?'active':''}}">
                            <a href="{{ url('clientecc') }}">Cuenta corriente</a>
                        </li> --}}
                    </ul>
                </li>
                @endrole


                {{-- @role("administrador")
                <li class="sidebar-item   {{(Request::path() == "ventas" ) ?'active':''}}  ">
                    <a href="{{ url('ventas') }}" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Ventas</span>
                    </a>
                </li>
                @endrole --}}


                @role("vendedor")
                <li class="sidebar-item   {{( Request::path() == "ventas/nuevo" || strpos(Request::path(),"ventas/edit") !==false  ) ?'active':''}}  ">
                    <a href="{{ url('ventas/nuevo') }}" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Nueva venta</span>
                    </a>
                </li>
                @endrole

                @role("vendedor")
                <li class="sidebar-item   {{( Request::path() == "ventas-diarias" ) ?'active':''}}  ">
                    <a href="{{ url('ventas-diarias') }}" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Ventas del dia</span>
                    </a>
                </li>
                @endrole

             






               
                {{-- @role("administrador")
                <li class="sidebar-item  has-sub  {{(Request::path() == "compras"||  Request::path() == "compras/nuevo" ||Request::path() == "proveedores" ) ?'active':''}} ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cart-dash"></i>
                        <span>Compras</span>
                    </a>
                    <ul class="submenu  {{(Request::path() == "compras"|| Request::path() == "compras/nuevo" ||Request::path() == "proveedores" ) ?'active':''}} ">
                        
                        <li class="submenu-item {{Request::path() == "compras"||Request::path() == "compras/nuevo" ?'active':''}} ">
                            <a href="{{ url('compras') }}">Compras</a>
                        </li>
                        <li class="submenu-item {{Request::path() == "proveedores" ?'active':''}} ">
                            <a href="{{ url('proveedores') }}">Proveedores</a>
                        </li>
                        
                    </ul>
                </li>
                @endrole --}}


                {{-- @role("administrador")
                <li class="sidebar-item   {{(Request::path() == "compras") ?'active':''}} ">
                    <a href="{{ url('compras') }}" class='sidebar-link'>
                        <i class="bi bi-cart-dash"></i>
                        <span>Compras</span>
                    </a>
                </li>
                @endrole --}}




                {{-- <li class="sidebar-title">Clientes</li> --}}

                {{-- @role("administrador")
                <li class="sidebar-item  has-sub {{(Request::path() == "clientes" ||Request::path() == "clientecc" ) ?'active':''}}  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Clientes</span>
                    </a>
                    <ul class="submenu {{(Request::path() == "clientes"||Request::path() == "clientecc") ?'active':''}} ">
                        @role("administrador")
                        <li class="submenu-item  {{Request::path() == "clientes" ?'active':''}}">
                            <a href="{{ url('clientes') }}">Clientes</a>
                        </li>
                        <li class="submenu-item  {{Request::path() == "clientecc" ?'active':''}}">
                            <a href="{{ url('clientecc') }}">Cuenta corriente</a>
                        </li>
                        @endrole
                    </ul>
                </li>
                @endrole --}}



                {{-- @role("administrador")
                <li class="sidebar-item  {{(Request::path() == "clientes"  ) ?'active':''}}  ">
                    <a href="{{ url('clientes') }}" class='sidebar-link'>
                        <i class="bi bi-person"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                @endrole --}}




                {{-- @role("administrador")
                <li class="sidebar-item  {{(Request::path() == "proveedores") ?'active':''}} ">
                    <a href="{{ url('proveedores') }}" class='sidebar-link'>
                        <i class="bi bi-person"></i>
                        <span>Proveedores</span>
                    </a>
                </li>
                @endrole --}}



                


                {{-- <li class="sidebar-item  has-sub" hidden>
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Facturas</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <!-- factura c, nota de credito c, -->
                            <!-- factura: punto de venta 4 digitos, codigo 8 digitos -->
                            <!-- fecha, tipo de comprobante, nro comprobante,cae,  tipo de doc, acciones ver -->
                        </li>
                        <li class="submenu-item ">
                            <a href="_facturas.nuevo.php">Nuevo</a>
                        </li>

                        <li class="submenu-item ">
                            <a href="_facturas.listado.php">Facturas</a>
                        </li>
                        <!-- para cancelar una factura -->
                        <li class="submenu-item ">
                            <a href="_facturas.notasdecredito.php">Notas de credito</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="_facturas.facturaciononline.php">Facturacion online</a>
                        </li>
                    </ul>
                </li> --}}


                {{-- <li class="sidebar-item  " hidden>
                    <a href="_presupuesto.listado.php" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Presupuestos</span>
                    </a>
                </li> --}}


                <!-- <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Presupuestos</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="_presupuesto.listado.php">Presupuestos</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="_presupuesto.nuevo.php">Nuevo</a>
                        </li>
                    </ul>
                </li> -->




                @hasanyrole("administrador|vendedor")
                <li class="sidebar-item  {{Request::path() == "egresos" || Request::path() == "egresostipos" ?'active':''}} ">
                    <a href="{{ url('egresos') }}" class='sidebar-link'>
                        <i class="bi bi-graph-down"></i>
                        <span>Egresos</span>
                    </a>
                </li>
                @endrole

                @role("administrador")
                <li class="sidebar-item   {{Request::path() == "ingresos" || Request::path() == "ingresostipos" ?'active':''}} ">
                    <a href="{{ url('ingresos') }}" class='sidebar-link'>
                        <i class="bi bi-graph-up"></i>
                        <span>Ingresos</span>
                    </a>
                </li>
                @endrole




                @role("administrador")
                <li class="sidebar-item  {{Request::path() == "empleados" ?'active':''}}">
                    <a href="{{ url('empleados') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Empleados</span>
                    </a>
                </li>
                @endrole


                
                @hasanyrole("administrador")
                <li class="sidebar-item   {{Request::path() == "estadisticas" || Request::path() == "estadisticas" || Request::path() == "estadisticas/articulos_vendidos_por_dia"  ?'active':''}} ">
                    <a href="{{ url('estadisticas') }}" class='sidebar-link'>
                        <i class="bi bi-bar-chart"></i>
                        <span>Estadisticas</span>
                    </a>
                </li>
                @endrole

                @hasanyrole("vendedor")
                <li class="sidebar-item   {{Request::path() == "estadisticas" || Request::path() == "estadisticas/articulos_vendidos_por_dia"  ?'active':''}} ">
                    <a href="{{ route('estadisticas.articulos') }}" class='sidebar-link'>
                        <i class="bi bi-bar-chart"></i>
                        <span>Estadisticas</span>
                    </a>
                </li>
                @endrole


      
                {{-- <!-- <li class="sidebar-item  ">
                    <a href="_usuarios.listado.php" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Usuarios</span>
                    </a>
                </li> --> --}}


                {{-- <li hidden class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Reportes</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="">Ventas</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="">Compras</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="">Gastos</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="">Cajas</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="">Cajas</a>
                        </li>
                    </ul>
                </li> --}}



            {{-- @role("administrador")
                <li class="sidebar-item  has-sub   ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-clipboard-data"></i>
                        <span>Reportes</span>
                    </a>
                    <ul class="submenu  ">
                        <li class="submenu-item   ">
                            <a href="{{route("reportes-ventas")}}">Ventas</a>
                        </li>
                         
                    </ul>
                </li>
            @endrole --}}





            {{-- @role("administrador")
                <li class="sidebar-item  has-sub {{(Request::path() == "empleados"||Request::path() == "empresa" ) ?'active':''}} ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>Configuracion</span>
                    </a>
                    <ul class="submenu {{(Request::path() == "empleados"||Request::path() == "empresa" ) ?'active':''}} "> --}}

                        {{-- <!-- <li class="submenu-item ">
                            <a href="_configuracion.cajas.php">Cajas</a>
                        </li> --> --}}

                        {{-- <!-- <li class="submenu-item ">
                            <a href="_configuracion.formasdepago.php">Formas de pago</a>
                        </li> --> --}}

                        {{-- <!-- <li class="submenu-item ">
                            <a href="_configuracion.roles.php">Roles</a>
                        </li> --> --}}

                        {{-- <li class="submenu-item " hidden>
                            <a href="_configuracion.permisos.php">Permisos</a>
                        </li> --}}

                        {{-- <li class="submenu-item  {{Request::path() == "empleados" ?'active':''}} ">
                            <a href="{{ url('empleados') }}">Vendedor</a>
                        </li>

                        <li class="submenu-item  {{Request::path() == "empresa" ?'active':''}}  ">
                            <a href="{{url("empresa")}}">General</a>
                        </li> --}}

                        {{-- <li class="submenu-item " hidden>
                            <a href="_configuracion.certificadodigital.php" hidden>Certificado digital</a>
                        </li>
                        <li class="submenu-item " hidden>
                            <a href="_configuracion.facturacionelectronica.php">Facturacion electronica</a>
                        </li>
                        <li class="submenu-item " hidden>
                            <a href="_configuracion.planes.php">Planes</a>
                        </li>
                        <li class="submenu-item " hidden>
                            <a href="_configuracion.notificaciones.php">Notificaciones</a>
                        </li> --}}
                {{-- 
                    </ul>
                </li>
            @endrole --}}
                
 




            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
