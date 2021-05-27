@extends('layouts.master')

@section('content')

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
                        <form action="{{ route('program_intervensis.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Jenis Program Intervensi</label>
                                    <select id="jenispi" class="form-control" name="jenis">

                                        @if (Auth::user()->role_id == 1)
                                            <option value="1">Nasional</option>
                                            <option value="2" selected>Khusus</option>
                                        @else
                                            <option value="2" selected>Khusus</option>
                                        @endif
                                    </select>
                                </div>

                                @error('jenis')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

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
                                    <select class="form-control" name="pias[]" multiple>
                                        @foreach ($pias as $pia)
                                            <option value="{{ $pia->id }}">{{ $pia->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('pias')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Volume Kegiatan Setahun</label>
                                    <input type="text" name="vol_keg_tahun" class="form-control" placeholder="">
                                </div>

                                @error('vol_keg_tahun')
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
                                    <label>Awal Pelaksanaan</label>
                                    <input type="date" name="awal_pelaksanaan" class="form-control" placeholder="">
                                </div>

                                @error('awal_pelaksanaan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Selesai Pelaksanaan</label>
                                    <input type="date" name="selesai_pelaksanaan" class="form-control" placeholder="">
                                </div>

                                @error('selesai_pelaksanaan')
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

                                @if (Auth::User()->role_id == 1)
                                    <div id="provinsi_id" class="form-group">
                                        <label>Wilayah</label>
                                        <select class="form-control" name="provinsi_id">
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

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

        <script>
            // $(document).ready(function() {
            //     var textarea = $('#divtextarea');
            //     textarea.hide();
            // });

            $('#jenispi').on('change', function() {
                var provinsi = $('#provinsi_id');
                var select = $(this).val();

                if (select == '1') {
                    provinsi.hide();
                    provinsi.val("99");
                } else {
                    provinsi.show();
                }

            });

        </script>



    @endsection
