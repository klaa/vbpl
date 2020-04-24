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

<body class="bg-gradient-primary">
    
    @yield('content')

    <!-- Custom scripts for all admin pages-->
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')

</body>

</html>