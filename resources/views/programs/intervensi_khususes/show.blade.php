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
                        <li class="breadcrumb-item"><a href="{{ route('programs.index') }}">Rencana</a></li>
                        <li class="breadcrumb-item active">{{ $intervensiKhusus->nama }}</li>
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
                            <h3 class="card-title">{{ $intervensiKhusus->nama }} </h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('intervensi-khususes.approve', $intervensiKhusus) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- /.card-header -->


                            <div class="card-body">
                                <dl>
                                    <dt> Jenis</dt>
                                    <dd>Program Intervensi Khusus</dd>
                                    <dt>Unit Kerja</dt>
                                    <dd>{{ $intervensiKhusus->provinsi['nama'] }} </dd>
                                    <dt>Nama Program Intervensi</dt>
                                    <dd>{{ $intervensiKhusus->nama }}</dd>
                                    <dt>Uraian Kegiatan</dt>
                                    <dd style="white-space: pre-wrap;">{{ $intervensiKhusus->uraian_kegiatan }}</dd>
                                    <dt>Volume Kegiatan setahun</dt>
                                    <dd>{{ $intervensiKhusus->volume }}</dd>
                                    <dt>Nilai Pia</dt>
                                    @foreach ($intervensiKhusus->pias as $pia)
                                        <dd>{{ $pia->nama }}</dd>
                                    @endforeach
                                    <dt>Output</dt>
                                    <dd style="white-space: pre-wrap;">{{ $intervensiKhusus->output }} </dd>
                                    <dt>Outcome</dt>
                                    <dd style="white-space: pre-wrap;">{{ $intervensiKhusus->outcome }} </dd>
                                    <dt>keterangan</dt>
                                    <dd style="white-space: pre-wrap;">{{ $intervensiKhusus->keterangan }} </dd>

                                    <dt>Status</dt>
                                    @switch($intervensiKhusus->status)
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
                                            <dd style="white-space: pre-wrap;">{{ $intervensiKhusus->alasan }}</dd>
                                        @break
                                        @default
                                            <dd>Tidak ada yang sesuai</dd>
                                    @endswitch
                                </dl>

                                @can('approve', $intervensiKhusus)
                                    <div class="form-group">
                                        <label>Tindakan</label>
                                        <select id="selectA" class="form-control" name="status">
                                            <option value="2">Setuju</option>
                                            <option value="3">Tidak Setuju</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="divtextarea">
                                        <label>Alasan</label>
                                        <textarea type="text" name="alasan" value="{{ $intervensiKhusus->alasan }}"
                                            class="form-control" placeholder=""></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            @endcan
                    </div>
                    <!-- /.card -->
                    </form>
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
