@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Edit</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('progress.index') }}">Progres</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional) }}">{{ $intervensiNasional->nama }}</a>
                        </li>
                        @if (isset($progressIntervensiNasional))
                            <li class="breadcrumb-item active">{{ $progressIntervensiNasional->getBulan() }}</li>
                        @else
                            <li class="breadcrumb-item active">Create</li>
                        @endif
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

                            <h3 class="card-title">
                                {{ isset($progressIntervensiNasional) ? 'Edit progres' . $intervensiNasional->nama : 'Create progres ' . $intervensiNasional->nama }}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($progressIntervensiNasional))
                            <form
                                action="{{ route('intervensi-nasionals.progress-intervensi-nasionals.update', [$intervensiNasional, $progressIntervensiNasional]) }}"
                                method="POST" enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form
                                    action="{{ route('intervensi-nasionals.progress-intervensi-nasionals.store', $intervensiNasional) }}"
                                    method="POST" enctype="multipart/form-data">
                        @endif
                        @csrf

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @if (isset($progressIntervensiNasional))
                                <div class="form-group" hidden>
                                    <label>Program Intervensi</label>
                                    <select class="form-control" name="intervensi_nasional_id">
                                        <option value="{{ $intervensiNasional->id }}" selected>
                                            {{ $intervensiNasional->nama }}</option>
                                    </select>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Penjelasan Progress</label>
                                <textarea type="text" name="uraian_program" class="form-control"
                                    placeholder="">{{ old('uraian_program', isset($progressIntervensiNasional) ? $progressIntervensiNasional->uraian_program : '') }}</textarea>
                            </div>



                            <div class="form-group">
                                <label>Bulan</label>
                                <select class="form-control" name="bulan" id="">
                                    <option value="1" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 1)
                                        selected='selected' @endif @endisset>Januari</option>
                                    <option value="2" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 2)
                                        selected='selected' @endif @endisset>Februari</option>
                                    <option value="3" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 3)
                                        selected='selected' @endif @endisset>Maret</option>
                                    <option value="4" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 4)
                                        selected='selected' @endif @endisset>April</option>
                                    <option value="5" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 5)
                                        selected='selected' @endif @endisset>Mei</option>
                                    <option value="6" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 6)
                                        selected='selected' @endif @endisset>Juni</option>
                                    <option value="7" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 7)
                                        selected='selected' @endif @endisset>Juli</option>
                                    <option value="8" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 8)
                                        selected='selected' @endif @endisset>Agustus</option>
                                    <option value="9" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 9)
                                        selected='selected' @endif @endisset>September</option>
                                    <option value="10" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 10)
                                        selected='selected' @endif @endisset>Oktober</option>
                                    <option value="11" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 11)
                                        selected='selected' @endif @endisset>November</option>
                                    <option value="12" @isset($progressIntervensiNasional) @if ($progressIntervensiNasional->bulan == 12)
                                        selected='selected' @endif @endisset>Desember</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Realisasi Pelaksanaan Kegiatan</label>
                                <input type="number" name="realisasi_pelaksanaan_kegiatan" class="form-control"
                                    placeholder=""
                                    value="{{ old('realisasi_pelaksanaan_kegiatan', isset($progressIntervensiNasional) ? $progressIntervensiNasional->realisasi_pelaksanaan_kegiatan : '') }}"
                                    min="1" max="100">
                            </div>



                            <div class="form-group">
                                <label>Upload Dokumentasi</label>
                                @if (isset($progressIntervensiNasional))
                                    <a href="{{ route('pins.download.dok', $progressIntervensiNasional) }}"> Dokumentasi
                                    </a>
                                @endif
                                <input type="file" accept=".pdf" name="upload_dokumentasi" class="form-control"
                                    placeholder="" value="">
                            </div>


                            <div class="form-group">
                                <label>Upload Bukti Dukung</label>
                                @if (isset($progressIntervensiNasional))
                                    <a href="{{ route('pins.download.duk', $progressIntervensiNasional) }}">Bukti Dukung
                                    </a>
                                @endif
                                <input type="file" accept=".pdf" name="upload_bukti_dukung" class="form-control"
                                    placeholder="" value="">
                            </div>

                            <div class="form-group">
                                <label>kendala dan keterangan lain</label>
                                <input type="text" name="keterangan" class="form-control" placeholder=""
                                    value="{{ old('keterangan', isset($progressIntervensiNasional) ? $progressIntervensiNasional->keterangan : '') }}">
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                            <input type="submit" class="btn btn-primary" name=" submit" value="submit">
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

    </section>


@endsection
