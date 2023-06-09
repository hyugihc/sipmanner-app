@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('') }}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">

                </div><!-- /.col -->
                <div class="col-sm-4">
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item active">Data</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Change Agent Network Tahun {{ Auth::user()->getSetting('tahun') }}
                        </h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-hover text-nowrap" id="table_cans">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if (Auth::user()->isAdminOrTopLeader())
                                        <th>Unit Kerja</th>
                                    @endif
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Jumlah CAN</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cans as $can)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if (Auth::user()->isAdminOrTopLeader())
                                            @if ($can->isCanPusat())
                                                <td>BPS Pusat</td>
                                            @else
                                                <td>{{ $can->provinsi['nama'] }}</td>
                                            @endif
                                        @endif
                                        <td>{{ $can->nomor_sk }}</td>
                                        <td>{{ $can->tanggal_sk }}</td>
                                        <td>{{ $can->jumlahCAN() }}</td>
                                        <td>{{ $can->getCanStatus() }}
                                            @if ($can->status_sk == 1)
                                                <br> <span class="badge badge-info right">Perlu Tindakan</span>
                                            @endif
                                        </td>

                                        <td>

                                            <form action="{{ route('cans.destroy', $can->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('cans.show', $can->id) }}">Show</a>

                                                @can('update', $can)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('cans.edit', $can->id) }}">Edit</a>
                                                @endcan

                                                @can('delete', $can)
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
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
                    <div class="card-footer">

                        <div class="row">
                            <div class="col-sm-2">
                                @can('create', App\Can::class)
                                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('cans.create') }}">Upload SK CAN</a>
                                @endcan
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card -->

                <div class="d-flex justify-content-center">
                    {!! $cans->links() !!}
                </div>



            </div>
        </div>

        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            //define data table


            //toastr
            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.error("{{ Session::get('error') }}");
            @endif

            @if (Session::has('success'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('warning'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.warning("{{ Session::get('warning') }}");
            @endif

            @if (Session::has('info'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": false
                }
                toastr.info("{{ Session::get('info') }}");
            @endif
        </script>

    </section>
@endsection
