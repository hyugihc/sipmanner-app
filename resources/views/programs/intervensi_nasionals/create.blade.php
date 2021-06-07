@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
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
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('intervensi_nasionals.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Jenis Program Intervensi</label>
                                    <select id="jenispi" class="form-control" name="jenis">
                                        <option selected>Nasional</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="">
                                </div>

                                @error('nama')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Uraian Kegiatan</label>
                                    <textarea type="text" name="uraian_kegiatan" class="form-control" placeholder="">
                                                                                                                                                                                                                                                                                                                                                                                                                    </textarea>
                                </div>

                                @error('uraian_kegiatan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Nilai Pia</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" data-placeholder="Pilih nilai Pia"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;" name="pias[]">
                                            @foreach ($pias as $pia)
                                                <option value="{{ $pia->id }}">{{ $pia->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @error('pias')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Volume Kegiatan Setahun</label>
                                    <input type="text" name="volume" class="form-control" placeholder="">
                                </div>

                                @error('volume')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Output</label>
                                    <input type="text" name="output" class="form-control" placeholder="">
                                </div>

                                @error('output')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Outcome</label>
                                    <input type="text" name="outcome" class="form-control" placeholder="">
                                </div>

                                @error('outcome')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea type="text" name="keterangan" class="form-control" placeholder=""></textarea>
                                    </textarea>
                                </div>

                                @error('keterangan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
