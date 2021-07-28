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
                            <li class="breadcrumb-item active">{{ $progressIntervensiNasional->bulan }}</li>
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
                                <input type="text" name="uraian_program" class="form-control" placeholder=""
                                    value="{{ old('uraian_program', isset($progressIntervensiNasional) ? $progressIntervensiNasional->uraian_program : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Bulan</label>
                                <select class="form-control" name="bulan" id="">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Persentase Capaian Program</label>
                                <input type="number" name="presentase_program" class="form-control" placeholder=""
                                    value="{{ old('presentase_program', isset($progressIntervensiNasional) ? $progressIntervensiNasional->presentase_program : '') }}"
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
                            <input type="submit" class="btn btn-primary" name=" submit"
                                value="{{ isset($progressIntervensiNasional) ? 'Simpan' : 'Submit' }}">
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
