@extends('layouts.master')

@section('content')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/plugins/toastr/toastr.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">{{ $report->tahun }}</a></li>
                        <li class="breadcrumb-item active">Semester {{ $report->semester }}</li>
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

                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Laporan Tahun {{ $report->tahun }} Semester
                                {{ $report->semester }}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('reports.update', $report) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label>BAB I. Pendahuluan</label>
                                    <textarea class="form-control" name="bab_i" id="" cols="10" rows="10"
                                        placeholder="Pada bagian ini, dijelaskan tujuan program perubahan secara umum. Dijelaskan pula bahwa kegiatan perubahan ini merupakan bagian dari program reformasi birokrasi di unit kerja yang dimulai dari pilar manajemen perubahan sebagai inisiator dan integrator pilar-pilar reformasi birokrasi lainnya. Kemudian dalam pelaksanaannya, dijelaskan secara ringkas bahwa program perubahan ini melibatkan area perubahan lainnya (seperti pelayanan publik, akuntabilitas, pengawasan, SDM, tatalaksana), sehingga dokumen ini dapat dijadikan sebagai bukti dukung pelaksanaan RB unit kerja yang terintegrasi yang tidak hanya menjawab sisi manajemen perubahan saja, namun juga pilar lainnya. Pada akhir bagian ini, dijelaskan harapan yang ingin dicapai dari kegiatan ini (terutama dalam rangka peningkatan kinerja dan kualitas pelayanan publik)">{{ old('bab_i', $report->bab_i) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>BAB II. Latar Belakang</label>
                                    <textarea class="form-control" name="bab_ii" id="" cols="30" rows="10"
                                        placeholder="Program perubahan ini dilatarbelakangi oleh aspek yang dinilai perlu dan menjadi prioritas utama dalam menjawab kebutuhan untuk meningkatkan kinerja organisasi unit kerja dalam berbagai hal (terutama kualitas pelayanan publik).">{{ old('bab_ii', $report->bab_ii) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>BAB III. Program</label>
                                    <textarea class="form-control" name="bab_iii" id="" cols="30" rows="10"
                                        placeholder="Program seharusnya terbentuk untuk menjawab kebutuhan, mengatasi permasalahan, atau sebagai upaya meningkatkan kinerja unit kerja. Program perubahan yang meningkatkan kualitas pelayanan publik unit kerja akan memperoleh poin penilaian yang lebih besar dalam penilaian RB Keterangan :     Khusus item Pelaksanaan : dalam bagian ini dijelaskan pelaksanaan program secara rinci dimulai dari proses perencanaan (termasuk penyusunan timeline kegiatan atau roadmap bila ada, dan melibatkan stakeholder internal dan eksternal/masyarakat/pengguna data), implementasi, dan upaya monitoring dan evaluasi yang berkala. Dijelaskan pula dalam melaksanakan program ini melibat aspek pilar perubahan apa saja atau bagaimana peran pilar-pilar RB lainya dalam menyukseskan program perubahan ini.">{{ old('bab_iii', $report->bab_iii) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>A. Program Intervensi Nasional </label>
                                    <div class="card-body table-bordered table-condensed table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Uraian Kegiatan</th>
                                                    <th>Output</th>
                                                    <th>Timeline</th>
                                                </tr>
                                            </thead>
                                            <tbody style="white-space: pre-line;">
                                                @php
                                                    $i = 1;
                                                    //dd($report->intervensiNasionalProvinsis());
                                                @endphp
                                                @foreach ($report->intervensiNasionalProvinsis as $pi)
                                                    <tr>
                                                        <td><b>{{ $i }}</b></td>
                                                        <td>{{ $pi->intervensiNasional->nama }}</td>
                                                        <td>{{ $pi->intervensiNasional->uraian_kegiatan }}</td>
                                                        <td>{{ $pi->intervensiNasional->output }}</td>
                                                        <td>{{ $pi->intervensiNasional->timeline }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Outcome</th>
                                                        <td colspan="4">{{ $pi->intervensiNasional->outcome }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ukuran Keberhasilan</th>
                                                        <td colspan="4">{{ $pi->ukuran_keberhasilan }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kendala</th>
                                                        <td colspan="4"><input
                                                                name="intervensiNasional_kendala[{{ $pi->id }}]"
                                                                class="form-control" type="text"
                                                                value="{{ $pi->pivot->kendala }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Solusi</th>
                                                        <td colspan="4"><input
                                                                name="intervensiNasional_solusi[{{ $pi->id }}]"
                                                                class="form-control" type="text"
                                                                value="{{ $pi->pivot->solusi }}"></td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>B. Program Intervensi Khusus </label>

                                    <div class="card-body table-bordered table-condensed table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Change Champions</th>
                                                    <th>Uraian Kegiatan</th>
                                                    <th>Output</th>
                                                    <th>Timeline</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($report->intervensiKhususes as $pi)
                                                    <tr>
                                                        <td><b>{{ $i }}</b></td>
                                                        <td>{{ $pi->nama }}</td>
                                                        <td>{{ $pi->user->name }}</td>
                                                        <td>{{ $pi->uraian_kegiatan }}</td>
                                                        <td>{{ $pi->output }}</td>
                                                        <td>{{ $pi->timeline }} </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Outcome</th>
                                                        <td colspan="5">{{ $pi->outcome }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ukuran Keberhasilan</th>
                                                        <td colspan="5">{{ $pi->ukuran_keberhasilan }}
                                                        </td>
                                                    </tr>
                                                    <tr @if ($pi->user_id != Auth::user()->id) style="display:none;" @endif>
                                                        <th>Kendala</th>
                                                        <td colspan="5"><input
                                                                name="intervensiKhusus_kendala[{{ $pi->id }}]"
                                                                class="form-control" type="text"
                                                                value="{{ $pi->pivot->kendala }}"></td>
                                                    </tr>
                                                    <tr @if ($pi->user_id != Auth::user()->id) style="display:none;" @endif>
                                                        <th>Solusi</th>
                                                        <td colspan="5"><input
                                                                name="intervensiKhusus_solusi[{{ $pi->id }}]"
                                                                class="form-control" type="text"
                                                                value="{{ $pi->pivot->solusi }}"></td>
                                                    </tr>

                                                    <tr @if ($pi->user_id == Auth::user()->id) style="display:none;" @endif>
                                                        <th>Kendala</th>
                                                        <td colspan="5">{{ $pi->pivot->kendala }}</td>
                                                    </tr>
                                                    <tr @if ($pi->user_id == Auth::user()->id) style="display:none;" @endif>
                                                        <th>Solusi</th>
                                                        <td colspan="5">{{ $pi->pivot->solusi }}</td>
                                                    </tr>

                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>BAB IV. Perubahan yang Konkret</label>
                                    <textarea class="form-control" name="bab_iv" id="" cols="30" rows="10"
                                        placeholder="Program yg dibangun harus berdasarkan permasalahan yang ada di unit kerja, sehingga dengan adanya program akan jelas menyelesaikan masalah yang ada, dan tentunya akan meningkatkan nilai budaya kinerja">{{ old('bab_iv', $report->bab_iv) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>BAB V. Komitmen Pimpinan</label>
                                    <textarea class="form-control" name="bab_v" id="" cols="30" rows="10"
                                        placeholder="Komitmen pimpinan adalah kunci utama dalam memimpin perubahan, menyukseskan program reformasi birokrasi unit kerja/instansi, perbaikan kualitas pelayanan publik dan perbaikan kinerja dalam berbagai aspek teknis dan non teknis. Komitmen pimpinan dimulai dari upaya shared vision kepada jajarannya sehingga semua pegawai di unit kerja mempunyai sense dan visi yang sama dalam berorganisasi, dan sebagai langkah dasar dalam menciptakan budaya kerja organisasi yang kuat. Dalam konteks laporan ini, pada bagian ini ditunjukkan bahwa program perubahan ini mendapat dukungan penuh dari pimpinan dan sebagai upaya mencapai visi pimpinan unit kerja untuk menyelesaikan permasalahan unit kerja dan meningkatkan kinerja. Komitmen ini dapat berupa keterlibatan langsung pimpinan dalam perencanaan, implementasi, atau monitoring dan evaluasi program perubahan ini; dapat pula berupa dukungan pimpinan dalam berbagai kesempatan untuk menginternalisasi kegiatan ini, atau bentuk lainnya.">{{ old('bab_v', $report->bab_v) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>BAB VI. Kesimpulan</label>
                                    <textarea class="form-control" name="bab_vi" id="" cols="30" rows="10"
                                        placeholder="Dijelaskan secara umum apakah program ini telah menjawab kebutuhan yang menjadi dasar penciptaan program ini (menyelesaikan permasalahan, peningkatan pelayanan publik, atau peningkatan kinerja unit kerja) atau sesuai dengan harapan pada bagian pendahuluan. Bila telah sesuai, dijelaskan bahwa hal ini menjadi perubahan yang nyata (konkret) di unit  kerja">{{ old('bab_vi', $report->bab_vi) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>BAB VII. Penutup</label>
                                    <textarea class="form-control" name="bab_vii" id="" cols="30" rows="10"
                                        placeholder="Berisi penutup secara umum, namun juga diulas rencana kedepan terkait program kegiatan ini, apakah tetap dilanjutkan, ditindaklanjuti dengan program/kegiatan lanjutan,dimodifikasi, atau ditingkatkan menjadi kegiatan yang lebih besar.">{{ old('bab_vii', $report->bab_vii) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Lampiran</label><br>
                                    <span>Berisi foto-foto/dokumentasi lain terkait kegiatan Manajemen Perubahan (Catatan :
                                        Jumlah halaman termasuk lampiran maksimal 20 halaman)</span>
                                    <br>
                                    @if ($report->lampiran != null)
                                        <div id="link-lampiran">
                                            <span><a
                                                    href="{{ route('reports.download-lampiran', $report) }}">Lampiran</a></span>
                                            <div class="btn-group btn-group-sm">
                                                {{-- <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a> --}}
                                                {{-- <a id="lampiran-delete" href="#" class="btn btn-danger"><i
                                                        class="fas fa-trash"></i></a> --}}
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div id="upload-lampiran">
                                        <input accept=".pdf" type="file" name="lampiran" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label>Persetujuan </label>
                                    @foreach ($report->changeChampions as $changeChampion)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="changeChampions[{{ $changeChampion->id }}]"
                                                @if (Auth::User()->id != $changeChampion->id) disabled @endif @if ($changeChampion->pivot->status == 2) checked
                                    @endif >
                                    <label class="form-check-label">{{ $changeChampion->name }}</label>
                                </div>
                                @endforeach
                            </div>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name=" draft" value="Simpan sebagai draft">
                        <input type="submit" class="btn btn-primary" name=" submit" value="Simpan & Submit">
                    </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>


        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- .modal -->
        <div class="modal fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    {{-- <div class="modal-header">
                        <h4 class="modal-title">A</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> --}}
                    <div class="modal-body">
                        <i class="fas fa-trash"></i> Apakah anda yakin akan menghapus lampiran ini?&hellip;
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button id="lampiran-delete" type="button" data-dismiss="modal"
                            class="btn btn-outline-light">Ya</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tidak</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- Toastr -->
        <script src="{{ asset('') }}assets/plugins/toastr/toastr.min.js"></script>

        <script>
            @if (Session::has('warning'))
                toastr.options = {
                "closeButton": true,
                "progressBar": false
                }
                toastr.warning("{{ Session::get('warning') }}");
            @endif
            @if (Session::has('success'))
                toastr.options = {
                "closeButton": true,
                "progressBar": false
                }
                toastr.success("{{ Session::get('success') }}");
            @endif

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#lampiran-delete').click(function() {
                    var urlx = '{{ config('app.url') }}' + '/reports/:id/delete-lampiran';
                    // var urlx = '{{ route('reports.delete-lampiran', ':id') }}';
                    urlx = urlx.replace(':id', @php echo $report->id;   @endphp);
                    $.ajax({
                        url: urlx,
                        type: 'post',
                        dataType: 'json',
                        success: function(response) {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": false
                            }
                            toastr.success("Lampiran berhasil dihapus");
                            $("#link-lampiran").hide();
                            $("#upload-lampiran").show();
                        },
                        error: function(response) {
                            toastr.warning("Lampiran tidak berhasil dihapus");
                        }
                    });
                });
                if (
                    @php
                    if ($report != null) {
                        if ($report->lampiran != null) {
                            echo 'true';
                        } else {
                            echo 'false';
                        }
                    } else {
                        echo 'false';
                    }
                    @endphp
                ) {
                    $("#link-lampiran").show();
                    $("#upload-lampiran").hide();
                }
            });
        </script>


    </section>

@endsection
