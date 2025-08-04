<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aspek;
use App\Models\Domain;
use App\Models\Formulir;
use App\Models\FormulirPenilaianDisposisi;
use App\Models\Indikator;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{

    public function index()
    {
        $data['title'] = 'Dashboard';

        // Ambil formulir yang indikatornya semua sudah dinilai, hanya untuk OPD yang sedang login
        $data['kegiatanPenilaian'] = Formulir::with('domains.aspek.indikator.penilaian')
            ->where('created_by_id', Auth::user()->id) // Tambahkan filter berdasarkan user yang membuat
            ->whereDoesntHave('domains.aspek.indikator.penilaian', function ($query) {
                $query->whereNull('nilai');
            })
            ->latest()
            ->get();

        foreach ($data['kegiatanPenilaian'] as $formulir) {
            $totalIndikator = 0;
            $terisi = 0;
            foreach ($formulir->domains as $domain) {
                foreach ($domain->aspek as $aspek) {
                    $totalIndikator += $aspek->indikator->count();
                    foreach ($aspek->indikator as $indikator) {
                        // Filter berdasarkan user & formulir yang sedang di-loop
                        if ($indikator->penilaian->where('user_id', Auth::user()->id)->where('formulir_id', $formulir->id)->isNotEmpty()) {
                            $terisi++;
                        }
                    }
                }
            }

            // Tambahkan data ke instance Formulir
            $formulir->total_indikator = $totalIndikator;
            $formulir->indikator_terisi = $terisi;
            $formulir->persentase = $totalIndikator > 0 ? round(($terisi / $totalIndikator) * 100, 2) : 0;
        }

        return view('dashboard.penilaian.penilaian-index', $data);
    }


    public function penilaianTersedia(Formulir $formulir)
    {
        // Pastikan yang mengakses adalah pembuat formulir atau admin
        if (Auth::user()->role !== 'admin' && $formulir->created_by_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke formulir ini');
        }

        $totalIndikator = 0;
        $terisi = 0;

        // Array untuk menyimpan hasil persentase per domain
        $dataPersentasePerDomain = [];

        $formulir->load('formulir_domains.domain.aspek.indikator.penilaian');

        foreach ($formulir->formulir_domains as $formulirDomain) {
            $domain = $formulirDomain->domain;
            $totalPersentaseDomain = 0;

            foreach ($domain->aspek as $aspek) {
                foreach ($aspek->indikator as $indikator) {
                    $totalPersentasePerIndikator = 0;

                    $totalIndikator++;

                    // Hitung hanya penilaian untuk formulir & user saat ini
                    if (
                        $indikator->penilaian
                        ->where('formulir_id', $formulir->id)
                        ->where('user_id', Auth::id())
                        ->isNotEmpty()
                    ) {
                        $terisi++;
                    }

                    foreach ($indikator->penilaian as $penilaian) {
                        if (
                            $penilaian->formulir_id == $formulir->id &&
                            $penilaian->user_id == Auth::id()
                        ) {
                            $totalPersentasePerIndikator += (($penilaian->nilai * $indikator->bobot_indikator) / 100) / $domain->aspek->count();;
                        }
                    }

                    $totalPersentaseDomain += $totalPersentasePerIndikator;
                }
            }

            // Simpan data persentase domain berdasarkan ID domain
            $dataPersentasePerDomain[$domain->id] = [
                'nama' => $domain->nama_domain,
                'persentase_domain' => number_format($totalPersentaseDomain, 2),
                'jumlah_aspek' => $domain->aspek->count(),
            ];
        }

        $persentase = $totalIndikator > 0 ? round(($terisi / $totalIndikator) * 100, 2) : 0;

        return view('dashboard.penilaian.penilaian', compact(
            'formulir',
            'persentase',
            'totalIndikator',
            'terisi',
            'dataPersentasePerDomain'
        ));
    }



    //  public function penilaianTersedia(Formulir $formulir)
    // {
    //     $totalIndikator = 0;
    //     $terisi = 0;

    //     $formulir->load('domains.aspek.indikator');

    //     foreach ($formulir->domains as $domain) {
    //         foreach ($domain->aspek as $aspek) {
    //             $totalIndikator += $aspek->indikator->count();
    //             foreach ($aspek->indikator as $indikator) {

    //                 if ($indikator->penilaian->isNotEmpty()) {
    //                     $terisi++;
    //                 }
    //             }
    //         }
    //     }


    //     // dd($totalIndikator,$terisi);

    //     $persentase = $totalIndikator > 0 ? round(($terisi / $totalIndikator) * 100, 2) : 0;


    //     return view('dashboard.penilaian.penilaian', compact('formulir', 'persentase', 'totalIndikator', 'terisi'));
    // }




    //  formulir/{1}/domain-penilaian

    public function domainPenilaian(Formulir $formulir)
    {
        // Pastikan yang mengakses adalah pembuat formulir atau admin
        if (Auth::user()->role !== 'admin' && $formulir->created_by_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke formulir ini');
        }

        $formulir->load('domains.aspek.indikator');

        return view('dashboard.penilaian.domain-penilaian', compact('formulir'));
    }



    public function isiDomain(Formulir $formulir, $nama_domain)
    {
        // Pastikan yang mengakses adalah pembuat formulir atau admin
        if (Auth::user()->role !== 'admin' && $formulir->created_by_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke formulir ini');
        }

        $domain = Domain::where('nama_domain', $nama_domain)->first();
        $formulir->load('formulir_domains.domain.aspek.indikator.penilaian');
        return view('dashboard.penilaian.isi-domain-aspek-penilaian', compact(['formulir', 'domain']));
    }


    public function penilaianAspek(Formulir $formulir, $nama_domain, $aspek, $req_indikator)
    {


        $domain = Domain::where('nama_domain', $nama_domain)->first();


        // dd($req_indikator);
        $aspek = Aspek::where('domain_id', $domain->id)->where('nama_aspek', $aspek)->first();
        $indikator = Indikator::with('penilaian')->where('aspek_id', $aspek->id)->where('nama_indikator', $req_indikator)->first();
        $formulir->load('domains.aspek.indikator');




        // dd($req_indikator);


        // dd($formulir->id);

        // $dinilai = Indikator::with('penilaian')->whereHas('penilaian', function ($query) use ($indikator, $formulir) {
        //     $query->where('user_id', Auth::user()->id)->where('nilai', '!=', null)->where('indikator_id', $indikator->id)->whereFormulirId($formulir->id);
        // })
        //     ->where('nama_indikator', $req_indikator)->get();


        $dinilai = Penilaian::with('indikator')->whereHas('indikator', function ($query) use ($req_indikator,$formulir) {
            $query->where('nama_indikator', $req_indikator)->where('user_id', Auth::user()->id)->where('formulir_id', $formulir->id);
        })->first();
        // dd($dinilai);
        // dd($indikator->id);
        $next_indikator = Indikator::with('penilaian')->where('id', '>', $indikator->id)->first();
        $prev_indikator = Indikator::with('penilaian')->where('id', '<', $indikator->id)->first();


        // dd($next_indikator, $prev_indikator);
        return view('dashboard.penilaian.sesi-penilaian', compact('formulir', 'domain', 'aspek', 'indikator', 'dinilai', 'next_indikator', 'prev_indikator'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Formulir $formulir, $nama_domain, $aspek, $indikator)
    {


        $request->validate([
            'nilai' => 'required|numeric',
        ], [
            'nilai.required' => 'Tingkat kematangan harus diisi',
        ]);

        $savedFileName = '';


        if ($request->hasFile('bukti_dukung')) {
            $file = $request->file('bukti_dukung');
            $fileName = $file->getClientOriginalName();
            $fileExt = $file->getClientOriginalExtension();
            $savedFileName = time() . '-' . Auth::user()->id . '-' . $fileName . '.' . $fileExt;
            $file->move('bukti-dukung', $savedFileName);
        }


        $penilaian = Penilaian::create([
            'indikator_id' => $indikator,
            'nilai' => $request->nilai,
            'tanggal_penilaian' => date('Y-m-d'),
            'formulir_id' => $formulir->id,
            'user_id' =>  Auth::user()->id,
            'catatan' => $request->catatan,
            'bukti_dukung' => 'bukti-dukung/' . $savedFileName ?? '-'
        ]);

        // if ($penilaian) {
        //     FormulirPenilaianDisposisi::create([
        //         'formulir_id' => $formulir->id,
        //         'indikator_id' => $indikator,
        //         'assigned_profile_id' => Auth::user()->id,
        //         'status' => 'sent',
        //         'is_completed' => false,

        //     ]);
        // }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan');
    }



    public function update(Request $request, Formulir $formulir, $nama_domain, $aspek, $indikator)
    {

        dd($request->all());
        $request->validate([
            'nilai' => 'required|numeric',
        ], [
            'nilai.required' => 'Tingkat kematangan harus diisi',
        ]);
    }

    // public function prev_indikator(Formulir $formulir, $nama_domain, $aspek, $indikator)
    // {
    //     $domain = Domain::where('nama_domain', $nama_domain)->first();
    //     $aspek = Aspek::where('domain_id', $domain->id)->where('nama_aspek', $aspek)->first();
    //     $indikator = Indikator::where('aspek_id', $aspek->id)->where('nama_indikator', $indikator)->first();
    //     return redirect()->route('formulir.penilaianAspek', [$formulir, $domain, $aspek]);
    // }

}
