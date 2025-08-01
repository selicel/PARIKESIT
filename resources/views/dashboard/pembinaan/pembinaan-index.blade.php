@extends('dashboard.layout')
@section('title', 'Pembinaan')
@section('content')
    <div class="card p-8">

        <div class="flex justify-between mb-4">
            <h4 class="h4">Pembinaan</h4>


            <div class="">
                <a href="{{ route('pembinaan.create') }}"
                    class="p-2 px-4 bg-blue-500 text-white hover:bg-blue-700 hover:text-white ease-in-out transition duration-100 border rounded-md flex items-center">
                    <i class="fad fa-plus mr-2"></i> Tambah Pembinaan</a>
            </div>
        </div>

        <hr class="my-4 border-t-2 border-gray-300">


        <div class="grid grid-cols-3 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-6">
            @foreach ($pembinaans as $pb)
                <div class="border rounded-lg shadow p-6 bg-white hover:bg-gray-50 transition ease-in-out duration-150">
                    {{-- <i class="fas fa-check-circle text-green-500 mr-2"></i> <span>Domain tersedia</span> --}}
                    {{-- @endif --}}
                    <div class="flex xl:flex md:flex-none justify-between mt-4">
                        <h2 class="text-lg font-semibold mb-2">{{ $pb->judul_pembinaan }}</h2>
                    </div>
                    <div class="text-sm text-gray-500 flex items-center mb-2">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v1H3V6a2 2 0 012-2h1V3a1 1 0 011-1zM3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($pb->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </div>
                    <p class="text-sm text-gray-700 mb-3">
                        @php
                            $countDok = count($pb->file_Pembinaan);
                        @endphp
                        <b>

                            @if ($countDok > 0)
                                File Media Tersedia
                            @else
                                Belum ada File Media
                            @endif
                        </b>

                    </p>
                    <div class="flex space-x-2">
                        <a href="{{ route('pembinaan.show', $pb->id) }}"
                            class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-gray-600">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        $('.deleteBtn').click(function(e) {

            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda tidak dapat mengembalikan formulir ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus formulir ini!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    $('#form_delete').submit();

                }
            })
        });
    </script>
@endpush
