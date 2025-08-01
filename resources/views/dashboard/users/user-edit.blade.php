@extends('dashboard.layout')
@section('content')
    <div class="card mt-6 p-8">
        <h4 class="h4 mb-4">Edit Formulir</h4>


        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="flex flex-col gap my-3">
                <label class="font-semibold">Nama</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="name" value="{{ $user->name }}" required>

            </div>

            <div class="flex flex-col gap my-3">
                <label class="font-semibold">Email</label>
                <input type="email"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="email" value="{{ $user->email }}" required>

            </div>

            <div class="flex flex-col gap my-3">
                <label class="font-semibold">Alamat</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="address" value="{{ $user->alamat }}" required>

            </div>

            <div class="flex flex-col gap my-3">
                <label class="font-semibold">Nomor Telepon</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nomor_telepon" value="{{ $user->nomor_telepon }}" required>

            </div>
            <div class="flex flex-col gap my-3">
                <label class="font-semibold">Role</label>
                <select name="role"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="opd" {{ $user->role == 'opd' ? 'selected' : '' }}>OPD</option>
                    <option value="walidata" {{ $user->role == 'walidata' ? 'selected' : '' }}>Walidata</option>
                </select>
            </div>


            <div class="flex gap-2">
                <button type="submit"
                    class="mt-5 p-2 px-8 bg-blue-500 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md">Perbarui</button>
                <a href="{{ route('user.index') }}"
                    class="mt-5 p-2 px-8 bg-gray-600 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md">
                    Kembali</a>
            </div>

        </form>


    </div>
@endsection



{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            $('#form_create').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            swal("Berhasil", response.message, "success");
                            window.location.href = "{{ route('formulir.index') }}";
                        } else {
                            swal("Gagal", response.message, "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Gagal", xhr.responseText, "error");
                    }
                });
            });
        });
    </script>
@endpush --}}
