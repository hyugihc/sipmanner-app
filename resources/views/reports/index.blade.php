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
                        Create
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
                        <h3 class="card-title">Data</h3>

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
                                        <td>{{ $report->updated_at }}</td>
                                        <td>{{ $report->user['name'] }}</td>
                                        <td>{{ $report->getStatus() }}
                                            @if ($report->status == 1)
                                                <br> <span class="badge badge-info right">Perlu Tindakan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('view', $report)
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('reports.show', $report) }}">Show</a>
                                            @endcan
                                            @can('update', $report)
                                                <a class="btn btn-block btn-warning btn-xs"
                                                    href="{{ route('reports.edit', $report) }}">Edit</a>
                                            @endcan

                                            @can('delete', $report)
                                                <form action="{{ route('reports.destroy', $report) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                                        class="btn btn-block btn-danger btn-xs"
                                                        style="margin-top: 10px">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- <tr>
                                    @if (Auth::user()->isChangeLeader() and ($reportSm1->status == 0 or $reportSm1->status == 3))
                                        <td>{{ $reportSm1->tahun }}</td>
                                        <td>{{ $reportSm1->semester }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>Belum tersedia</td>
                                        <td>-</td>
                                    @else
                                        <td>{{ $reportSm1->tahun }}</td>
                                        <td>{{ $reportSm1->semester }}</td>
                                        <td>{{ $reportSm1->updated_at }}</td>
                                        <td>
                                            @if ($reportSm1->user_id != null)
                                                {{ $reportSm1->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @switch($reportSm1->status)
                                                @case(0)
                                                    draft
                                                @break
                                                @case(1)
                                                    submitted
                                                @break
                                                @case(2)
                                                    approved
                                                @break
                                                @case(3)
                                                    rejected
                                                @break
                                                @default

                                            @endswitch
                                        </td>
                                        <td>
                                            @can('view', $reportSm1)
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('reports.show', $reportSm1) }}">Show</a>
                                            @endcan
                                            @can('update', $reportSm1)
                                                <a class="btn btn-block btn-warning btn-xs"
                                                    href="{{ route('reports.edit', $reportSm1) }}">Edit</a>
                                            @endcan
                                        </td>

                                    @endif

                                </tr>
                                <tr>
                                    @if (Auth::user()->isChangeLeader() and ($reportSm2->status == 0 or $reportSm2->status == 3))
                                        <td>{{ $reportSm2->tahun }}</td>
                                        <td>{{ $reportSm2->semester }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>Belum tersedia</td>
                                        <td>-</td>
                                    @else
                                        <td>{{ $reportSm2->tahun }}</td>
                                        <td>{{ $reportSm2->semester }}</td>
                                        <td>{{ $reportSm2->updated_at }}</td>
                                        <td>
                                            @if ($reportSm2->user_id != null)
                                                {{ $reportSm2->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @switch($reportSm2->status)
                                                @case(0)
                                                    draft
                                                @break
                                                @case(1)
                                                    submitted
                                                @break
                                                @case(2)
                                                    approved
                                                @break
                                                @case(3)
                                                    rejected
                                                @break
                                                @default

                                            @endswitch
                                        </td>
                                        <td>
                                            @can('view', $reportSm2)
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('reports.show', $reportSm2) }}">Show</a>
                                            @endcan
                                            @can('update', $reportSm2)
                                                <a class="btn btn-block btn-warning btn-xs"
                                                    href="{{ route('reports.edit', $reportSm2) }}">Edit</a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr> --}}

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
                        <h4 class="modal-title">Buat laporan</h4>
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
                            href="{{ route('reports.create.laporan', ['2021', '1']) }}">Semester
                            1 tahun 2021</a>
                        <a class="btn btn-outline-light"
                            href="{{ route('reports.create.laporan', ['2021', '2']) }}">Semester
                            2 tahun 2021</a>

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
