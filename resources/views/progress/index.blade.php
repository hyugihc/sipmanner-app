@extends('layouts.master')

@section('content')

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <script src="{{ asset('') }}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_pins').DataTable();
            $('#table_piks').DataTable();
        });
    </script>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item active">Progres</li>
                    </ol>
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
                        <h3 class="card-title">Program Intervensi Nasional</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover" id="table_pins">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Uraian Kegiatan</th>
                                    <th>Outcome</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($intervensiNasionalProvinsis as $intervensiNasional)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $intervensiNasional->intervensiNasional->nama }}</td>

                                        <td>
                                            {{ $intervensiNasional->intervensiNasional->uraian_kegiatan }}
                                        </td>
                                        <td>
                                            {{ $intervensiNasional->intervensiNasional->outcome }}
                                        </td>
                                        <td>
                                            <a class="btn btn-block btn-primary btn-xs"
                                                href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional->intervensiNasional->id) }}">Show
                                                Progress</a>

                                        </td>

                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Rencana Aksi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover" id="table_piks">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if (Auth::user()->isAdmin())
                                        <th>Satker</th>
                                    @endif
                                    <th>Nama</th>

                                    <th>Change Champions</th>

                                    <th>Output</th>
                                    <th>Outcome</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($intervensiKhususes as $intervensiKhusus)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        @if (Auth::user()->isAdmin())
                                            <td>{{ $intervensiKhusus->provinsi->nama }}</td>
                                        @endif
                                        <td>{{ $intervensiKhusus->nama }}</td>

                                        <td>{{ $intervensiKhusus->user->name }}</td>

                                        <td>
                                            {{ $intervensiKhusus->uraian_kegiatan }}
                                        </td>
                                        <td>
                                            {{ $intervensiKhusus->outcome }}
                                        </td>
                                        <td>
                                            <a class="btn btn-block btn-primary btn-xs"
                                                href="{{ route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus) }}">Show
                                                Progress</a>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
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
                toastr.options = {
                "closeButton": true,
                "progressBar": false
                }
                toastr.success("{{ Session::get('error') }}");
            @endif
        </script>
    </section>
@endsection
