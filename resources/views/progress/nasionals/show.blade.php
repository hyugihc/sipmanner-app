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
                            <h3 class="card-title">{{ $intervensiNasional->nama }}
                            </h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt>Uraian</dt>
                                <dd>{{ $progressIntervensiNasional->uraian_program }}</dd>
                                <dt>Bulan</dt>
                                @switch($progressIntervensiNasional->bulan)
                                    @case(1)
                                        Januari
                                    @break
                                    @case(2)
                                        Februari
                                    @break
                                    @case(3)
                                        Maret
                                    @break
                                    @case(4)
                                        April
                                    @break
                                    @case(5)
                                        Mei
                                    @break
                                    @case(6)
                                        Juni
                                    @break
                                    @case(7)
                                        Juli
                                    @break
                                    @case(8)
                                        Agustus
                                    @break
                                    @case(9)
                                        September
                                    @break
                                    @case(10)
                                        Oktober
                                    @break
                                    @case(11)
                                        November
                                    @break
                                    @case(12)
                                        Desember
                                    @break

                                    @default

                                @endswitch
                                <dt>Presentase Program</dt>
                                <dd> {{ $progressIntervensiNasional->presentase_program }} </dd>
                                <dt>Dokumentasi</dt>
                                @if ($progressIntervensiNasional->upload_dokumentasi != null)
                                    <dd> <a href="{{ route('pins.download.dok', $progressIntervensiNasional) }}">
                                            Arsip Dokumentasi</a>
                                    @else
                                    <dd>Belum ada dokumentasi yang di upload</dd>
                                @endif
                                <dt>Bukti Dukung</dt>
                                @if ($progressIntervensiNasional->upload_bukti_dukung != null)
                                    <dd> <a href="{{ route('pins.download.duk', $progressIntervensiNasional) }}"> Arsip Bukti
                                            Dukung</a>
                                    @else
                                    <dd>Belum ada bukti dukung yang di upload</dd>
                                @endif
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
