@extends('dashboard.layout')
@section('title','Tambah User')
@section('content')
    <div class="card mt-6 p-8">
        <h4 class="h4 mb-4">Tambah User</h4>


        <form action="{{ route('user.store') }}" method="POST" id="form_create">

            @csrf
            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Nama</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="name" value="{{ old('name') }}" required>
            </div>

            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Email</label>
                <input type="email"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="email" value="{{ old('email') }}" required>
            </div>

            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Password</label>
                <input type="password"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="password" required>
            </div>

            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Role</label>
                <select name="role"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="opd" {{ old('role') == 'opd' ? 'selected' : '' }}>OPD</option>
                    <option value="walidata" {{ old('role') == 'walidata' ? 'selected' : '' }}>Walidata</option>
                </select>
            </div>

            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Alamat</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="alamat" value="{{ old('alamat') }}" required>
            </div>

            <div class="flex flex-col gap mb-3">
                <label class="font-semibold">Nomor Telepon</label>
                <input type="text"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
            </div>


            <button
                class="mt-5 p-2 px-8 bg-blue-500 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md">Tambahkan</button>
        </form>


    </div>
@endsection



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
