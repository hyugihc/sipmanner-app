@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
                        <form action="{{ route('cans.store') }}" method="POST" id="quickForm">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor SK</label>
                                    <input type="text" name="nomor_sk" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Perihal SK</label>
                                    <input type="text" name="perihal_sk" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">File SK</label>
                                    <input type="file" name="file_sk" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kode Org</label>
                                    <input type="text" name="kode_org" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Aproval</label>
                                    <input type="text" name="aproval" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alasan</label>
                                    <input type="text" name="alasan" class="form-control" id="exampleInputEmail1"
                                        placeholder="">
                                </div>

                                <input type='text' id='search' name='search' placeholder='Enter userid 1-27'>

                                <input type='button' value='Search' id='but_search'>
                                <br />

                                <table class="table table-bordered" id='userTable'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sample_table"></tbody>
                                </table>

                                <div style="display:none;">
                                  <table id="sample_tabley">
                                      <tr id="">
                                          <td><span class="sn"></span>.</td>
                                          <td>ABC Posts</td>
                                          <td>04</td>

                                          <td><a class="btn btn-xs delete-record" data-id="0"><i
                                                      class="glyphicon glyphicon-trash"></i>delete</a></td>
                                      </tr>
                                  </table>
                              </div>


                                <br />


                                <div class="well clearfix">
                                    <a class="btn btn-primary pull-right add-record" data-added="0"><i
                                            class="glyphicon glyphicon-plus"></i> Add Row</a>
                                </div>

                                <br />

                                <table class="table table-bordered" id="tbl_posts">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_posts_body">
                                        <tr id="rec-1">
                                            <td><span class="sn">1</span>.</td>
                                            <td>Sanitary Inspector</td>
                                            <td>02</td>

                                            <td><a class="btn btn-xs delete-record" data-id="1"><i
                                                        class="glyphicon glyphicon-trash"></i>delete</a></td>
                                        </tr>
                                        <tr id="rec-2">
                                            <td><span class="sn">2</span>.</td>
                                            <td>Tax & Revenue Superintendent</td>
                                            <td>02</td>

                                            <td><a class="btn btn-xs delete-record" data-id="2"><i
                                                        class="glyphicon glyphicon-trash"></i>delete</a></td>
                                        </tr>

                                        <tr id="rec-3">
                                            <td><span class="sn">3</span>.</td>
                                            <td>Tax & Revenue Inspector</td>
                                            <td>04</td>

                                            <td><a class="btn btn-xs delete-record" data-id="3"><i
                                                        class="glyphicon glyphicon-trash"></i>delete</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                

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
            $(document).ready(function() {
                jQuery(document).delegate('a.add-record', 'click', function(e) {
                    e.preventDefault();
                    var content = jQuery('#sample_table tr'),
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

                        //regnerate index number on table
                        $('#tbl_posts_body tr').each(function(index) {
                            $(this).find('span.sn').html(index + 1);
                        });
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

                                var tr_str = "<tr>" +
                                    "<td align='center'>" + (i + 1) + "</td>" +
                                    "<td align='center'>" + name + "</td>" +
                                    "<td align='center'>" + email + "</td>" +
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

        </script>

    @endsection
