@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1>Dashboard</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $data['canCount'] }}</h3>

                            <p>Change Agent Network</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('cans.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $data['inCount'] }}<sup style="font-size: 20px"></sup></h3>

                            <p>Program Intervensi Nasional</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('programs.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $data['ikCount'] }}</h3>

                            <p>Program Intervensi Khusus</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('programs.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">

                            <h3> <i class="fas fa-arrow-circle-right"></i></h3>


                            <p>Progress Program</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('progress.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Rencana Aksi Change Champion
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                                    <div id="piechart"></div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </section>
                <!-- /.Left col -->
                <!-- right col -->
                <section class="col-lg-6 connectedSortable">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah <b> Change Champions, Intervensi Nasional & Rencana Aksi </b> Tiap
                                Eselon II</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Provinsi</th>
                                        <th>Change Champions</th>
                                        <th style="width: 40px">Intervensi Nasional</th>
                                        <th style="width: 40px">Rencana Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($provinsis as $provinsi)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td><a
                                                    href="{{ route('rekap.intervensikhusus.index') }}#{{ $provinsi->kode_provinsi }}">{{ $provinsi->nama_singkat }}</a>
                                            </td>

                                            @if ($provinsi->changeChampions()->exists())
                                                <td>
                                                    {{ $provinsi->changeChampions->count() }}
                                                    {{-- @foreach ($provinsi->changeChampions as $cc)
                                                         {{ $cc->name }} <br>
                                                    @endforeach --}}
                                                </td>
                                                <td>

                                                    {{ $provinsi->intervensi_nasional_provinsi_by_year->count() }}

                                                </td>
                                                <td>
                                                    {{ $provinsi->intervensi_khususes_by_year->count() }}
                                                </td>
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                            </td>

                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </section>
                <!-- /.right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


        <script type="text/javascript">
            // Load google charts
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            // Draw the chart and set the chart values
            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Intervensi Khusus', 'status'],

                    @php
                        
                        echo "['Draft', " . $data['ikDraft'] . '],';
                        
                        echo "['Submit', " . $data['ikSubmit'] . '],';
                        
                        echo "['Disetujui', " . $data['ikApproved'] . '],';
                        
                        echo "['Ditolak', " . $data['ikRejected'] . '],';
                        
                    @endphp
                ]);

                // Optional; add a title and set the width and height of the chart
                var options = {
                    'width': 550,
                    'height': 400
                };

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>


    </section>
    <!-- /.content -->
@endsection
