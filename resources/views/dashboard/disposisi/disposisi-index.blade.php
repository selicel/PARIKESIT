    @extends('dashboard.layout')
    @section('content')
        <div class="card p-8">

            <div class="flex justify-between mb-4">
                <h4 class="h4">Penilaian Selesai</h4>



            </div>



            @foreach ($penilaianSelesai as $selesai)
                <div class="bg-white rounded-lg shadow-md p-6 space-y-4 my-3 border border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-1">{{ $selesai->nama_formulir }}
                            </h2>
                            {{-- <div class="flex flex-wrap gap-2">
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">Aktif</span>
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-semibold">Tinggi</span>
                        </div> --}}
                            <p class="text-sm text-gray-600 mt-2">
                                Formulir untuk evaluasi penerapan sistem statistik sektoral pada semester pertama tahun
                                2025.
                                Mencakup 5 domain dengan 19 aspek penilaian.
                            </p>
                            <div class="text-xs text-gray-500 mt-1 space-x-2">
                                <span class="inline-block"><i class="fas fa-tag mr-1"></i>Penilaian Mandiri</span>
                                <span class="inline-block"><i class="fas fa-user-shield mr-1"></i>Admin BPS</span>
                                <span class="inline-block"><i class="fas fa-calendar-alt mr-1"></i>Deadline:
                                    31/3/2025</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            {{-- <button
                            class="bg-gray-100 hover:bg-gray-200 text-sm px-3 py-1.5 rounded text-gray-700 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Edit
                        </button> --}}
                            <a href="{{route('disposisi.penilaian.tersedia.detail',['formulir' => $selesai->nama_formulir] )}}"
                                class="bg-blue-600 hover:bg-blue-700 text-sm px-3 py-2 rounded text-white flex items-center gap-1">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </div>
                    </div>

                    <!-- Stats -->
                    {{-- <div class="grid grid-cols-4 xl:grid-cols-4 lg:grid-cols-4 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <!-- Respon -->
                        <div class="flex items-center space-x-2">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Respon</div>
                                <div class="font-bold text-sm text-gray-700">
                                    {{ $selesai->formulir_penilaian_diposisi->unique('assigned_profile_id')->count() }} / {{$countMaxPeserta}}
                                </div>
                            </div>
                        </div>

                        <!-- Tingkat Selesai -->
                        <div class="flex items-center space-x-2">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Tingkat Selesai</div>
                                <div class="font-bold text-sm text-red-600">57.7%</div>
                            </div>
                        </div>

                        <!-- Terakhir Diperbarui -->
                        <div class="flex items-center space-x-2">
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Terakhir Diperbarui</div>
                                <div class="font-bold text-sm text-gray-700">
                                    @php
                                        $lastUpdated = $selesai->formulir_penilaian_diposisi->max('created_at');
                                    @endphp

                                {{\Carbon\Carbon::parse($lastUpdated)->format('D-m-Y H:i:s')}}
                                </div>
                            </div>
                        </div>

                        <!-- Ditugaskan Kepada -->
                        <div class="flex items-center space-x-2">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Ditugaskan Kepada</div>
                                <div class="font-bold text-sm text-gray-700">Koordinator Daerah +2 lainnya</div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-700 font-semibold">Progress</span>
                            <span class="text-sm text-gray-700 font-semibold">57.7%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-red-500 h-3 rounded-full" style="width: 57.7%"></div>
                        </div>
                    </div> --}}
                </div>
            @endforeach



            {{-- <table class="table-auto table-bordered w-full ">
                <thead>
                    <tr class="bg-blue-200 border-2">
                        <th class="px-4 py-2 text-left">Nama Formulir</th>
                        <th class="px-4 py-2 text-left">Yang melakukan</th>
                        <th class="px-4 py-2 text-left">Admin dituju</th>
                        <th class="px-4 py-2 text-left">Nama yang mengerjakan</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Completed</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disposisis as $disposisi)
                        <tr class="border border-1">
                            <td class="px-4 py-2">{{ $disposisi->formulir->nama_formulir }}</td>
                            <td class="px-4 py-2">{{ $disposisi->fromProfile->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $disposisi->toProfile->name ?? '-'}}</td>
                            <td class="px-4 py-2">{{ $disposisi->assignedProfile->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($disposisi->status == 'proses')
                                    <button class="px-2 py-1 bg-yellow-600 text-white rounded">Proses</button>
                                @elseif ($disposisi->status == 'selesai')
                                    <button class="px-2 py-1 bg-green-500 text-white rounded">Selesai</button>
                                @else
                                    <button class="px-2 py-1 bg-red-600 text-white rounded">Batal</button>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ $disposisi->is_completed ? 'Ya' : 'Tidak' }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}


        </div>
    @endsection

    @push('scripts')
        <script>
            $('.deleteBtn').click(function(e) {

                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Anda tidak dapat mengembalikan user ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus user ini!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.preventDefault();
                        $('#form_delete').submit();

                    }
                })
            });
        </script>
    @endpush
