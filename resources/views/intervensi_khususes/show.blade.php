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
                        <li class="breadcrumb-item active">Program Intervensi Khusus</li>
                        <li class="breadcrumb-item active">{{ $intervensiKhusus->nama }}</li>
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
                            <h3 class="card-title">{{ $intervensiKhusus->nama }} <small>program intervensi</small></h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt> Jenis</dt>
                                <dd>Program Intervensi Khusus</dd>
                                <dt>Nama Program Intervensi</dt>
                                <dd>{{ $intervensiKhusus->nama }}</dd>
                                <dt>Uraian Kegiatan</dt>
                                <dd>{{ $intervensiKhusus->uraian_kegiatan }}</dd>
                                <dt>Volume Kegiatan setahun</dt>
                                <dd>{{ $intervensiKhusus->volume }}</dd>
                                <dt>Nilai Pia</dt>
                                @foreach ($intervensiKhusus->pias as $pia)
                                    <dd>{{ $pia->nama }}</dd>
                                @endforeach
                                <dt>Output</dt>
                                <dd> {{ $intervensiKhusus->output }} </dd>
                                <dt>Outcome</dt>
                                <dd> {{ $intervensiKhusus->outcome }} </dd>
                                <dt>keterangan</dt>
                                <dd> {{ $intervensiKhusus->keterangan }} </dd>
                                <dt>keterangan</dt>
                                <dd> {{ $intervensiKhusus->status }} </dd>
                                <dt>Unit Kerja</dt>
                                <dd> {{ $intervensiKhusus->provinsi['nama'] }} </dd>


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
