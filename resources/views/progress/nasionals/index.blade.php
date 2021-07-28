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
                        href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.create', $intervensiNasional) }}">Create</a>
                </div><!-- /.col -->
                <div class="col-sm-10">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('progress.index') }}">Progres</a></li>
                        <li class="breadcrumb-item active">{{ $intervensiNasional->nama }}</li>
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
                        <h3 class="card-title">Progres {{ $intervensiNasional->nama }}</h3>

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
                                    <th>Penjelasan Progres</th>
                                    <th>Bulan</th>
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
                                        <td>
                                            @switch($progress_program->bulan)
                                                @case(1)
                                                    Januari
                                                @break
                                                @case(2)
                                                    Februari
                                                @break
                                                @case(3)
                                                    Maret
                                                @break
                                                @case(4)
                                                    April
                                                @break
                                                @case(5)
                                                    Mei
                                                @break
                                                @case(6)
                                                    Juni
                                                @break
                                                @case(7)
                                                    Juli
                                                @break
                                                @case(8)
                                                    Agustus
                                                @break
                                                @case(9)
                                                    September
                                                @break
                                                @case(10)
                                                    Oktober
                                                @break
                                                @case(11)
                                                    November
                                                @break
                                                @case(12)
                                                    Desember
                                                @break

                                                @default

                                            @endswitch


                                        </td>
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
                                                action="{{ route('intervensi-nasionals.progress-intervensi-nasionals.destroy', [$intervensiNasional, $progress_program]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.show', [$intervensiNasional, $progress_program]) }}">Show</a>


                                                @can('update', $progress_program)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi-nasionals.progress-intervensi-nasionals.edit', [$intervensiNasional, $progress_program]) }}">Edit</a>

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
