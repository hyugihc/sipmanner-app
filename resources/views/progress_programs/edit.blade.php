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
                        <form action="{{ route('progress_programs.update', $progress_program->id) }}" method="POST"
                            id="quickForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Program Intervensi</label>
                                    <label>{{ $progress_program->program_intervensi['nama'] }}</label>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder=""
                                        value="{{ $progress_program->nama }}">
                                </div>


                                <div class="form-group">
                                    <label>Tanggal Kegiatan</label>
                                    <input type="date" name="tanggal_kegiatan" class="form-control" placeholder=""
                                        value="{{ $progress_program->tanggal_kegiatan }}">
                                </div>



                                <div class="form-group">
                                    <label>Progress Kegiatan</label>
                                    <input type="number" name="progress_kegiatan" class="form-control" placeholder=""
                                        value="{{ $progress_program->progress_kegiatan }}">
                                </div>

                                <div class="form-group">
                                    <label>Progress Output</label>
                                    <input type="number" name="progress_output" class="form-control" placeholder=""
                                        value="{{ $progress_program->progress_output }}">
                                </div>

                                <div class="form-group">
                                    <label>Upload Dokumentasi</label>
                                    <input type="file" name="upload_dokumentasi" class="form-control" placeholder=""
                                        value="{{ $progress_program->upload_dokumentasi }}">
                                </div>

                                <div class="form-group">
                                    <label>Upload Bukti Dukung</label>
                                    <input type="file" name="upload_bukti_dukung" class="form-control" placeholder=""
                                        value="{{ $progress_program->upload_bukti_dukung }}">
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="awal_pelaksanaan" class="form-control" placeholder=""
                                        value="{{ $progress_program->keterangan }}">
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
