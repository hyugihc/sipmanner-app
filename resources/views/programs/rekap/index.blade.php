@extends('layouts.master')


@section('content')
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('') }}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">


                </div><!-- /.col -->
                <div class="col-sm-4">
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item active">Rekap</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        @foreach ($provinsis as $provinsi)
            <div class="row">
                <div class="col-12">

                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>

                                    [{{ $provinsi->kode_provinsi }}] - {{ $provinsi->nama }}
                                    <small class="float-right"></small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-6 invoice-col">
                                <address>
                                    <strong>Change Leader</strong><br>
                                    @if (!$provinsi->changeLeader()->exists())
                                        tidak ada change leader
                                    @else
                                        {{ $provinsi->changeLeader['name'] }}
                                    @endif
                                </address>
                            </div>

                            <!-- /.col -->
                            <div class="col-sm-6 invoice-col">
                                <b>Jumlah Change Champions:</b>
                                @if (!$provinsi->changeChampions()->exists())
                                    tidak ada change champion <br>
                                @else
                                    {{ $provinsi->changeChampions->count() }} <br>
                                @endif


                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        @if (!$provinsi->changeChampions()->exists())
                            <p>Belum ada Change Champion</p>
                        @else
                            @foreach ($provinsi->changeChampions as $cc)
                                <div class="row invoice-info">
                                    <div class="col-sm-6 invoice-col">
                                        <address>
                                            <strong>Change Champions: </strong>{{ $cc->name }}<br>
                                        </address>
                                    </div>
                                </div>


                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Rencana Aksi</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Realisasi Terakhir</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($cc->intervensi_khususes_by_year->count() > 0)
                                                    @foreach ($cc->intervensi_khususes_by_year as $intervensi)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $intervensi->nama }}</td>
                                                            <td>{{ $intervensi->uraian_kegiatan }}</td>
                                                            <td>{{ $intervensi->getStatus() }}</td>
                                                            <td>
                                                                @if (!$intervensi->getRealisasiTerakhir() == null)
                                                                    {{ $intervensi->getRealisasiTerakhir() }}
                                                                @else
                                                                    0
                                                                @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5"> belum ada rencana aksi</td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            @endforeach
                        @endif
                    </div>


                </div>
            </div>
        @endforeach


        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            // $(document).ready(function() {
            //     $('#table_renaksi').DataTable();
            // });
        </script>

    </section>
@endsection
