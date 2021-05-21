@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-block btn-primary btn-sm"
                        href="{{ route('program_intervensis.create') }}">Create</a>
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

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

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
                                    <th>Jenis Program Intervensi</th>
                                    <th>Nama</th>
                                    <th>Uraian Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($program_intervensis as $program_intervensi)
                                    <tr>
                                        <td>
                                            @if ({{ $program_intervensi->jenis=1 }})
                                            Program Intervensi Nasional
                                            @else  Program Intervensi khusus
                                            @endif  
                                        </td>
                                        <td>{{ $program_intervensi->nama }}</td>
                                        <td>{{ $program_intervensi->uraian_kegiatan }}</td>
                                        <td>

                                            <form action="{{ route('program_intervensis.destroy', $program_intervensi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-block btn-primary btn-sm"
                                                    href="{{ route('program_intervensis.show', $program_intervensi) }}">Show</a>

                                                <a class="btn btn-block btn-warning btn-sm"
                                                    href="{{ route('program_intervensis.edit', $program_intervensi) }}">Edit</a>

                                                <button type="submit"
                                                    class="btn btn-block btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $program_intervensis->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>



    @endsection
