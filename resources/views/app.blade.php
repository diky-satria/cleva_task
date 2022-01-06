<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- bootstrap css -->
    <link href="{{ asset('bootstrap/bootstrap.css') }}" rel="stylesheet">
    <!-- cssku -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- datatable -->
    <link rel="stylesheet" href="{{ asset('datatable/datatable.css') }}">
    <!-- csrf-token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>cleva</title>
  </head>
  <body>
    
    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">CLEVA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto text-center">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">Karyawan</a>
            <a class="nav-link {{ request()->is('jabatan') ? 'active' : '' }}" href="{{ url('jabatan') }}">Jabatan</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- konten -->
    <div class="container con">
      @yield('konten')
    </div>
    <!-- akhir konten -->

    <!-- bootstrap js -->
    <script src="{{ asset('bootstrap/bootstrap.js') }}"></script>
    <!-- vue js -->
    <script src="{{ asset('vue/vue.js') }}"></script>
    <!-- jquery js -->
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <!-- datatable -->
    <script src="{{ asset('datatable/datatable.js') }}"></script>
    <!-- axios -->
    <script src="{{ asset('axios/axios.js') }}"></script>
    
    <!-- sweetalert -->
    <script src="{{ asset('sweetalert/sweetalert.js') }}"></script>
    <script>
        // berhasil
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            iconColor: 'green',
            background: 'rgb(91, 255, 96)'
        })

        // gagal
        const toastFail = Swal.mixin({
              toast: true,
              position: 'top-start',
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
              },
              iconColor: 'green',
              background: 'rgb(255, 71, 71)'
          })
    </script>

    @stack('js')

  </body>
</html>
