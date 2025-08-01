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


        <table class="table-auto table-bordered w-full ">
            <thead>
                <tr class="bg-blue-200 border-2">
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Alamat</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Tanggal Dibuat</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border border-1">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->instansi->alamat_instansi ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if ($user->role == 'opd')
                                <button class="px-2 py-1 bg-yellow-600 text-white rounded">OPD</button>
                            @elseif ($user->role == 'admin')
                                <button class="px-2 py-1 bg-blue-500 text-white rounded">Admin</button>
                            @else
                                <button class="px-2 py-1 bg-green-500 text-white rounded">Walidata</button>
                            @endif
                        </td>
                        <td class="px-4 py-2">
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
                    $(this).closest('form').submit();

                }
            })
        });
    </script>
@endpush
