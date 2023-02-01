@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frequently Asked Questions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">FAQ</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12" id="accordion">
                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                1. Apa itu SIPMANNER?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            Sistem pengelolaan manajemen perubahan (SIPMANNER) merupakan sistem pengelolaan manajemen
                            perubahan yang dikembangkan dengan tujuan mengoptimalkan pengelolaan kegiatan manajemen
                            perubahan sehingga dapat meningkatkan pelayanan fungsi manajemen perubahan.
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                2. Apasaja fitur-fitur yang terdapat dalam SIPMANNER
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Saat ini fitur-fitur yang tersedia yaitu:
                            <ul>
                                <li>
                                    Data: Berisi database Change Agent Network BPS seluruh Indonesia</li>
                                <li>
                                    Program: Berisi rencana, progres, dan laporan kegiatan manajemen perubahan</li>
                                </li>
                                <li>
                                    Dashboard: Berisi chart yang menggambarkan progres pelaksanaan kegiatan manajemen
                                    perubahan sebagai monitoring dan evaluasi kegiatan.</li>
                                </li>
                                <li>
                                    Sharing: Berisi berbagai informasi berupa panduan aplikasi, panduan kegiatan dan
                                    panduan lain terkait manajemen perubahan. Selain itu fitur ini merupakan sarana
                                    berbagi informasi terkait manajemen perubahan baik dalam skala nasional maupun pada
                                    unit kerja.</li>
                                </li>
                                <li>
                                    FAQ: Berisi list pertanyaan yang sering diajukan beserta jawabannya terkait
                                    penggunaan aplikasi, kegiatan manajemen perubahan maupun pertanyaan lainnya.</li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                3. Siapa saja yang dapat mengakses SIPMANNER?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            SIPMANNER dapat diakses oleh Change Agent Network (Top Leader, Change Leader, Change Champion), Sekretariat RB, serta pihak lain yang berkepentingan dalam kegiatan manajemen
                            perubahan.
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapse4">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                4. Bagaimana cara untuk memperoleh hak akses SIPMANNER?
                            </h4>
                        </div>
                    </a>
                    <div id="collapse4" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Hak akses untuk CAN dapat diperoleh dengan mengirimkan SK Tim Manajemen Perubahan, sedangkan
                            pihak lain dapat mengajukan memperoleh hak akses sesuai dengan kepentingannya.
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapse5">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                5. Apakah yang dimaksud Program Intervensi Nasional dan Program Intervensi Khusus.
                            </h4>
                        </div>
                    </a>
                    <div id="collapse5" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Program Intervensi Nasional merupakan program yang disusun dengan tujuan meningkatkan pemahaman
                            dan implementasi perilaku PIA dan budaya kerja oleh setiap insan BPS dalam upaya mewujudkan
                            pencapaian visi dan misi organisasi.
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapse6">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                6. Informasi apasaja yang tersedia pada SIPMANNER?
                            </h4>
                        </div>
                    </a>
                    <div id="collapse6" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Informasi yang tersedia dalam SIPMANNER antara lain Panduan penggunaan aplikasi, Panduan
                            Kegiatan Manajemen Perubahan, serta informasi lain yang terkait manajemen perubahan.
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapse7">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                7. Informasi apasaja yang dapat dibagikan pada SIPMANNER?
                            </h4>
                        </div>
                    </a>
                    <div id="collapse7" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Aksi perubahan yang dilakukan oleh unit kerja, inovasi yang dilakukan serta sharing knowledge
                            yang bermanfaat untuk organisasi.
                        </div>
                    </div>
                </div>
                {{-- <div class="card card-warning card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                4. Donec pede justo
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFour" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card card-danger card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                7. Aenean leo ligula
                            </h4>
                        </div>
                    </a>
                    <div id="collapseSeven" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 text-center">
                <p class="lead">
                    Hubungin kami di
                    <a href="#"> cerdas@bps.go.id</a>,
                    jika anda bingung atau punya pertanyaan lain<br />
                </p>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
