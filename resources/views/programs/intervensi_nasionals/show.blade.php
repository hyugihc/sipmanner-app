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
                        <li class="breadcrumb-item active">{{ $intervensiNasional->nama }}</li>
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
                            <h3 class="card-title">{{ $intervensiNasional->nama }} </h3>
                        </div>
                        <!-- /.card-header -->


                        <div class="card-body">
                            <dl>
                                <dt> Jenis</dt>
                                <dd>Program Intervensi Nasional</dd>
                                <dt>Nama Program</dt>
                                <dd>{{ $intervensiNasional->nama }}</dd>
                                <dt>Uraian Kegiatan</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->uraian_kegiatan }}</dd>
                                <dt>Isu Strategis</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->isu_strategis }}</dd>
                                <dt>Output</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->output }} </dd>
                                <dt>Timeline</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->timeline }} </dd>
                                <dt>Ukuran Keberhasilan</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->ukuran_keberhasilan }} </dd>
                                <dt>Outcome</dt>
                                <dd style="white-space: pre-wrap;">{{ $intervensiNasional->outcome }} </dd>
                                <dt>keterangan</dt>
                                <dd style="white-space: pre-wrap;"> {{ $intervensiNasional->keterangan }} </dd>
                            </dl>


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

            if (select == '2') {
                textarea.show();
            }
            if (select == '1') {
                textarea.hide();
            }
        });
    </script>

@endsection
