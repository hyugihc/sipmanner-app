@extends('layouts.master')


@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Edit</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cans.index') }}"> Data</a></li>
                        <li class="breadcrumb-item active">{{ $can->nomor_sk }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">SK Nomor : {{ $can->nomor_sk }} </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.update', $can->id) }}" method="POST" id="quickForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tahun SK</label>
                                    <input type="number" name="tahun_sk" value="{{ old('tahun_sk', $can->tahun_sk) }}"
                                        class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor SK</label>
                                    <input type="text" name="nomor_sk" value="{{ old('nomor_sk', $can->nomor_sk) }}"
                                        class="form-control" placeholder="">
                                </div>
                                @error('nomor_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" value="{{ old('tanggal_sk', $can->tanggal_sk) }}"
                                        class="form-control" placeholder="">
                                </div>
                                @error('tanggal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Perihal SK</label>
                                    <input type="text" name="perihal_sk"
                                        value="{{ old('perihal_sk', $can->perihal_sk) }}" class="form-control"
                                        placeholder="">
                                </div>
                                @error('perihal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label>File SK</label>
                                    <a href="{{ route('cans.download', $can) }}"> file SK </a>
                                    <input accept=".pdf" type="file" name="file_sk"
                                        value="{{ old('file_sk', $can->file_sk) }}" class="form-control" placeholder="">
                                </div>
                                @error('file_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label>Jumlah Change Agent Network <small>(Termasuk Change Leader & Change
                                            Champions)</small></label>
                                    <input type="number" name="jumlah_can" class="form-control"
                                        value="{{ old('jumlah_can', $can->jumlah_can) }}">
                                </div>
                                @error('jumlah_can')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Change Network</label>
                                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                                        data-target="#modal-default">
                                        + Tambahkan Change Ambassador
                                    </button>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nip Lama</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($can->changeLeaders as $user)
                                                <tr>
                                                    <td class="id"></td>
                                                    <td>{{ $user->nip_lama }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>Change Leader</td>
                                                    <td>-</td>
                                                </tr>
                                            @endforeach
                                            @foreach ($can->changeChampions as $user)
                                                <tr>
                                                    <td class="id"></td>
                                                    <td>{{ $user->nip_lama }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>Change Champions</td>
                                                    <td>-</td>
                                                </tr>
                                            @endforeach


                                            @if (old('change_agents') != null)
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach (old('change_agents') as $can)
                                                    <tr>
                                                        <td class="id"></td>
                                                        <td>{{ old('ca_nip')[$i] }} <input name='ca_nip[]'
                                                                value='{{ old('ca_nip')[$i] }}' hidden> </td>
                                                        <td>{{ old('ca_name')[$i] }} <input name='ca_name[]'
                                                                value='{{ old('ca_name')[$i] }}' hidden></td>
                                                        <td>{{ old('ca_email')[$i] }} <input name='ca_email[]'
                                                                value='{{ old('ca_email')[$i] }}' hidden></td>
                                                        <td>Change Ambassador<input hidden name='change_agents[]'
                                                                value='{{ old('change_agents')[$i] }}'></td>
                                                        <td><button type='button' name='remove'
                                                                id='{{ old('change_agents')[$i] }}'
                                                                class='btn btn-danger btn_remove'>delete</button></td>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach ($can->changeAgents as $ca)
                                                    <tr>
                                                        <td class="id"></td>
                                                        <td>{{ $ca->nip_lama }} <input name='ca_nip[]'
                                                                value='{{ $ca->nip_lama }}' hidden></td>
                                                        <td>{{ $ca->name }}<input name='ca_name[]'
                                                                value='{{ $ca->name }}' hidden></td>
                                                        <td>{{ $ca->email }}<input name='ca_email[]'
                                                                value='{{ $ca->email }}' hidden></td>
                                                        <td>Change Ambassador<input hidden name="change_agents[]"
                                                                value="{{ $ca->id }}"></td>
                                                        <td><button type='button' name='remove' id='{{ $ca->id }}'
                                                                class='btn btn-danger btn_remove'>delete</button></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @error('change_agents')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary " name="draft" value="Save as Draft">

                                <input type="submit" class="btn btn-primary " name="submit" value="Submit">
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
    </section>

    @include('cans.search')




@endsection
