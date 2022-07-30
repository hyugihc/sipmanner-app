@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
                        Upload
                    </button>
                </div><!-- /.col -->
                <div class="col-sm-4">
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Laporan Tahun 2021</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Semester</th>
                                    <th>Tanggal Modified</th>
                                    <th>Last Modified by</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{ $report->tahun }}</td>
                                        <td>{{ $report->semester }}</td>
                                        <td>{{ date('d-m-Y', strtotime($report->updated_at)) }}</td>
                                        <td>
                                            @if ($report->user_id == null)
                                                -
                                            @else
                                                {{ $report->user->name }}
                                            @endif


                                        </td>
                                        <td>
                                            @if ($report->status == 0)
                                                Belum ada laporan
                                                <br> <span class="badge badge-warning right">Belum Upload Softcopy</span>
                                            @endif
                                            @if ($report->status == 4)
                                                Sudah ada laporan
                                                <br> <span class="badge badge-success right">Sudah Upload Softcopy</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($report->status == 0)
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('reports.2021.show', $report) }}">Upload</a>
                                            @endif
                                            @if ($report->status == 4)
                                                <a href="{{ route('reports.download-laporan', $report) }}"
                                                    class="btn btn-success "><i class="fas fa-download"></i>
                                                    Unduh Laporan</a>
                                            @endif

                                        </td>
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

        <div class="modal fade" id="modal-primary">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload laporan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Setiap semester setiap satuan kerja membuat laporan terkait rencana aksi yang dibuatnya</p>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button> --}}

                        <a class="btn btn-outline-light"
                            href="{{ route('reports.create.laporan', [Auth::user()->getSetting('tahun'), '1']) }}">Semester
                            1 tahun {{ Auth::user()->getSetting('tahun') }}</a>
                        <a class="btn btn-outline-light"
                            href="{{ route('reports.create.laporan', [Auth::user()->getSetting('tahun'), '2']) }}">Semester
                            2 tahun {{ Auth::user()->getSetting('tahun') }}</a>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

            @if (Session::has('warning'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.warning("{{ Session::get('warning') }}");
            @endif
        </script>


    </section>
@endsection
