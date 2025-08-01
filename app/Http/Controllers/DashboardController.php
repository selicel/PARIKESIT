<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Formulir;
use App\Models\Indikator;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FormulirPenilaianDisposisi;

class DashboardController extends Controller
{
    public function index()
    {

        // if (Auth::user()->role == 'opd') {
        //     $data['title'] = 'Dashboard OPD';
        //     return view('dashboard.opd.opd-dashboard', $data);
        // } else {
            $data['title'] = 'Dashboard';
            $data['kegiatanPenilaian'] = Formulir::latest()->get();
            $data['jumlahKegiatanPenilaian'] = Formulir::count();
            $data['jumlahPenilaianSelesai'] = Formulir::count();
            $data['jumlahPenilaianProgres'] = Formulir::count();
            $data['userTerdaftar'] = User::count();
            $data['users'] = User::doesntHave('penilaians')->latest()->get();

        //     // dd($data['users']);
            return view('dashboard.dashboard', $data);
        // }
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
