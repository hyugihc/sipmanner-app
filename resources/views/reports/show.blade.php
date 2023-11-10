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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">{{ $report->tahun }}</a></li>
                    <li class="breadcrumb-item active">Semester {{ $report->semester }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->
<section class="content">


    <div class="container-fluid">
        @if (Auth::user()->isChangeLeader() AND $report->status == 0)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Laporan Masih Draft</h5>
            Hanya Laporan yang berstatus <b>Diajukan ke Change Leader</b> yang dapat dilakukan Approval
        </div>
        @endif

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="position-relative">
                    @if ($report->status == 2)
                    <!-- jika user adalah change champion pada satker report ini maka tampilkan tombol upload laporan -->
                    @if (Auth::user()->isChangeChampionOf($report->provinsi_id))
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Upload Softcopy Laporan
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="form-group">
                                {{-- <label>Upload Softcopy Laporan</label> --}}
                                <!-- upload softcopy pdf laporan -->
                                <form action="{{ route('reports.upload-laporan', $report->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        {{-- <label for="exampleInputFile">Upload Softcopy Laporan</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="exampleInputFile"
                                                            name="laporan" accept=".pdf">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>

                                                </div> --}}
                                        <label>Upload Softcopy Laporan</label>
                                        <input accept=".pdf" type="file" name="laporan" class="form-control" placeholder="">


                                        <div class="input-group-append" style="padding-top: 5px">
                                            <button class="btn btn-primary" type="submit">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    @endif
                    @endif


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Laporan {{ $report->provinsi->nama }} Tahun {{ $report->tahun }} Semester
                                {{ $report->semester }}
                            </h3>
                        </div>

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
                                    <label>A. Program Intervensi Nasional </label>
                                    <div class="card-body table-bordered table-condensed table-responsive p-0">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Uraian Kegiatan</th>
                                                    <th>Output</th>
                                                    <th>Timeline</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach ($report->intervensiNasionalProvinsis as $pi)
                                                <tr>
                                                    <td><b>{{ $i }}</b></td>
                                                    <td>{{ $pi->intervensiNasional->nama }}</td>
                                                    <td>{{ $pi->intervensiNasional->uraian_kegiatan }}</td>
                                                    <td>{{ $pi->intervensiNasional->output }}</td>
                                                    <td>{{ $pi->intervensiNasional->timeline }} </td>
                                                </tr>
                                                <tr>
                                                    <th>Outcome</th>
                                                    <td colspan="4"> {{ $pi->intervensiNasional->outcome }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Ukuran Keberhasilan</th>
                                                    <td colspan="4"> {{ $pi->ukuran_keberhasilan }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Kendala</th>
                                                    <td colspan="4"> {{ $pi->pivot->kendala }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Solusi</th>
                                                    <td colspan="4"> {{ $pi->pivot->solusi }}</td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>B. Program Intervensi Khusus </label>
                                    <div class="card-body table-bordered table-condensed table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Change Champions</th>
                                                    <th>Uraian Kegiatan</th>
                                                    <th>Output</th>
                                                    <th>Timeline</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1;
                                                @endphp
                                                @foreach ($report->intervensiKhususes as $pi)
                                                <tr>
                                                    <td><b>{{ $i }}</b></td>
                                                    <td>{{ $pi->nama }}</td>
                                                    <td>{{ $pi->user->name }}</td>
                                                    <td>{{ $pi->uraian_kegiatan }}</td>
                                                    <td>{{ $pi->output }}</td>
                                                    <td>{{ $pi->timeline }} </td>
                                                </tr>
                                                <tr>
                                                    <th>Outcome</th>
                                                    <td colspan="5">{{ $pi->outcome }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Ukuran Keberhasilan</th>
                                                    <td colspan="5">{{ $pi->ukuran_keberhasilan }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Kendala</th>
                                                    <td colspan="5"> {{ $pi->pivot->kendala }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Solusi</th>
                                                    <td colspan="5"> {{ $pi->pivot->solusi }}</td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
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
                                @if ($report->status == 3)
                                <dt>Alasan Tidak Disetujui</dt>
                                <dd>{{ $report->alasan }}</dd>
                                @endif

                            </dl>

                            <div class="col-md-6 float-left">
                                @if ($report->lampiran != null)
                                <a href="{{ route('reports.download-lampiran', $report) }}"> <i class="fas fa-paperclip"></i> Download
                                    lampiran</a>
                                @endif

                            </div>
                            <div class="col-md-6 float-right">
                                @if ($report->status == 2)
                                <a href="{{ route('reports.print', $report) }}"><i class="fas fa-print"></i>
                                    Print</a>
                                @endif
                                @if ($report->status == 4)
                                <a href="{{ route('reports.download-laporan', $report) }}"><i class="fas fa-download"></i>
                                    Unduh Laporan</a>
                                @endif

                            </div>



                            <br>
                            <br>





                            <!-- cek jika report sedang diajukan ke change leader -->
                            @if ($report->status == 1)
                            <!-- form start -->
                            <form action="{{ route('reports.approve', $report) }}" method="POST">
                                @csrf
                                @method('PUT')
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
                                    <textarea type="text" name="alasan" value="{{ $report->alasan }}" class="form-control" placeholder=""></textarea>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                @endcan
                            </form>
                            @endif



                        </div>

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
                            @case(4)
                            Sudah Upload
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