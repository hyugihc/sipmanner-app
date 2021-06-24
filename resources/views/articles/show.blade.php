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
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol> --}}
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
                    <div class="card card-primary card-outline">

                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5>{{ $article->title }}</h5>
                                <h6>From: {{ $article->user->name }}
                                    <span class="mailbox-read-time float-right">{{ $article->created_at }}</span>
                                </h6>
                            </div>

                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                @php
                                    echo $article->content;
                                @endphp

                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="{{ route('articles.download', $article) }}"
                                            class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>
                                            {{ $article->file_content }} </a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1,245 KB</span>
                                            <a href="{{ route('articles.download', $article) }}"
                                                class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-footer -->
                        <div class="card-footer">
                            <form action="{{ route('articles.approve', $article) }}" method="POST" id="quickForm">
                                @csrf
                                @method('PUT')
                                @can('approve', $article)
                                    <div class="form-group">
                                        <label>Tindakan</label>
                                        <select id="selectA" class="form-control" name="status">
                                            <option value="2">Setuju</option>
                                            <option value="3">Tidak Setuju</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="divtextarea">
                                        <label>Alasan</label>
                                        <textarea type="text" name="alasan" value="{{ $article->alasan }}"
                                            class="form-control" placeholder=""></textarea>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Submit</button>

                                @endcan

                            </form>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->

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
    </section>



@endsection
