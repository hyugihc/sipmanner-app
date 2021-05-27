@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cans Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Cans</li>
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
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('cans.store') }}" method="POST" id="quickForm"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor SK</label>
                                    <input type="text" name="nomor_sk" class="form-control" value="{{ old('nomor_sk') }}"
                                        placeholder="">
                                </div>
                                @error('nomor_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" class="form-control"
                                        value="{{ old('tanggal_sk') }}" placeholder="">
                                </div>
                                @error('tanggal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Perihal SK</label>
                                    <input type="text" name="perihal_sk" class="form-control"
                                        value="{{ old('perihal_sk') }}" placeholder="">
                                </div>
                                @error('perihal_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="exampleInputEmail1">File SK</label>
                                    <input type="file" name="file_sk" class="form-control" value="{{ old('file_sk') }} "
                                        accept=".pdf" placeholder="">
                                </div>
                                @error('file_sk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                @if (Auth::User()->role_id == 1)
                                    <div class="form-group">
                                        <label>Provinsis</label>
                                        <select class="form-control" name="provinsi_id">
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cari pegawai berdasarkan NIP lama</label>
                                    <input class="form-control" type='text' id='search' name='search'
                                        placeholder='Enter nip lama'>
                                </div>




                                <input type='button' value='Search' id='but_search'>
                                <br />
                                <br />

                                <table class="table table-bordered" id='userTable'>
                                    <thead>
                                        <tr>
                                            <th>Nip Lama</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="user_table"></tbody>
                                </table>

                                <br />


                                <div class="well clearfix">
                                    <a id="add-row" class="btn btn-primary pull-right add-record" data-added="0"><i
                                            class="glyphicon glyphicon-plus"></i> Tambahkan pegawai</a>
                                </div>

                                <br />
                                <div class="form-group">
                                    {{-- <label for="exampleInputEmail1">Change Leader, Change Champions dan Change Agent</label> --}}
                                    <table class="table table-bordered" id="tbl_posts">
                                        <thead>
                                            <tr>
                                                <th>Nip Lama</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_posts_body">

                                        </tbody>
                                    </table>
                                </div>

                                @error('users')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <select id="selectedUser" name="users[]" multiple hidden>
                                </select>

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Aproval</label>
                                    <input type="text" name="aproval" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Alasan</label>
                                    <input type="text" name="alasan" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div> --}}



                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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

        <script type="text/javascript">



        </script>

        {{-- tambah dan hapus data --}}

        <script type="text/javascript">
            $(document).ready(function() {
                jQuery(document).delegate('a.add-record', 'click', function(e) {
                    e.preventDefault();
                    var content = jQuery('#user_table tr'),
                        size = jQuery('#tbl_posts >tbody >tr').length + 1,
                        element = null,
                        element = content.clone();
                    element.attr('id', 'rec-' + size);
                    element.find('.delete-record').attr('data-id', size);
                    element.appendTo('#tbl_posts_body');
                    element.find('.sn').html(size);



                });
                jQuery(document).delegate('a.delete-record', 'click', function(e) {
                    e.preventDefault();
                    var didConfirm = confirm("Are you sure You want to delete");
                    if (didConfirm == true) {
                        var id = jQuery(this).attr('data-id');
                        var targetDiv = jQuery(this).attr('targetDiv');
                        jQuery('#rec-' + id).remove();
                        removeUserOptions(jQuery(this).attr('data-uid'));
                        //regnerate index number on table
                        // $('#tbl_posts_body tr').each(function(index) {
                        //     $(this).find('span.sn').html(index + 1);
                        // });

                        return true;
                    } else {
                        return false;
                    }
                });
            });

        </script>

        {{-- cari data --}}

        <script type='text/javascript'>
            $(document).ready(function() {
                // Search by userid
                $('#but_search').click(function() {
                    var id = Number($('#search').val().trim());

                    if (id > 0) {
                        fetchRecords(id);
                    }

                });

            });

            function fetchRecords(id) {
                $.ajax({
                    url: 'getUser/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        $('#userTable tbody').empty(); // Empty <tbody>
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;
                                var email = response['data'][i].email;
                                var nipLama = response['data'][i].nip_lama;

                                var tr_str = "<tr>" +
                                    "<td align='center'>" + nipLama + "</td>" +
                                    "<td align='center'>" + name + "</td>" +
                                    "<td align='center'> <a  id = 'tabel_atas' value='" + id +
                                    "' class='btn btn-xs delete-record' data-uid= '" + id +
                                    "' data-id=" +
                                    id +
                                    " hidden> delete</a >" + email + "</td>" +
                                    "</tr>";

                                $("#userTable tbody").append(tr_str);

                            }
                        } else {
                            var tr_str = "<tr>" +
                                "<td align='center' colspan='4'>No record found.</td>" +
                                "</tr>";

                            $("#userTable tbody").append(tr_str);
                        }

                    }
                });
            }

            function addUserOptions(id) {
                $("#selectedUser").append('<option value="' + id + '" selected>' + id + '</option>');
            }

            function removeUserOptions(id) {
                $("#selectedUser option[value='" + id + "']").remove();
            }

            $(document).ready(function() {
                $("#add-row").click(function() {
                    var id = jQuery("#tabel_atas").attr('data-id');
                    addUserOptions(id);
                });
            });

            // $(document).ready(function() {
            //     $("#add-row").click(function() {
            //         var id = jQuery("#tabel_atas").attr('data-id');
            //         addUserOptions(id);
            //     });
            // });

        </script>

    @endsection
