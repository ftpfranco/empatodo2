<!DOCTYPE html>
<html lang="es">

<head>
    @include('partials.head')
    <meta name="google" content="notranslate" />

    @if (env('APP_ENV') !== 'local')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLDCDCQ1Y"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-PWLDCDCQ1Y');
        </script>
    @endif

</head>

<body>
    <div id="app">

        
        @include('partials.sidebar')

        <div id="main" class='layout-navbar'>

            @include('partials.header')

            <div id="main-content mx-0">
                @yield('content')

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start mx-3">
                            <p> {{ date('Y') }} &copy; FH</p>
                        </div>

                        {{-- <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="http://ahmadsaugi.com">FH</a></p>
                        </div> --}}
                    </div>
                </footer>
            </div>


        </div>
    </div>


    @include('partials.scripts')
    @yield('scripts')

</body>

</html>
