@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        
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
                             
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $provinsi->nama }}</td>
                                        <td>
                                            <!-- / jika provinsi tidak  mempunyai change leader tampilkan kosong, jika punya tampilkan nama change leader -->
                                            @if (!$provinsi->changeLeader()->exists())
                                                -
                                            @else
                                                {{ $provinsi->changeLeader['name'] }} <br>
                                                ({{$provinsi->changeLeader['email']}})
                                            @endif


                                        </td>
                                        <td>
                                            @php
                                                $x = 1;
                                            @endphp
                                            @foreach ($provinsi->changeChampions as $cc)
                                            
                                                {{ $cc['name'] }} <br>
                                                ({{$cc['email']}})
                                                <br>
                                                @php
                                                    $x++;
                                                @endphp
                                            @endforeach
                                        </td>
                                        <td>

                                        </td>
                                   
                                    </tr>



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
