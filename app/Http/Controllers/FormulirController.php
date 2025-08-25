<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Domain;
use App\Models\Formulir;
use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Models\FormulirDomain;
use Illuminate\Support\Facades\Auth; // Tambahkan Auth facade

class FormulirController extends Controller
{

    public function __construct() {


    }


    public function index()
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Jika user adalah admin, tampilkan semua formulir
        if ($user->role === 'admin') {
            $formulirs = Formulir::with('domains')->latest()->get();
        } else {
            // Untuk user lain, hanya tampilkan formulir milik mereka
            $formulirs = Formulir::where('created_by_id', $user->id)
                ->with('domains')
                ->latest()
                ->get();
        }

        return view('dashboard.formulir.form-index', compact('formulirs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.formulir.form-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_formulir' => 'required',
        ], [
            'nama_formulir.required' => 'Nama formulir harus diisi',
        ]);


        $formulir =  Formulir::create([
            'nama_formulir' => $request->nama_formulir,
            'created_by_id' => Auth::id() // Tambahkan created_by_id
        ]);

        $domainCount = Domain::count();
        $aspekCount =  Aspek::count();
        $indikatorCount =  Indikator::count();


        // dd($indikatorCount);


        if ($domainCount == 5 && $aspekCount == 19 && $indikatorCount == 38) {
            return redirect()->route('formulir.index')->with('success', 'Formulir berhasil disimpan');
        } else {
            $domainPrinsipSDI = Domain::create([
                'formulir_id' => $formulir->id,
                'nama_domain' => 'Domain Prinsip SDI',
                'bobot_domain' => 28
            ]);

            $domainKualitasData = Domain::create([
                'formulir_id' => $formulir->id,
                'nama_domain' => 'Domain Kualitas Data',
                'bobot_domain' => 24
            ]);

            $domainProsesBisnis = Domain::create([
                'formulir_id' => $formulir->id,
                'nama_domain' => 'Domain Proses Bisnis Statistik',
                'bobot_domain' => 19
            ]);

            $domainKelembagaan = Domain::create([
                'formulir_id' => $formulir->id,
                'nama_domain' => 'Domain Kelembagaan',
                'bobot_domain' => 17
            ]);

            $domainStatistikNasional = Domain::create([
                'formulir_id' => $formulir->id,
                'nama_domain' => 'Domain Statistik Nasional',
                'bobot_domain' => 12
            ]);







            ///////////////////////////////////////////////// Start Aspek ////////////////////////////////////////////

            // Domain Prinsip SDI
            $aspekStandarDataStatistik = Aspek::create([
                'domain_id' => $domainPrinsipSDI->id,
                'nama_aspek' => 'Standar Data Statistik',
                'bobot_aspek' => 25,
            ]);

            $aspekMetadataStatistik = Aspek::create([
                'domain_id' => $domainPrinsipSDI->id,
                'nama_aspek' => 'Metadata Statistik',
                'bobot_aspek' => 25,
            ]);

            $aspekInteroperabilitasData = Aspek::create([
                'domain_id' => $domainPrinsipSDI->id,
                'nama_aspek' => 'Interoperabilitas Data',
                'bobot_aspek' => 25,
            ]);

            $aspekKodeReferensi = Aspek::create([
                'domain_id' => $domainPrinsipSDI->id,
                'nama_aspek' => 'Kode Referensi dan atau Data Induk',
                'bobot_aspek' => 25,
            ]);

            // Domain Kualitas Data
            $aspekRelevansi = Aspek::create([
                'domain_id' => $domainKualitasData->id,
                'nama_aspek' => 'Relevansi',
                'bobot_aspek' => 21,
            ]);

            $aspekAkurasi = Aspek::create([
                'domain_id' => $domainKualitasData->id,
                'nama_aspek' => 'Akurasi',
                'bobot_aspek' => 16,
            ]);

            $aspekAktualitas = Aspek::create([
                'domain_id' => $domainKualitasData->id,
                'nama_aspek' => 'Aktualitas & Ketepatan Waktu',
                'bobot_aspek' => 21,
            ]);

            $aspekAksesibilitas = Aspek::create([
                'domain_id' => $domainKualitasData->id,
                'nama_aspek' => 'Aksesibilitas',
                'bobot_aspek' => 21,
            ]);

            $aspekKeterbandingan = Aspek::create([
                'domain_id' => $domainKualitasData->id,
                'nama_aspek' => 'Keterbandingan & Konsistensi',
                'bobot_aspek' => 21,
            ]);

            // Domain Proses Bisnis Statistik
            $aspekPerencanaanData = Aspek::create([
                'domain_id' => $domainProsesBisnis->id,
                'nama_aspek' => 'Perencanaan Data',
                'bobot_aspek' => 32,
            ]);

            $aspekPengumpulanData = Aspek::create([
                'domain_id' => $domainProsesBisnis->id,
                'nama_aspek' => 'Pengumpulan Data',
                'bobot_aspek' => 26,
            ]);

            $aspekPemeriksaanData = Aspek::create([
                'domain_id' => $domainProsesBisnis->id,
                'nama_aspek' => 'Pemeriksaan Data',
                'bobot_aspek' => 21,
            ]);

            $aspekPenyebarluasanData = Aspek::create([
                'domain_id' => $domainProsesBisnis->id,
                'nama_aspek' => 'Penyebarluasan Data',
                'bobot_aspek' => 21,
            ]);

            // Domain Kelembagaan
            $aspekProfesionalitas = Aspek::create([
                'domain_id' => $domainKelembagaan->id,
                'nama_aspek' => 'Profesionalitas',
                'bobot_aspek' => 35,
            ]);

            $aspekSDM = Aspek::create([
                'domain_id' => $domainKelembagaan->id,
                'nama_aspek' => 'SDM yang Memadai dan Kapabel',
                'bobot_aspek' => 30,
            ]);

            $aspekPengorganisasian = Aspek::create([
                'domain_id' => $domainKelembagaan->id,
                'nama_aspek' => 'Pengorganisasian Statistik',
                'bobot_aspek' => 35,
            ]);

            // Domain Statistik Nasional
            $aspekPemanfaatanData = Aspek::create([
                'domain_id' => $domainStatistikNasional->id,
                'nama_aspek' => 'Pemanfaatan Data Statistik',
                'bobot_aspek' => 34,
            ]);

            $aspekPengelolaanKegiatan = Aspek::create([
                'domain_id' => $domainStatistikNasional->id,
                'nama_aspek' => 'Pengelolaan Kegiatan Statistik ',
                'bobot_aspek' => 33,
            ]);

            $aspekPenguatanSSN = Aspek::create([
                'domain_id' => $domainStatistikNasional->id,
                'nama_aspek' => 'Penguatan SSN Berkelanjutan',
                'bobot_aspek' => 33,
            ]);


            /////////////////////////////////////////////// End Aspek /////////////////////////////////////////////////





            ///////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////// Start Indikator  ////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////


            // Prinsip Satu Data Indonesia
            $indikator1 = Indikator::create([
                'aspek_id' => $aspekStandarDataStatistik->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Standar Data Statistik (SDS)',
                'bobot_indikator' => 100,
            ]);

            $indikator2 = Indikator::create([
                'aspek_id' => $aspekMetadataStatistik->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Metadata Statistik',
                'bobot_indikator' => 100,
            ]);

            $indikator3 = Indikator::create([
                'aspek_id' => $aspekInteroperabilitasData->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Interoperabilitas Data',
                'bobot_indikator' => 100,
            ]);

            $indikator4 = Indikator::create([
                'aspek_id' => $aspekKodeReferensi->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Kode Referensi',
                'bobot_indikator' => 100,
            ]);


            // Kualitas Data

            // Relevansi
            $indikator5 = Indikator::create([
                'aspek_id' => $aspekRelevansi->id,
                'nama_indikator' => 'Tingkat Kematangan Relevansi Data Terhadap Pengguna',
                'bobot_indikator' => 60,
            ]);

            $indikator6 = Indikator::create([
                'aspek_id' => $aspekRelevansi->id,
                'nama_indikator' => 'Tingkat Kematangan Proses Identifikasi Kebutuhan Data',
                'bobot_indikator' => 40,
            ]);
            //

            // Akurasi
            $indikator7 = Indikator::create([
                'aspek_id' => $aspekAkurasi->id,
                'nama_indikator' => 'Tingkat Kematangan Penilaian Akurasi Data',
                'bobot_indikator' => 100,
            ]);
            //


            // Aktualitas & Ketepatan Waktu
            $indikator8 = Indikator::create([
                'aspek_id' => $aspekAktualitas->id,
                'nama_indikator' => 'Tingkat Kematangan Penjaminan Aktualitas Data',
                'bobot_indikator' => 50,
            ]);

            $indikator9 = Indikator::create([
                'aspek_id' => $aspekAktualitas->id,
                'nama_indikator' => 'Tingkat Kematangan Pemantauan Ketepatan Waktu Diseminasi',
                'bobot_indikator' => 50,
            ]);

            //


            // Aksesbilitas
            $indikator10 = Indikator::create([
                'aspek_id' => $aspekAksesibilitas->id,
                'nama_indikator' => 'Tingkat Kematangan Ketersediaan Data untuk Pengguna Data',
                'bobot_indikator' => 34,
            ]);

            $indikator11 = Indikator::create([
                'aspek_id' => $aspekAksesibilitas->id,
                'nama_indikator' => 'Tingkat Kematangan Akses Media Penyebarluasan Data',
                'bobot_indikator' => 33,
            ]);

            $indikator12 = Indikator::create([
                'aspek_id' => $aspekAksesibilitas->id,
                'nama_indikator' => 'Tingkat Kematangan Penyediaan Format Data',
                'bobot_indikator' => 33,
            ]);
            //


            // Keterbandingan & Konsistensi

            $indikator13 = Indikator::create([
                'aspek_id' => $aspekKeterbandingan->id,
                'nama_indikator' => 'Tingkat Kematangan Keterbandingan Data',
                'bobot_indikator' => 50,
            ]);

            $indikator14 = Indikator::create([
                'aspek_id' => $aspekKeterbandingan->id,
                'nama_indikator' => 'Tingkat Kematangan Konsistensi Statistik',
                'bobot_indikator' => 50,
            ]);



            // Proses Bisnis Statistik

            // Perencanaan Data

            $indikator15 = Indikator::create([
                'aspek_id' => $aspekPerencanaanData->id,
                'nama_indikator' => 'Tingkat Kematangan Pendefinisian Kebutuhan Statistik',
                'bobot_indikator' => 33,
            ]);

            $indikator16 = Indikator::create([
                'aspek_id' => $aspekPerencanaanData->id,
                'nama_indikator' => 'Tingkat Kematangan Desain Statistik',
                'bobot_indikator' => 33,
            ]);

            $indikator17 = Indikator::create([
                'aspek_id' => $aspekPerencanaanData->id,
                'nama_indikator' => 'Tingkat Kematangan Penyiapan Instrumen',
                'bobot_indikator' => 34,
            ]);

            //


            // Pengumpulan Data

            $indikator18 = Indikator::create([
                'aspek_id' => $aspekPengumpulanData->id,
                'nama_indikator' => 'Tingkat Kematangan Proses Pengumpulan Data atau Akuisisi Data',
                'bobot_indikator' => 100,
            ]);

            //

            // Pemeriksaan Data

            $indikator19 = Indikator::create([
                'aspek_id' => $aspekPemeriksaanData->id,
                'nama_indikator' => 'Tingkat Kematangan Pengolahan Data',
                'bobot_indikator' => 50,
            ]);

            $indikator20 = Indikator::create([
                'aspek_id' => $aspekPemeriksaanData->id,
                'nama_indikator' => 'Tingkat Kematangan Analisis Data',
                'bobot_indikator' => 50,
            ]);

            //


            // Penyebarluasan Data

            $indikator21 = Indikator::create([
                'aspek_id' => $aspekPenyebarluasanData->id,
                'nama_indikator' => 'Tingkat Kematangan Diseminasi Data',
                'bobot_indikator' => 100,
            ]);


            // Kelembagaan

            // Profesionalitas
            $indikator22 = Indikator::create([
                'aspek_id' => $aspekProfesionalitas->id,
                'nama_indikator' => 'Tingkat Kematangan  Penjaminan Transparansi  Informasi Statistik',
                'bobot_indikator' => 25,
            ]);

            $indikator23 = Indikator::create([
                'aspek_id' => $aspekProfesionalitas->id,
                'nama_indikator' => 'Tingkat Kematangan  Penjaminan Netralitas dan  Objektivitas terhadap  Penggunaan Sumber Data  Metodologi',
                'bobot_indikator' => 25,
            ]);

            $indikator24 = Indikator::create([
                'aspek_id' => $aspekProfesionalitas->id,
                'nama_indikator' => 'Tingkat Kematangan  Penjaminan Kualitas Data',
                'bobot_indikator' => 25,
            ]);

            $indikator25 = Indikator::create([
                'aspek_id' => $aspekProfesionalitas->id,
                'nama_indikator' => 'Tingkat Kematangan  Penjaminan Konfidensialitas  Data',
                'bobot_indikator' => 25,
            ]);


            // SDM yang Memadai dan Kapabel

            $indikator26 = Indikator::create([
                'aspek_id' => $aspekSDM->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Kompetensi Sumber Daya Manusia Bidang Statistik',
                'bobot_indikator' => 50,
            ]);

            $indikator27 = Indikator::create([
                'aspek_id' => $aspekSDM->id,
                'nama_indikator' => 'Tingkat Kematangan Penerapan Kompetensi Sumber Daya Manusia Bidang Manajemen Data ',
                'bobot_indikator' => 50,
            ]);


            // Pengorganisasian Statistik

            $indikator28 = Indikator::create([
                'aspek_id' => $aspekPengorganisasian->id,
                'nama_indikator' => 'Tingkat Kematangan Kolaborasi Penyelenggaraan Kegiatan Statistik ',
                'bobot_indikator' => 25,
            ]);

            $indikator29 = Indikator::create([
                'aspek_id' => $aspekPengorganisasian->id,
                'nama_indikator' => 'Tingkat Kematangan Penyelenggaraan Forum Satu Data Indonesia',
                'bobot_indikator' => 25,
            ]);

            $indikator30 = Indikator::create([
                'aspek_id' => $aspekPengorganisasian->id,
                'nama_indikator' => 'Tingkat Kematangan Kolaborasi dengan Pembina Data Statistik',
                'bobot_indikator' => 25,
            ]);

            $indikator31 = Indikator::create([
                'aspek_id' => $aspekPengorganisasian->id,
                'nama_indikator' => 'Tingkat Kematangan Penyelenggaraan Pelaksanaan Tugas Sebagai Walidata',
                'bobot_indikator' => 25,
            ]);

            // Statistik Nasional

            // Pemanfaatan Data Statistik

            $indikator32 = Indikator::create([
                'aspek_id' => $aspekPemanfaatanData->id,
                'nama_indikator' => 'Tingkat Kematangan  Penggunaan Data Statistik  Dasar untuk Perencanaan,  Monitoring, dan Evaluasi,  dan atau Penyusunan  Kebijakan',
                'bobot_indikator' => 34,
            ]);

            $indikator33 = Indikator::create([
                'aspek_id' => $aspekPemanfaatanData->id,
                'nama_indikator' => 'Tingkat Kematangan  Penggunaan Data Statistik  Sektoral untuk Perencanaan,  Monitoring, dan Evaluasi,  dan atau Penyusunan  Kebijakan',
                'bobot_indikator' => 33,
            ]);

            $indikator34 = Indikator::create([
                'aspek_id' => $aspekPemanfaatanData->id,
                'nama_indikator' => 'Tingkat Kematangan  Sosialisasi dan Literasi Data  Statistik',
                'bobot_indikator' => 33,
            ]);


            // Pengelolaan Kegiatan Statistik

            $indikator35 = Indikator::create([
                'aspek_id' => $aspekPengelolaanKegiatan->id,
                'nama_indikator' => 'Tingkat Kematangan Pelaksanaan Rekomendasi Kegiatan Statistik',
                'bobot_indikator' => 100,
            ]);

            // Penguatan SSN Berkelanjutan

            $indikator36 = Indikator::create([
                'aspek_id' => $aspekPenguatanSSN->id,
                'nama_indikator' => 'Tingkat Kematangan Perencanaan Pembangunan Statistik',
                'bobot_indikator' => 33,
            ]);

            $indikator37 = Indikator::create([
                'aspek_id' => $aspekPenguatanSSN->id,
                'nama_indikator' => 'Tingkat Kematangan Penyebarluasan Data',
                'bobot_indikator' => 33,
            ]);

            $indikator38 = Indikator::create([
                'aspek_id' => $aspekPenguatanSSN->id,
                'nama_indikator' => 'Tingkat Kematangan Pemanfaatan Big Data',
                'bobot_indikator' => 34,
            ]);


            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////// End Indikator  ////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        }




        return redirect()->route('formulir.index')->with('success', 'Formulir berhasil ditambahkan');
    }


    public function show(Formulir $formulir)
    {
        // dd($formulir->with('domains')->get());
        $formulir->load('domains.aspek.indikator');
        return view('dashboard.formulir.form-show', compact('formulir'));
    }


    public function edit(Formulir $formulir)
    {

        // dd($formulir);
        return view('dashboard.formulir.form-edit', compact('formulir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulir $formulir)
    {

        // dd($formulir);
        $request->validate([
            'nama_formulir' => 'required',
        ], [
            'nama_formulir.required' => 'Nama formulir harus diisi',
        ]);


        $formulir->update([
            'nama_formulir' => $request->nama_formulir,
            'created_by_id' => Auth::id() // Tambahkan created_by_id
        ]);

        return redirect()->back()->with('success', 'Formulir berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulir $formulir)
    {
        try {
            // Log informasi sebelum penghapusan
            \Log::info('Menghapus Formulir', [
                'formulir_id' => $formulir->id,
                'nama_formulir' => $formulir->nama_formulir,
                'domains_count' => $formulir->domains()->count(),
                'penilaians_count' => $formulir->penilaians()->count(),
                'formulir_domains_count' => $formulir->formulir_domains()->count()
            ]);

            // Hapus relasi terkait terlebih dahulu
            $formulir->domains()->detach(); // Lepaskan hubungan domain
            $formulir->penilaians()->delete(); // Hapus penilaian terkait
            $formulir->formulir_domains()->delete(); // Hapus formulir domain terkait

            // Kemudian hapus formulir
            $formulir->delete();

            return redirect()->route('formulir.index')->with('success', 'Formulir berhasil dihapus');
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            \Log::error('Gagal menghapus Formulir', [
                'formulir_id' => $formulir->id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus formulir: ' . $e->getMessage());
        }
    }


    public function setDefaultChildren($id)
    {
        $formulir = Formulir::find($id);
        $domains = Domain::all();

        foreach ($domains as $domain) {
            FormulirDomain::create([
                'formulir_id' => $formulir->id,
                'domain_id' => $domain->id
            ]);
        }



        return redirect()->route('formulir.index')->with('success', 'Data Domain telah ditambahkan ke dalam formulir');
    }
}
