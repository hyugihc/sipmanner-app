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
                                <dt>Penjelasan progress</dt>
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
                                <dt>Presentase Capaian Program</dt>
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
                                    <dd> <a href="{{ route('pins.download.duk', $progressIntervensiNasional) }}"> Arsip
                                            Bukti
                                            Dukung</a>
                                    @else
                                    <dd>Belum ada bukti dukung yang di upload</dd>
                                @endif
                                <dt>kendala dan keterangan lain</dt>
                                <dd> {{ $progressIntervensiNasional->keterangan }} </dd>
                                <dt>Status</dt>
                                @switch($progressIntervensiNasional->status)
                                    @case(1)
                                        <dl> Submitted</dl>
                                    @break
                                    @case(2)
                                        <dl> Approved</dl>
                                    @break
                                    @case(3)
                                        <dl> Rejected</dl>
                                        <dl> {{ $progressIntervensiNasional->alasan }}</dl>
                                    @break
                                    @default
                                @endswitch

                                <!-- form start -->
                                <form action="{{ route('pins.approve', $progressIntervensiNasional) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @can('approve', $progressIntervensiNasional)
                                        <div class="form-group">
                                            <label>Tindakan</label>
                                            <select id="selectA" class="form-control" name="status">
                                                <option value="2">Setuju</option>
                                                <option value="3">Tidak Setuju</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="divtextarea">
                                            <label>Alasan</label>
                                            <textarea type="text" name="alasan"
                                                value="{{ $progressIntervensiNasional->alasan }}" class="form-control"
                                                placeholder=""></textarea>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    @endcan
                                </form>

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

            if (select == '3') {
                textarea.show();
            }
            if (select == '2') {
                textarea.hide();
            }
        });
    </script>

@endsection
