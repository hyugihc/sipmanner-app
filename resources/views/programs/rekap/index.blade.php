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

                    <div id="{{ $provinsi->kode_provinsi }}" class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> [{{ $provinsi->kode_provinsi }}] - {{ $provinsi->nama }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div>
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

                                        <address>
                                            <strong>Change Champions</strong><br>
                                            @if (!$provinsi->changeChampions()->exists())
                                                tidak ada Change Champions
                                            @else
                                                @foreach ($provinsi->changeChampions as $cc)
                                                    {{ $cc->name }} <br>
                                                @endforeach
                                            @endif
                                        </address>


                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                @if (!$provinsi->changeChampions()->exists())
                                    <p>Belum ada Change Champion</p>
                                @else
                                    <!-- Text center -->
                                    <div class="text-center">
                                        <h6>Program Intervensi Nasional</h6>
                                    </div>
                                    <!-- Table intervensi nasional row -->
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 20%">Nama Intervensi Nasional</th>
                                                        <th style="width: 53%">Ukuran Keberhasilan</th>
                                                        <th style="width: 7%">Status</th>

                                                        <th style="width: 7%">Realisasi Terakhir</th>
                                                        <th style="width: 8%">Aksi</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($provinsi->intervensi_nasional_provinsi_by_year->count() > 0)
                                                        @foreach ($provinsi->intervensi_nasional_provinsi_by_year as $intervensi)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $intervensi->intervensiNasional->nama }}</td>
                                                                <td>{{ $intervensi->ukuran_keberhasilan }}</td>
                                                                <td>{{ $intervensi->getStatus() }}</td>

                                                                <td>
                                                                    @if (!$intervensi->getRealisasiTerakhir() == null)
                                                                        {{ $intervensi->getRealisasiTerakhir() }} %
                                                                    @else
                                                                        0 %
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @can('view', $intervensi->intervensiNasional)
                                                                        <a class="btn btn-block btn-primary btn-xs "
                                                                            style="width: 100%;
                                                                            href="{{ route('intervensi-nasionals.show', $intervensi->intervensiNasional) }}">Show</a>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5">Belum Ada Intervensi Nasional</td>
                                                        </tr>
                                                    @endif



                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.table intervensi nasional -->
                                    <!-- Text center -->
                                    <br>
                                    @foreach ($provinsi->changeChampions as $cc)
                                        <div class="text-center">
                                            <h6>Rencana Aksi oleh {{ $cc->name }}</h6>
                                        </div>

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%">No</th>
                                                            <th style="width: 20%">Nama Rencana Aksi</th>
                                                            <th style="width: 53%">Keterangan</th>
                                                            <th style="width: 5%">Status</th>
                                                            <th style="width: 7%">Realisasi Terakhir</th>
                                                            <th style="width: 8%">Aksi</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($cc->intervensi_khususes_by_year->count() > 0)
                                                            @foreach ($cc->intervensi_khususes_by_year as $intervensi)
                                                                <tr class='clickable-row'
                                                                    data-href='{{ route('intervensi-khususes.show', $intervensi) }}'>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $intervensi->nama }}</td>
                                                                    <td>{{ $intervensi->uraian_kegiatan }}</td>
                                                                    <td>{{ $intervensi->getStatus() }}</td>
                                                                    <td>
                                                                        @if (!$intervensi->getRealisasiTerakhir() == null)
                                                                            {{ $intervensi->getRealisasiTerakhir() }} %
                                                                        @else
                                                                            0 %
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @can('view', $intervensi)
                                                                            <a class="btn btn-block btn-primary btn-xs"
                                                                                style="width: 100%;"
                                                                                href="{{ route('intervensi-khususes.show', $intervensi) }}">Show</a>
                                                                        @endcan
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="5"> Belum Ada Rencana Aksi</td>
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
                </div>
            </div>
        @endforeach


        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            jQuery(document).ready(function($) {
                $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            });
        </script>

    </section>
@endsection
