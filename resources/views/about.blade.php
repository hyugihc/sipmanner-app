<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sipmanner-app</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('') }}plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('') }}assets/dist/css/adminlte.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <i class="bi bi-gear-fill"></i><a href="#">SIP<b>MANNER</b></a>
        </div>

        <!-- form start -->
        <form action="{{ route('settings.tahun', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="{{ asset('') }}assets/dist/img/AdminLTELogo.png" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <div class="lockscreen-credentials">
                    <div class="input-group">
                        <select name="tahun" class="form-control select2" style="width: 100%;">
                            <option value="2021">2021</option>
                            <option value="2022" selected>2022</option>
                        </select>

                    </div>
                </div>
                <!-- /.lockscreen credentials -->


            </div>
            <!-- /.lockscreen-item -->

            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-arrow-right text-muted"></i> Simpan
                </button>
            </div>

        </form>

        {{-- <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
            <a href="login.html">Or sign in as a different user</a>
        </div> --}}

        <div class="lockscreen-footer text-center">
            <strong>Copyright &copy; 2021 <a href="https://bps.go.id">Transformasi Statistik BPS</a>.</strong>

            <div class=" d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </div>
    </div>
    <!-- /.center -->

    <!-- jQuery -->
    <script src="{{ asset('') }}assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('') }}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr -->
    <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

    <script>
        @if (Session::has('success'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : false
            }
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>

</html>
