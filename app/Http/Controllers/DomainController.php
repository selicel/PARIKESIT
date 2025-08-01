<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Formulir;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Formulir $formulir)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Formulir $formulir)
    {
        return view('dashboard.domain.domain-create',compact('formulir'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Formulir $formulir, Request $request)
    {

        $request->validate([
            'nama_domain' => 'required|string|max:255',
            'nama_aspek' => 'required|array|min:1',
            'nama_aspek.*' => 'required|string|max:255',
        ],[
            'nama_domain.required' => 'Nama domain harus diisi',
            'nama_domain.string' => 'Nama domain harus berupa string',
            'nama_domain.max' => 'Nama domain maksimal 255 karakter',
            'nama_aspek.required' => 'Aspek harus diisi',
            'nama_aspek.array' => 'Aspek harus berupa array',
            'nama_aspek.min' => 'Minimal 1 aspek',
            'nama_aspek.*.required' => 'Aspek harus diisi',
            'nama_aspek.*.string' => 'Aspek harus berupa string',
            'nama_aspek.*.max' => 'Aspek maksimal 255 karakter',
        ]);


        $domain = Domain::create([
            'formulir_id' => $formulir->id,
            'nama_domain' => $request->nama_domain,
        ]);


        foreach ($request->nama_aspek as $aspek) {
            $domain->aspek()->create([
                'domain_id' => $domain->id,
                'nama_aspek' => $aspek,
            ]);
        }


        return redirect()->route('formulir.domain.index',['formulir' => $formulir->id])->with('success', 'Domain berhasil ditambahkan');
        // dd($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(Formulir $formulir,Domain $domain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulir $formulir,Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Formulir $formulir,Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulir $formulir,Domain $domain)
    {
        //
    }
}
