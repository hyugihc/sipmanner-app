<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sipmanner-app</title>

    <link rel="icon" href="{{ asset('') }}assets/dist/img/top.png">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                            <option value="2022">2022</option>
                            <option value="2023" selected>2023</option>
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
            <strong>Copyright &copy; 2023 <a href="https://bps.go.id">Transformasi Statistik BPS</a>.</strong>

            <div class=" d-none d-sm-inline-block">
                <b>Version</b> 2.2.0
            </div>
        </div>
    </div>
    <!-- /.center -->
    <!-- Main content -->
    <br>
    <br>

    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-6">
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Change Log</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        Update 2.2.0
                        <ul>
                            {{-- judul --}}
                            <li> menu <b>Rekap Laporan</b></li>
                            <li> pilihan <b> Batalkan Pengajuan</b> pada <b>Laporan</b></li>

                        </ul>
                        Versi 2.2.0
                        <ul>
                            {{-- judul --}}
                            <li> submit <b>Progres</b> tidak perlu persetujuan Change Leader</li>
                            <li> submit <b> Data CAN</b> tidak perlu persetujuan Change Leader</li>
                            <li>Menggabungkan input dokumentasi dan bukti dukung pada menu <b>Progres</b></li>
                            <li>Penambahan Fitur Pencarian by Nama pada menu <b>Data</b></li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
        </div>
    </div>

    <!-- /.content -->

    <!-- jQuery -->
    <script src="{{ asset('') }}assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('') }}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr -->
    <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

    <script>
        @if(Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": false
        }
        toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>

</html>