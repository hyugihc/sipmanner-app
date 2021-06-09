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
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol> --}}
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
                            <h3 class="card-title">{{ $intervensiNasional->nama }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('intervensi_nasionals.update', $intervensiNasional->id) }}" method="POST"
                            id="quickForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">



                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder=""
                                        value="{{ $intervensiNasional->nama }}">
                                </div>
                                <div class="form-group">
                                    <label>Uraian Kegiatan</label>
                                    <textarea type="text" name="uraian_kegiatan" class="form-control"
                                        placeholder="">{{ $intervensiNasional->uraian_kegiatan }}
                                                                                                                                                                                                                    </textarea>
                                </div>


                                <div class="form-group">
                                    <label>Volume Kegiatan Setahun</label>
                                    <input type="number" name="volume" class="form-control" placeholder=""
                                        value="{{ $intervensiNasional->volume }}" min="1" max="100">
                                </div>


                                <div class="form-group">
                                    <label>Nilai Pia</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" data-placeholder="Pilih nilai Pia"
                                            data-dropdown-css-class="select2-purple" style="width: 100%;" name="pias[]">
                                            @foreach ($pias as $pia)
                                                @foreach ($intervensiNasional->pias as $piaselected)
                                                    @if ($piaselected->id == $pia->id)
                                                        <option value="{{ $pia->id }}" selected>{{ $pia->nama }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $pia->id }}">{{ $pia->nama }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Output</label>
                                    <input type="text" name="output" class="form-control" placeholder=""
                                        value="{{ $intervensiNasional->output }}">
                                </div>

                                <div class="form-group">
                                    <label>Outcome</label>
                                    <input type="text" name="outcome" class="form-control" placeholder=""
                                        value="{{ $intervensiNasional->outcome }}">
                                </div>


                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea type="text" name="keterangan" class="form-control"
                                        placeholder="">{{ $intervensiNasional->keterangan }}
                                                                                                                                                          </textarea>
                                </div>


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
