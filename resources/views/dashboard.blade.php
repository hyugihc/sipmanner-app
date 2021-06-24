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
                            @if (Auth::user()->role_id != 1)
                                <h3>{{ $data['piCount'] }}</h3>
                            @else
                                <h3> <i
                                    class="fas fa-arrow-circle-right"></i></h3>
                            @endif

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
                                Program Intervensi Khusus
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

                @if (Auth::user()->role_id != 1)
                    <section class="col-lg-6 connectedSortable">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Laporan Semesteran</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Task</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Label</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Laporan Semester 1</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    @switch($data['reportSm1Status'])
                                                        @case(0)
                                                            <div class="progress-bar bg-primary" style="width: 0%"></div>
                                                        @break
                                                        @case(1)
                                                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                        @break
                                                        @case(2)
                                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                                        @break
                                                        @case(3)
                                                            <div class="progress-bar-danger" style="width: 100%"></div>
                                                        @break
                                                        @default

                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                @switch($data['reportSm1Status'])
                                                    @case(0)
                                                        <span class="badge bg-primary">Draft</span>
                                                    @break
                                                    @case(1)
                                                        <span class="badge bg-warning">Submit</span>
                                                    @break
                                                    @case(2)
                                                        <span class="badge bg-success">Approved</span>
                                                    @break
                                                    @case(3)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @break
                                                    @default

                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Laporan Semester 2</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    @switch($data['reportSm2Status'])
                                                        @case(0)
                                                            <div class="progress-bar bg-primary" style="width: 0%"></div>
                                                        @break
                                                        @case(1)
                                                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                        @break
                                                        @case(2)
                                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                                        @break
                                                        @case(3)
                                                            <div class="progress-bar-danger" style="width: 100%"></div>
                                                        @break
                                                        @default

                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                @switch($data['reportSm2Status'])
                                                    @case(0)
                                                        <span class="badge bg-primary">Draft</span>
                                                    @break
                                                    @case(1)
                                                        <span class="badge bg-warning">Submit</span>
                                                    @break
                                                    @case(2)
                                                        <span class="badge bg-success">Approved</span>
                                                    @break
                                                    @case(3)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @break
                                                    @default

                                                @endswitch
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Progress Intervensi Nasional</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Task</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Label</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pinMaxs as $pinMax)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $pinMax->intervensiNasionalProvinsi->intervensiNasional->nama }}
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $pinMax->presentase_program }}%"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary">{{ $pinMax->presentase_program }}%</span>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Progress Intervensi Khusus</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Task</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Label</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pikMaxs as $pikMax)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $pikMax->intervensi_Khusus->nama }}</td>
                                                <td>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $pikMax->presentase_program }}%"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary">{{ $pikMax->presentase_program }}%</span>
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
                @endif

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
                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                chart.draw(data, options);
            }
        </script>


    </section>
    <!-- /.content -->
@endsection
