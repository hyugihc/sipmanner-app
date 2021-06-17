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
                                    <textarea class="form-control" name="bab_i" id="" cols="10" rows="10"
                                        placeholder="Pada bagian ini, dijelaskan tujuan program perubahan secara umum. Dijelaskan pula bahwa kegiatan perubahan ini merupakan bagian dari program reformasi birokrasi di unit kerja yang dimulai dari pilar manajemen perubahan sebagai inisiator dan integrator pilar-pilar reformasi birokrasi lainnya. Kemudian dalam pelaksanaannya, dijelaskan secara ringkas bahwa program perubahan ini melibatkan area perubahan lainnya (seperti pelayanan publik, akuntabilitas, pengawasan, SDM, tatalaksana), sehingga dokumen ini dapat dijadikan sebagai bukti dukung pelaksanaan RB unit kerja yang terintegrasi yang tidak hanya menjawab sisi manajemen perubahan saja, namun juga pilar lainnya. Pada akhir bagian ini, dijelaskan harapan yang ingin dicapai dari kegiatan ini (terutama dalam rangka peningkatan kinerja dan kualitas pelayanan publik)">{{ $report->bab_i }}</textarea>
                                </div>

                                @error('bab_i')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Latar Belakang</label>
                                    <textarea class="form-control" name="bab_ii" id="" cols="30" rows="10"
                                        placeholder="Program perubahan ini dilatarbelakangi oleh aspek yang dinilai perlu dan menjadi prioritas utama dalam menjawab kebutuhan untuk meningkatkan kinerja organisasi unit kerja dalam berbagai hal (terutama kualitas pelayanan publik).">{{ $report->bab_ii }}</textarea>
                                </div>

                                @error('bab_ii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Program</label>
                                    <textarea class="form-control" name="bab_iii" id="" cols="30" rows="10"
                                        placeholder="Program seharusnya terbentuk untuk menjawab kebutuhan, mengatasi permasalahan, atau sebagai upaya meningkatkan kinerja unit kerja. Program perubahan yang meningkatkan kualitas pelayanan publik unit kerja akan memperoleh poin penilaian yang lebih besar dalam penilaian RB Keterangan :     Khusus item Pelaksanaan : dalam bagian ini dijelaskan pelaksanaan program secara rinci dimulai dari proses perencanaan (termasuk penyusunan timeline kegiatan atau roadmap bila ada, dan melibatkan stakeholder internal dan eksternal/masyarakat/pengguna data), implementasi, dan upaya monitoring dan evaluasi yang berkala. Dijelaskan pula dalam melaksanakan program ini melibat aspek pilar perubahan apa saja atau bagaimana peran pilar-pilar RB lainya dalam menyukseskan program perubahan ini.">{{ $report->bab_iii }}</textarea>
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
                                                        <td>{{ $pi->intervensiNasional->outcome }} </td>



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
                                                        <td>{{ $pi->outcome }} </td>

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
                                    <textarea class="form-control" name="bab_iv" id="" cols="30" rows="10"
                                        placeholder="Program yg dibangun harus berdasarkan permasalahan yang ada di unit kerja, sehingga dengan adanya program akan jelas menyelesaikan masalah yang ada, dan tentunya akan meningkatkan nilai budaya kinerja">{{ $report->bab_iv }}</textarea>
                                </div>

                                @error('bab_iv')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Komitmen Pimpinan</label>
                                    <textarea class="form-control" name="bab_v" id="" cols="30" rows="10"
                                        placeholder="Komitmen pimpinan adalah kunci utama dalam memimpin perubahan, menyukseskan program reformasi birokrasi unit kerja/instansi, perbaikan kualitas pelayanan publik dan perbaikan kinerja dalam berbagai aspek teknis dan non teknis. Komitmen pimpinan dimulai dari upaya shared vision kepada jajarannya sehingga semua pegawai di unit kerja mempunyai sense dan visi yang sama dalam berorganisasi, dan sebagai langkah dasar dalam menciptakan budaya kerja organisasi yang kuat. Dalam konteks laporan ini, pada bagian ini ditunjukkan bahwa program perubahan ini mendapat dukungan penuh dari pimpinan dan sebagai upaya mencapai visi pimpinan unit kerja untuk menyelesaikan permasalahan unit kerja dan meningkatkan kinerja. Komitmen ini dapat berupa keterlibatan langsung pimpinan dalam perencanaan, implementasi, atau monitoring dan evaluasi program perubahan ini; dapat pula berupa dukungan pimpinan dalam berbagai kesempatan untuk menginternalisasi kegiatan ini, atau bentuk lainnya.">{{ $report->bab_v }}</textarea>
                                </div>

                                @error('bab_v')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Kesimpulan</label>
                                    <textarea class="form-control" name="bab_vi" id="" cols="30" rows="10"
                                        placeholder="Dijelaskan secara umum apakah program ini telah menjawab kebutuhan yang menjadi dasar penciptaan program ini (menyelesaikan permasalahan, peningkatan pelayanan publik, atau peningkatan kinerja unit kerja) atau sesuai dengan harapan pada bagian pendahuluan. Bila telah sesuai, dijelaskan bahwa hal ini menjadi perubahan yang nyata (konkret) di unit  kerja">{{ $report->bab_iv }}</textarea>
                                </div>

                                @error('bab_vi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Penutup</label>
                                    <textarea class="form-control" name="bab_vii" id="" cols="30" rows="10"
                                        placeholder="Berisi penutup secara umum, namun juga diulas rencana kedepan terkait program kegiatan ini, apakah tetap dilanjutkan, ditindaklanjuti dengan program/kegiatan lanjutan,dimodifikasi, atau ditingkatkan menjadi kegiatan yang lebih besar.">{{ $report->bab_vii }}</textarea>
                                </div>

                                @error('bab_vii')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="form-group">
                                    <label>Lampiran</label><br>
                                    <span>Berisi foto-foto/dokumentasi lain terkait kegiatan Manajemen Perubahan (Catatan :
                                        Jumlah halaman termasuk lampiran maksimal 20 halaman)</span>
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
            $(document).on("click", "#launch-modal", function() {
                var pi = $(this).data('id');
                $(".modal-body #bookId").val(pi);
                // As pointed out in comments, 
                // it is unnecessary to have to manually call the modal.
                // $('#addBookDialog').modal('show');
            });

        </script>
    </section>

@endsection
