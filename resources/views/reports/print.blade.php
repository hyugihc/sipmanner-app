<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sipmanner | Print Laporan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        table {
            /* font-family: arial, sans-serif; */
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12 ">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> Laporan Tahun {{ $report->tahun }} Semester
                        {{ $report->semester }}
                    </h2>
                </div>
                <!-- /.col -->
            </div>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Satker {{ $report->provinsi->nama }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div>
                    <dl>
                        <dt><b>I. Pendahuluan</b> </dt>
                        <br>
                        <dd>{{ $report->bab_i }}</dd>
                        <br>
                        <dt><b>II. Latar Belakang</b> </dt>
                        <br>
                        <dd>{{ $report->bab_ii }}</dd>
                        <br>
                        <dt><b>III. Program</b> </dt>
                        <br>
                        <dd>{{ $report->bab_iii }}</dd>
                        <br>
                        <div>
                            <label><b>A. Program Intervensi Nasional</b>  </label>
                            <br><br>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><b>No</b></td>
                                            <td><b>Nama</b></td>
                                            <td><b>Uraian Kegiatan</b></td>
                                            <td><b>Output</b></td>
                                            <td><b>Timeline</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($report->intervensiNasionalProvinsis as $pi)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $pi->intervensiNasional->nama }}</td>
                                                <td>{{ $pi->intervensiNasional->uraian_kegiatan }}</td>
                                                <td>{{ $pi->intervensiNasional->output }}</td>
                                                <td>{{ $pi->intervensiNasional->timeline }} </td>
                                            </tr>
                                            <tr>
                                                <td><b>Outcome</b></td>
                                                <td colspan="4"> {{ $pi->intervensiNasional->outcome }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Ukuran Keberhasilan</b></td>
                                                <td colspan="4"> {{ $pi->ukuran_keberhasilan }}</td>
                                            </tr>

                                            <tr>
                                                <td><b>Kendala</b></td>
                                                <td colspan="4"> {{ $pi->pivot->kendala }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Solusi</b></td>
                                                <td colspan="4"> {{ $pi->pivot->solusi }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div>
                            <label><b>B. Program Intervensi Khusus </b> </label>
                            <br><br>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><b>No</b></td>
                                            <td><b>Nama</b></td>
                                            <td><b>Change Champions</b></td>
                                            <td><b>Uraian Kegiatan</b></td>
                                            <td><b>Output</b></td>
                                            <td><b>Timeline</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($report->intervensiKhususes as $pi)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $pi->nama }}</td>
                                                <td>{{ $pi->user->name }}</td>
                                                <td>{{ $pi->uraian_kegiatan }}</td>
                                                <td>{{ $pi->output }}</td>
                                                <td>{{ $pi->timeline }} </td>
                                            </tr>
                                            <tr>
                                                <td><b>Outcome</b></td>
                                                <td colspan="5">{{ $pi->outcome }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Ukuran Keberhasilan</b></td>
                                                <td colspan="5">{{ $pi->ukuran_keberhasilan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Kendala</b></td>
                                                <td colspan="5"> {{ $pi->pivot->kendala }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Solusi</b></td>
                                                <td colspan="5"> {{ $pi->pivot->solusi }}</td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>

                        <dt><b>IV. Perubahan Yang Konkret</b> </dt>
                        <br>
                        <dd>{{ $report->bab_iv }}</dd>
                        <br>
                        <dt><b>V. Komitmen Pimpinan</b> </dt>
                        <br>
                        <dd>{{ $report->bab_v }}</dd>
                        <br>
                        <dt><b>VI. Kesimpulan</b> </dt>
                        <br>
                        <dd>{{ $report->bab_vi }} </dd>
                        <br>
                        <dt><b>VII. Penutup</b> </dt>
                        <br>
                        <dd> {{ $report->bab_vii }} </dd>
                        <br>
                        {{-- <dt>Lampiran</dt>
                        <br>
                        <dd> {{ $report->bab_viii }} </dd>
                        <br> --}}
                        @if ($report->status == 3)
                            <dt>Alasan Tidak Disetujui</dt>
                            <dd>{{ $report->alasan }}</dd>
                        @endif

                    </dl>


                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
