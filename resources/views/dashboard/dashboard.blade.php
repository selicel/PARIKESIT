@extends('dashboard.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 gap-6">
            {{-- Welcome Card --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Selamat Datang</h2>
                        <p class="text-gray-600">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span class="text-sm text-gray-700">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm text-gray-700">{{ auth()->user()->nomor_telepon }}</span>
                    </div>
                </div>
            </div>

            {{-- Pintasan Card --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pintasan</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @if (auth()->user()->role == 'opd')
                        <a href="{{ route('penilaian.index') }}"
                            class="bg-blue-100 border-2 border-blue-200 rounded-2xl p-6 hover:bg-blue-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-tasks text-blue-600 text-4xl"></i>
                            <span class="text-base font-bold text-blue-900">Penilaian Mandiri</span>
                            <p class="text-xs text-blue-700 opacity-75">Lakukan penilaian mandiri Anda</p>
                        </a>
                        <a href="{{ route('pembinaan.index') }}"
                            class="bg-green-100 border-2 border-green-200 rounded-2xl p-6 hover:bg-green-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-whistle text-green-600 text-4xl"></i>
                            <span class="text-base font-bold text-green-900">Pembinaan</span>
                            <p class="text-xs text-green-700 opacity-75">Kelola program pembinaan</p>
                        </a>
                    @elseif (auth()->user()->role == 'walidata')
                        <a href="{{ route('disposisi.penilaian.tersedia') }}"
                            class="bg-yellow-100 border-2 border-yellow-200 rounded-2xl p-6 hover:bg-yellow-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-check-circle text-yellow-600 text-4xl"></i>
                            <span class="text-base font-bold text-yellow-900">Penilaian Selesai</span>
                            <p class="text-xs text-yellow-700 opacity-75">Lihat penilaian yang telah diselesaikan</p>
                        </a>
                        <a href="{{ route('pembinaan.index') }}"
                            class="bg-green-100 border-2 border-green-200 rounded-2xl p-6 hover:bg-green-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-whistle text-green-600 text-4xl"></i>
                            <span class="text-base font-bold text-green-900">Pembinaan</span>
                            <p class="text-xs text-green-700 opacity-75">Kelola program pembinaan</p>
                        </a>
                    @elseif (auth()->user()->role == 'admin')
                        <a href="{{ route('disposisi.penilaian.tersedia') }}"
                            class="bg-yellow-100 border-2 border-yellow-200 rounded-2xl p-6 hover:bg-yellow-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-check-circle text-yellow-600 text-4xl"></i>
                            <span class="text-base font-bold text-yellow-900">Penilaian Selesai</span>
                            <p class="text-xs text-yellow-700 opacity-75">Lihat penilaian yang telah diselesaikan</p>
                        </a>
                        <a href="{{ route('dokumentasi.index') }}"
                            class="bg-purple-100 border-2 border-purple-200 rounded-2xl p-6 hover:bg-purple-200 transition transform hover:scale-105 flex flex-col items-center justify-center space-y-4 text-center shadow-md">
                            <i class="fad fa-camera text-purple-600 text-4xl"></i>
                            <span class="text-base font-bold text-purple-900">Dokumentasi</span>
                            <p class="text-xs text-purple-700 opacity-75">Kelola dokumentasi kegiatan</p>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Generate Penilaian Card --}}
            {{-- <div class="mt-8 bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <div class="max-w-xl mx-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Generate Penilaian</h2>
                    <form action="{{ route('dashboard.generate-penilaian') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih User</label>
                            <select name="user_id" id="user_id" required
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="" selected>-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="formulir_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kegiatan Penilaian</label>
                            <select name="formulir_id" id="formulir_id" required
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="" selected>-- Pilih Kegiatan Penilaian --</option>
                                @foreach ($kegiatanPenilaian as $penilaian)
                                    <option value="{{ $penilaian->id }}">{{ $penilaian->nama_formulir }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <a href="{{ url()->previous() }}"
                                class="bg-gray-200 text-gray-800 px-6 py-2.5 rounded-lg hover:bg-gray-300 transition">Kembali</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">Generate</button>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
@push('scripts')
@endpush
