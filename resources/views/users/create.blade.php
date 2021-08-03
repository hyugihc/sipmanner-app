@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create a User</h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">

                            <div class="form-group">
                                <label>Cari Pegawai:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="input_nip" />
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-search" id="search_nip"></i></div>
                                    </div>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="alert alert-danger" id="danger_nip">
                                <label>Pegawai tidak ditemukan</label>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf


                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control  @error('name') is-invalid @enderror" required
                                        data-error-msg="Nama wajib di isi" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email')
                                                                                                                                                    is-invalid @enderror"
                                        value="{{ old('email') }}" required data-error-msg="Email Tidak Valid">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        value="{{ old('password') }}">
                                </div>

                                <div class="form-group">
                                    <label>NIP Lama</label>
                                    <input type="number" name="nip_lama" id="nip_lama"
                                        class="form-control  @error('nip_lama') is-invalid @enderror"
                                        value="{{ old('nip_lama') }}" required data-error-msg="NIP lama wajib di isi">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if ($role->id == old('role_id')) selected="selected" @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Unit Organisasi</label>
                                    <select class="form-control" name="provinsi_id" id="provinsi_id">
                                        @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}" @if ($role->id == old('provinsi_id')) selected="selected" @endif>
                                                {{ $provinsi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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

        {{-- <script src="js/validate-bootstrap/validate-bootstrap.jquery.min.js"></script> --}}
        <script>
            // $(function() {
            //     $('form').validator({
            //         validHandlers: {
            //             '.customhandler': function(input) {
            //                 //may do some formatting before validating
            //                 input.val(input.val().toUpperCase());
            //                 //return true if valid
            //                 return input.val() === 'JQUERY' ? true : false;
            //             }
            //         }
            //     });

            //     $('form').submit(function(e) {
            //         e.preventDefault();
            //         if ($('form').validator('check') < 1) {
            //             alert('Hurray, your information will be saved!');
            //         }
            //     })
            // })

            $(document).ready(function() {
                $('#danger_nip').hide();
                $('#input_nip').keypress(function(e) {
                    var key = e.which;
                    if (key == 13) {
                        $('#search_nip').click();
                        return false;
                    }
                });
            });
            $('#search_nip').click(function() {
                $('#danger_nip').hide();
                $('#error_nip').val("");
                var nip = Number($('#input_nip').val().trim());
                if (nip > 0) {
                    var loadingText =
                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Loading...";
                    $("#search_nip").html(loadingText);
                    cariPegawai(nip);
                }
            });

            function cariPegawai(nip) {
                var urlx = '{{ route('get_user_byniplama_sso', ':nip') }}';
                urlx = urlx.replace(':nip', nip);
                $.ajax({
                    url: urlx,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0; // Empty <tbody>
                        if (response['data'] != null) {
                            var id = response['data'].id;
                            var name = response['data'].name;
                            var email = response['data'].email;
                            var nip_lama = response['data'].nip_lama;
                            var provinsi_id = response['data'].provinsi_id;
                            var role_id = 6;
                            console.log(provinsi_id);
                            $('#name').val(name);
                            $('#email').val(email);
                            $('#password').val("admin");
                            $('#nip_lama').val(nip_lama);
                            $('#provinsi_id').val(provinsi_id);
                            $("#search_nip").html("");
                        }
                    },
                    error: function(response) {
                        console.log("response error");
                        $('#name').val("");
                        $('#email').val("");
                        $('#password').val("");
                        $('#nip_lama').val("");
                        try {
                            data = JSON.parse(response);
                        } catch (e) {
                            $('#danger_nip').show();
                            $("#search_nip").html("");
                        }
                    }
                });
            }
        </script>

    </section>
@endsection
