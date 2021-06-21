@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress Program</li>
                        <li class="breadcrumb-item active">{{ $intervensiNasional->nama }}</li>
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
                            <h3 class="card-title">{{ $intervensiNasional->nama }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form
                            action="{{ route('progress_intervensi_nasionals.update', [$intervensiNasional, $progressIntervensiNasional]) }}"
                            method="POST" id="quickForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group" hidden>
                                    <label>Program Intervensi</label>
                                    <select class="form-control" name="intervensi_nasional_id">
                                        <option value="{{ $intervensiNasional->id }}" selected>
                                            {{ $intervensiNasional->nama }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Penjelasan Progress</label>
                                    <input type="text" name="uraian_program" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiNasional->uraian_program }}">
                                </div>

                                @error('uraian_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select class="form-control" name="bulan" id="">
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>

                                @error('bulan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Persentase Capaian Program</label>
                                    <input type="number" name="presentase_program" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiNasional->presentase_program }}" min="1" max="100">
                                </div>

                                @error('presentase_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Upload Dokumentasi</label>
                                    <a href="{{ route('pins.download.dok', $progressIntervensiNasional) }}"> Dokumentasi
                                    </a>
                                    <input type="file" accept=".pdf" name="upload_dokumentasi" class="form-control"
                                        placeholder="" value="{{ $progressIntervensiNasional->upload_dokumentasi }}">
                                </div>

                                @error('upload_dokumentasi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Upload Bukti Dukung</label>
                                    <a href="{{ route('pins.download.duk', $progressIntervensiNasional) }}">Bukti Dukung
                                    </a>
                                    <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                        placeholder="" value="{{ $progressIntervensiNasional->upload_bukti_dukung }}">
                                </div>

                                @error('upload_bukti_dukung')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>kendala dan keterangan lain</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiNasional->keterangan }}">
                                </div>

                                @error('keterangan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


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
