@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">{{ $report->tahun }}</a></li>
                        <li class="breadcrumb-item active">Semester {{ $report->semester }}</li>
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
                    <div class="position-relative">
                        @if ($report->status == 0)
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Upload Softcopy Laporan Tahun 2021 Semester
                                        {{ $report->semester }}</h3>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                    <div class="form-group">
                                        {{-- <label>Upload Softcopy Laporan</label> --}}
                                        <!-- upload softcopy pdf laporan -->
                                        <form action="{{ route('reports.upload-laporan', $report->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">

                                                <label>Upload Softcopy Laporan</label>
                                                <input accept=".pdf" type="file" name="laporan" class="form-control"
                                                    placeholder="">


                                                <div class="input-group-append" style="padding-top: 5px">
                                                    <button class="btn btn-primary" type="submit">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if ($report->status == 4)
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Tahun {{ $report->tahun }} Semester
                                        {{ $report->semester }}
                                    </h3>
                                </div>

                                <!-- /.card-header -->


                                <div class="card-body">

                                    <div class="col-md-12" >
                                        @if ($report->status == 4)

                                            <a href="{{ route('reports.download-laporan', $report) }}"
                                                class="btn btn-primary "><i class="fas fa-download"></i>
                                                Unduh Laporan</a>
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <!-- /.card -->
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>



@endsection
