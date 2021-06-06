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
                            <h3 class="card-title">{{ $intervensiNasional->nama }}   <small>  &nbsp; progress program</small></h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt>Uraian</dt>
                                <dd>{{ $progressIntervensiNasional->uraian_program }}</dd>
                                <dt>Bulan</dt>
                                <dd>{{ $progressIntervensiNasional->bulan }}</dd>
                                <dt>Presentase Program</dt>
                                <dd> {{ $progressIntervensiNasional->presentase_program }} </dd>
                                <dt>Upload Dokumentasi</dt>
                                <dd> {{ $progressIntervensiNasional->upload_dokumentasi }} </dd>
                                <dt>Upload Bukti Dukung</dt>
                                <dd> {{ $progressIntervensiNasional->upload_bukti_dukung }} </dd>
                                <dt>Keterangan</dt>
                                <dd> {{ $progressIntervensiNasional->keterangan }} </dd>


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
