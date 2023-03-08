@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('users.create') }}">Create</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Rekap Pengguna Aplikasi</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover" id="table_users">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Eselon II</th>
                                    <th>Change Leader</th>
                                    <th>Change Champions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($provinsis as $provinsi)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $provinsi->nama }}</td>
                                        <td>
                                            <!-- / jika provinsi tidak  mempunyai change leader tampilkan kosong, jika punya tampilkan nama change leader -->
                                            @if (!$provinsi->changeLeader()->exists())
                                                -
                                            @else
                                                {{ $provinsi->changeLeader['name'] }}<a
                                                    href="{{ route('revoke_jabatan', $provinsi->changeLeader['id']) }}"> <small>&#60;revoke&#62;</small></a>
                                            @endif


                                        </td>
                                        <td>
                                            @php
                                                $x = 1;
                                            @endphp
                                            @foreach ($provinsi->changeChampions as $cc)
                                                ({{ $x }})
                                                {{ $cc['name'] }} <a
                                                    href="{{ route('revoke_jabatan', $cc['id']) }}"><small>&#60;revoke&#62;</small></a>
                                                <br>
                                                @php
                                                    $x++;
                                                @endphp
                                            @endforeach
                                        </td>
                                        <td>

                                        </td>
                                        @php
                                            $i++;
                                        @endphp
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            @if (Session::has('success'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                // toastr.options =
                // {
                // "closeButton" : true,
                // "progressBar" : false
                // }
                // toastr.error("{{ session('error') }}");
                // @endif

                @if (Session::has('info'))
                    // toastr.options =
                    // {
                    // "closeButton" : true,
                    // "progressBar" : false
                    // }
                    // toastr.info("{{ session('info') }}");
                    // @endif

                    @if (Session::has('warning'))
                        // toastr.options =
                        // {
                        // "closeButton" : true,
                        // "progressBar" : false
                        // }
                        // toastr.warning("{{ session('warning') }}");
                        // @endif
        </script>
    </section>
@endsection
