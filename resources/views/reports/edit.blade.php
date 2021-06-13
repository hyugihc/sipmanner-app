@extends('layouts.master')

@section('content')

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
                        <li class="breadcrumb-item active">Report</li>
                        <li class="breadcrumb-item active">{{ $report->tahun }}</li>
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
                            <h3 class="card-title">Laporan Tahun {{ $report->tahun }} &nbsp; Semester
                                {{ $report->semester }}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('reports.update', $report) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pendahuluan</label>
                                    <textarea class="form-control" name="bab_i" id="" cols="10" rows="10">
                               {{ $report->bab_i }} 
                                                                                     </textarea>
                                </div>

                                @error('bab_i')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Latar Belakang</label>
                                    <textarea class="form-control" name="bab_ii" id="" cols="30" rows="10">
                {{ $report->bab_ii }}                                                                    </textarea>
                                </div>

                                @error('bab_ii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Program</label>
                                    <textarea class="form-control" name="bab_iii" id="" cols="30" rows="10">
                            {{ $report->bab_iii }}
                                                                                    </textarea>
                                </div>

                                

                                @error('bab_iii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Perubahan yang Konkret</label>
                                    <textarea class="form-control" name="bab_iv" id="" cols="30" rows="10">
                       {{ $report->bab_iv }}
                                                                                    </textarea>
                                </div>

                                @error('bab_iv')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Komitmen Pimpinan</label>
                                    <textarea class="form-control" name="bab_v" id="" cols="30" rows="10">
                        {{ $report->bab_v }}
                                                                                    </textarea>
                                </div>

                                @error('bab_v')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Kesimpulan</label>
                                    <textarea class="form-control" name="bab_vi" id="" cols="30" rows="10">
            {{ $report->bab_iv }}                                                                        </textarea>
                                </div>

                                @error('bab_vi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Penutup</label>
                                    <textarea class="form-control" name="bab_vii" id="" cols="30" rows="10">
        {{ $report->bab_vii }}                                                                            </textarea>
                                </div>

                                @error('bab_vii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Lampiran</label>
                                    <textarea class="form-control" name="bab_viii" id="" cols="30" rows="10">
                      {{ $report->bab_viii }}
                                                                                    </textarea>
                                </div>

                                @error('bab_viii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
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
