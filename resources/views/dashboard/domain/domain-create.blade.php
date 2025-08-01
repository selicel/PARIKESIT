@extends('dashboard.layout')
@section('content')
    <form action="{{ route('formulir.domain.store', $formulir->id) }}" method="POST" id="form_create">
        @csrf
        <div class="card px-8 py-4 pb-8">
            <div class="mb-4 px-0">

                <h4 class="h4 mb-2">
                    Tambah Domain
                </h4>
                <hr>
            </div>


            <div class="flex flex-col gap">
                <label class="font-semibold mb-2">Nama Domain</label>
                <input type="text" placeholder="Nama Domain"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_domain" required>

            </div>






        </div>


        <div class="card mt-4 px-8 py-4 pb-8">

            <div class="mb-4 px-0">

                <h4 class="h4 mb-2">
                    Tambah Aspek
                </h4>
                <hr>
            </div>

            <div class="flex flex-col gap">
                <label class="font-semibold my-3">Nama Aspek 1</label>
                <input type="text" placeholder="Nama Aspek 1"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_aspek[]" required>
            </div>


            <div class="flex flex-col gap">
                <label class="font-semibold my-3">Nama Aspek 2</label>
                <input type="text" placeholder="Nama Aspek 2"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_aspek[]" required>
            </div>


            <div class="flex flex-col gap">
                <label class="font-semibold my-3">Nama Aspek 3</label>
                <input type="text" placeholder="Nama Aspek 3"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_aspek[]" required>
            </div>


            <div class="flex flex-col gap">
                <label class="font-semibold my-3">Nama Aspek 4</label>
                <input type="text" placeholder="Nama Aspek 4"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_aspek[]" required>
            </div>


            <div class="flex flex-col gap">
                <label class="font-semibold my-3">Nama Aspek 5</label>
                <input type="text" placeholder="Nama Aspek 5"
                    class="p-2 rounded border border-gray-400 shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 focus:bg-gray-200"
                    name="nama_aspek[]" required>
            </div>



            {{-- <button type="button" class="bg-blue-900 mt-4 p-2 px-2 text-sm text-white hover:bg-gray-800 transition ease-in-out duration-100 border rounded-md" id="addAspek">Tambah Aspek</button> --}}


        </div>


        <button
            class="mt-5 p-2 px-8 bg-blue-500 text-white hover:bg-blue-900 hover:text-white ease-in-out transition duration-100 border rounded-md">Tambahkan</button>



    </form>
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

