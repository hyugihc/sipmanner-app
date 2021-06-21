@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Progress</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress</li>
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
                            <h3 class="card-title">{{ $intervensiKhusus->nama }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form
                            action="{{ route('progress_intervensi_khususes.update', [$intervensiKhusus, $progressIntervensiKhusus]) }}"
                            method="POST" id="quickForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group" hidden>
                                    <label>Program Intervensi</label>
                                    <select class="form-control" name="intervensi_nasional_id">
                                        <option value="{{ $intervensiKhusus->id }}" selected>
                                            {{ $intervensiKhusus->nama }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Penjelasan progress</label>
                                    <input type="text" name="uraian_program" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiKhusus->uraian_program }}">
                                </div>

                                @error('uraian_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="bulan" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiKhusus->bulan }}">
                                </div>
                                @error('bulan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                                <div class="form-group">
                                    <label>Presentase Capaian Program</label>
                                    <input type="number" name="presentase_program" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiKhusus->presentase_program }}" min="1" max="100">
                                </div>
                                @error('presentase_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Upload Dokumentasi</label>
                                    <a href="{{ route('piks.download.dok', $progressIntervensiKhusus) }}"> Dokumentasi
                                    </a>
                                    <input type="file" accept=".pdf" name="upload_dokumentasi" class="form-control"
                                        placeholder="" value="{{ $progressIntervensiKhusus->upload_dokumentasi }}">
                                </div>

                                <div class="form-group">
                                    <label>Upload Bukti Dukung</label>
                                    <a href="{{ route('piks.download.duk', $progressIntervensiKhusus) }}"> Bukti
                                        Dukung</a>
                                    <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                        placeholder="" value="{{ $progressIntervensiKhusus->upload_bukti_dukung }}">
                                </div>

                                <div class="form-group">
                                    <label>kendala dan keterangan lain</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder=""
                                        value="{{ $progressIntervensiKhusus->keterangan }}">
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
