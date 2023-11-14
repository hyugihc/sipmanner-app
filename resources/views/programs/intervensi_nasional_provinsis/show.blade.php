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
                    <li class="breadcrumb-item"><a href="{{ route('programs.index') }}"> Rencana</a></li>
                    <li class="breadcrumb-item active">{{ $intervensiNasionalProvinsi->intervensiNasional->nama }}</li>
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
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $intervensiNasionalProvinsi->intervensiNasional->nama }} </h3>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">
                        <dl>
                            <dt> Jenis</dt>
                            <dd>Program Intervensi Nasional</dd>
                            <dt>Nama Program</dt>
                            <dd>{{ $intervensiNasionalProvinsi->intervensiNasional->nama }}</dd>
                            <dt>Uraian Kegiatan</dt>
                            <dd>
                                <p class="preline">{{ $intervensiNasionalProvinsi->intervensiNasional->uraian_kegiatan }}
                                </p>
                            </dd>
                            <dt>Output</dt>
                            <dd>
                                <p class="preline"> {{ $intervensiNasionalProvinsi->intervensiNasional->output }} </p>
                            </dd>
                            <dt>Timeline</dt>
                            <dd>
                                {{ $intervensiNasionalProvinsi->intervensiNasional->timeline }}
                            </dd>
                            <dt>Ukuran Keberhasilan</dt>
                            <dd>
                                @if ($intervensiNasionalProvinsi->ukuran_keberhasilan == null)
                                Ukuran keberhasilan untuk satker belum ditentukan
                                @else
                                <p class="preline"> {{ $intervensiNasionalProvinsi->ukuran_keberhasilan }} </p>
                                @endif

                            </dd>
                            <dt>Outcome</dt>
                            <dd>
                                <p class="preline"> {{ $intervensiNasionalProvinsi->intervensiNasional->outcome }} </p>
                            </dd>
                            @if ($intervensiNasionalProvinsi->intervensiNasional->keterangan == null)
                            @else
                            <dt>Keterangan</dt>
                            <dd>
                                <p class="preline">
                                    {{ $intervensiNasionalProvinsi->intervensiNasional->keterangan }}
                                </p>
                            </dd>
                            @endif



                        </dl>



                    </div>
                    <!-- jika sudah disetujui maka akan muncul tombol untuk melihat progress -->
                    @if ($intervensiNasionalProvinsi->status == 2)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-2">
                                <a class="btn btn-block btn-primary btn-xs" href="{{ route('progress-intervensi-nasionals-provinsi.index2', $intervensiNasionalProvinsi) }}">Lihat
                                    Progress</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Penyesuaian Program Intervensi
                            {{ $intervensiNasionalProvinsi->intervensiNasional->nama }} pada
                            {{ $intervensiNasionalProvinsi->provinsi->nama_singkat }}
                        </h3>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">
                        <dl>


                            <dt>Ukuran Keberhasilan</dt>
                            <dd>
                                @if ($intervensiNasionalProvinsi->ukuran_keberhasilan == null)
                                Ukuran keberhasilan untuk satker belum ditentukan
                                @else
                                <p class="preline">{{ $intervensiNasionalProvinsi->ukuran_keberhasilan }} </p>
                                @endif

                            </dd>
                            @if ($intervensiNasionalProvinsi->timeline == null)
                            @else
                            <dt>Timeline</dt>
                            <dd>
                                {{ $intervensiNasionalProvinsi->timeline }}
                                @endif
                                @if ($intervensiNasionalProvinsi->keterangan == null)
                                @else
                            <dt>Keterangan</dt>
                            <dd>
                                <p class="preline"> {{ $intervensiNasionalProvinsi->keterangan }} </p>
                            </dd>
                            @endif

                            <dt>Status</dt>
                            <dd>
                                {{ $intervensiNasionalProvinsi->getStatus() }}
                            </dd>
                            @if ($intervensiNasionalProvinsi->status == 3)
                            <dt>Alasan</dt>
                            <dd>
                                {{ $intervensiNasionalProvinsi->alasan }}
                            </dd>
                            @endif

                            @can('approve', $intervensiNasionalProvinsi)
                            <!-- form start -->
                            <form action="{{ route('inp.approve', $intervensiNasionalProvinsi) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Tindakan</label>
                                    <select id="selectA" class="form-control" name="status">
                                        <option value="2">Setuju</option>
                                        <option value="3">Tidak Setuju</option>
                                    </select>
                                </div>

                                <div class="form-group" id="divtextarea">
                                    <label>Alasan</label>
                                    <textarea type="text" name="alasan" value="{{ $intervensiNasionalProvinsi->intervensiNasional->alasan }}" class="form-control" placeholder=""></textarea>
                                </div>

                                <div style="margin: 10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                            @endcan

                        </dl>




                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<style>
    /* kelas preline untuk element <p> */
    p.preline {
        white-space: pre-line;
    }
</style>

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