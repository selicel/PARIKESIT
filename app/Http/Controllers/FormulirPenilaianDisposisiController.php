<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Domain;
use App\Models\Formulir;
use App\Models\Indikator;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\FormulirPenilaianDisposisi;

class FormulirPenilaianDisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tersedia()
    {
        // Cek role pengguna yang sedang login
        $user = Auth::user();

        // Jika role adalah walidata atau admin, tampilkan semua formulir yang sudah dinilai
        if ($user->role === 'walidata' || $user->role === 'admin') {
            $penilaianSelesai = Formulir::whereHas('penilaians')->get();
        }
        // Jika role adalah OPD, tampilkan hanya formulir yang dibuat atau dinilai oleh OPD tersebut
        else if ($user->role === 'opd') {
            $penilaianSelesai = Formulir::whereHas('penilaians', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('created_by_id', $user->id);
            })->get();

            // Jika tidak ada kegiatan penilaian, kembalikan dengan pesan
            if ($penilaianSelesai->isEmpty()) {
                return redirect()->back()->with('error', 'Silahkan buat kegiatan terlebih dahulu!');
            }
        }
        // Untuk role lain, kembalikan collection kosong
        else {
            $penilaianSelesai = collect();
        }

        $countMaxPeserta = User::whereRole('opd')->count();
        $progresPenialian = '';

        return view('dashboard.disposisi.disposisi-index', compact('penilaianSelesai', 'countMaxPeserta'));
    }


    public function detail($formulir)
    {
        $formulir = Formulir::whereNamaFormulir($formulir)->first();

        // Cek role pengguna yang sedang login
        $user = Auth::user();

        // Jika role adalah walidata atau admin, tampilkan semua OPD yang menilai
        if ($user->role === 'walidata' || $user->role === 'admin') {
            $opdsMenilai = User::with('penilaians.formulir.formulir_domains.domain.aspek.indikator')
                ->whereHas('penilaians', function ($query) use ($formulir) {
                    $query->where('formulir_id', $formulir->id);
                })->get()->map(function ($opd) use ($formulir) {
                    return [
                        'opd' => $opd,
                        'domains' => $opd->penilaians->where('formulir_id', $formulir->id)->map(function ($penilaian) {
                            return $penilaian->formulir->formulir_domains->map(function ($fd) {
                                return $fd->domain;
                            });
                        })->flatten()->unique()
                    ];
                });
        }
        // Jika role adalah OPD, tampilkan hanya data untuk OPD tersebut
        else if ($user->role === 'opd') {
            $opdsMenilai = User::with('penilaians.formulir.formulir_domains.domain.aspek.indikator')
                ->whereHas('penilaians', function ($query) use ($formulir, $user) {
                    $query->where('formulir_id', $formulir->id)
                          ->where('user_id', $user->id);
                })->get()->map(function ($opd) use ($formulir) {
                    return [
                        'opd' => $opd,
                        'domains' => $opd->penilaians->where('formulir_id', $formulir->id)->map(function ($penilaian) {
                            return $penilaian->formulir->formulir_domains->map(function ($fd) {
                                return $fd->domain;
                            });
                        })->flatten()->unique()
                    ];
                });
        }
        // Untuk role lain, kembalikan collection kosong
        else {
            $opdsMenilai = collect();
        }

        return view('dashboard.disposisi.disposisi-detail', compact('formulir', 'opdsMenilai'));
    }


    public function koreksiIsiDomain($opd, $formulir, $domain)
    {
        $opd = User::where('name', $opd)->first();
        $formulir = Formulir::where('nama_formulir', $formulir)->first();
        $domain = Domain::where('nama_domain', $domain)->first();

        // Debug logging
        Log::info('Koreksi Isi Domain Debug', [
            'opd_name' => $opd->name,
            'opd_id' => $opd->id,
            'formulir_name' => $formulir->nama_formulir,
            'formulir_id' => $formulir->id,
            'domain_name' => $domain->nama_domain,
            'domain_id' => $domain->id
        ]);

        // Debug logging tambahan untuk penilaian Walidata
        Log::info('Penilaian Walidata Debug', [
            'opd_name' => $opd->name,
            'opd_id' => $opd->id,
            'formulir_name' => $formulir->nama_formulir,
            'formulir_id' => $formulir->id,
            'domain_name' => $domain->nama_domain,
            'domain_id' => $domain->id,
            'penilaian_walidata' => Penilaian::where('user_id', $opd->id)
                ->where('formulir_id', $formulir->id)
                ->whereHas('user', function($query) {
                    $query->where('role', 'walidata');
                })
                ->get()->toArray()
        ]);

        $formulir->load('formulir_domains.domain.aspek.indikator.penilaian');

        return view('dashboard.disposisi.koreksi-detail-isi-domain', compact('formulir', 'domain', 'opd'));
    }


    public function koreksi($opd, $formulir, $domain, $aspek, $indikator)
    {
        $opd = User::where('name', $opd)->first();
        $formulir = Formulir::where('nama_formulir', $formulir)->first();
        $domain = Domain::where('nama_domain', $domain)->first();
        $aspek = $domain->aspek()->where('nama_aspek', $aspek)->first();
        $indikator = $aspek->indikator()->where('nama_indikator', $indikator)->first();

        $nilai_diinput = Penilaian::where('user_id', $opd->id)->where('formulir_id', $formulir->id)->where('indikator_id', $indikator->id)->first();
        $nilai_dikoreksi = Penilaian::where('user_id', $opd->id)->where('formulir_id', $formulir->id)
            ->where('indikator_id', $indikator->id)->where('nilai_diupdate', '!=', null)->first();
        $nilai_dievaluasi = Penilaian::where('user_id', $opd->id)->where('formulir_id', $formulir->id)
            ->where('indikator_id', $indikator->id)->where('nilai_koreksi', '!=', null)->first();

        // Tambahkan logging untuk detail penilaian
        Log::info('Koreksi Penilaian Detail', [
            'opd_name' => $opd->name,
            'formulir_name' => $formulir->nama_formulir,
            'domain_name' => $domain->nama_domain,
            'aspek_name' => $aspek->nama_aspek,
            'indikator_name' => $indikator->nama_indikator,
            'nilai_diinput' => $nilai_diinput ? $nilai_diinput->toArray() : null,
            'nilai_dikoreksi' => $nilai_dikoreksi ? $nilai_dikoreksi->toArray() : null,
            'nilai_dievaluasi' => $nilai_dievaluasi ? $nilai_dievaluasi->toArray() : null,
            'current_user_role' => Auth::user()->role
        ]);

        return view('dashboard.disposisi.koreksi-penilaian', compact(
            'opd',
            'formulir',
            'domain',
            'aspek',
            'indikator',
            'nilai_diinput',
            'nilai_dikoreksi',
            'nilai_dievaluasi'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeKoreksi(Request $request)
    {
        $penilaian = Penilaian::find($request->penilaian_id);
        $pengoreksi = Auth::user()->id;
        $pengoreksiUser = User::find($pengoreksi);

        // Debug logging yang lebih komprehensif
        Log::info('Store Koreksi Debug - Detailed', [
            'request_data' => $request->all(),
            'penilaian_id' => $request->penilaian_id,
            'penilaian_details' => $penilaian ? $penilaian->toArray() : null,
            'pengoreksi_id' => $pengoreksi,
            'pengoreksi_role' => $pengoreksiUser->role,
            'pengoreksi_name' => $pengoreksiUser->name,
            'request_nilai' => $request->nilai,
            'current_user_role' => Auth::user()->role
        ]);

        // Tambahkan validasi tambahan
        if (!$penilaian) {
            Log::error('Penilaian not found', [
                'penilaian_id' => $request->penilaian_id
            ]);
            return redirect()->back()->with('error', 'Data penilaian tidak ditemukan');
        }

        // Pastikan hanya Walidata yang bisa update
        if ($pengoreksiUser->role !== 'walidata') {
            Log::warning('Unauthorized update attempt', [
                'user_id' => $pengoreksi,
                'user_role' => $pengoreksiUser->role
            ]);
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan koreksi');
        }

        $updateResult = $penilaian->update([
            'nilai_diupdate' => $request->nilai,
            'pengoreksi' => $pengoreksi
        ]);

        // Log hasil update
        Log::info('Store Koreksi Update Result', [
            'update_success' => $updateResult,
            'updated_penilaian' => $penilaian->fresh()->toArray()
        ]);

        return redirect()->back()->with('success', 'Berhasil mengoreksi penilaian');
    }



    public function updateEvaluasi(Request $request)
    {
        // dd($request->all());
        $penilaian = Penilaian::find($request->penilaian_id);
        $pengoreksi = Auth::user()->id;

        // Validasi: Pastikan Walidata sudah mengisi nilai_diupdate sebelum admin bisa menilai
        if (Auth::user()->role === 'admin') {
            if ($penilaian->nilai_diupdate === null) {
                return redirect()->back()->with('error', 'Walidata belum mengisi penilaian. Anda tidak dapat melakukan evaluasi.');
            }
        }

        $penilaian->update([
            'nilai_koreksi' => $request->nilai_evaluasi,
            'dikoreksi_by' => $pengoreksi,
            'evaluasi' => $request->evaluasi,
            'tanggal_dikoreksi' => now()
        ]);

        return redirect()->back()->with('success', 'Berhasil mengoreksi penilaian');
    }


    public function show(FormulirPenilaianDisposisi $formulirPenilaianDisposisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormulirPenilaianDisposisi $formulirPenilaianDisposisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormulirPenilaianDisposisi $formulirPenilaianDisposisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormulirPenilaianDisposisi $formulirPenilaianDisposisi)
    {
        //
    }
}
