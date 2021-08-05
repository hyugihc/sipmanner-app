@extends('layouts.master')

@section('content')

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('users.create') }}">Create</a>
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
                        <h3 class="card-title">Users</h3>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" id="input_query" class="form-control float-right" placeholder="Search"
                                    value="@isset($query){{$query}}@endisset">

                                <div class="input-group-append">
                                    <button type="submit" id="button_query" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover" id="table_users">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nip Lama</th>
                                    <th>Role</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td> {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nip_lama }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->provinsi->nama }}</td>
                                        <td>

                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('users.show', $user) }}">Show</a>

                                                <a class="btn btn-block btn-warning btn-xs"
                                                    href="{{ route('users.edit', $user) }}">Edit</a>

                                                <button type="submit" class="btn btn-block btn-danger btn-xs"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            $(document).ready(function() {

                var $tableQ = $('#table_query');
                // $tableQ.hide();
                // $('#danger_nip').hide();
                $('#input_query').keypress(function(e) {
                    var key = e.which;
                    if (key == 13) {
                        $('#button_query').click();
                        return false;
                    }
                });
            });
            $('#button_query').click(function() {
                //$('#danger_nip').hide();
                //$('#error_nip').val("");
                var query = $('#input_query').val().trim();
                if (query != null) {
                    cariPegawai(query);
                }
            });

            function cariPegawai(query) {
                console.log("cari peg");
                var urlx = '{{ route('users.index.query', ':query') }}';
                urlx = urlx.replace(':query', query);
                window.location.href = urlx;

            }

            @if (Session::has('success'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                // toastr.options =
                // {
                // "closeButton" : true,
                // "progressBar" : false
                // }
                // toastr.error("{{ session('error') }}");
                // @endif

            @if (Session::has('info'))
                // toastr.options =
                // {
                // "closeButton" : true,
                // "progressBar" : false
                // }
                // toastr.info("{{ session('info') }}");
                // @endif

            @if (Session::has('warning'))
                // toastr.options =
                // {
                // "closeButton" : true,
                // "progressBar" : false
                // }
                // toastr.warning("{{ session('warning') }}");
                // @endif
        </script>
    </section>
@endsection
