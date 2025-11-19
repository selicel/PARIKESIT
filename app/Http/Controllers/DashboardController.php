<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Formulir;
use App\Models\Indikator;
use App\Models\Penilaian;
use App\Models\Domain;
use App\Models\Aspek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FormulirPenilaianDisposisi;

class DashboardController extends Controller
{
    public function index()
    {
            $data['title'] = 'Dashboard';
            $data['kegiatanPenilaian'] = Formulir::latest()->get();
            $data['jumlahKegiatanPenilaian'] = Formulir::count();
            $data['jumlahPenilaianSelesai'] = Formulir::count();
            $data['jumlahPenilaianProgres'] = Formulir::count();
            $data['userTerdaftar'] = User::count();
            $data['users'] = User::doesntHave('penilaians')->latest()->get();

        // Progress bar data berdasarkan role
        $user = Auth::user();
        $data['progressData'] = [];

        if ($user->role == 'opd') {
            $data['progressData'] = $this->getOPDProgress($user);
        } elseif ($user->role == 'walidata') {
            $data['progressData'] = $this->getWalidataProgress();
        } elseif ($user->role == 'admin') {
            $data['progressData'] = $this->getAdminProgress();
        }

            return view('dashboard.dashboard', $data);
    }

    /**
     * Get progress data for OPD
     */
    private function getOPDProgress($user)
    {
        // Ambil formulir yang memiliki penilaian dari user ini
        $formulirs = Formulir::whereHas('penilaians', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['domains.aspek.indikator.penilaian' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->latest()
        ->get();

        $progressData = [];

        foreach ($formulirs as $formulir) {
            $formulirData = [
                'id' => $formulir->id,
                'nama' => $formulir->nama_formulir,
                'tanggal' => $formulir->tanggal_dibuat,
                'progress_per_indikator' => [],
                'hasil_penilaian_akhir' => null,
                'progress_koreksi_walidata' => null,
                'progress_evaluasi_admin' => null,
            ];

            // 1. Progress per indikator
            $totalIndikator = 0;
            $indikatorTerisi = 0;
            $indikatorDetails = [];

            foreach ($formulir->domains as $domain) {
                foreach ($domain->aspek as $aspek) {
                    foreach ($aspek->indikator as $indikator) {
                        $totalIndikator++;
                        $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                        $indikatorDetails[] = [
                            'id' => $indikator->id,
                            'nama' => $indikator->nama_indikator,
                            'domain' => $domain->nama_domain,
                            'aspek' => $aspek->nama_aspek,
                            'sudah_dinilai' => $penilaian && $penilaian->nilai !== null,
                            'nilai' => $penilaian ? $penilaian->nilai : null,
                        ];

                        if ($penilaian && $penilaian->nilai !== null) {
                            $indikatorTerisi++;
                        }
                    }
                }
            }

            $formulirData['progress_per_indikator'] = [
                'total' => $totalIndikator,
                'terisi' => $indikatorTerisi,
                'persentase' => $totalIndikator > 0 ? round(($indikatorTerisi / $totalIndikator) * 100, 2) : 0,
                'details' => $indikatorDetails,
            ];

            // 2. Hasil penilaian akhir (rata-rata dari berbagai domain)
            $formulirData['hasil_penilaian_akhir'] = $this->calculateRataRataDomain($formulir, $user, 'nilai');

            // 3. Progress koreksi Walidata
            $formulirData['progress_koreksi_walidata'] = $this->calculateProgressKoreksi($formulir, $user);

            // 4. Progress evaluasi Admin
            $formulirData['progress_evaluasi_admin'] = $this->calculateProgressEvaluasi($formulir, $user);

            $progressData[] = $formulirData;
        }

        return $progressData;
    }

    /**
     * Get progress data for Walidata
     */
    private function getWalidataProgress()
    {
        $formulirs = Formulir::with(['domains.aspek.indikator.penilaian.user'])->latest()->get();

        $progressData = [];

        foreach ($formulirs as $formulir) {
            $formulirData = [
                'id' => $formulir->id,
                'nama' => $formulir->nama_formulir,
                'tanggal' => $formulir->tanggal_dibuat,
                'nilai_koreksi_akhir' => null,
                'indikator_belum_dikoreksi' => [],
            ];

            // 1. Nilai koreksi akhir (rata-rata dari berbagai domain)
            $formulirData['nilai_koreksi_akhir'] = $this->calculateRataRataDomainKoreksi($formulir);

            // 2. Indikator yang belum dikoreksi
            $formulirData['indikator_belum_dikoreksi'] = $this->getIndikatorBelumDikoreksi($formulir);

            $progressData[] = $formulirData;
        }

        return $progressData;
    }

    /**
     * Get progress data for Admin
     */
    private function getAdminProgress()
    {
        $formulirs = Formulir::with(['domains.aspek.indikator.penilaian.user'])->latest()->get();

        $progressData = [];

        foreach ($formulirs as $formulir) {
            $formulirData = [
                'id' => $formulir->id,
                'nama' => $formulir->nama_formulir,
                'tanggal' => $formulir->tanggal_dibuat,
                'nilai_evaluasi_akhir' => null,
                'indikator_belum_dievaluasi' => [],
                'statistik_opd' => [
                    'total_indikator' => 0,
                    'terisi' => 0,
                    'persentase' => 0,
                ],
                'statistik_walidata' => [
                    'total_indikator' => 0,
                    'terkoreksi' => 0,
                    'persentase' => 0,
                ],
            ];

            // 1. Nilai evaluasi akhir (rata-rata dari berbagai domain)
            $formulirData['nilai_evaluasi_akhir'] = $this->calculateRataRataDomainEvaluasi($formulir);

            // 2. Indikator yang belum dievaluasi
            $formulirData['indikator_belum_dievaluasi'] = $this->getIndikatorBelumDievaluasi($formulir);

            // 3. Statistik pengisian OPD
            $formulirData['statistik_opd'] = $this->getStatistikOPD($formulir);

            // 4. Statistik koreksi Walidata
            $formulirData['statistik_walidata'] = $this->getStatistikWalidata($formulir);

            $progressData[] = $formulirData;
        }

        return $progressData;
    }

    /**
     * Calculate average value from domains (for OPD initial assessment)
     *
     * Rumus: Indeks Domain_k = (Σ_{i=1}^{I} Bobot Indikator_{ik} × Nilai Indikator_{ik}) / (Σ_{i=1}^{I} Bobot Indikator_{ik})
     *
     * Catatan: Perhitungan langsung dari Indikator ke Domain (skip Aspek)
     * Untuk perhitungan melalui Aspek, rumus: Indeks Domain_k = (Σ_{j=1}^{J} Bobot Aspek_{jk} × Indeks Aspek_{jk}) / (Σ_{j=1}^{J} Bobot Aspek_{jk})
     */
    private function calculateRataRataDomain($formulir, $user, $field = 'nilai')
    {
        $domainAverages = [];

        foreach ($formulir->domains as $domain) {
            $domainNilai = [];
            $totalBobot = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                    if ($penilaian && $penilaian->$field !== null) {
                        $bobot = $indikator->bobot_indikator ?? 1;
                        $domainNilai[] = $penilaian->$field * $bobot;
                        $totalBobot += $bobot;
                    }
                }
            }

            if (count($domainNilai) > 0 && $totalBobot > 0) {
                $domainAverages[$domain->nama_domain] = [
                    'nilai' => round(array_sum($domainNilai) / $totalBobot, 2), // Gunakan round() untuk konsistensi
                    'bobot' => $domain->bobot_domain ?? 1,
                ];
            }
        }

        // Hitung Indeks Pembangunan Statistik (rata-rata tertimbang domain)
        // Rumus: Indeks Pembangunan Statistik = (Σ_{k=1}^{K} Bobot Domain_k × Indeks Domain_k) / (Σ_{k=1}^{K} Bobot Domain_k)
        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($domainAverages as $domain) {
            $totalNilai += $domain['nilai'] * $domain['bobot'];
            $totalBobot += $domain['bobot'];
        }

        return $totalBobot > 0 ? round($totalNilai / $totalBobot, 2) : null;
    }

    /**
     * Calculate average correction value from domains (for Walidata)
     */
    private function calculateRataRataDomainKoreksi($formulir)
    {
        $domainAverages = [];

        foreach ($formulir->domains as $domain) {
            $domainNilai = [];
            $totalBobot = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->first();

                    if ($penilaian && $penilaian->nilai_koreksi !== null) {
                        $bobot = $indikator->bobot_indikator ?? 1;
                        $domainNilai[] = $penilaian->nilai_koreksi * $bobot;
                        $totalBobot += $bobot;
                    }
                }
            }

            if (count($domainNilai) > 0 && $totalBobot > 0) {
                $domainAverages[$domain->nama_domain] = [
                    'nilai' => round(array_sum($domainNilai) / $totalBobot, 2), // Gunakan round() untuk konsistensi
                    'bobot' => $domain->bobot_domain ?? 1,
                ];
            }
        }

        // Hitung rata-rata tertimbang
        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($domainAverages as $domain) {
            $totalNilai += $domain['nilai'] * $domain['bobot'];
            $totalBobot += $domain['bobot'];
        }

        return $totalBobot > 0 ? round($totalNilai / $totalBobot, 2) : null;
    }

    /**
     * Calculate average evaluation value from domains (for Admin)
     */
    private function calculateRataRataDomainEvaluasi($formulir)
    {
        // Evaluasi adalah string, jadi kita perlu konversi atau hitung berbeda
        // Asumsi: evaluasi bisa berupa nilai numerik atau string
        $domainAverages = [];

        foreach ($formulir->domains as $domain) {
            $domainNilai = [];
            $totalBobot = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->first();

                    if ($penilaian && $penilaian->evaluasi !== null) {
                        // Jika evaluasi adalah string numerik, konversi ke float
                        $nilaiEvaluasi = is_numeric($penilaian->evaluasi) ? (float)$penilaian->evaluasi : null;

                        if ($nilaiEvaluasi !== null) {
                            $bobot = $indikator->bobot_indikator ?? 1;
                            $domainNilai[] = $nilaiEvaluasi * $bobot;
                            $totalBobot += $bobot;
                        }
                    }
                }
            }

            if (count($domainNilai) > 0 && $totalBobot > 0) {
                $domainAverages[$domain->nama_domain] = [
                    'nilai' => round(array_sum($domainNilai) / $totalBobot, 2), // Gunakan round() untuk konsistensi
                    'bobot' => $domain->bobot_domain ?? 1,
                ];
            }
        }

        // Hitung rata-rata tertimbang
        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($domainAverages as $domain) {
            $totalNilai += $domain['nilai'] * $domain['bobot'];
            $totalBobot += $domain['bobot'];
        }

        return $totalBobot > 0 ? round($totalNilai / $totalBobot, 2) : null;
    }

    /**
     * Calculate progress koreksi Walidata
     */
    private function calculateProgressKoreksi($formulir, $user)
    {
        $totalIndikator = 0;
        $sudahDikoreksi = 0;

        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                    if ($penilaian && $penilaian->nilai !== null) {
                        $totalIndikator++;
                        if ($penilaian->nilai_koreksi !== null) {
                            $sudahDikoreksi++;
                        }
                    }
                }
            }
        }

        return [
            'total' => $totalIndikator,
            'sudah_dikoreksi' => $sudahDikoreksi,
            'persentase' => $totalIndikator > 0 ? round(($sudahDikoreksi / $totalIndikator) * 100, 2) : 0,
        ];
    }

    /**
     * Calculate progress evaluasi Admin
     */
    private function calculateProgressEvaluasi($formulir, $user)
    {
        $totalIndikator = 0;
        $sudahDievaluasi = 0;

        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                    if ($penilaian && $penilaian->nilai_koreksi !== null) {
                        $totalIndikator++;
                        if ($penilaian->evaluasi !== null && $penilaian->evaluasi !== '') {
                            $sudahDievaluasi++;
                        }
                    }
                }
            }
        }

        return [
            'total' => $totalIndikator,
            'sudah_dievaluasi' => $sudahDievaluasi,
            'persentase' => $totalIndikator > 0 ? round(($sudahDievaluasi / $totalIndikator) * 100, 2) : 0,
        ];
    }

    /**
     * Get indicators that haven't been corrected yet
     */
    private function getIndikatorBelumDikoreksi($formulir)
    {
        $indikatorBelumDikoreksi = [];

        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->first();

                    if ($penilaian && $penilaian->nilai !== null && $penilaian->nilai_koreksi === null) {
                        $indikatorBelumDikoreksi[] = [
                            'id' => $indikator->id,
                            'nama' => $indikator->nama_indikator,
                            'domain' => $domain->nama_domain,
                            'aspek' => $aspek->nama_aspek,
                            'user_id' => $penilaian->user_id,
                            'user_name' => $penilaian->user->name ?? 'N/A',
                        ];
                    }
                }
            }
        }

        return $indikatorBelumDikoreksi;
    }

    /**
     * Get indicators that haven't been evaluated yet
     */
    private function getIndikatorBelumDievaluasi($formulir)
    {
        $indikatorBelumDievaluasi = [];

        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->first();

                    if ($penilaian && $penilaian->nilai_koreksi !== null && ($penilaian->evaluasi === null || $penilaian->evaluasi === '')) {
                        $indikatorBelumDievaluasi[] = [
                            'id' => $indikator->id,
                            'nama' => $indikator->nama_indikator,
                            'domain' => $domain->nama_domain,
                            'aspek' => $aspek->nama_aspek,
                            'user_id' => $penilaian->user_id,
                            'user_name' => $penilaian->user->name ?? 'N/A',
                            'nilai_koreksi' => $penilaian->nilai_koreksi,
                            'catatan_koreksi' => $penilaian->catatan_koreksi,
                        ];
                    }
                }
            }
        }

        return $indikatorBelumDievaluasi;
    }

    /**
     * Get perbandingan hasil akhir dari OPD, Walidata, dan BPS (Admin)
     */
    private function getPerbandinganHasil()
    {
        $formulirs = Formulir::with(['domains.aspek.indikator.penilaian.user'])->latest()->get();
        $perbandingan = [];

        foreach ($formulirs as $formulir) {
            $formulirPerbandingan = [
                'id' => $formulir->id,
                'nama' => $formulir->nama_formulir,
                'tanggal' => $formulir->tanggal_dibuat,
                'opd_results' => [],
                'walidata_results' => [],
                'bps_results' => [],
            ];

            // Ambil semua user OPD yang memiliki penilaian di formulir ini
            $opdUsers = User::where('role', 'opd')
                ->whereHas('penilaians', function($query) use ($formulir) {
                    $query->where('formulir_id', $formulir->id);
                })
                ->get();

            foreach ($opdUsers as $opdUser) {
                $nilaiOPD = $this->calculateRataRataDomain($formulir, $opdUser, 'nilai');
                $nilaiWalidata = $this->calculateRataRataDomainKoreksiPerUser($formulir, $opdUser);
                $nilaiBPS = $this->calculateRataRataDomainEvaluasiPerUser($formulir, $opdUser);

                $formulirPerbandingan['opd_results'][] = [
                    'user_id' => $opdUser->id,
                    'user_name' => $opdUser->name,
                    'nilai' => $nilaiOPD,
                ];

                $formulirPerbandingan['walidata_results'][] = [
                    'user_id' => $opdUser->id,
                    'user_name' => $opdUser->name,
                    'nilai' => $nilaiWalidata,
                ];

                $formulirPerbandingan['bps_results'][] = [
                    'user_id' => $opdUser->id,
                    'user_name' => $opdUser->name,
                    'nilai' => $nilaiBPS,
                ];
            }

            $perbandingan[] = $formulirPerbandingan;
        }

        return $perbandingan;
    }

    /**
     * Calculate average correction value per user (for comparison)
     */
    private function calculateRataRataDomainKoreksiPerUser($formulir, $user)
    {
        $domainAverages = [];

        foreach ($formulir->domains as $domain) {
            $domainNilai = [];
            $totalBobot = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                    if ($penilaian && $penilaian->nilai_koreksi !== null) {
                        $bobot = $indikator->bobot_indikator ?? 1;
                        $domainNilai[] = $penilaian->nilai_koreksi * $bobot;
                        $totalBobot += $bobot;
                    }
                }
            }

            if (count($domainNilai) > 0 && $totalBobot > 0) {
                $domainAverages[$domain->nama_domain] = [
                    'nilai' => round(array_sum($domainNilai) / $totalBobot, 2), // Gunakan round() untuk konsistensi
                    'bobot' => $domain->bobot_domain ?? 1,
                ];
            }
        }

        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($domainAverages as $domain) {
            $totalNilai += $domain['nilai'] * $domain['bobot'];
            $totalBobot += $domain['bobot'];
        }

        return $totalBobot > 0 ? round($totalNilai / $totalBobot, 2) : null;
    }

    /**
     * Calculate average evaluation value per user (for comparison)
     */
    private function calculateRataRataDomainEvaluasiPerUser($formulir, $user)
    {
        $domainAverages = [];

        foreach ($formulir->domains as $domain) {
            $domainNilai = [];
            $totalBobot = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $penilaian = $indikator->penilaian->where('formulir_id', $formulir->id)->where('user_id', $user->id)->first();

                    if ($penilaian && $penilaian->evaluasi !== null) {
                        $nilaiEvaluasi = is_numeric($penilaian->evaluasi) ? (float)$penilaian->evaluasi : null;

                        if ($nilaiEvaluasi !== null) {
                            $bobot = $indikator->bobot_indikator ?? 1;
                            $domainNilai[] = $nilaiEvaluasi * $bobot;
                            $totalBobot += $bobot;
                        }
                    }
                }
            }

            if (count($domainNilai) > 0 && $totalBobot > 0) {
                $domainAverages[$domain->nama_domain] = [
                    'nilai' => round(array_sum($domainNilai) / $totalBobot, 2), // Gunakan round() untuk konsistensi
                    'bobot' => $domain->bobot_domain ?? 1,
                ];
            }
        }

        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($domainAverages as $domain) {
            $totalNilai += $domain['nilai'] * $domain['bobot'];
            $totalBobot += $domain['bobot'];
        }

        return $totalBobot > 0 ? round($totalNilai / $totalBobot, 2) : null;
    }

    /**
     * Get statistik pengisian indikator oleh OPD
     */
    private function getStatistikOPD($formulir)
    {
        $totalIndikator = 0;
        $terisi = 0;

        // Hitung semua indikator dalam formulir
        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $totalIndikator++;

                    // Cek apakah ada penilaian OPD untuk indikator ini
                    $hasPenilaianOPD = $indikator->penilaian
                        ->where('formulir_id', $formulir->id)
                        ->whereNotNull('nilai')
                        ->filter(function($penilaian) {
                            return $penilaian->user && $penilaian->user->role === 'opd';
                        })
                        ->isNotEmpty();

                    if ($hasPenilaianOPD) {
                        $terisi++;
                    }
                }
            }
        }

        return [
            'total_indikator' => $totalIndikator,
            'terisi' => $terisi,
            'persentase' => $totalIndikator > 0 ? round(($terisi / $totalIndikator) * 100, 2) : 0,
        ];
    }

    /**
     * Get statistik koreksi indikator oleh Walidata
     */
    private function getStatistikWalidata($formulir)
    {
        $totalIndikator = 0;
        $terkoreksi = 0;

        // Hitung semua indikator dalam formulir
        foreach ($formulir->domains as $domain) {
            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $totalIndikator++;

                    // Cek apakah ada koreksi Walidata untuk indikator ini
                    $hasKoreksiWalidata = $indikator->penilaian
                        ->where('formulir_id', $formulir->id)
                        ->whereNotNull('nilai_koreksi')
                        ->isNotEmpty();

                    if ($hasKoreksiWalidata) {
                        $terkoreksi++;
                    }
                }
            }
        }

        return [
            'total_indikator' => $totalIndikator,
            'terkoreksi' => $terkoreksi,
            'persentase' => $totalIndikator > 0 ? round(($terkoreksi / $totalIndikator) * 100, 2) : 0,
        ];
    }

    public function generatePenilaian(Request $request)
    {
        $indikators = Indikator::with('aspek.domain.formulirs')->get();



        $cekPenilaian = Penilaian::where('formulir_id', $request->formulir_id)->where('user_id', $request->user_id)->exists();

        // dd($cekPenilaian);
        foreach ($indikators as $indikator) {


            $penilaian = new Penilaian();
            $penilaian->indikator_id = $indikator->id;
            $penilaian->nilai = rand(1, 5);
            $penilaian->formulir_id = $request->formulir_id;
            $penilaian->tanggal_penilaian = Carbon::now();
            $penilaian->user_id = $request->user_id;
            $penilaian->save();

            // if ($penilaian) {
            //     FormulirPenilaianDisposisi::create([
            //         'formulir_id' => $request->formulir_id,
            //         'indikator_id' => $indikator->id,
            //         'assigned_profile_id' => $request->user_id,
            //         'status' => 'sent',
            //         'is_completed' => false,

            //     ]);
            // }
        }

        return redirect()->back();
    }
}
