<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembinaan;
use App\Models\Penjadwalan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FilePembinaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PembinaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pembinaans = Pembinaan::with('file_pembinaan')->latest()->get();


        return view('dashboard.pembinaan.pembinaan-index', compact('pembinaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pembinaan.pembinaan-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $request->validate([
            'judul_pembinaan' => 'required',
            'bukti_dukung_undangan' => 'required|mimes:pdf|max:5120',
            'daftar_hadir' => 'required|mimes:pdf|max:5120',
            'materi' => 'required|mimes:pdf|max:5120',
            'notula' => 'required|mimes:pdf|max:5120',
            'files' => 'nullable|array',
            'files.*' => 'required|mimes:jpeg,png,jpg,gif,mp4,mp3,avi,flv|max:5120',
        ], [
            'judul_pembinaan.required' => 'Nama pembinaan harus diisi',
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


        $judul = Str::slug($request->judul_pembinaan . '-' . time());
        $path = 'file-pembinaan/' . $judul;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        // dd($judul);
        $data = [];
        $data['judul_pembinaan'] = $request->judul_pembinaan;

        // Daftar field file tunggal sesuai model
        $fileFields = [
            'bukti_dukung_undangan',
            'daftar_hadir',
            'materi',
            'notula',
        ];

        foreach ($fileFields as $field) {
            $file = $request->file($field);
            if ($file) {

                // if(File::exists)
                $filSaved = $field . '-'. time() . '.' . $file->getClientOriginalExtension();

                // dd($filSaved);
                $path = $file->move('file-pembinaan/' . $judul . '/', $filSaved);
                $data[$field] = $path;
            } else {
                $data[$field] = null;
            }
        }

        // dd($data);
        // Simpan ke model
        $kegiatan = Pembinaan::create([
            'created_by_id' => Auth::user()->id,
            'judul_pembinaan' => $request->judul_pembinaan,
            'directory_pembinaan' => $judul,
            'bukti_dukung_undangan_pembinaan' => $data['bukti_dukung_undangan'],
            'daftar_hadir_pembinaan' => $data['daftar_hadir'],
            'materi_pembinaan' => $data['materi'],
            'notula_pembinaan' => $data['notula'],
        ]);


        // Kalau ada files[] tambahan (bukti tambahan), bisa ditangani terpisah
        $files = $request->file('files');
        if ($files && is_array($files)) {
            foreach ($files as $index => $file) {
                if ($file) {
                    $filename = $file->getClientOriginalName();
                    $filSaved = 'media-' . $index . '-'. time() . '.' . $file->getClientOriginalExtension();
                    $fileext = $file->getClientOriginalExtension();
                    $path = $file->move('file-pembinaan/' . $judul . '/media', $filSaved);


                    // dd($path);
                    // Contoh simpan ke tabel terpisah dengan relasi
                    $kegiatan->file_pembinaan()->create([
                        'nama_file' => 'file-pembinaan/' . $judul . '/media/' . $filSaved,
                        'tipe_file' => $fileext,
                        'pembinaan_id' => $kegiatan->id
                    ]);
                }
            }
        }




        return redirect()->route('pembinaan.index')->with('success', 'Pembinaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembinaan $pembinaan)
    {

        $pembinaan->load('file_pembinaan');

        // dd($pembinaan);
        return view('dashboard.pembinaan.pembinaan-show', compact('pembinaan'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembinaan $pembinaan)
    {
        $pembinaan->load('file_pembinaan');

        return view('dashboard.pembinaan.pembinaan-edit', compact('pembinaan'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembinaan $pembinaan)
    {

        $pembinaan->load('file_pembinaan');

        $request->validate([
            'judul_pembinaan' => 'required',
            'bukti_dukung_undangan' => 'mimes:pdf|max:5120',
            'daftar_hadir' => 'mimes:pdf|max:5120',
            'materi' => 'mimes:pdf|max:5120',
            'notula' => 'mimes:pdf|max:5120',

        ], [
            'judul_pembinaan.required' => 'Nama pembinaan harus diisi',
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
        $judul = Str::slug($request->judul_pembinaan . '-' . $time);
        $pembinaan_slug = Str::slug($pembinaan->judul_pembinaan . '-' . $time);
        $path = 'file-pembinaan/' . $judul;
        $data = [];
        $data['judul_pembinaan'] = $request->judul_pembinaan;


        $dataFiles =  [
            'bukti_dukung_undangan' => [
                'request_file' => $request->file('bukti_dukung_undangan'),
                'local_file' => $pembinaan->bukti_dukung_undangan_pembinaan
            ],
            'daftar_hadir' => [
                'request_file' => $request->file('daftar_hadir'),
                'local_file' => $pembinaan->daftar_hadir_pembinaan,
            ],
            'materi' => [
                'request_file' => $request->file('materi'),
                'local_file' => $pembinaan->materi_pembinaan,
            ],
            'notula' => [
                'request_file' => $request->file('notula'),
                'local_file' => $pembinaan->notula_pembinaan,
            ],
        ];

        foreach ($dataFiles as $indexName => $field) {

            $file = $field['request_file'];
            $localFile = $field['local_file'];


            if ($file) {

                if (File::exists($localFile)) {
                    unlink($localFile);
                    $fileSaved = $indexName . '-' . $localFile . '-' . $time . '.' . $file->getClientOriginalExtension();
                    $path = $file->move('file-pembinaan/' . $judul . '/', $fileSaved);

                    $data[$indexName] = $path;
                } else {
                    $fileSaved = $indexName . '-' . $request->judul_pembinaan . '-' . $time . '.' . $file->getClientOriginalExtension();
                    $path = $file->move('file-pembinaan/' . $judul . '/', $fileSaved);
                    $data[$indexName] = $path;
                }
            }
            //  else {
            //     $data[$indexName] = $localFile;
            // }
        }

        $pembinaan->update([
            'created_by_id' => Auth::user()->id,
            'judul_pembinaan' => $request->judul_pembinaan,
            'bukti_dukung_undangan_pembinaan' => $data['bukti_dukung_undangan'] ?? $pembinaan->bukti_dukung_undangan_pembinaan,
            'daftar_hadir_pembinaan' => $data['daftar_hadir'] ?? $pembinaan->daftar_hadir_pembinaan ,
            'materi_pembinaan' => $data['materi'] ?? $pembinaan->materi_pembinaan,
            'notula_pembinaan' => $data['notula'] ?? $pembinaan->notula_pembinaan,
        ]);



        return redirect()->route('pembinaan.show',$pembinaan->id)->with('success', 'Pembinaan berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembinaan $pembinaan)
    {

        // dd($pembinaan);
        $pembinaan->delete();



        return redirect()->route('pembinaan.index')->with('success', 'Pembinaan Berhasil dihapus');
    }
}
