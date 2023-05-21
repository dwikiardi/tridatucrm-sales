
@include('layouts/header')

<div class="page-wrapper">
  <div class="container-xl">
    <!-- Page title -->
    @yield('content_header')
   
  </div>
  <!-- BEGIN BODY -->
  <div class="page-body">
  @yield('content')
  </div>
  <!-- END BODY -->

  @include('layouts/footer')
</div>
</div>

</div>
<!-- Libs JS -->
<script src="{{asset('public/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<!-- Tabler Core -->
<script src="{{asset('public/js/tabler.min.js')}}"></script>
<script src="{{asset('public/js/demo.min.js')}}"></script>

@stack('js')

</body>
</html>