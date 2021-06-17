@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    <h3>Create</h3>

                </div><!-- /.col -->
                <div class="col-sm-4">
                </div><!-- /.col -->

                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Cans</li>
                    </ol> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">

                <!-- form start -->
                <form action="{{ route('articles.store') }}" method="POST" id="quickForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Buat Artikel baru</h3>
                        </div>
                        <!-- /.card-header -->
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach


                        <div class="card-body">
                            <div class="form-group">
                                <label for="Judul">Judul</label>
                                <input class="form-control" placeholder="Judul" name="title">
                            </div>
                            <div class="form-group">
                                <label for="isi">Isi Berita</label>
                                <textarea name="content" id="compose-textarea" class="form-control" style="height: 300px">

                                                                </textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Attachment
                                    <input type="file" name="file_content">
                                </div>
                                <p class="help-block">Max. 2MB</p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                {{-- <button name="draft" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i>
                                    Draft</button> --}}
                                <button name="submit" type="submit" class="btn btn-primary"><i class="far fa-envelope"></i>
                                    Send</button>
                            </div>
                            <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->

                </form>
            </div>
        </div>

        <!-- Summernote -->
        <script src="{{ asset('') }}assets/plugins/summernote/summernote-bs4.min.js"></script>
        <script>
            $(function() {
                //Add text editor
                $('#compose-textarea').summernote()
            })

        </script>

    </section>
@endsection
