<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>@yield('pagetitle',__('admin.dashboard'))</title>

  <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/admin-list.css') }}" rel="stylesheet">
  @stack('styles')

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    @include('admin.parts.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        @include('admin.parts.topbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

          @yield('pageheading')

          <!-- Begin error display -->
          @if (session('success'))
              <div class="alert alert-success">
                  <span>{{ session('success') }}</span>
              </div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger">        
              <span>{{ session('error') }}</span>
          </div>
          @endif

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="nav flex-column">
                      @foreach ($errors->all() as $error)
                          <li class="nav-item">{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; {{ config('app.name') }} 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.ready_to_leave') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">{{ __('admin.select_logout') }}</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('admin.cancel') }}</button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit">{{ __('admin.logout') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom scripts for all admin pages-->
  <script src="{{ asset('js/admin.js') }}"></script>
  @stack('scripts')

</body>

</html>
