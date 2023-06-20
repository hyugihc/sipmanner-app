@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Edit Progress</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('progress.index') }}">Progres</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus) }}">{{ $intervensiKhusus->nama }}</a>
                        </li>
                        @if (isset($progressIntervensiKhusus))
                            <li class="breadcrumb-item active">{{ $progressIntervensiKhusus->tanggal }}</li>
                        @else
                            <li class="breadcrumb-item active">Buat Progres</li>
                        @endif
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
                            <h3 class="card-title">Buat Progres {{ $intervensiKhusus->nama }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($progressIntervensiKhusus))
                            <form
                                action="{{ route('intervensi-khususes.progress-intervensi-khususes.update', [$intervensiKhusus, $progressIntervensiKhusus]) }}"
                                method="POST" enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form
                                    action="{{ route('intervensi-khususes.progress-intervensi-khususes.store', $intervensiKhusus) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                        @endif
                        @csrf

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group" hidden>
                                <label>Program Intervensi</label>
                                <select class="form-control" name="intervensi_khusus_id">
                                    <option value="{{ $intervensiKhusus->id }}" selected>
                                        {{ $intervensiKhusus->nama }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Penjelasan progres</label>
                                <textarea type="text" rows="3" name="uraian_program" class="form-control" placeholder="">{{ old('uraian_program', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->uraian_program : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" placeholder=""
                                    value="{{ old('tanggal', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->tanggal : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Realisasi Pelaksanaan Kegiatan %</label>
                                <input type="number" name="realisasi_pelaksanaan_kegiatan" class="form-control"
                                    placeholder=""
                                    value="{{ old('realisasi_pelaksanaan_kegiatan', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->realisasi_pelaksanaan_kegiatan : '') }}"
                                    min="1" max="100">
                            </div>

                            <div class="form-group">
                                <label>Realisasi Capaian Keberhasilan %</label>
                                <input type="number" name="realisasi_capaian_keberhasilan" class="form-control"
                                    placeholder=""
                                    value="{{ old('realisasi_capaian_keberhasilan', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->realisasi_capaian_keberhasilan : '') }}"
                                    min="1" max="100">
                            </div>

                            <div class="form-group">
                                <label>Upload Dokumentasi & Bukti Dukung</label>
                                @if (isset($progressIntervensiKhusus))
                                    <a href="{{ route('piks.download.duk', $progressIntervensiKhusus) }}"> Bukti
                                        Dukung</a>
                                @endif
                                <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                    placeholder="">
                            </div>

                            <div class="form-group">
                                <label>kendala dan keterangan lain</label>
                                <textarea type="text" rows="3" name="keterangan" class="form-control" placeholder="">{{ old('keterangan', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->keterangan : '') }}</textarea>
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                            <input type="submit" class="btn btn-primary" name=" submit">
                        </div>
                        </form>
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



    @endsection
