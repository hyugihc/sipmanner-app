@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <h1 class="m-0">Create</h1>
                </div><!-- /.col -->

                <div class="col-sm-4">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
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
                        <form action="{{ route('users.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>NIP Lama</label>
                                    <input type="text" name="nip_lama" class="form-control" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Unit Organisasi</label>
                                    <select class="form-control" name="provinsi_id">
                                        @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

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
