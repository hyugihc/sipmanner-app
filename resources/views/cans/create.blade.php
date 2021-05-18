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
          <form action="{{route('cans.store') }}" method="POST" id="quickForm">
            @csrf
            
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Tanggal SK</label>
                <input type="date" name="tanggal_sk" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Perihal SK</label>
                <input type="text" name="perihal_sk" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">File SK</label>
                <input type="file" name="file_sk" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              
              <div class="form-group">
                <label for="exampleInputEmail1">Kode Org</label>
                <input type="text" name="kode_org" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Aproval</label>
                <input type="text" name="aproval" class="form-control" id="exampleInputEmail1" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Alasan</label>
                <input type="text" name="alasan" class="form-control" id="exampleInputEmail1" placeholder="">
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

@endsection

   
 


