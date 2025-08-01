<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FileDokumentasi;
use App\Models\DokumentasiKegiatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DokumentasiKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumentasis = DokumentasiKegiatan::with('file_dokumentasi')->latest()->get();

        // dd($formulirs);
        return view('dashboard.dokumentasi.dokumentasi-index', compact('dokumentasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.dokumentasi.dokumentasi-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_dokumentasi' => 'required',
            'bukti_dukung_undangan' => 'required|mimes:pdf|max:5120',
            'daftar_hadir' => 'required|mimes:pdf|max:5120',
            'materi' => 'required|mimes:pdf|max:5120',
            'notula' => 'required|mimes:pdf|max:5120',
            'files' => 'nullable|array',
            'files.*' => 'required|mimes:jpeg,png,jpg,gif,mp4,mp3,avi,flv|max:5120',
        ], [
            'judul_dokumentasi.required' => 'Nama Dokumentasi harus diisi',
            'bukti_dukung_undangan.required' => 'Bukti Dukung harus diisi',
            'bukti_dukung_undangan.mimes' => 'Bukti Dukung harus PDF',
            'bukti_dukung_undangan.max' => 'Bukti Dukung maximal 5mb',
            'daftar_hadir.required' => 'Daftar Hadir harus diisi',
            'daftar_hadir.mimes' => 'Daftar Hadir harus PDF',
            'daftar_hadir.max' => 'Daftar Hadir maximal 5mb',
            'materi.required' => 'Materi harus diisi',
            'materi.mimes' => 'Materi harus PDF',
            'materi.max' => 'Materi maximal 5mb',
            'notula.required' => 'Notula harus diisi',
            'notula.mimes' => 'Notula harus PDF',
            'notula.max' => 'Notula maximal 5mb',
            'files.*.required' => 'File harus diisi',
            'files.*.mimes' => 'File harus berupa gambar atau video',
            'files.*.max' => 'File maximal 5mb',
        ]);

        $judul = Str::slug($request->judul_dokumentasi . '-' . time());
        $path = 'file-dokumentasi/' . $judul;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $data = [];
        $data['judul_dokumentasi'] = $request->judul_dokumentasi;

        $fileFields = [
            'bukti_dukung_undangan',
            'daftar_hadir',
            'materi',
            'notula',
        ];

        foreach ($fileFields as $field) {
            $file = $request->file($field);
            if ($file) {
                $filSaved = $field . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->move('file-dokumentasi/' . $judul . '/', $filSaved);
                $data[$field] = $path;
            } else {
                $data[$field] = null;
            }
        }

        $kegiatan = DokumentasiKegiatan::create([
            'created_by_id' => Auth::user()->id,
            'judul_dokumentasi' => $request->judul_dokumentasi,
            'directory_dokumentasi' => $judul,
            'bukti_dukung_undangan_dokumentasi' => $data['bukti_dukung_undangan'],
            'daftar_hadir_dokumentasi' => $data['daftar_hadir'],
            'materi_dokumentasi' => $data['materi'],
            'notula_dokumentasi' => $data['notula'],
        ]);

        $files = $request->file('files');
        if ($files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ($file) {
                    $filSaved = 'media-' . $index . '-' . time() . '.' . $file->getClientOriginalExtension();
                    $fileext = $file->getClientOriginalExtension();
                    $path = $file->move('file-dokumentasi/' . $judul . '/media', $filSaved);

                    $kegiatan->file_dokumentasi()->create([
                        'nama_file' => 'file-dokumentasi/' . $judul . '/media/' . $filSaved,
                        'tipe_file' => $fileext,
                        'dokumentasi_id' => $kegiatan->id,
                    ]);
                }
            }
        }

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumentasiKegiatan $dokumentasiKegiatan)
    {


        $dokumentasiKegiatan->load('file_dokumentasi');

        // dd($dokumentasiKegiatan);
        return view('dashboard.dokumentasi.dokumentasi-show', compact('dokumentasiKegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumentasiKegiatan $dokumentasiKegiatan)
    {
        $dokumentasiKegiatan->load('file_dokumentasi');
        return view('dashboard.dokumentasi.dokumentasi-edit', compact('dokumentasiKegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumentasiKegiatan $dokumentasiKegiatan)
    {
        $request->validate([
            'judul_dokumentasi' => 'required',
            'bukti_dukung_undangan' => 'mimes:pdf|max:5120',
            'daftar_hadir' => 'mimes:pdf|max:5120',
            'materi' => 'mimes:pdf|max:5120',
            'notula' => 'mimes:pdf|max:5120',
        ], [
            'judul_dokumentasi.required' => 'Nama Dokumentasi harus diisi',
            'bukti_dukung_undangan.required' => 'Bukti Dukung harus diisi',
            'bukti_dukung_undangan.mimes' => 'Bukti Dukung harus PDF',
            'bukti_dukung_undangan.max' => 'Bukti Dukung maximal 5mb',
            'daftar_hadir.required' => 'Daftar Hadir harus diisi',
            'daftar_hadir.mimes' => 'Daftar Hadir harus PDF',
            'daftar_hadir.max' => 'Daftar Hadir maximal 5mb',
            'materi.required' => 'Materi harus diisi',
            'materi.mimes' => 'Materi harus PDF',
            'materi.max' => 'Materi maximal 5mb',
            'notula.required' => 'Notula harus diisi',
            'notula.mimes' => 'Notula harus PDF',
            'notula.max' => 'Notula maximal 5mb',

        ]);

        $time = time();
        $judul = Str::slug($request->judul_dokumentasi . '-' . $time);
        $dokSlug = Str::slug($dokumentasiKegiatan->judul_dokumentasi . '-' . $time);
        $path = 'file-dokumentasi/' . $judul;

        $data = [];
        $data['judul_dokumentasi'] = $request->judul_dokumentasi;

        $dataFiles = [
            'bukti_dukung_undangan' => [
                'request_file' => $request->file('bukti_dukung_undangan'),
                'local_file' => $dokumentasiKegiatan->bukti_dukung_undangan_dokumentasi,
            ],
            'daftar_hadir' => [
                'request_file' => $request->file('daftar_hadir'),
                'local_file' => $dokumentasiKegiatan->daftar_hadir_dokumentasi,
            ],
            'materi' => [
                'request_file' => $request->file('materi'),
                'local_file' => $dokumentasiKegiatan->materi_dokumentasi,
            ],
            'notula' => [
                'request_file' => $request->file('notula'),
                'local_file' => $dokumentasiKegiatan->notula_dokumentasi,
            ],
        ];

        foreach ($dataFiles as $indexName => $field) {
            $file = $field['request_file'];
            $localFile = $field['local_file'];

            if ($file) {
                if (File::exists($localFile)) {
                    unlink($localFile);
                }
                $fileSaved = $indexName . '-' . $request->judul_dokumentasi . '-' . $time . '.' . $file->getClientOriginalExtension();
                $path = $file->move('file-dokumentasi/' . $judul . '/', $fileSaved);
                $data[$indexName] = $path;
            }
        }

        $dokumentasiKegiatan->update([
            'created_by_id' => Auth::user()->id,
            'judul_dokumentasi' => $request->judul_dokumentasi,
            'bukti_dukung_undangan_dokumentasi' => $data['bukti_dukung_undangan'] ?? $dokumentasiKegiatan->bukti_dukung_undangan_dokumentasi,
            'daftar_hadir_dokumentasi' => $data['daftar_hadir'] ?? $dokumentasiKegiatan->daftar_hadir_dokumentasi,
            'materi_dokumentasi' => $data['materi'] ?? $dokumentasiKegiatan->materi_dokumentasi,
            'notula_dokumentasi' => $data['notula'] ?? $dokumentasiKegiatan->notula_dokumentasi,
        ]);

        // Jika ada file tambahan (media), tambahkan ke relasi file_dokumentasi
        $files = $request->file('files');
        if ($files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ($file) {
                    $fileSaved = 'media-' . $index . '-' . $time . '.' . $file->getClientOriginalExtension();
                    $fileext = $file->getClientOriginalExtension();
                    $path = $file->move('file-dokumentasi/' . $judul . '/media', $fileSaved);

                    $dokumentasiKegiatan->file_dokumentasi()->create([
                        'nama_file' => 'file-dokumentasi/' . $judul . '/media/' . $fileSaved,
                        'tipe_file' => $fileext,
                        'dokumentasi_id' => $dokumentasiKegiatan->id,
                    ]);
                }
            }
        }

        return redirect()->route('dokumentasi.show', $dokumentasiKegiatan->id)
            ->with('success', 'Dokumentasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumentasiKegiatan $dokumentasiKegiatan)
    {
        $dokumentasiKegiatan->delete();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus');
    }
}
