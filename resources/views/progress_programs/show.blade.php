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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress Program</li>
                        <li class="breadcrumb-item active">{{ $progress_program->nama }}</li>
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
                            <h3 class="card-title">{{ $progress_program->nama }} <small>progress program</small></h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt> Program Intervensi</dt>
                                <dd>{{ $progress_program->program_intervensi['nama'] }}</dd>

                                <dt>Nama</dt>
                                <dd>{{ $progress_program->nama }}</dd>
                                <dt>Tanggal Kegiatan</dt>
                                <dd>{{ $progress_program->tanggal_kegiatan }}</dd>
                                <dt>Progress Kegiatan</dt>
                                <dd>{{ $progress_program->progress_kegiatan }}</dd>
                                <dt>Progress Output</dt>
                                <dd> {{ $progress_program->progress_output }} </dd>
                                <dt>Upload Dokumentasi</dt>
                                <dd> {{ $progress_program->upload_dokumentasi }} </dd>
                                <dt>Upload Bukti Dukung</dt>
                                <dd> {{ $progress_program->upload_bukti_dukung }} </dd>
                                <dt>Keterangan</dt>
                                <dd> {{ $progress_program->keterangan }} </dd>


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

        $('#selectA').on('change', function() {
            var textarea = $('#divtextarea');
            var select = $(this).val();

            textarea.hide();

            if (select == '2') {
                textarea.show();
            }
            if (select == '1') {
                textarea.hide();
            }
        });

    </script>

@endsection
