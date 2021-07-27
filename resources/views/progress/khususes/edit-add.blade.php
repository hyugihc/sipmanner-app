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
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress</li>
                    </ol> --}}
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
                            <h3 class="card-title">{{ $intervensiKhusus->nama }}</h3>
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
                                <label>Penjelasan progress</label>
                                <input type="text" name="uraian_program" class="form-control" placeholder=""
                                    value="{{ old('uraian_program', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->uraian_program : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="bulan" class="form-control" placeholder=""
                                    value="{{ old('bulan', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->bulan : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Presentase Capaian Program</label>
                                <input type="number" name="presentase_program" class="form-control" placeholder=""
                                    value="{{ old('presentase_program', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->presentase_program : '') }}"
                                    min="1" max="100">
                            </div>

                            <div class="form-group">
                                <label>Upload Dokumentasi</label>
                                @if (isset($progressIntervensiKhusus))
                                    <a href="{{ route('piks.download.dok', $progressIntervensiKhusus) }}"> Dokumentasi
                                    </a>
                                @endif
                                <input type="file" accept=".pdf" name="upload_dokumentasi" class="form-control"
                                    placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Upload Bukti Dukung</label>
                                @if (isset($progressIntervensiKhusus))
                                    <a href="{{ route('piks.download.duk', $progressIntervensiKhusus) }}"> Bukti
                                        Dukung</a>
                                @endif
                                <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                    placeholder="">
                            </div>

                            <div class="form-group">
                                <label>kendala dan keterangan lain</label>
                                <input type="text" name="keterangan" class="form-control" placeholder=""
                                    value="{{ old('keterangan', isset($progressIntervensiKhusus) ? $progressIntervensiKhusus->keterangan : '') }}">
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
