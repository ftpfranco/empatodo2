const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

.js('public/js/resources/articulos.edit_.js', 'public/js/articulos.edit.min.js')
    .js('public/js/resources/articulos.listado_.js', 'public/js/articulos.listado.min.js')
    .js('public/js/resources/categorias_.js', 'public/js/categorias.min.js')
    .js('public/js/resources/clientes_.js', 'public/js/clientes.min.js')
    .js('public/js/resources/compras_.js', 'public/js/compras.min.js')
    .js('public/js/resources/compras.nuevo_.js', 'public/js/compras.nuevo.min.js')
    .js('public/js/resources/gastos_.js', 'public/js/gastos.min.js')
    .js('public/js/resources/gastostipos_.js', 'public/js/gastostipos.min.js')
    .js('public/js/resources/ingresos_.js', 'public/js/ingresos.min.js')
    .js('public/js/resources/ingresostipos_.js', 'public/js/ingresostipos.min.js')
    .js('public/js/resources/mostrador_.js', 'public/js/mostrador.min.js')
    .js('public/js/resources/notificacion_.js', 'public/js/notificacion.min.js')
    .js('public/js/resources/proveedores_.js', 'public/js/proveedores.min.js')
    .js('public/js/resources/ventas.edit_.js', 'public/js/ventas.edit.min.js')
    .js('public/js/resources/ventas.index_.js', 'public/js/ventas.index.min.js')
    .js('public/js/resources/ventas.listado_.js', 'public/js/ventas.listado.min.js')
    .js('public/js/resources/ventas.nuevo_.js', 'public/js/ventas.nuevo.min.js')
    .js('public/js/resources/empleados.js', 'public/js/empleados.min.js')


// .sass('resources/sass/app.scss', 'public/css')
//     .sass('resources/sass/toastr.scss', 'public/css/toastr.min.css')
//     .sass('resources/sass/bootstrap4c-chosen.scss', 'public/css/bootstrap4c-chosen.min.css')
//     .sass('resources/sass/chosen-js.scss', 'public/css/chosen-js.min.css')
//     .sass('resources/sass/summernote.scss', 'public/css/summernote.min.css')