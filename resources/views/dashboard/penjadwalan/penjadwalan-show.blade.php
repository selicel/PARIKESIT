@extends('dashboard.layout')
@section('content')
    <div class="card mt-6 p-8 border border-indigo-400">
        <h4 class="h4 mb-4">Detail Penjadwalan</h4>
        <hr>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Nama Pemateri</label>
                <p class="text-gray-800 ">{{ $penjadwalan->nama_pemateri }}</p>
            </div>
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Judul Jadwal</label>
                <p class="text-gray-800 ">{{ $penjadwalan->judul_jadwal }}</p>
            </div>
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Tanggal Jadwal</label>
                <p class="text-gray-800 ">{{ $penjadwalan->tanggal_jadwal }}</p>
            </div>
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Waktu Mulai</label>
                <p class="text-gray-800 ">{{ $penjadwalan->waktu_mulai }}</p>
            </div>
            {{-- <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Pemateri Jadwal</label>
                <p class="p-2 rounded border">{{ $penjadwalan->pemateri_jadwal }}</p>
            </div> --}}
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Keterangan Jadwal</label>
                <p class="text-gray-800 ">{{ $penjadwalan->keterangan_jadwal }}</p>
            </div>
            <div class="flex flex-col gap my-3">
                <label class="font-semibold mb-2 block">Lokasi</label>
                <p class="text-gray-800 ">{{ $penjadwalan->lokasi }}</p>
            </div>
        </div>



    </div>

    <div class="card mt-6 p-8 border border-indigo-400">
        <h4 class="h4 mb-4">Peserta</h4>
        <hr>
        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Nomor Telefon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjadwalan->peserta_pembinaan as $index => $peserta)
                    <tr class="{{$index % 2 == 0 ? 'bg-gray-200' : 'bg-indigo-100'}}">
                        <td class="border px-4 py-2">{{ $peserta->peserta->name }}</td>
                        <td class="border px-4 py-2">{{ $peserta->peserta->nomor_telepon }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


