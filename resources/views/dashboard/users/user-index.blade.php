@extends('dashboard.layout')
@section('title', 'User')
@section('content')
    <div class="card p-8">

        <div class="flex justify-between mb-4">
            <h4 class="h4">User</h4>


            <a href="{{ route('user.create') }}"
                class="py-3 px-8 bg-blue-600 rounded shadow text-white hover:text-blue-200 hover:bg-gray-800 transform duration-100 ease-in-out">Tambah
                User</a>

        </div>

        <hr class="my-4 border-t-2 border-gray-300">

        <div class="mb-4 flex space-x-4">
            <div class="relative w-full">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchUser"
                        placeholder="Cari user (nama, email, role)..."
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span id="clearSearchIcon" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer hover:text-red-500 hidden">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </div>
        </div>

        <div id="noUserFound" class="hidden text-center py-10 text-gray-600">
            Tidak ada user yang cocok dengan pencarian
        </div>

        <table class="table-auto table-bordered w-full ">
            <thead>
                <tr class="bg-blue-200 border-2">
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Tanggal Dibuat</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="user-row border border-1">
                        <td class="px-4 py-2 user-name">{{ $user->name }}</td>
                        <td class="px-4 py-2 user-email">{{ $user->email }}</td>
                        <td class="px-4 py-2 user-role">
                            @if ($user->role == 'opd')
                                <button class="px-2 py-1 bg-yellow-600 text-white rounded">OPD</button>
                            @elseif ($user->role == 'admin')
                                <button class="px-2 py-1 bg-blue-500 text-white rounded">Admin</button>
                            @else
                                <button class="px-2 py-1 bg-green-500 text-white rounded">Walidata</button>
                            @endif
                        </td>
                        <td class="px-4 py-2 user-created-at">
                            {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('user.edit', $user->id) }}"
                                    class="text-green-600 hover:text-green-800 border rounded-md p-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800 border rounded-md p-2 deleteBtn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                <a href="{{ route('user.show', $user->id) }}"
                                    class="text-gray-800 hover:text-gray-600 border rounded-md px-2 py-1">
                                    <i class="fad fa-eye text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        // Live Search
        const searchInput = $('#searchUser');
        const clearSearchIcon = $('#clearSearchIcon');
        const noUserFound = $('#noUserFound');

        // Fungsi untuk melakukan pencarian
        function performSearch() {
            const searchTerm = searchInput.val().toLowerCase().trim();
            let visibleItems = 0;

            $('.user-row').each(function() {
                const name = $(this).find('.user-name').text().toLowerCase();
                const email = $(this).find('.user-email').text().toLowerCase();
                const role = $(this).find('.user-role').text().toLowerCase();
                const createdAt = $(this).find('.user-created-at').text().toLowerCase();

                if (name.includes(searchTerm) ||
                    email.includes(searchTerm) ||
                    role.includes(searchTerm) ||
                    createdAt.includes(searchTerm)) {
                    $(this).show();
                    visibleItems++;
                } else {
                    $(this).hide();
                }
            });

            // Tampilkan/sembunyikan pesan "Tidak ada user"
            if (visibleItems === 0) {
                noUserFound.removeClass('hidden');
            } else {
                noUserFound.addClass('hidden');
            }

            // Tampilkan/sembunyikan ikon clear
            if (searchTerm) {
                clearSearchIcon.removeClass('hidden');
            } else {
                clearSearchIcon.addClass('hidden');
            }
        }

        // Jalankan pencarian saat mengetik
        searchInput.on('input', performSearch);

        // Aksi clear search
        clearSearchIcon.on('click', function() {
            searchInput.val('');
            $('.user-row').show();
            noUserFound.addClass('hidden');
            clearSearchIcon.addClass('hidden');
        });

        // Konfirmasi Hapus User
        $('.deleteBtn').click(function(e) {
            e.preventDefault(); // Mencegah submit form langsung

            const form = $(this).closest('form');

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
                    form.submit(); // Submit form jika dikonfirmasi
                }
            });
        });
    });
    </script>
@endpush
