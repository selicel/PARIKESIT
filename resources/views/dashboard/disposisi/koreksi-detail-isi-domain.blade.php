@extends('dashboard.layout')
@section('title', 'Domain Penilaian Kegiatan : ' . $formulir->nama_formulir)
@section('content')
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h4 class="text-xl font-semibold text-gray-700">KOREKSI PENILAIAN DARI DOMAIN</h4>
        </div>
        <nav class="bg-white p-4 border-2 rounded-md w-full mb-4">
            <ol class="list-reset flex text-grey-dark">

                <li><a href="{{ route('disposisi.penilaian.tersedia') }}" class="text-blue-600 hover:underline">Koreksi
                        Penilaian</a></li>
                <li><span class="mx-2">&gt;</span></li>
                <li class="text-gray-700"> <a
                        href="{{ route('disposisi.penilaian.tersedia.detail', [$formulir->nama_formulir]) }}"
                        class="text-blue-600 hover:underline">Kegiatan Selesai : {{ $formulir->nama_formulir }} </a> </li>
                <li><span class="mx-2">&gt;</span></li>
                <li class="text-gray-700">Domain Kegiatan : {{ $domain->nama_domain }}</li>
            </ol>
        </nav>
        {{-- Judul --}}

        <div id="accordion-color" data-accordion="collapse"
            data-active-classes="bg-indigo-500 text-gray-100 rounded dark:bg-gray-800 dark:text-white"
            data-inactive-classes="text-white">
            <h2 id="accordion-color-heading-1">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-medium rtl:text-right border-2 bg-black text-white border-indigo-100 border-b-0 rounded-t-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-gray-100 gap-3"
                    data-accordion-target="#accordion-color-body-1" aria-expanded="false"
                    aria-controls="accordion-color-body-1">
                    <span>Data Identitas Penilai</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-1" class="hidden bg-white" aria-labelledby="accordion-color-heading-1">
                <div class="p-5 border border-gray-200  dark:border-gray-700 dark:bg-gray-900">
                    <table class="w-full border-2">
                        <tbody>
                            <tr>
                                <td
                                    class="px-3 py-1 border-t border-b text-gray-100 border-gray-300 bg-gray-900 dark:border-gray-600 w-1/6">
                                    Nama OPD</td>
                                <td class="px-3 py-1 border-t border-b border-gray-300 dark:border-gray-600 text-uppercase">
                                    {{ $opd->name }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="px-3 py-1 border-t border-b text-gray-100 border-gray-300 bg-gray-900 dark:border-gray-600 w-1/6">
                                    Jabatan</td>
                                <td class="px-3 py-1 border-t border-b border-gray-300 dark:border-gray-600 text-uppercase">
                                    {{ $opd->role ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="px-3 py-1 border-t border-b text-gray-100 border-gray-300 bg-gray-900 dark:border-gray-600 w-1/6">
                                    Kontak</td>
                                <td class="px-3 py-1 border-t border-b border-gray-300 dark:border-gray-600 text-uppercase">
                                    {{ $opd->nomor_telepon ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>


        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
            @foreach ($domain->aspek as $aspek)
                <div
                    class="bg-white border border-gray-300 shadow-lg rounded-md hover:bg-gray-100 transition ease-in-out duration-100">

                    <div class="h-4 bg-gray-800 rounded-t-md"></div>
                    <div class="px-8 pt-6 pb-8">
                        <div class="flex items-center justify-between">
                            <h5 class="text-md font-bold text-blue-700">Koreksi Aspek {{ $aspek->nama_aspek }}</h5>


                            <p class="text-gray-800 text-md">
                                {{ \Carbon\Carbon::parse($aspek->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </p>



                        </div>
                        <div class="flex bg-blue-100 rounded-md p-4 mt-4 shadow">




                            <div class="relative overflow-x-auto w-full">

                                <table class="w-full">
                                    <thead class="bg-gray-100 w-100">
                                        <tr>
                                            <th scope="col"
                                                class="w-1/2 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider break-all">
                                                Indikator</th>
                                            <th scope="col"
                                                class="w-1/5 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Bobot</th>

                                            <th scope="col"
                                                class="w-1/5 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Nilai Diisi</th>
                                            <th scope="col"
                                                class="w-1/5 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Nilai Koreksi</th>
                                            <th scope="col"
                                                class="w-1/5 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Nama Pengoreksi</th>
                                            <th scope="col"
                                                class="w-1/5 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="w-1/3 px-6 py-3 text-left text-xs leading-4 font-bold text-gray-700 uppercase tracking-wider">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($aspek->indikator as $indikator)
                                            @php

                                                $domainDibuka = $indikator->aspek->domain->formulirs->firstWhere(
                                                    'id',
                                                    $formulir->id,
                                                );
                                                $penilaianUser = $indikator->penilaian
                                                    ->where('user_id', $opd->id)
                                                    ->where('formulir_id', $domainDibuka->id)
                                                    ->first();
                                            @endphp


                                            <tr class="{{ $penilaianUser != null ? 'bg-green-300' : '' }}">
                                                <td class="px-6 py-4 border-b border-gray-200 break-all truncate max-w-20"
                                                    title="{{ $indikator->nama_indikator }}">
                                                    <p class="text-gray-800 font-semibold text-md ">
                                                        {{ Str::of($indikator->nama_indikator)->limit(50) }}
                                                    </p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <p class="text-gray-800 font-bold">{{ $indikator->bobot_indikator }}
                                                    </p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">


                                                    @if ($penilaianUser && $domainDibuka->id == $formulir->id)
                                                        <span class="text-black rounded text-md font-bold">
                                                            {{ $penilaianUser->nilai }}
                                                        </span>
                                                    @else
                                                        <span class="text-red-500">- </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <span class="text-black rounded text-md font-bold">
                                                        {{ $penilaianUser->nilai_koreksi ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>

                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    @if ($penilaianUser)
                                                        <span
                                                            class="bg-blue-500 p-3 text-white rounded text-xs font-semibold">Sudah
                                                            Diisi</span>
                                                    @else
                                                        <span
                                                            class="bg-red-500 p-3 text-white rounded text-xs font-semibold">Belum
                                                            diisi</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <a href="{{ route('disposisi.koreksi.indikator.beri-koreksi', [$opd->name, $formulir->nama_formulir, $domain->nama_domain, $aspek->nama_aspek, $indikator->nama_indikator]) }}"
                                                        class="text-blue-500 hover:text-blue-700 font-normal text-sm">
                                                        <i
                                                            class="fad fa-external-link-alt text-md mr-1 bg-indigo-500 text-white p-4 rounded ml-2"></i>

                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                    {{-- <div class="w-full">
                        <a href="{{route('formulir.sesiPenilaian',[$formulir, $domain])}}" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded w-full transition mt-4">Mulai Penilaian</a>
                    </div> --}}


                </div>
            @endforeach
        </div>


    </div>
@endsection

@push('scripts')
@endpush
