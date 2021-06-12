@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('articles.create') }}">Create</a>

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
                <div class="card">
                    {{-- <div class="card-header p-2">
                        <h3>Article</h3>
                    </div> --}}
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">

                                @foreach ($articles as $article)
                                    <!-- Post -->

                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm"
                                                src="{{ asset('') }}assets/dist/img/user1-128x128.jpg" alt="user image">
                                            <span class="username">
                                                <a
                                                    href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            {{-- {{ $article->user->name}} --}}
                                            <span class="description">{{ $article->created_at }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            @php
                                                echo Str::substr($article->content, 0, 500);
                                            @endphp
                                        </p>

                                        <p>
                                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
                                                Share</a>
                                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                                Like</a>
                                            <span class="float-right">
                                                <a href="{{ route('articles.edit', $article) }}"
                                                    class="link-black text-sm">
                                                    <i class="far  mr-1"></i> edit
                                                </a>
                                            </span>
                                        </p>

                                        {{-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> --}}
                                    </div>
                                    <!-- /.post -->
                                @endforeach



                                {{ $articles->links() }}
                            </div>

                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
@endsection
