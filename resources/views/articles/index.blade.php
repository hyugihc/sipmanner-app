@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    <a class="btn btn-block btn-primary btn-sm" href="{{ route('articles.create') }}">Create</a>
                </div><!-- /.col -->

                <div class="col-sm-10">
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

        @if (auth()->user()->isAdmin())
            @if ($submittedArticles->count() != 0)
                <div class="p-2">
                    <h6>Belum Disetujui</h6>
                </div>
            @endif
            @foreach ($submittedArticles as $article)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="{{ $article->user->avatar }}"
                                                    alt="user image">
                                                <span class="username">
                                                    <a
                                                        href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                                    @can('delete', $article)
                                                        <form action="{{ route('articles.destroy', $article) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            {{-- <a href="#" class="float-right btn-tool"> --}}

                                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                                class="float-right btn-tool fas fa-times"></button>
                                                        </form>
                                                    @endcan
                                                </span>
                                                {{-- {{ $article->user->name}} --}}
                                                <span class="description">{{ $article->user->name }}
                                                    @php
                                                        echo date_format($article->created_at, 'd-m-Y');
                                                    @endphp</span>
                                            </div>
                                            <!-- /.user-blockx -->
                                            <p>
                                                @php
                                                    echo substr(strip_tags($article->content), 0, 500) . '.......';
                                                @endphp
                                            </p>

                                            <p>
                                                @can('update', $article)
                                                    <span class="float-right">
                                                        <a href="{{ route('articles.edit', $article) }}"
                                                            class="link-black text-sm">
                                                            <i class="far  mr-1"></i> edit
                                                        </a>
                                                    </span>
                                                @endcan
                                            </p>
                                        </div>
                                        <!-- /.post -->
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
            @endforeach
        @endif

        @if (auth()->user()->isAdmin())
            <div class="p-2">
                <h6>Sudah Disetujui</h6>
            </div>
        @endif

        @foreach ($articles as $article)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">

                                    <!-- Post -->

                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="{{ $article->user->avatar }}"
                                                alt="user image">
                                            <span class="username">
                                                <a
                                                    href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                                @can('delete', $article)
                                                    <form action="{{ route('articles.destroy', $article) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        {{-- <a href="#" class="float-right btn-tool"> --}}

                                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                            class="float-right btn-tool fas fa-times"></button>

                                                    </form>
                                                @endcan
                                            </span>

                                            <span class="description">{{ $article->user->name }}
                                                @php
                                                    echo date_format($article->created_at, 'd-m-Y');
                                                @endphp
                                            </span>
                                        </div>
                                        <!-- /.user-blockx -->
                                        <p>
                                            @php
                                                echo substr(strip_tags($article->content), 0, 500) . '.......';
                                            @endphp
                                        </p>

                                        <p>
                                          
                                            @can('update', $article)
                                                <span class="float-right">
                                                    <a href="{{ route('articles.edit', $article) }}"
                                                        class="link-black text-sm">
                                                        <i class="far  mr-1"></i> edit
                                                    </a>
                                                </span>
                                            @endcan
                                        </p>

                                        {{-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment"> --}}
                                    </div>
                                    <!-- /.post -->

                                </div>
                                <!-- /.tab pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col md 12 -->
            </div>
            <!-- /.row -->

        @endforeach
        {{ $articles->links() }}

    </section>
@endsection
