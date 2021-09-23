@extends('layouts.master')

@section('content')


    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('') }}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_ins').DataTable();
            $('#table_iks').DataTable();
        });
    </script>


    <!-- Main content -->
    <section class="content">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        @can('create', App\IntervensiNasional::class)
                            <a class="btn btn-block btn-primary btn-sm"
                                href="{{ route('intervensi-nasionals.create') }}">Create</a>
                        @endcan
                    </div><!-- /.col -->
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                            <li class="breadcrumb-item active"> Rencana</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        @if (Auth::user()->isAdmin() or Auth::user()->isTopLeader())
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Program Intervensi Nasional Tahun {{ date('Y') }}</h3>

                            {{-- <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover" id="table_ins">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
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
                                            <td>{{ $program_intervensi->nama }}
                                                @if ($program_intervensi->status == 0)
                                                    <b> (draft)</b>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $program_intervensi->output }}

                                            </td>
                                            <td>
                                                {{ $program_intervensi->outcome }}

                                            </td>
                                            <td>


                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('intervensi-nasionals.show', $program_intervensi) }}">Show</a>
                                                @endcan


                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('intervensi-nasionals.edit', $program_intervensi) }}">Edit</a>
                                                @endcan

                                                @can('delete', $program_intervensi)
                                                    <form
                                                        action="{{ route('intervensi-nasionals.destroy', $program_intervensi) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="margin-top: 10px" type="submit"
                                                            onclick="return confirm('Are you sure?')"
                                                            class="btn btn-block btn-danger btn-xs">Delete</button>
                                                    </form>
                                                @endcan
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
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Program Intervensi Nasional</h3>

                            {{-- <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover" id="table_ins">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Uraian Kegiatan</th>
                                        <th>Outcome</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($intervensiNasionalProvinsis as $program_intervensi)
                                        <tr>
                                            <td>{{ $program_intervensi->intervensiNasional->nama }}
                                            </td>
                                            <td>
                                                {{ $program_intervensi->intervensiNasional->uraian_kegiatan }}
                                            </td>
                                            <td>
                                                {{ $program_intervensi->intervensiNasional->outcome }}
                                            </td>
                                            <td>
                                                {{ $program_intervensi->getStatus() }}
                                                @if ($program_intervensi->status == 3)
                                                    <br> ({{ $program_intervensi->alasan }})
                                                @endif
                                            </td>
                                            <td>

                                                @can('view', $program_intervensi)
                                                    <a class="btn btn-block btn-primary btn-xs"
                                                        href="{{ route('inp.show', $program_intervensi) }}">Show</a>
                                                @endcan


                                                @can('update', $program_intervensi)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('inp.edit', $program_intervensi) }}">Sesuaikan Ukuran
                                                        Keberhasilan</a>
                                                @endcan


                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        @endif


        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        @can('create', App\IntervensiKhusus::class)
                            <a class="btn btn-block btn-primary btn-sm"
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Rencana Aksi </h3>

                        {{-- <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover" id="table_iks">
                            <thead>
                                <tr>
                                    @if (Auth::user()->isAdmin())
                                        <th>Satker</th>
                                    @endif

                                    <th>Nama</th>
                                    @if (Auth::user()->isAdmin() or Auth::user()->isChangeLeader())
                                        <th>Change Champions</th>
                                    @endif
                                    <th>Uraian Kegiatan</th>
                                    <th>Outcome</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($intervensiKhususes as $program_intervensi)
                                    <tr>
                                        @if (Auth::user()->role_id == 1)
                                            <td>{{ $program_intervensi->provinsi->nama }}</td>
                                        @endif
                                        <td>{{ $program_intervensi->nama }}</td>

                                        @if (Auth::user()->isAdmin() or Auth::user()->isChangeLeader())
                                            <td>{{ $program_intervensi->user->name }}</td>
                                        @endif
                                        <td>
                                            {{ $program_intervensi->uraian_kegiatan }}
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
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif
        </script>

    </section>

@endsection
