@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                        <li class="breadcrumb-item active">Tahun {{ $report->tahun }}</li>
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
                    <div class="position-relative">


                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Laporan Tahun {{ $report->tahun }} Semester
                                    {{ $report->semester }}
                                </h3>
                            </div>
                            <!-- form start -->
                            <form action="{{ route('reports.approve', $report) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- /.card-header -->


                                <div class="card-body">
                                    <dl>
                                        <dt>I. Pendahuluan</dt>
                                        <dd>{{ $report->bab_i }}</dd>
                                        <dt>II. Latar Belakang</dt>
                                        <dd>{{ $report->bab_ii }}</dd>
                                        <dt>III. Program</dt>
                                        <dd>{{ $report->bab_iii }}</dd>

                                        <div class="form-group">
                                            <label>Program Intervensi Nasional </label>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Volume</th>
                                                            <th>Output</th>
                                                            <th>Outcome</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($intervensiNasionalProvinsis as $pi)
                                                            <tr>
                                                                <td>{{ $pi->intervensiNasional->nama }}</td>
                                                                <td>{{ $pi->intervensiNasional->volume }}</td>
                                                                <td>{{ $pi->intervensiNasional->output }}</td>
                                                                <td>{{ $pi->intervensiNasional->outcome }} </td>



                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Program Intervensi Khusus </label>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Volume</th>
                                                            <th>Output</th>
                                                            <th>Outcome</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($intervensiKhususes as $pi)
                                                            <tr>
                                                                <td>{{ $pi->nama }}</td>
                                                                <td>{{ $pi->volume }}</td>
                                                                <td>{{ $pi->output }}</td>
                                                                <td>{{ $pi->outcome }} </td>

                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <dt>IV. Perubahan Yang Konkret</dt>
                                        <dd>{{ $report->bab_iv }}</dd>
                                        <dt>V. Komitmen Pimpinan</dt>
                                        <dd>{{ $report->bab_v }}</dd>
                                        <dt>VI. Kesimpulan</dt>
                                        <dd>{{ $report->bab_vi }} </dd>
                                        <dt>VII. Penutup</dt>
                                        <dd> {{ $report->bab_vii }} </dd>
                                        <dt>Lampiran</dt>
                                        <dd> {{ $report->bab_viii }} </dd>
                                        @if ($report->status == 3)
                                            <dt>Alasan Tidak Disetujui</dt>
                                            <dd>{{ $report->alasan }}</dd>
                                        @endif

                                    </dl>

                                    @can('approve', $report)
                                        <div class="form-group">
                                            <label>Tindakan</label>
                                            <select id="selectA" class="form-control" name="status">
                                                <option value="2">Setuju</option>
                                                <option value="3">Tidak Setuju</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="divtextarea">
                                            <label>Alasan</label>
                                            <textarea type="text" name="alasan" value="{{ $report->alasan }}"
                                                class="form-control" placeholder=""></textarea>
                                        </div>

                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    @endcan

                                    @if ($report->status == 2)
                                        <div class="card-footer">
                                            <div class="col-md-2 float-right" >
                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('reports.show', $report) }}">Print</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                        <div class="ribbon-wrapper ribbon-xl">
                            <div class="ribbon bg-success text-lg">
                                @switch($report->status)
                                    @case(0)
                                        Draft
                                    @break
                                    @case(1)
                                        Belum Disetujui
                                    @break
                                    @case(2)
                                        Sudah Disetujui
                                    @break
                                    @case(3)
                                        Tidak Disetujui
                                    @break
                                    @default
                                        Tidak ada yang sesuai
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
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
