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
                        <li class="breadcrumb-item active">Program Intervensi</li>
                        <li class="breadcrumb-item active">{{ $program_intervensi->nama }}</li>
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
                            <h3 class="card-title">{{ $program_intervensi->nama }} <small>program intervensi</small></h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt> Jenis</dt>
                                @if ($program_intervensi->jenis == 1)
                                    <dd>Program Intervensi Nasional</dd>
                                @else
                                    <dd>Program Intervensi Khusus</dd>
                                @endif
                                <dt>Nama Program Intervensi</dt>
                                <dd>{{ $program_intervensi->nama }}</dd>
                                <dt>Uraian Kegiatan</dt>
                                <dd>{{ $program_intervensi->uraian_kegiatan }}</dd>
                                <dt>Nilai Pia</dt>
                                @foreach ($program_intervensi->pias as $pia)
                                    <dd>{{ $pia->nama }}</dd>
                                @endforeach

                                <dt>Volume Kegiatan setahun</dt>
                                <dd>{{ $program_intervensi->vol_keg_tahun }}</dd>
                                <dt>Output</dt>
                                <dd> {{ $program_intervensi->output }} </dd>
                                <dt>Outcome</dt>
                                <dd> {{ $program_intervensi->outcome }} </dd>

                                <dt>Awal Pelaksanaan</dt>
                                <dd> {{ $program_intervensi->awal_pelaksanaan }} </dd>
                                <dt>Selesai Pelaksanaan</dt>
                                <dd> {{ $program_intervensi->selesai_pelaksanaan }} </dd>
                                <dt>keterangan</dt>
                                <dd> {{ $program_intervensi->keterangan }} </dd>


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
