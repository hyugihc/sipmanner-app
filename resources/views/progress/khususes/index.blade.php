@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
          
                </div><!-- /.col -->

                <div class="col-sm-10">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('progress.index') }}">Progres</a></li>
                        <li class="breadcrumb-item active">{{ $intervensiKhusus->nama }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Progres {{ $intervensiKhusus->nama }}</h3>

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
                                    <th>Penjelasan Progress</th>
                                    <th>Dilaporkan pada</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($progressPrograms as $progress_program)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $progress_program->uraian_program }}</td>
                                        <!-- format dd mmm yyyy -->
                                        <td>{{ $progress_program->created_at->format('Y-m-d') }}</td>
                                            <!-- format dd mmm yyyy -->
                                        <td>{{ $progress_program->tanggal }}</td>
                                        <td>{{ $progress_program->getStatus() }}
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('intervensi-khususes.progress-intervensi-khususes.destroy', [$intervensiKhusus, $progress_program]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('intervensi-khususes.progress-intervensi-khususes.show', [$intervensiKhusus, $progress_program]) }}">Show</a>

                                                @can('update', $progress_program)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi-khususes.progress-intervensi-khususes.edit', [$intervensiKhusus, $progress_program]) }}">Edit</a>
                                                @endcan
                                                @can('delete', $progress_program)
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
                    <div class="card-footer">
                        @can('create', $intervensiKhusus)
                            <div class="row">
                                <div class="col-sm-2">
                                    <a class="btn btn-block btn-primary btn-sm"
                                        href="{{ route('intervensi-khususes.progress-intervensi-khususes.create', $intervensiKhusus) }}">Buat
                                        Progres</a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            @if (Session::has('success'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif
            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.error("{{ Session::get('error') }}");
            @endif
        </script>

    </section>
@endsection
