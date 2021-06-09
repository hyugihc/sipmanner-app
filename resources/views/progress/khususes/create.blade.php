@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Progress</h1>
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
                            <h3 class="card-title"> {{$intervensiKhusus->nama}} </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('progress_intervensi_khususes.store', $intervensiKhusus) }}" method="POST"
                            id="quickForm" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                <div class="form-group" hidden>
                                    <label>Program Intervensi</label>
                                    <select class="form-control" name="intervensi_khusus_id">
                                        <option value="{{ $intervensiKhusus->id }}">
                                            {{ $intervensiKhusus->nama }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Uraian Kegiatan</label>
                                    <input type="text" name="uraian_program" class="form-control" placeholder="">
                                </div>
                                @error('uraian_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="bulan" class="form-control" placeholder="">
                                </div>

                                @error('bulan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                                <div class="form-group">
                                    <label>Presentase Program</label>
                                    <input type="number" name="presentase_program" class="form-control" placeholder=""
                                        min="1" max="100">
                                </div>
                                @error('presentase_program')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Upload Dokumentasi</label>
                                    <input type="file" accept=".pdf" name="upload_dokumentasi" class="form-control"
                                        placeholder="">
                                </div>
                                @error('upload_dokumentasi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label>Upload Bukti Dukung</label>
                                    <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                        placeholder="">
                                </div>
                                @error('upload_bukti_dukung')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder="">
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
