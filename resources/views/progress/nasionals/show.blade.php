@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h1 class="m-0">Dashboard</h1> --}}
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('progress.index') }}">Progres</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional) }}">{{ $intervensiNasional->nama }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $progressIntervensiNasional->getBulan() }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $intervensiNasional->nama }}
                        </h3>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">
                        <dl>
                            <dt>Penjelasan progress</dt>
                            <dd>{{ $progressIntervensiNasional->uraian_program }}</dd>

                            @if ($progressIntervensiNasional->tanggal != null)
                            <dt>Tanggal</dt>
                            <dd>{{ $progressIntervensiNasional->tanggal }}</dd>
                            @else
                            <dt>Bulan</dt>
                            <dd>{{ $progressIntervensiNasional->getBulan() }}</dd>
                            @endif
                            <dt>Realisasi Pelaksanaan Kegiatan %</dt>
                            <dd> {{ $progressIntervensiNasional->realisasi_pelaksanaan_kegiatan }} </dd>

                            @if ($progressIntervensiNasional->upload_dokumentasi != null)
                            <dt>Dokumentasi</dt>
                            <dd> <a href="{{ route('pins.download.dok', $progressIntervensiNasional) }}">
                                    Arsip Dokumentasi</a>
                                @else
                            <dd></dd>
                            @endif
                            <dt>Bukti Dukung</dt>
                            @if ($progressIntervensiNasional->upload_bukti_dukung != null)
                            <dd> <a href="{{ route('pins.download.duk', $progressIntervensiNasional) }}"> Arsip
                                    Bukti
                                    Dukung</a>
                                @else
                            <dd>Belum ada bukti dukung yang di upload</dd>
                            @endif
                            <dt>kendala dan keterangan lain</dt>
                            <dd> {{ $progressIntervensiNasional->keterangan }} </dd>
                            <dt>Status</dt>
                            <dd>{{ $progressIntervensiNasional->getStatus() }}</dd>



                        </dl>


                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
</section>

<script>
    $(document).ready(function() {
        var textarea = $('#divtextarea');
        textarea.hide();
    });
</script>
@endsection