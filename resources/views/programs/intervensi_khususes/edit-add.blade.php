@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ isset($intervensiKhusus) ? 'Edit' : 'Create' }}</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('programs.index') }}">Rencana</a></li>
                        @if (isset($intervensiKhusus))
                            <li class="breadcrumb-item active">{{ $intervensiKhusus->nama }}</li>
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
                                {{ isset($intervensiKhusus) ? 'Form ' . $intervensiKhusus->nama : 'Form Rencana Aksi' }}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($intervensiKhusus))
                            <form action="{{ route('intervensi-khususes.update', $intervensiKhusus->id) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('intervensi-khususes.store') }}" method="POST">
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
                                <label>Nama Program*</label>
                                <input type="text" name="nama" class="form-control" placeholder=""
                                    value="{{ old('nama', isset($intervensiKhusus) ? $intervensiKhusus->nama : '') }}">
                            </div>
                            <div class="form-group">
                                <label>Uraian Kegiatan*</label>
                                <textarea type="text" name="uraian_kegiatan" class="form-control" placeholder="">{{ old('uraian_kegiatan', isset($intervensiKhusus) ? $intervensiKhusus->uraian_kegiatan : '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Isu Strategis*</label>
                                <textarea type="text" name="isu_strategis" class="form-control" placeholder="">{{ old('isu_strategis', isset($intervensiKhusus) ? $intervensiKhusus->isu_strategis : '') }}</textarea>
                            </div>

                            {{-- select2 rb2023 --}}
                            <div class="form-group">
                                <label>Dukungan RB</label>
                                <select name="rb2023s[]" class="select2bs4" multiple="multiple"
                                    data-placeholder="Pilih Dukungan RB" style="width: 100%;">
                                    @if (isset($intervensiKhusus))
                                        @php
                                            $idrb2023 = $intervensiKhusus->rb2023s->pluck('id');
                                        @endphp
                                        @foreach ($rb2023s as $rb2023)
                                            <option value="{{ $rb2023->id }}"
                                                {{ $idrb2023->contains($rb2023->id) ? 'selected' : '' }}>
                                                {{ $rb2023->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($rb2023s as $rb2023)
                                            <option value="{{ $rb2023->id }}">{{ $rb2023->nama }}</option>
                                        @endforeach
                                    @endif


                                    {{-- @foreach ($pias as $pia)
                                        @foreach ($intervensiKhusus->pias as $piaselected)
                                            @if ($piaselected->id == $pia->id)
                                                <option value="{{ $pia->id }}" selected>{{ $pia->nama }}
                                                </option>
                                            @else
                                                <option value="{{ $pia->id }}">{{ $pia->nama }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach --}}

                                </select>
                            </div>



                            <div class="form-group">
                                <label>Output*</label>
                                <textarea type="text" name="output" class="form-control" placeholder="">{{ old('output', isset($intervensiKhusus) ? $intervensiKhusus->output : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Timeline*</label>
                                <textarea type="text" name="timeline" class="form-control" placeholder="">{{ old('timeline', isset($intervensiKhusus) ? $intervensiKhusus->timeline : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Ukuran Keberhasilan*</label>
                                <textarea type="text" name="ukuran_keberhasilan" class="form-control" placeholder="">{{ old('ukuran_keberhasilan', isset($intervensiKhusus) ? $intervensiKhusus->ukuran_keberhasilan : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Outcome*</label>
                                <textarea type="text" name="outcome" class="form-control" placeholder="">{{ old('outcome', isset($intervensiKhusus) ? $intervensiKhusus->outcome : '') }}</textarea>
                            </div>


                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea type="text" name="keterangan" class="form-control" placeholder="">{{ old('keterangan', isset($intervensiKhusus) ? $intervensiKhusus->keterangan : '') }}</textarea>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                            <input type="submit" class="btn btn-primary" name=" submit"
                                value="{{ isset($intervensiNasional) ? 'Simpan' : 'Submit' }}">
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
