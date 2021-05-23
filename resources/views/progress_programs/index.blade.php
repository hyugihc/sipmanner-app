@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('progress_programs.create') }}">Create</a>
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
                        <h3 class="card-title">Progress Programs</h3>

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
                                    <th>Nama Program Intervensi</th>
                                    <th>Nama Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progress_programs as $progress_program)
                                    <tr>
                                        <td>
                                            @if ($progress_program->program_intervensi['jenis'] == 1)
                                                {{ 'Program Intervensi Nasional' }}
                                            @else {{ 'Program Intervensi Khusus' }}
                                            @endif
                                        </td>
                                        <td>{{ $progress_program->program_intervensi['nama'] }}</td>
                                        <td>{{ $progress_program->nama }}</td>
                                        <td>

                                            <form action="{{ route('progress_programs.destroy', $progress_program) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-block btn-primary btn-sm"
                                                    href="{{ route('progress_programs.show', $progress_program) }}">Show</a>

                                                <a class="btn btn-block btn-warning btn-sm"
                                                    href="{{ route('progress_programs.edit', $progress_program) }}">Edit</a>

                                                <button type="submit"
                                                    class="btn btn-block btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $progress_programs->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>



    @endsection
