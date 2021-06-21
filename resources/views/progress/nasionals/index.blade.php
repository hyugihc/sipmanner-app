@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm"
                        href="{{ route('progress_intervensi_nasionals.create', $intervensiNasional) }}">Create</a>
                </div><!-- /.col -->

                <div class="col-sm-4">

                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress Program</li>
                        <li class="breadcrumb-item active">{{ $intervensiNasional->nama }}</li>
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
                        <h3 class="card-title">{{ $intervensiNasional->nama }}</h3>

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
                                    <th>Penjelasan Progres</th>
                                    <th>Bulan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progressPrograms as $progress_program)
                                    <tr>
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
                                                action="{{ route('progress_intervensi_nasionals.destroy', [$intervensiNasional, $progress_program]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('progress_intervensi_nasionals.show', [$intervensiNasional, $progress_program]) }}">Show</a>


                                                @can('update', $progress_program)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('progress_intervensi_nasionals.edit', [$intervensiNasional, $progress_program]) }}">Edit</a>

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



    @endsection
