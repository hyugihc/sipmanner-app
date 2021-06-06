@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
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
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('progress_intervensi_nasionals.store', $intervensiKhusus) }}" method="POST"
                            id="quickForm">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
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


                                <div class="form-group">
                                    <label>Bulan</label>
                                    <input type="date" name="bulan" class="form-control" placeholder="">
                                </div>



                                <div class="form-group">
                                    <label>Presentase Program</label>
                                    <input type="number" name="presentase_program" class="form-control" placeholder="">
                                </div>


                                <div class="form-group">
                                    <label>Upload Dokumentasi</label>
                                    <input type="file" name="upload_dokumentasi" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Upload Bukti Dukung</label>
                                    <input type="file" name="upload_bukti_dukung" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder="">
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
