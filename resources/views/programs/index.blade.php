@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    {{-- <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm"
                        href="{{ route('intervensi_nasionals.create') }}">Create</a>
                </div><!-- /.col -->
                <div class="col-sm-4">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Program Intervensi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> --}}
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        @can('create', App\IntervensiNasional::class)
                            <a class="btn btn-block btn-primary btn-xs"
                                href="{{ route('intervensi_nasionals.create') }}">Create</a>
                        @endcan
                    </div><!-- /.col -->
                    <div class="col-sm-10">

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

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
                                @foreach ($intervensiNasionals as $program_intervensi)
                                    <tr>
                                        <td>{{ $program_intervensi->nama }}</td>
                                        <td>{{ $program_intervensi->uraian_kegiatan }}</td>
                                        <td>

                                            <form
                                                action="{{ route('intervensi_nasionals.destroy', $program_intervensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('intervensi_nasionals.show', $program_intervensi) }}">Show</a>
                                                @endcan


                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi_nasionals.edit', $program_intervensi) }}">Edit</a>
                                                @endcan

                                                @can('delete', $program_intervensi)
                                                    <button type="submit"
                                                        class="btn btn-block btn-danger btn-xs">Delete</button>
                                                @endcan



                                            </form>
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

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        @can('create', App\IntervensiKhusus::class)
                            <a class="btn btn-block btn-primary btn-xs"
                                href="{{ route('intervensi_khususes.create') }}">Create</a>
                        @endcan
                    </div><!-- /.col -->
                    <div class="col-sm-10">

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Program Intervensi Khususes</h3>

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
                                @foreach ($intervensiKhususes as $program_intervensi)
                                    <tr>
                                        <td>{{ $program_intervensi->nama }}</td>
                                        <td>{{ $program_intervensi->uraian_kegiatan }}</td>
                                        <td>

                                            <form
                                                action="{{ route('intervensi_khususes.destroy', $program_intervensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('intervensi_khususes.show', $program_intervensi) }}">Show</a>
                                                @endcan

                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi_khususes.edit', $program_intervensi) }}">Edit</a>
                                                @endcan

                                                @can('delete', $program_intervensi)
                                                    <button type="submit"
                                                        class="btn btn-block btn-danger btn-xs">Delete</button>
                                                @endcan


                                            </form>
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
