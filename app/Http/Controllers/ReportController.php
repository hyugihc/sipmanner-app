<?php

namespace App\Http\Controllers;

use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    private $bab_i = 'Pada bagian ini, dijelaskan tujuan program perubahan secara umum. Dijelaskan pula bahwa kegiatan perubahan ini merupakan bagian dari program reformasi birokrasi di unit kerja yang dimulai dari pilar manajemen perubahan sebagai inisiator dan integrator pilar-pilar reformasi birokrasi lainnya. Kemudian dalam pelaksanaannya, dijelaskan secara ringkas bahwa program perubahan ini melibatkan area perubahan lainnya (seperti pelayanan publik, akuntabilitas, pengawasan, SDM, tatalaksana), sehingga dokumen ini dapat dijadikan sebagai bukti dukung pelaksanaan RB unit kerja yang terintegrasi yang tidak hanya menjawab sisi manajemen perubahan saja, namun juga pilar lainnya. Pada akhir bagian ini, dijelaskan harapan yang ingin dicapai dari kegiatan ini (terutama dalam rangka peningkatan kinerja dan kualitas pelayanan publik).';
    private $bab_ii = 'Program perubahan ini dilatarbelakangi oleh aspek yang dinilai perlu dan menjadi prioritas utama dalam menjawab kebutuhan untuk meningkatkan kinerja organisasi unit kerja dalam berbagai hal (terutama kualitas pelayanan publik).';
    private $bab_iii = 'Program seharusnya terbentuk untuk menjawab kebutuhan, mengatasi permasalahan, atau sebagai upaya meningkatkan kinerja unit kerja. Program perubahan yang meningkatkan kualitas pelayanan publik unit kerja akan memperoleh poin penilaian yang lebih besar dalam penilaian RB Keterangan :     Khusus item Pelaksanaan : dalam bagian ini dijelaskan pelaksanaan program secara rinci dimulai dari proses perencanaan (termasuk penyusunan timeline kegiatan atau roadmap bila ada, dan melibatkan stakeholder internal dan eksternal/masyarakat/pengguna data), implementasi, dan upaya monitoring dan evaluasi yang berkala. Dijelaskan pula dalam melaksanakan program ini melibat aspek pilar perubahan apa saja atau bagaimana peran pilar-pilar RB lainya dalam menyukseskan program perubahan ini.';
    private $bab_iv = 'Program yg dibangun harus berdasarkan permasalahan yang ada di unit kerja, sehingga dengan adanya program akan jelas menyelesaikan masalah yang ada, dan tentunya akan meningkatkan nilai budaya kinerja';
    private $bab_v = 'Komitmen pimpinan adalah kunci utama dalam memimpin perubahan, menyukseskan program reformasi birokrasi unit kerja/instansi, perbaikan kualitas pelayanan publik dan perbaikan kinerja dalam berbagai aspek teknis dan non teknis. Komitmen pimpinan dimulai dari upaya shared vision kepada jajarannya sehingga semua pegawai di unit kerja mempunyai sense dan visi yang sama dalam berorganisasi, dan sebagai langkah dasar dalam menciptakan budaya kerja organisasi yang kuat. Dalam konteks laporan ini, pada bagian ini ditunjukkan bahwa program perubahan ini mendapat dukungan penuh dari pimpinan dan sebagai upaya mencapai visi pimpinan unit kerja untuk menyelesaikan permasalahan unit kerja dan meningkatkan kinerja. Komitmen ini dapat berupa keterlibatan langsung pimpinan dalam perencanaan, implementasi, atau monitoring dan evaluasi program perubahan ini; dapat pula berupa dukungan pimpinan dalam berbagai kesempatan untuk menginternalisasi kegiatan ini, atau bentuk lainnya.';
    private $bab_vi = 'Dijelaskan secara umum apakah program ini telah menjawab kebutuhan yang menjadi dasar penciptaan program ini (menyelesaikan permasalahan, peningkatan pelayanan publik, atau peningkatan kinerja unit kerja) atau sesuai dengan harapan pada bagian pendahuluan. Bila telah sesuai, dijelaskan bahwa hal ini menjadi perubahan yang nyata (konkret) di unit  kerja';
    private $bab_vii = 'Berisi penutup secara umum, namun juga diulas rencana kedepan terkait program kegiatan ini, apakah tetap dilanjutkan, ditindaklanjuti dengan program/kegiatan lanjutan,dimodifikasi, atau ditingkatkan menjadi kegiatan yang lebih besar.';
    private $bab_viii = 'Berisi foto-foto/dokumentasi lain terkait kegiatan Manajemen Perubahan (Catatan : Jumlah halaman termasuk lampiran maksimal 20 halaman)';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportSm1 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '1', 'provinsi_id' => Auth::user()->provinsi_id],
            ['status' => '0',  'bab_i' => $this->bab_i, 'bab_ii' => $this->bab_ii, 'bab_iii' => $this->bab_iii, 'bab_iv' => $this->bab_iv, 'bab_v' => $this->bab_v, 'bab_vi' => $this->bab_vi, 'bab_vii' => $this->bab_vii, 'bab_viii' => $this->bab_viii]
        );
        $reportSm2 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '2', 'provinsi_id' => Auth::user()->provinsi_id],
            ['status' => '0',  'bab_i' => $this->bab_i, 'bab_ii' => $this->bab_ii, 'bab_iii' => $this->bab_iii, 'bab_iv' => $this->bab_iv, 'bab_v' => $this->bab_v, 'bab_vi' => $this->bab_vi, 'bab_vii' => $this->bab_vii, 'bab_viii' => $this->bab_viii]
        );

        $pins = IntervensiNasional::
        return view('reports.index', compact('reportSm1',  'reportSm2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
        return view('reports.edit', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
