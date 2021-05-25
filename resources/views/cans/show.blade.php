@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
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
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.update', $can->id) }}" method="POST" id="quickForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <dl>
                                    <dt> Nomor SK</dt>
                                    <dd> {{ $can->nomor_sk }}</dd>
                                    <dt>Tanggal SK</dt>
                                    <dd>{{ $can->tanggal_sk }}</dd>
                                    <dt>Perihal SK</dt>
                                    <dd>{{ $can->perihal_sk }}</dd>
                                    <dt>File SK</dt>
                                    <dd> <a href="{{ route('cans.download', $can) }}"> File SK</a></dd>
                                </dl>
                                @if ($can->approval == 1)
                                    <dt>Approval</dt>
                                    <dd>Sudah Disetujui</dd>
                                @endif
                                @can('approval', $can)
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Approval</label>
                                        <select class="form-control" name="approval">
                                            <option value="1">Setuju</option>
                                            <option value="2">Tidak Setuju</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Alasan</label>
                                        <input type="text" name="alasan" value="{{ $can->alasan }}" class="form-control"
                                            id="exampleInputEmail1" placeholder="">
                                    </div>
                                @endcan

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
    </section>

@endsection
