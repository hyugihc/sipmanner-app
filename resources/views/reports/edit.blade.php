@extends('layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                        <li class="breadcrumb-item active">{{ $report->tahun }}</li>
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
                            <h3 class="card-title">Laporan Tahun {{ $report->tahun }} &nbsp; Semester
                                {{ $report->semester }}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('reports.update', $report) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pendahuluan</label>
                                    <textarea class="form-control" name="bab_i" id="" cols="10" rows="10">
                               {{ $report->bab_i }} 
                                      </textarea>
                                </div>

                                @error('bab_i')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Latar Belakang</label>
                                    <textarea class="form-control" name="bab_ii" id="" cols="30" rows="10">
                                  {{ $report->bab_ii }}   
                                    </textarea>
                                </div>

                                @error('bab_ii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Program</label>
                                    <textarea class="form-control" name="bab_iii" id="" cols="30" rows="10">
                            {{ $report->bab_iii }}
                                                                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Program Intervensi Nasional </label>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Volume</th>
                                                    <th>Output</th>
                                                    <th>Outcome</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($intervensiNasionalProvinsis as $pi)
                                                    <tr>
                                                        <td>{{ $pi->intervensiNasional->nama }}</td>
                                                        <td>{{ $pi->intervensiNasional->volume }}</td>
                                                        <td>{{ $pi->intervensiNasional->output }}</td>
                                                        <td>{{$pi->intervensiNasional->outcome}} </td>
                                                       

                
                                                    </tr>
                                                @endforeach
                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Program Intervensi Khusus </label>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Volume</th>
                                                    <th>Output</th>
                                                    <th>Outcome</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($intervensiKhususes as $pi)
                                                    <tr>
                                                        <td>{{ $pi->nama }}</td>
                                                        <td>{{ $pi->volume }}</td>
                                                        <td>{{ $pi->output }}</td>
                                                        <td>{{$pi->outcome}} </td>
                
                                                    </tr>
                                                @endforeach
                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                

                                @error('bab_iii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Perubahan yang Konkret</label>
                                    <textarea class="form-control" name="bab_iv" id="" cols="30" rows="10">
                       {{ $report->bab_iv }}
                                                                                    </textarea>
                                </div>

                                @error('bab_iv')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Komitmen Pimpinan</label>
                                    <textarea class="form-control" name="bab_v" id="" cols="30" rows="10">
                        {{ $report->bab_v }}
                                                                                    </textarea>
                                </div>

                                @error('bab_v')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Kesimpulan</label>
                                    <textarea class="form-control" name="bab_vi" id="" cols="30" rows="10">
            {{ $report->bab_iv }}                                                                        </textarea>
                                </div>

                                @error('bab_vi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Penutup</label>
                                    <textarea class="form-control" name="bab_vii" id="" cols="30" rows="10">
        {{ $report->bab_vii }}                                                                            </textarea>
                                </div>

                                @error('bab_vii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Lampiran</label>
                                    <textarea class="form-control" name="bab_viii" id="" cols="30" rows="10">
                      {{ $report->bab_viii }}
                                                                                    </textarea>
                                </div>

                                @error('bab_viii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror



                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary" name=" draft" value="Save as Draft">
                                <input type="submit" class="btn btn-primary" name=" submit" value="Submit">
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
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Large Modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

          <script>
              $(document).on("click", "#launch-modal", function () {
                    var pi = $(this).data('id');
                    $(".modal-body #bookId").val( pi );
                    // As pointed out in comments, 
                    // it is unnecessary to have to manually call the modal.
                    // $('#addBookDialog').modal('show');
                });
          </script>
    </section>

@endsection
