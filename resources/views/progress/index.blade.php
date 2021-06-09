@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <a class="btn btn-block btn-primary btn-sm"
                        href="{{ route('intervensiKhususs.create') }}">Create</a> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress Program</li>
                    </ol> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Program Intervensi Nasionals</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Uraian Kegiatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($intervensiNasionals as $intervensiNasional)
                                    <tr>
                                        <td>{{ $intervensiNasional->nama }}</td>
                                        <td>{{ $intervensiNasional->uraian_kegiatan }}</td>
                                        <td>
                                            <a class="btn btn-block btn-primary btn-xs"
                                                href="{{ route('progress_intervensi_nasionals.index', $intervensiNasional) }}">Show
                                                Progress</a>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $intervensiNasionals->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Program Intervensis Khususes</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Uraian Kegiatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($intervensiKhususes as $intervensiKhusus)
                                    <tr>
                                        <td>{{ $intervensiKhusus->nama }}</td>
                                        <td>{{ $intervensiKhusus->uraian_kegiatan }}</td>
                                        <td>
                                            <a class="btn btn-block btn-primary btn-xs"
                                                href="{{ route('progress_intervensi_khususes.index', $intervensiKhusus) }}">Show
                                                Progress</a>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $intervensiKhususes->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>



    @endsection
