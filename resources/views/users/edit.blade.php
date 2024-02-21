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

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit {{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder=""
                                        value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" placeholder=""
                                        value="{{ old('email', $user->email) }}">
                                </div>

                                <div class="form-group">
                                    <label>Password <small>kosongkan jika tidak berubah</small></label>
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>NIP Lama</label>
                                    <input type="text" name="nip_lama" class="form-control" placeholder=""
                                        value="{{ old('email', $user->nip_lama) }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if ($role->id == old('role_id', $user->role_id)) selected="selected" @endif>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Unit Organisasi</label>
                                    <select class="form-control" name="provinsi_id">
                                        @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}" @if ($provinsi->id == old('role_id', $user->provinsi_id)) selected="selected" @endif>
                                                {{ $provinsi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
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

    @endsection
