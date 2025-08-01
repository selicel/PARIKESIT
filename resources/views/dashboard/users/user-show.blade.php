@extends('dashboard.layout')
@section('content')
    <div class="card mt-6 p-8">
        <h4 class="h4 mb-4">Detail User</h4>

        <div class="flex flex-col gap my-3">
            <label class="font-semibold">Nama</label>
            <input type="text"
                class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                value="{{ $user->name }}" readonly>

        </div>

        <div class="flex flex-col gap my-3">
            <label class="font-semibold">Email</label>
            <input type="email"
                class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                value="{{ $user->email }}" readonly>

        </div>

        <div class="flex flex-col gap my-3">
            <label class="font-semibold">Alamat</label>
            <input type="text"
                class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                value="{{ $user->alamat }}" readonly>

        </div>

        <div class="flex flex-col gap my-3">
            <label class="font-semibold">Nomor Telepon</label>
            <input type="text"
                class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                value="{{ $user->nomor_telepon }}" readonly>

        </div>
        <div class="flex flex-col gap my-3">
            <label class="font-semibold">Role</label>
               <input type="text"
                class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                value="{{ $user->role }}" readonly>
        </div>

        <div class="flex gap-2 mt-5">
            <a href="{{ route('user.index') }}"
                class="p-2 px-8 bg-gray-600 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md">
                Kembali</a>
        </div>

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
