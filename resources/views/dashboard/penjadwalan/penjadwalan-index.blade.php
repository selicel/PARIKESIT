@extends('dashboard.layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Agenda Pembinaan</h1>
            <p class="text-gray-600">Jadwal dan informasi kegiatan pembinaan statistik sektoral</p>
        </div>

        @if (Auth::user()->role == 'admin')
            <a href="{{ route('penjadwalan.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">
                + Tambah Agenda
            </a>
        @endif
    </div>

    <div class="mb-6">
        <ul class="flex space-x-4">
            <li>
                <button class="tab-button font-semibold text-sm py-2 px-4 rounded bg-blue-100 text-blue-800 active">Akan
                    Datang</button>
            </li>
            <li>
                <button class="tab-button font-semibold text-sm py-2 px-4 rounded hover:bg-gray-200">Sedang
                    Berlangsung</button>
            </li>
            <li>
                <button class="tab-button font-semibold text-sm py-2 px-4 rounded hover:bg-gray-200">Selesai</button>
            </li>
            <li>
                <button class="tab-button font-semibold text-sm py-2 px-4 rounded hover:bg-gray-200">Semua</button>
            </li>
        </ul>
    </div>

    <div class="grid grid-cols-3 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-6">
        @foreach ($penjadwalans as $penjadwalan)
            <div class="border rounded-lg shadow p-6 bg-white">

                <div class="flex xl:flex md:flex-none justify-between">
                    <h2 class="text-lg font-semibold mb-2">{{ $penjadwalan->judul_jadwal }}</h2>


                    @if (Auth::user()->role == 'admin')
                        <div class="flex gap-2">
                            <a href="{{ route('penjadwalan.edit', $penjadwalan->id) }}"
                                class="text-blue-600 hover:text-blue-800 border rounded-md p-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('penjadwalan.destroy', $penjadwalan->id) }}" id="form_delete"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-800 border rounded-md p-2 deleteBtn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
                <div class="text-sm text-gray-500 flex items-center mb-2">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v1H3V6a2 2 0 012-2h1V3a1 1 0 011-1zM3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    {{ \Carbon\Carbon::parse($penjadwalan->tanggal_jadwal)->format('d M Y') }}
                </div>

                @php
                    $now = \Carbon\Carbon::now();
                    $jadwal = \Carbon\Carbon::parse($penjadwalan->tanggal_jadwal);
                    $style = 'bg-yellow-200 text-yellow-800';
                    if ($jadwal->isFuture()) {
                        $style = 'bg-blue-200 text-blue-800';
                    } elseif ($jadwal->isToday()) {
                        $style = 'bg-green-200 text-green-800';
                    } elseif ($jadwal->isPast()) {
                        $style = 'bg-red-200 text-red-800';
                    }
                @endphp

                <span class="inline-block {{ $style }} text-xs px-3 py-1 rounded mb-3">
                    {{ $jadwal->isFuture() ? 'Akan Datang' : ($jadwal->isToday() ? 'Berlangsung Hari Ini' : 'Terlewat') }}
                </span>
                <p class="text-sm text-gray-700 mb-3">{{ Str::limit($penjadwalan->keterangan_jadwal, 100) }}</p>
                <div class="text-sm text-gray-600 mb-1"><strong>Peserta:</strong>
                    {{ $penjadwalan->peserta_pembinaan->count() ?? 'N/A' }} orang</div>
                <div class="text-sm text-gray-600 mb-1"><strong>Lokasi:</strong> {{ $penjadwalan->lokasi }}</div>
                <div class="text-sm text-gray-600 mb-4"><strong>Penyelenggara:</strong>
                    {{ $penjadwalan->penyelenggara ?? 'BPS' }}</div>
                <div class="flex space-x-2">
                    {{-- <a href="#" class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-gray-600">Materi</a> --}}
                    <a href="{{ route('penjadwalan.show', $penjadwalan->id) }}"
                        class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-800">Detail</a>

                    <a href="{{ route('penjadwalan.show', $penjadwalan->id) }}"
                        class="border border-green-600 text-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-500 hover:text-white">Penugasan</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection


@push('scripts')
    <script>
        $('.deleteBtn').click(function(e) {

            var id = $(this).data('id');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda tidak dapat mengembalikan penjadwalan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus penjadwalan ini!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    $('#form_delete').submit();
                }
            })
        });
    </script>
@endpush
