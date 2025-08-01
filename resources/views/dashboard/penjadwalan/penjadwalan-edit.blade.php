@extends('dashboard.layout')
@section('content')
    <form action="{{ route('penjadwalan.update', $penjadwalan) }}" method="POST" id="form_create">
        @method('PUT')
        @csrf
        <div class="card px-8 py-4 pb-8">
            <div class="mb-4 px-0">
                <h4 class="h4 mb-2">Edit Penjadwalan</h4>
                <hr>
            </div>
            <div class="grid grid-cols-2 gap-4">

                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Nama Pemateri</label>
                    <input type="text" placeholder="Nama Pemateri"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200 w-full"
                        name="nama_pemateri" value="{{ old('nama_pemateri') ?? $penjadwalan->nama_pemateri }}" required>
                </div>
                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Judul Jadwal</label>
                    <input type="text" placeholder="Judul Jadwal"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="judul_jadwal" value="{{ old('judul_jadwal') ?? $penjadwalan->judul_jadwal }}" required>
                </div>
                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Tanggal Jadwal</label>
                    <input type="date" placeholder="Tanggal Jadwal"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="tanggal_jadwal" value="{{ old('tanggal_jadwal') ?? $penjadwalan->tanggal_jadwal }}" required>
                </div>
                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Waktu Mulai</label>
                    <input type="time" placeholder="Waktu Mulai"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="waktu_mulai" value="{{ old('waktu_mulai') ?? $penjadwalan->waktu_mulai }}" required>
                </div>
                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Keterangan Jadwal</label>
                    <textarea placeholder="Keterangan Jadwal"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="keterangan_jadwal" required>{{ old('keterangan_jadwal') ?? $penjadwalan->keterangan_jadwal }}</textarea>
                </div>
                {{-- <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Pemateri Jadwal</label>
                    <input type="text" placeholder="Pemateri Jadwal"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="pemateri_jadwal" value="{{ old('pemateri_jadwal') ?? $penjadwalan->pemateri_jadwal }}" required>
                </div> --}}
                <div class="flex flex-col gap my-3">
                    <label class="font-semibold mb-2">Lokasi</label>
                    <textarea placeholder="Lokasi"
                        class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                        name="lokasi" required>{{ old('lokasi') ?? $penjadwalan->lokasi }}</textarea>
                </div>
            </div>
        </div>


        <div class="card px-8 py-4 pb-8 mb-8 border border-indigo-400">
            <div class="mb-4 px-0">
                <h4 class="h4 mb-2">Tambahkan Peserta</h4>
                <hr>
            </div>

            <div class="flex justify-start">
                <button id="checkAll" type="button"
                    class="p-2 px-4 bg-green-500 text-white hover:bg-green-900 hover:text-white ease-in-out transition duration-100 border rounded-md w-40 flex items-center">
                    <i class="fad fa-check-double mr-2"></i> Check All</button>
                <button id="uncheckAll" type="button"
                    class="p-2 px-4 bg-red-500 text-white hover:bg-red-900 hover:text-white ease-in-out transition duration-100 border rounded-md ml-2 w-40 flex items-center">
                    <i class="fad fa-times-circle mr-2"></i> Uncheck All</button>
            </div>

            <table class="table-auto w-full mt-4">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 w-10">#</th>
                        <th class="border px-4 py-2 w-1/12"></th>
                        <th class="border px-4 py-2 text-left">Nama</th>
                        <th class="border px-4 py-2 text-left">NIM</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="{{ in_array($user->id, $penjadwalan->peserta_pembinaan->pluck('peserta_id')->toArray()) ? 'bg-green-200' : '' }}">
                            <td class="border px-4 py-2 ">{{$loop->iteration}}</td>
                            <td class="border px-4 py-2 ">
                                <input type="checkbox" name="peserta_pembinaan[]" class="bg-green-500 rounded"
                                    {{ in_array($user->id, $penjadwalan->peserta_pembinaan->pluck('peserta_id')->toArray()) ? 'checked' : '' }}
                                    value="{{ $user->id }}">
                            </td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->instansi->nama_instansi ?? 'Instansi Lorem Ipsum' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>






        </div>

        <button
            class="mt-5 p-2 px-8 bg-blue-500 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md"
            type="submit" id="submitPenjadwalanButton">Perbarui</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                $('input[name="peserta_pembinaan[]"]').prop('checked', true).closest('tr').addClass('bg-green-200');
            });

            $('#uncheckAll').click(function() {
                $('input[name="peserta_pembinaan[]"]').prop('checked', false).closest('tr').removeClass(
                    'bg-green-200');
            });

            $('input[name="peserta_pembinaan[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').addClass('bg-green-200');
                } else {
                    $(this).closest('tr').removeClass('bg-green-200');
                }
            });



            $('#submitPenjadwalanButton').click(function(e) {
                if ($('input[name="peserta_pembinaan[]"]:checked').length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tidak ada peserta yang dipilih!',
                    });
                    e.preventDefault();
                }
            });




            $('#profile_select').select2({
                dropdownCssClass: "tailwind-dropdown",
                selectionCssClass: "tailwind-selection"
            });
        });
    </script>
@endpush
