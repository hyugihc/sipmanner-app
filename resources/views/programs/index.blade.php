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
                                href="{{ route('intervensi-nasionals.create') }}">Create</a>
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
                        <h3 class="card-title">Program Intervensi Nasional Tahun {{ date('Y') }}</h3>

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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nilai Pia</th>
                                    <th>Output</th>
                                    <th>Outcome</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($intervensiNasionals as $program_intervensi)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $program_intervensi->nama }}</td>
                                        <td>
                                            @foreach ($program_intervensi->pias as $pia)
                                                <small class="badge badge-success"> {{ $pia->nama }}</small>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $program_intervensi->output }}

                                        </td>
                                        <td>
                                            {{ $program_intervensi->outcome }}

                                        </td>
                                        <td>

                                            <form
                                                action="{{ route('intervensi-nasionals.destroy', $program_intervensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('intervensi-nasionals.show', $program_intervensi) }}">Show</a>
                                                @endcan


                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi-nasionals.edit', $program_intervensi) }}">Edit</a>
                                                @endcan

                                                @can('delete', $program_intervensi)
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-block btn-danger btn-xs">Delete</button>
                                                @endcan



                                            </form>
                                        </td>

                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
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
                                href="{{ route('intervensi-khususes.create') }}">Create</a>
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
                        <h3 class="card-title">Program Intervensi Khusus Tahun {{ date('Y') }}</h3>

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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if (Auth::user()->role_id == 1)
                                        <th>Provinsi</th>
                                    @endif
                                    <th>Nama</th>
                                    <th>Nilai Pia</th>
                                    <th>Output</th>
                                    <th>Outcome</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($intervensiKhususes as $program_intervensi)
                                    <tr>

                                        <td>{{ $i }}</td>
                                        @if (Auth::user()->role_id == 1)
                                            <td>{{ $program_intervensi->provinsi->nama }}</td>
                                        @endif
                                        <td>{{ $program_intervensi->nama }}</td>
                                        <td>
                                            @foreach ($program_intervensi->pias as $pia)
                                                <small class="badge badge-success"> {{ $pia->nama }}</small>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $program_intervensi->output }}
                                        </td>
                                        <td>
                                            {{ $program_intervensi->outcome }}
                                        </td>
                                        <td>
                                            @switch($program_intervensi->status)
                                                @case(0)
                                                    <dd>Draft</dd>
                                                @break
                                                @case(1)
                                                    <dd>Belum Disetujui</dd>
                                                @break
                                                @case(2)
                                                    <dd>Sudah Disetujui</dd>
                                                @break
                                                @case(3)
                                                    <dd>Tidak Disetujui</dd>
                                                    <dd> {{ $program_intervensi->alasan }}</dd>
                                                @break

                                                @default

                                            @endswitch

                                        </td>
                                        <td>

                                            <form
                                                action="{{ route('intervensi-khususes.destroy', $program_intervensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('intervensi-khususes.show', $program_intervensi) }}">Show</a>
                                                @endcan

                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi-khususes.edit', $program_intervensi) }}">Edit</a>
                                                @endcan

                                                @can('delete', $program_intervensi)
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                                        class="btn btn-block btn-danger btn-xs">Delete</button>
                                                @endcan


                                            </form>
                                        </td>

                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>



    @endsection
