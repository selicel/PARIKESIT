<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penjadwalan;
use App\Models\PesertaPembinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjadwalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->role == 'opd') {
            $penjadwalans = Penjadwalan::with('peserta_pembinaan')->whereHas('peserta_pembinaan',function($peserta) {
                $peserta->whereIn('peserta_id',[Auth::user()->id]);
            })->latest()->get();
        } else {
            $penjadwalans = Penjadwalan::with('peserta_pembinaan')->latest()->get();

        }


        // dd($penjadwalans);
        return view('dashboard.penjadwalan.penjadwalan-index', compact('penjadwalans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Penjadwalan Baru';
        $pesertas = User::whereIn('role', ['opd', 'walidata'])->get();
        // dd($users);
        return view('dashboard.penjadwalan.penjadwalan-create', compact('pesertas','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            // 'pemateri_id' => 'required|exists:users,id',
            'nama_pemateri' => 'required|string|max:255',
            'judul_jadwal' => 'required|string|max:255',
            'tanggal_jadwal' => 'required|date',
            'waktu_mulai' => 'required',
            'keterangan_jadwal' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
        ], [
            // 'pemateri_id.exists' => 'Profile pemateri tidak ditemukan',
            'nama_pemateri.required' => 'Nama pemateri harus diisi',
            'nama_pemateri.string' => 'Nama pemateri harus berupa string',
            'nama_pemateri.max' => 'Nama pemateri maksimal 255 karakter',
            'judul_jadwal.required' => 'Judul jadwal harus diisi',
            'judul_jadwal.string' => 'Judul jadwal harus berupa string',
            'judul_jadwal.max' => 'Judul jadwal maksimal 255 karakter',
            'tanggal_jadwal.required' => 'Tanggal jadwal harus diisi',
            'tanggal_jadwal.date' => 'Tanggal jadwal harus berupa tanggal',
            'waktu_mulai.required' => 'Waktu mulai harus diisi',
            'waktu_mulai.date_format' => 'Waktu mulai harus berupa jam (HH:mm)',
            'keterangan_jadwal.string' => 'Keterangan jadwal harus berupa string',
            'keterangan_jadwal.max' => 'Keterangan jadwal maksimal 255 karakter',
            'lokasi.required' => 'Lokasi harus diisi',
            'lokasi.string' => 'Lokasi harus berupa string',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
        ]);

        $penjadwalan = Penjadwalan::create([
            'nama_pemateri' => $request->nama_pemateri,
            // 'pemateri_id' => $request->pemateri_id,
            'judul_jadwal' => $request->judul_jadwal,
            'tanggal_jadwal' => $request->tanggal_jadwal,
            'waktu_mulai' => $request->waktu_mulai,
            'keterangan_jadwal' => $request->keterangan_jadwal,
            'lokasi' => $request->lokasi,
            'created_by' => Auth::user()->id
        ]);



        for($i=0; $i<count($request->peserta_pembinaan); $i++) {

            PesertaPembinaan::create([
                'penjadwalan_id' => $penjadwalan->id,
                'peserta_id' => $request->peserta_pembinaan[$i],
            ]);

        }


        $countPeserta = count($request->peserta_pembinaan);

        return redirect()->route('penjadwalan.index')->with('success', 'Penjadwalan berhasil disimpan. Sejumlah '.$countPeserta.' telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjadwalan $penjadwalan)
    {
        $penjadwalan->load('peserta_pembinaan.peserta');

        return view('dashboard.penjadwalan.penjadwalan-show',compact('penjadwalan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjadwalan $penjadwalan)
    {
        $users = User::whereIn('role', ['opd', 'walidata'])->get();
        $penjadwalan->load('peserta_pembinaan.peserta');
        return view('dashboard.penjadwalan.penjadwalan-edit', compact('penjadwalan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjadwalan $penjadwalan)
    {

        // dd($request->all());
        $request->validate([
            'nama_pemateri' => 'required|string|max:255',
            'judul_jadwal' => 'required|string|max:255',
            'tanggal_jadwal' => 'required|date',
            'waktu_mulai' => 'required',
            'keterangan_jadwal' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
        ], [
            'nama_pemateri.required' => 'Nama pemateri harus diisi',
            'nama_pemateri.string' => 'Nama pemateri harus berupa string',
            'nama_pemateri.max' => 'Nama pemateri maksimal 255 karakter',
            'judul_jadwal.required' => 'Judul jadwal harus diisi',
            'judul_jadwal.string' => 'Judul jadwal harus berupa string',
            'judul_jadwal.max' => 'Judul jadwal maksimal 255 karakter',
            'tanggal_jadwal.required' => 'Tanggal jadwal harus diisi',
            'tanggal_jadwal.date' => 'Tanggal jadwal harus berupa tanggal',
            'waktu_mulai.required' => 'Waktu mulai harus diisi',
            'waktu_mulai.date_format' => 'Waktu mulai harus berupa jam (HH:mm)',
            'keterangan_jadwal.string' => 'Keterangan jadwal harus berupa string',
            'keterangan_jadwal.max' => 'Keterangan jadwal maksimal 255 karakter',
            'lokasi.required' => 'Lokasi harus diisi',
            'lokasi.string' => 'Lokasi harus berupa string',
            'lokasi.max' => 'Lokasi maksimal 255 karakter',
        ]);



        $penjadwalan->peserta_pembinaan()->delete();

        $penjadwalan->update([
            'nama_pemateri' => $request->nama_pemateri,
            'judul_jadwal' => $request->judul_jadwal,
            'tanggal_jadwal' => $request->tanggal_jadwal,
            'waktu_mulai' => $request->waktu_mulai,
            'keterangan_jadwal' => $request->keterangan_jadwal,
            'lokasi' => $request->lokasi
        ]);


        for($i=0; $i<count($request->peserta_pembinaan); $i++) {

            PesertaPembinaan::create([
                'penjadwalan_id' => $penjadwalan->id,
                'peserta_id' => $request->peserta_pembinaan[$i],
            ]);

        }

        return redirect()->back()->with('success', 'Penjadwalan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjadwalan $penjadwalan)
    {
        $penjadwalan->delete();

        return redirect()->route('penjadwalan.index')->with('success', 'Penjadwalan berhasil dihapus');

    }
}
