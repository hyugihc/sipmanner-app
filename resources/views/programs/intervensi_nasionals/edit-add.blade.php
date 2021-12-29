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
                                <label>Isu Strategis*</label>
                                <textarea type="text" name="isu_strategis" class="form-control"
                                    placeholder="">{{ old('isu_strategis', isset($intervensiNasional) ? $intervensiNasional->isu_strategis : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Output*</label>
                                <textarea type="text" name="output" class="form-control"
                                    placeholder="">{{ old('output', isset($intervensiNasional) ? $intervensiNasional->output : '') }}</textarea>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Timeline*</label>
                                <textarea type="text" name="timeline" class="form-control"
                                    placeholder="">{{ old('timeline', isset($intervensiNasional) ? $intervensiNasional->timeline : '') }}</textarea>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>Ukuran Keberhasilan*</label>
                                <textarea type="text" name="ukuran_keberhasilan" class="form-control"
                                    placeholder="">{{ old('ukuran_keberhasilan', isset($intervensiNasional) ? $intervensiNasional->ukuran_keberhasilan : '') }}</textarea>
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

                            @if (isset($intervensiNasional))
                                @if ($intervensiNasional->status != 2)
                                    <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                                @endif
                            @else
                                <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                            @endif

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
