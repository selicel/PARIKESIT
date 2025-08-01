<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileDokumentasi;

class FileDokumentasiController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,png,jpeg|max:2048'
        ]);

        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();

        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload, $nama_file);

        FileDokumentasi::create([
            'nama_file' => $nama_file,
            'dokumentasi_kegiatan_id' => $request->dokumentasi_kegiatan_id
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload');
    }



    public function destroy(FileDokumentasi $fileDok)
    {
        $fileDok->delete();
        return redirect()->back()->with('success', 'File berhasil dihapus');
    }
}
