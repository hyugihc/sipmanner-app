@extends('layouts.master')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    @can('create', App\Can::class)
                        <a class="btn btn-block btn-primary btn-sm" href="{{ route('cans.create') }}">Create</a>
                    @endcan
                </div><!-- /.col -->

                <div class="col-sm-4">

                </div><!-- /.col -->




                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Cans</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cans</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Perihal SK</th>
                                    <th>Approval</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cans as $can)
                                    <tr>
                                        <td>{{ $can->nomor_sk }}</td>
                                        <td>{{ $can->tanggal_sk }}</td>
                                        <td>{{ $can->perihal_sk }}</td>
                                        <td>
                                            @if ($can->approval == 1)
                                                <dd>Sudah Disetujui</dd>
                                            @elseif ($can->approval == 2)
                                                <dd>Tidak Disetujui</dd>
                                                <dd> {{ $can->alasan }}</dd>
                                            @elseif($can->approval == 3)
                                                <dd>Belum Disetujui</dd>
                                            @endif

                                        </td>
                                        <td>{{ $can->provinsi['nama'] }}</td>
                                        {{-- <td>
                                        <button type="button" class="btn btn-block btn-primary btn-sm">Show</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-warning btn-sm">Edit</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger btn-sm">Delete</button>
                                    </td> --}}

                                        <td>

                                            <form action="{{ route('cans.destroy', $can->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <a class="btn btn-block btn-primary btn-xs"
                                                    href="{{ route('cans.show', $can->id) }}">Show</a>

                                                @can('update', $can)
                                                    <a class="btn btn-block btn-warning btn-xs"
                                                        href="{{ route('cans.edit', $can->id) }}">Edit</a>
                                                @endcan

                                                @can('delete', $can)
                                                    <button type="submit"
                                                        class="btn btn-block btn-danger btn-xs">Delete</button>
                                                @endcan



                                            </form>
                                        </td>

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


        {{-- <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->detail }}</td>
            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table> --}}

    @endsection
