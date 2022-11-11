<script defer src="{{  asset('assets/vendors/jquery/jquery.min.js') }}"></script>
<script defer src="{{  asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script defer src="{{  asset('assets/js/bootstrap.bundle.min.js') }}"></script>




<script defer src="{{  asset('assets/js/main.js') }}"></script>
<script defer src="{{  asset('assets/vendors/choices.js/choices.min.js') }}"></script>


{{-- <script src="{{  asset('js/resources/notificacion.js')}}"> </script> --}}
@can("notificacion-index")
<script defer src="{{  asset('js/notificacion.min.js')}}"> </script>
@endcan