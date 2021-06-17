@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit</h1>
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
                        <form action="{{ route('intervensi_khususes.update', $intervensiKhusus->id) }}" method="POST"
                            id="quickForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group">
                                    <span>Semua Isian bertanda * (bintang) wajib di isi</span>
                                </div>


                                <div class="form-group">
                                    <label>Nama Program*</label>
                                    <input type="text" name="nama" class="form-control" placeholder=""
                                        value="{{ $intervensiKhusus->nama }}">
                                </div>
                                <div class="form-group">
                                    <label>Uraian Kegiatan*</label>
                                    <textarea type="text" name="uraian_kegiatan" class="form-control"
                                        placeholder="">{{ $intervensiKhusus->uraian_kegiatan }}
                                                                                                                                                                                                                                                                                                    </textarea>
                                </div>


                                <div class="form-group">
                                    <label>Volume Kegiatan Setahun*</label>
                                    <input type="text" name="volume" class="form-control" placeholder=""
                                        value="{{ $intervensiKhusus->volume }}">
                                </div>


                                <div class="form-group">
                                    <label>Nilai PIA*</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" data-placeholder="Pilih nilai PIA"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;" name="pias[]">
                                            @foreach ($pias as $pia)
                                                <option value="{{ $pia->id }}"
                                                    {{ $idPia->contains($pia->id) ? 'selected' : '' }}>
                                                    {{ $pia->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Output*</label>
                                    <input type="text" name="output" class="form-control" placeholder=""
                                        value="{{ $intervensiKhusus->output }}">
                                </div>

                                <div class="form-group">
                                    <label>Outcome*</label>
                                    <textarea type="text" name="outcome" class="form-control" placeholder="">{{ $intervensiKhusus->outcome }}
                                            </textarea>
                                </div>


                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea type="text" name="keterangan" class="form-control" placeholder="">{{ $intervensiKhusus->keterangan }}
                                                                                   </textarea>
                                </div>

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
                                <input type="submit" class="btn btn-primary" name=" draft" value="Save as Draft">
                                <input type="submit" class="btn btn-primary" name=" submit" value="Submit">
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
