@extends('layouts.master')

@section('content')


    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.min.css"> 

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    {{-- <h3> Edit</h3> --}}

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


        <div class="row">
            <div class="col-md-12">

                <!-- form start -->
                @if (isset($article))
                    <form action="{{ route('articles.update', $article) }}" method="POST" id="quickForm"
                        enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('articles.store') }}" method="POST" id="quickForm"
                            enctype="multipart/form-data">
                @endif
                @csrf


                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ isset($article) ? 'Edit ' . $article->title : 'Buat Artikel Baru' }}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach


                    <div class="card-body">
                        <div class="form-group">
                            <label for="Judul">Judul</label>
                            <input class="form-control" placeholder="Judul" name="title"
                                value="{{ old('title', isset($article) ? $article->title : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi Berita</label>
                            <textarea name="content" id="compose-textarea" class="form-control" style="height: 300px">{{ old('content', isset($article) ? $article->content : '') }}</textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="float-right">
                            {{-- <button name="draft" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i>
                                    Draft</button> --}}
                            <input type="submit" class="btn btn-primary" name=" submit"
                                value="{{ isset($article) ? 'Simpan' : 'Submit' }}">
                        </div>
                        {{-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button> --}}
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
              $('#compose-textarea').summernote( {height: 400})
          })
      </script>

    </section>
@endsection
