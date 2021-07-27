@extends('layouts.master')

@section('content')

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm"
                        href="{{ route('intervensi-khususes.progress-intervensi-khususes.create', $intervensiKhusus) }}">Create</a>
                </div><!-- /.col -->

                <div class="col-sm-4">

                </div><!-- /.col -->

                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress Program</li>
                        <li class="breadcrumb-item active">{{ $intervensiKhusus->nama }}</li>
                    </ol> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        {{-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $intervensiKhusus->nama }}</h3>

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
                                    <th>Penjelasan Progress</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progressPrograms as $progress_program)
                                    <tr>
                                        <td>{{ $progress_program->uraian_program }}</td>
                                        <td>{{ $progress_program->bulan }}</td>
                                        <td>
                                            @switch($progress_program->status)
                                                @case(1)
                                                    Submitted
                                                @break
                                                @case(2)
                                                    Approved
                                                @break
                                                @case(3)
                                                    Rejected
                                                @break
                                                @default
                                            @endswitch

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
                                @endforeach

                            </tbody>
                        </table>
                        {{ $progressPrograms->links() }}
                    </div>
                    <!-- /.card-body -->
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
        </script>

    </section>

@endsection
