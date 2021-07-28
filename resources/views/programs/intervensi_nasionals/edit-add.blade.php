@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ isset($intervensiNasional) ? 'Edit' : 'Create' }}</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('programs.index') }}"> Rencana</a></li>
                        @if (isset($intervensiNasional))
                            <li class="breadcrumb-item active">{{ $intervensiNasional->nama }}</li>
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
                            <h3 class="card-title">{{ isset($intervensiNasional) ? 'Edit' : 'Create' }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($intervensiNasional))
                            <form action="{{ route('intervensi-nasionals.update', $intervensiNasional->id) }}"
                                method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('intervensi-nasionals.store') }}" method="POST">
                        @endif
                        @csrf
                        <div class="card-body">


                            <div class="form-group">
                                <span>Semua Isian bertanda * (bintang) wajib di isi</span>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Tahun SK</label>
                                <select name="tahun_sk" class="form-control">
                                    <option id="year"></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama Program*</label>
                                <input type="text" name="nama" class="form-control" placeholder=""
                                    value="{{ old('nama', isset($intervensiNasional) ? $intervensiNasional->nama : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Uraian Kegiatan*</label>
                                <textarea type="text" name="uraian_kegiatan" class="form-control"
                                    placeholder="">{{ old('uraian_kegiatan', isset($intervensiNasional) ? $intervensiNasional->uraian_kegiatan : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Volume Kegiatan Setahun*</label>
                                <input type="number" name="volume" class="form-control" placeholder=""
                                    value="{{ old('volume', isset($intervensiNasional) ? $intervensiNasional->volume : '') }}"
                                    min="1" max="1000">
                            </div>

                            <div class="form-group">
                                <label>Nilai PIA*</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder=""
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="pias[]">
                                        @foreach ($pias as $pia)
                                            <option value="{{ $pia->id }}"
                                                @isset($intervensiNasional){{ $idPia->contains($pia->id) ? 'selected' : '' }}
                                                @endisset>
                                                {{ $pia->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Output*</label>
                                <textarea type="text" name="output" class="form-control"
                                    placeholder="">{{ old('output', isset($intervensiNasional) ? $intervensiNasional->output : '') }}</textarea>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Outcome*</label>
                                <textarea type="text" name="outcome" class="form-control"
                                    placeholder="">{{ old('outcome', isset($intervensiNasional) ? $intervensiNasional->outcome : '') }}</textarea>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea type="text" name="keterangan" class="form-control"
                                    placeholder="">{{ old('keterangan', isset($intervensiNasional) ? $intervensiNasional->keterangan : '') }}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                            <input type="submit" class="btn btn-primary" name=" submit"
                                value="{{ isset($progressIntervensiKhusus) ? 'Simpan' : 'Submit' }}">
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

        <script src="{{ asset('') }}assets/plugins/select2/js/select2.full.min.js"></script>
        <script>
            $(document).ready(function() {
                var year = new Date().getFullYear();
                $("#year").append('<option value=' + year + '>' + year + '</option>');
                updateRowOrder();
            });
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })
        </script>

    </section>
@endsection
