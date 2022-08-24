@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Top Leader</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover" id="table_users">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($top_leaders as $tl)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $tl->name }}</td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Change Leader & Change Champions</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover" id="table_users">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Eselon II</th>
                                    <th>Change Leader</th>
                                    <th>Change Champions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($provinsis as $provinsi)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $provinsi->nama_singkat }}</td>
                                        <td>
                                            <!-- / jika provinsi tidak  mempunyai change leader tampilkan kosong, jika punya tampilkan nama change leader -->
                                            @if (!$provinsi->changeLeader()->exists())
                                                -
                                            @else
                                                {{ $provinsi->changeLeader['name'] }}
                                            @endif


                                        </td>
                                        <td>
                                            @php
                                                $x = 1;
                                            @endphp
                                            @foreach ($provinsi->changeChampions as $cc)
                                                -
                                                {{ $cc['name'] }}
                                                <br>
                                                @php
                                                    $x++;
                                                @endphp
                                            @endforeach
                                        </td>
                                        <td>

                                        </td>
                                        @php
                                            $i++;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>


    </section>
@endsection
