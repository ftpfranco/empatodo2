 {{-- turno 1  --}}
 <div class=" col-lg-6">
     <div class="card shadow">
         <div class="card-content">
             <div class="card-header">
                 <h4 class="card-title">Turno ma&ntilde;ana</h4>
             </div>
             <div class="card-body mt-0 pt-0" id="tabla">
                 <div class="table-responsive  ">
                     <table class="table table-hover  mb-0">
                         <thead>
                             <tr>
                                 <th>Articulo</th>
                                 <th class="text-end"> Cantidad </th>
                             </tr>
                         </thead>
                         <tbody class="productos-listado listado">
                             @if (isset($articulos_t1) && count($articulos_t1) > 0)
                                 @foreach ($articulos_t1 as $item)
                                     <tr>
                                         <td> {{ $item['articulo'] }} </td>
                                         <td class="text-end"> {{ $item['cantidad'] }} </td>
                                     </tr>
                                 @endforeach
                             @endif

                         </tbody>
                     </table>

                 </div>

             </div>

         </div>
     </div>
 </div>



 {{-- turno 2  --}}
 <div class=" col-lg-6">
     <div class="card shadow">
         <div class="card-content">
             <div class="card-header">
                 <h4 class="card-title">Turno tarde</h4>
             </div>
             <div class="card-body mt-0 pt-0" id="tabla">
                 <div class="table-responsive  ">
                     <table class="table table-hover  mb-0">
                         <thead>
                             <tr>
                                 <th>Articulo</th>
                                 <th class="text-end"> Cantidad </th>
                             </tr>
                         </thead>
                         <tbody class="productos-listado listado">
                             @if (isset($articulos_t2) && count($articulos_t2) > 0)
                                 @foreach ($articulos_t2 as $item)
                                     <tr>
                                         <td> {{ $item['articulo'] }} </td>
                                         <td class="text-end"> {{ $item['cantidad'] }} </td>
                                     </tr>
                                 @endforeach
                             @endif

                         </tbody>
                     </table>

                 </div>

             </div>

         </div>
     </div>
 </div>
