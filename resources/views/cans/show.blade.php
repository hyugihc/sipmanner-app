@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Show</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cans.index') }}"> Data</a></li>
                        <li class="breadcrumb-item active">{{ $can->nomor_sk }}</li>
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
                            <h3 class="card-title">SK Nomor : {{ $can->nomor_sk }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.approve', $can) }}" method="POST" id="quickForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <dl>
                                    <dt> Tahun SK</dt>
                                    <dd> {{ $can->tahun_sk }}</dd>
                                    <dt>Tanggal SK</dt>
                                    <dd>{{ $can->tanggal_sk }}</dd>
                                    <dt>Perihal SK</dt>
                                    <dd>{{ $can->perihal_sk }}</dd>
                                    <dt>File SK</dt>
                                    <dd> <a href="{{ route('cans.download', $can) }}"> File SK</a></dd>
                                    <dt>Jumlah Change Agent Network</dt>
                                    <dd>{{ $can->jumlah_can }}</dd>
                                    <dt>Change Leader</dt>
                                    @foreach ($can->changeLeaders as $user)
                                        <dd> {{ $user->name }} </dd>
                                    @endforeach
                                    <dt>Change Champions</dt>
                                    @foreach ($can->changeChampions as $user)
                                        <dd> {{ $user->name }} </dd>
                                    @endforeach
                                    <dt>Change Agents</dt>
                                    @foreach ($can->changeAgents as $user)
                                        <dd> {{ $user->name }} </dd>
                                    @endforeach

                                    <dt>Status</dt>
                                    @switch($can->status_sk)
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
                                            <dt>Alasan</dt>
                                            <dd>{{ $can->alasan }}</dd>
                                        @break
                                        @case(4)
                                            <dd>Sudah Disetujui (Tidak Aktif)</dd>
                                        @break
                                        @default
                                            <dd>Tidak ada yang sesuai</dd>
                                    @endswitch

                                </dl>
                                @can('approve', $can)
                                    <div class="form-group">
                                        <label>Tindakan</label>
                                        <select id="selectA" class="form-control" name="status_sk">
                                            <option value="2">Setuju</option>
                                            <option value="3">Tidak Setuju</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="divtextarea">
                                        <label for="exampleInputEmail1">Alasan</label>
                                        <textarea type="text" name="alasan" value="{{ $can->alasan }}" class="form-control"
                                            placeholder=""></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            @endcan


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

    <script>
        $(document).ready(function() {
            var textarea = $('#divtextarea');
            textarea.hide();
        });

        $('#selectA').on('change', function() {
            var textarea = $('#divtextarea');
            var select = $(this).val();

            textarea.hide();

            if (select == '3') {
                textarea.show();
            }
            if (select == '2') {
                textarea.hide();
            }
        });
    </script>

@endsection
