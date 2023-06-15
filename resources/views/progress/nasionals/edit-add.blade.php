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
                                <textarea type="text" name="uraian_program" class="form-control" placeholder="">{{ old('uraian_program', isset($progressIntervensiNasional) ? $progressIntervensiNasional->uraian_program : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" placeholder=""
                                    value="{{ old('tanggal', isset($progressIntervensiNasional) ? $progressIntervensiNasional->tanggal : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Realisasi Pelaksanaan Kegiatan %</label>
                                <input type="number" name="realisasi_pelaksanaan_kegiatan" class="form-control"
                                    placeholder=""
                                    value="{{ old('realisasi_pelaksanaan_kegiatan', isset($progressIntervensiNasional) ? $progressIntervensiNasional->realisasi_pelaksanaan_kegiatan : '') }}"
                                    min="1" max="100">
                            </div>


                            <div class="form-group">
                                <label>Upload Bukti Dukung & Dokumentasi</label>
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
