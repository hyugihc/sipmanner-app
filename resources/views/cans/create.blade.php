@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0"> Create</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cans.index') }}"> Data</a></li>
                        <li class="breadcrumb-item active"> Create</a></li>
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
                            <h3 class="card-title">Form Data Change Agent Network</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label>Tahun SK</label>
                                    <select name="tahun_sk" class="form-control">
                                        <option> {{ Auth::user()->getSetting('tahun') }}</option>
                                    </select>
                                </div>

                                @error('tahun_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Nomor SK</label>
                                    <input type="text" name="nomor_sk" class="form-control"
                                        value="{{ old('nomor_sk') }}">
                                </div>

                                @error('nomor_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" class="form-control"
                                        value="{{ old('tanggal_sk') }}">
                                </div>

                                @error('tanggal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Perihal SK</label>
                                    <input type="text" name="perihal_sk" class="form-control"
                                        value="{{ old('perihal_sk') }}">
                                </div>
                                @error('perihal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>File SK</label>
                                    <input type="file" name="file_sk" class="form-control" value="{{ old('file_sk') }} "
                                        accept=".pdf">
                                </div>
                                @error('file_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Jumlah Change Agent Network <small>(Termasuk Change Leader & Change
                                            Champions)</small></label>
                                    <input type="number" name="jumlah_can" class="form-control"
                                        value="{{ old('jumlah_can') }}">
                                </div>
                                @error('jumlah_can')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Change Network</label>
                                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                                        data-target="#modal-default-name">
                                        + Tambahkan Change Agent (Beta)
                                    </button>
                                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                                        data-target="#modal-default">
                                        + Tambahkan Change Agent (nip)
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

                                            @foreach ($changeLeaders as $cl)
                                                <tr>
                                                    <td class="id"></td>
                                                    <td>{{ $cl->nip_lama }}</td>
                                                    <td>{{ $cl->name }}</td>
                                                    <td>{{ $cl->email }}</td>
                                                    <td>Change Leader</td>
                                                    <td>-</td>
                                                </tr>
                                            @endforeach
                                            @foreach ($changeChampions as $cc)
                                                <tr>
                                                    <td class="id"></td>
                                                    <td>{{ $cc->nip_lama }}</td>
                                                    <td>{{ $cc->name }}</td>
                                                    <td>{{ $cc->email }}</td>
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
                                                        <td>Change Agent<input hidden name='change_agents[]'
                                                                value='{{ old('change_agents')[$i] }}'></td>
                                                        <td><button type='button' name='remove'
                                                                id='{{ old('change_agents')[$i] }}'
                                                                class='btn btn-danger btn_remove'>delete</button></td>
                                                        @php
                                                            $i++;
                                                        @endphp
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
                                <input type="submit" class="btn btn-primary" name=" draft" value="Save as Draft">
                                <input type="submit" class="btn btn-primary" name=" submit" value="Submit">
                                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
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
    <!-- include search-name.blade.php -->
    @include('cans.search-name')


@endsection
