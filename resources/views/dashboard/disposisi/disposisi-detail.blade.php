    @extends('dashboard.layout')
    @section('title', 'Detail Kegiatan')

    @section('content')
        <nav class="bg-white p-4 border-2 rounded-md w-full mb-4">
            <ol class="list-reset flex text-grey-dark">

                <li><a href="{{ route('disposisi.penilaian.tersedia') }}" class="text-blue-600 hover:underline">Koreksi Penilaian</a></li>
                <li><span class="mx-2">&gt;</span></li>
                <li class="text-gray-700"> <a href="{{ route('disposisi.penilaian.tersedia.detail', [$formulir->nama_formulir]) }}"
                        class="text-blue-600 hover:underline">Kegiatan Selesai : {{ $formulir->nama_formulir }} </a> </li>
                <li><span class="mx-2">&gt;</span></li>


            </ol>
        </nav>
        <div>
            <div class="bg-white border border-indigo-400 shadow-sm rounded-lg">
                <!-- Header -->
                <div class="p-6 pb-4 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                                Detail Kegiatan {{ $formulir->nama_formulir ?? 'perbaru' }}
                            </h1>
                            {{-- <p class="text-gray-600">
                                Berikut adalah daftar OPD yang sudah melakukan penilaian
                            </p> --}}
                        </div>
                        {{-- <button
                            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Ekspor Data
                        </button> --}}
                    </div>

                    <!-- Progress Summary -->
                    @php
                        $totalParticipants = 12;
                        $completedParticipants = 6;
                        $progressPercentage = ($completedParticipants / $totalParticipants) * 100;
                    @endphp

                    {{-- <div class="mt-6 grid grid-cols-3 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Total Peserta</p>
                                    <p class="text-2xl font-bold text-blue-800">{{ $totalParticipants }}</p>
                                </div>
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Sudah Selesai</p>
                                    <p class="text-2xl font-bold text-green-800">{{ $completedParticipants }}</p>
                                </div>
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-purple-600 font-medium">Progress</p>
                                    <p class="text-2xl font-bold text-purple-800">
                                        {{ number_format($progressPercentage, 1) }}%
                                    </p>
                                </div>
                                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress Keseluruhan</span>
                            <span>{{ $completedParticipants }} dari {{ $totalParticipants }} peserta</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div> --}}
                </div>

                <!-- Content -->
                <div class="p-6">


                    <!-- Accordion OPD List -->


                    @foreach ($opdsMenilai as $index => $opd)
                        <div class="my-4">
                            <div id="accordion-collapse-{{ $index }}" data-accordion="collapse" class="shadow border-indigo-400">
                                <h2 id="accordion-collapse-heading-{{ $index }}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right border border-b-0 border-blue-200 rounded-t-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-blue-700 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-800 gap-3"
                                        data-accordion-target="#accordion-collapse-body-{{ $index }}"
                                        aria-expanded="false" aria-controls="accordion-collapse-body-{{ $index }}">
                                        <span>
                                            <i class="fas fa-user  mr-5"></i>
                                            <b>{{ $opd['opd']->name }}</b>
                                        </span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-{{ $index }}" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-{{ $index }}">
                                    <div
                                        class="p-5 border border-b-0 border-gray-200 text-black bg-blue-100 dark:border-gray-700 dark:bg-gray-900">

                                        <div class="mt-6">
                                            <div class="font-semibold text-gray-700 mb-2">Nilai Indeks Pembangunan Statistik
                                                {{ $opd['opd']->name }}</div>
                                            <div class="overflow-x-auto">
                                                <table
                                                    class="min-w-full border text-sm text-left text-gray-700 bg-white shadow rounded">
                                                    <thead class="bg-indigo-500 text-white">
                                                        <tr>
                                                            <th class="py-2 px-4">Domain</th>
                                                            <th class="py-2 px-4">Indikator</th>
                                                            {{-- <th class="py-2 px-4">Aspek</th> --}}
                                                            {{-- <th class="py-2 px-4">Informasi</th> --}}
                                                            <th class="py-2 px-4">Aksi</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($opd['domains'] as $domain)
                                                            <tr>
                                                                <td class="py-2 px-4 font-semibold">
                                                                    {{ $domain->nama_domain }}</td>
                                                                <td class="py-2 px-4">{{ $domain->aspek->count() }}</td>
                                                                <td class="py-4 px-4 font-bold text-blue-700">
                                                                    <a href="{{ route('disposisi.koreksi.isi-domain', [$opd['opd']->name, $formulir->nama_formulir, $domain->nama_domain]) }}"
                                                                        class="text-white hover:underline bg-gray-900 p-2 rounded">
                                                                        <i class="fas fa-pencil-alt mr-2"></i> Menuju
                                                                        Koreksi
                                                                    </a>
                                                                    {{-- {{ $dataPersentasePerDomain[$domain->id]['persentase_domain'] ?? '0.00' }} --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>
                                </div>



                            </div>
                        </div>
                    @endforeach



                </div>
            </div>
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
