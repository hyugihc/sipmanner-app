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
                        <form action="{{ route('program_intervensi.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Jenis Program Intervensi</label>
                                    <select class="form-control" name="provinsi_id">
                                       @if ($program_intervensi->jenis=1)
                                            <option value="1" selected >Nasional</option>
                                            <option value="2">Khusus</option>
                                       @else
                                             <option value="1">Nasional</option>
                                             <option value="2" selected>Khusus</option>
                                       @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="" value="{{$program_intervensi->nama}}">
                                </div>
                                <div class="form-group">
                                    <label>Uraian Kegiatan</label>
                                    <textarea type="text" name="uraian_kegiatan" class="form-control" value="{{$program_intervensi->}}" placeholder="">
                                                                                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label>Nilai Pia</label>
                                    <select class="form-control" name="pias_id">
                                        @foreach ($pias as $pia)
                                            <option value="{{ $pia->id }}">{{ $pia->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Volume Kegiatan Setahun</label>
                                    <input type="text" name="vol_keg_tahun" class="form-control" placeholder="" value="{{$program_intervensi->vol_keg_tahun}}">
                                </div>

                                <div class="form-group">
                                    <label>Output</label>
                                    <input type="text" name="vol_keg_tahun" class="form-control" placeholder="" value="{{$program_intervensi->output}}">
                                </div>

                                <div class="form-group">
                                    <label>Outcome</label>
                                    <input type="text" name="vol_keg_tahun" class="form-control" placeholder="" value="{{$program_intervensi->outcome}}">
                                </div>

                                <div class="form-group">
                                    <label>Awal Pelaksanaan</label>
                                    <input type="date" name="awal_pelaksanaan" class="form-control" placeholder="" value="{{$program_intervensi->awal_pelaksanaan}}">
                                </div>

                                <div class="form-group">
                                    <label>Selesai Pelaksanaan</label>
                                    <input type="date" name="selesai_pelaksanaan" class="form-control" placeholder="" value="{{$program_intervensi->selesai_pelaksanaan}}">
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea type="text" name="keterangan" class="form-control" placeholder="" value="{{$program_intervensi->keterangan}}">
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



    @endsection
