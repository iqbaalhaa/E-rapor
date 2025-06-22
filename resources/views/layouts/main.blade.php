<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>E-Rapor | MTsN 3 Indragiri Hilir</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('template/vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('template/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('template/vendors/mdi/css/materialdesignicons.min.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('template/js/select.dataTables.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('template/css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('template/images/favicon.png')}}" />
  @stack('styles')
</head>
<body>
  <div class="container-scroller">
    
    {{-- Include Navbar --}}
    @include('partials.navbar')

    <div class="container-fluid page-body-wrapper">
      
      {{-- Include Sidebar --}}
      @include('partials.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        
        {{-- Include Footer --}}
        @include('partials.footer')
      </div>
    </div>
  </div>

  <!-- plugins:js -->
  <script src="{{asset('template/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset('template/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('template/vendors/datatables.net/jquery.dataTables.js')}}"></script>
  <script src="{{asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('template/js/dataTables.select.min.js')}}"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('template/js/off-canvas.js')}}"></script>
  <script src="{{asset('template/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('template/js/template.js')}}"></script>
  <script src="{{asset('template/js/settings.js')}}"></script>
  <script src="{{asset('template/js/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('template/js/dashboard.js')}}"></script>
  <script src="{{asset('template/js/Chart.roundedBarCharts.js')}}"></script>
  <!-- End custom js for this page-->

  @stack('scripts')
</body>
</html>