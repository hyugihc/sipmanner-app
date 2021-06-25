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

                        <!-- form start -->
                        <form action="{{ route('users.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror"
                                        required data-error-msg="Nama wajib di isi" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control @error('email')
                                                    is-invalid @enderror" value="{{ old('email') }}" required
                                        data-error-msg="Email Tidak Valid">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control"
                                        value="{{ old('password') }}">
                                </div>

                                <div class="form-group">
                                    <label>NIP Lama</label>
                                    <input type="number" name="nip_lama"
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
                                    <select class="form-control" name="provinsi_id">
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

        <script src="js/validate-bootstrap/validate-bootstrap.jquery.min.js"></script>
        <script>
            $(function() {
                $('form').validator({
                    validHandlers: {
                        '.customhandler': function(input) {
                            //may do some formatting before validating
                            input.val(input.val().toUpperCase());
                            //return true if valid
                            return input.val() === 'JQUERY' ? true : false;
                        }
                    }
                });

                $('form').submit(function(e) {
                    e.preventDefault();

                    if ($('form').validator('check') < 1) {
                        alert('Hurray, your information will be saved!');
                    }
                })
            })
        </script>

    </section>
@endsection
