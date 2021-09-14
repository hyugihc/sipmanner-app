@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ isset($intervensiNasional) ? 'Edit' : 'Create' }}</h1> --}}
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Penyesuaian Ukuran Keberhasilan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form action="{{ route('inp.update', $intervensiNasionalProvinsi) }}" method="POST">
                            @method('PUT')

                            @csrf
                            <div class="card-body">


                                <div class="form-group">
                                    <span>Semua Isian bertanda * (bintang) wajib di isi</span>
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

                                <div class="form-group">
                                    <label>Ukuran Keberhasilan*</label>
                                    <span>(silakan sesuaikan % nya saja)</span>
                                    <textarea type="text" name="ukuran_keberhasilan" class="form-control"
                                        placeholder="">{{ old('ukuran_keberhasilan', $intervensiNasionalProvinsi->intervensiNasional->ukuran_keberhasilan) }}</textarea>
                                    </textarea>
                                </div>

                                @if ($intervensiNasionalProvinsi->status == 3)
                                   Alasan Penolakan:  {{ $intervensiNasionalProvinsi->alasan }}
                                @endif


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name=" submit" value="Submit ke Change Leader">
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

        <script src="{{ asset('') }}assets/plugins/select2/js/select2.full.min.js"></script>
        <script>
            $(document).ready(function() {
                var year = new Date().getFullYear();
                $("#year").append('<option value=' + year + '>' + year + '</option>');
            });
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })
        </script>

    </section>
@endsection
