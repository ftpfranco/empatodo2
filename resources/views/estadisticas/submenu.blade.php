<div class="col-lg-2 col-md-2 col-xl-2 ">
    <div class="card shadow">
        <div class="card-body px-1">
            <div>
                <a href="{{ route('estadisticas.index') }}" class="btn  mt-1 mb-1 mx-0 {{Request::path() == "estadisticas"  ?'btn-outline-dark':'btn-light'}}">Estadistica General </a>
                {{-- <a href="{{ route('estadisticas.ganancias_por_tipopago') }}" class="btn  mt-1 mb-1 mx-0 {{ Request::path() == "estadisticas/ganancias_por_tipopago"  ?'btn-outline-dark':'btn-light'}}"> Ganancias por metodos de pago </a> --}}
                <a href="{{ route('estadisticas.porcentaje_ventas') }}" class="btn  mt-1 mb-1 mx-0 {{ Request::path() == "estadisticas/porcentaje_ventas"  ?'btn-outline-dark':'btn-light'}}"> Porcentaje de Ventas </a>
                <a href="{{ route('estadisticas.articulos') }}" class="btn  mt-1 mb-1 mx-0 {{ Request::path() == "estadisticas/articulos_vendidos_por_dia"  ?'btn-outline-dark':'btn-light'}}">Articulos vendidos por dia </a>
            </div>
        </div>
    </div>
</div>