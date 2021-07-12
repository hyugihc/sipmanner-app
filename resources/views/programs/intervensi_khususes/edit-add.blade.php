@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">

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
                            <h3 class="card-title">{{ isset($intervensiKhusus) ? 'Edit' : 'Create' }}</h3>
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
                                <textarea type="text" name="uraian_kegiatan" class="form-control"
                                    placeholder="">{{ old('uraian_kegiatan', isset($intervensiKhusus) ? $intervensiKhusus->uraian_kegiatan : '') }}</textarea>
                            </div>


                            <div class="form-group">
                                <label>Volume Kegiatan Setahun*</label>
                                <input type="number" min="1" max="1000" name="volume" class="form-control" placeholder=""
                                    value="{{ old('volume', isset($intervensiKhusus) ? $intervensiKhusus->volume : '') }}">
                            </div>

                            <div class="form-group">
                                <label>Nilai PIA*</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Pilih nilai PIA"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="pias[]">
                                        @foreach ($pias as $pia)
                                            <option value="{{ $pia->id }}"
                                                @isset($intervensiKhusus){{ $idPia->contains($pia->id) ? 'selected' : '' }}
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
                                    placeholder="">{{ old('output', isset($intervensiKhusus) ? $intervensiKhusus->output : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Outcome*</label>
                                <textarea type="text" name="outcome" class="form-control"
                                    placeholder="">{{ old('outcome', isset($intervensiKhusus) ? $intervensiKhusus->outcome : '') }}</textarea>
                            </div>


                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea type="text" name="keterangan" class="form-control"
                                    placeholder="">{{ old('keterangan', isset($intervensiKhusus) ? $intervensiKhusus->keterangan : '') }}</textarea>
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
