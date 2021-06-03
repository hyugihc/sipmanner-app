@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cans Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Cans</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.store') }}" method="POST" id="quickForm"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tahun SK</label>
                                    <input type="number" name="tahun_sk" class="form-control"
                                        value="{{ old('tahun_sk') }}" placeholder="">
                                </div>
                                @error('tahun_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor SK</label>
                                    <input type="text" name="nomor_sk" class="form-control" value="{{ old('nomor_sk') }}"
                                        placeholder="">
                                </div>
                                @error('nomor_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" class="form-control"
                                        value="{{ old('tanggal_sk') }}" placeholder="">
                                </div>
                                @error('tanggal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Perihal SK</label>
                                    <input type="text" name="perihal_sk" class="form-control"
                                        value="{{ old('perihal_sk') }}" placeholder="">
                                </div>
                                @error('perihal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">File SK</label>
                                    <input type="file" name="file_sk" class="form-control" value="{{ old('file_sk') }} "
                                        accept=".pdf" placeholder="">
                                </div>
                                @error('file_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                @if (Auth::User()->role_id == 1)
                                    <div class="form-group">
                                        <label>Provinsis</label>
                                        <select class="form-control" name="provinsi_id">
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif



                                <div class="form-group">
                                    <label for="exampleInputEmail1">Change Network</label>
                                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                                        data-target="#modal-default">
                                        + Tambahkan Change Agent
                                    </button>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Cek (✓)</th>
                                                <th>Nip Lama</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($change_leaders as $change_leader)
                                                <tr>
                                                    <td>(✓)</td>
                                                    <td>{{ $change_leader->nip_lama }}</td>
                                                    <td>{{ $change_leader->name }}</td>
                                                    <td>{{ $change_leader->email }}</td>
                                                    <td>Change Leader</td>
                                                </tr>
                                            @endforeach
                                            @foreach ($change_champions as $cc)
                                                <tr>
                                                    <td>(✓)</td>
                                                    <td>{{ $cc->nip_lama }}</td>
                                                    <td>{{ $cc->name }}</td>
                                                    <td>{{ $cc->email }}</td>
                                                    <td>Change Champions</td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>

                                @error('change_agents')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name=" draft" value="Save as Draft">
                                <input type="submit" class="btn btn-primary" name=" submit" value="Submit">
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <!-- .modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cari Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cari pegawai berdasarkan NIP lama</label>
                        <input class="form-control" type='text' id='p_input' name='search' placeholder='Enter nip lama'>
                    </div>

                    <input type='button' value='Search' id='sp_button'> <br /> <br />

                    <table class="table table-bordered" id='userTable'>
                        <thead>
                            <tr>
                                <th>Nip Lama</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="user_table"></tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_pegawai">Tambah Pegawai</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sp_button').click(function() {
                var id = Number($('#p_input').val().trim());
                if (id > 0) {
                    cariPegawai(id);
                }
            });
        });
        var tr_str;

        function cariPegawai(id) {
            $.ajax({
                url: '/getuser_by_niplama/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    var len = 0;
                    $('#userTable tbody').empty(); // Empty <tbody>
                    if (response['data'] != null) {
                        var id = response['data'].id;
                        var name = response['data'].name;
                        var email = response['data'].email;
                        var nip_lama = response['data'].nip_lama;
                        //alert(name);
                        tr_str = "<tr><td ><input type = 'checkbox' name = 'change_agents[]' value = '" +
                            id + "'  checked > </td>" +
                            "<td>" + nip_lama + "</td>" +
                            "<td>" + name + "</td>" +
                            "<td>" + email + "</td>" +
                            "<td>" + "Change Agent" + "</td>" +
                            "</tr>";
                        var tr_str2 = "<tr>" +
                            "<td>" + nip_lama + "</td>" +
                            "<td>" + name + "</td>" +
                            "<td>" + email + "</td>" +
                            "</tr>";
                        $("#userTable tbody").append(tr_str2);
                    }
                }
            });
        }
        $(document).ready(function() {
            $('#add_pegawai').click(function() {
                $('#userTable tbody').empty();
                $('#example1 tbody').prepend(tr_str);
            });
        });

    </script>





@endsection
