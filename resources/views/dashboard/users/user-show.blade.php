@extends('dashboard.layout')
@section('content')
    <div class="card mt-6 p-8 max-w-5xl mx-auto shadow-lg rounded-lg">
        <div class="border-b pb-4 mb-6">
            <h4 class="h4 text-2xl font-bold text-gray-800">Detail Pengguna</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nama</label>
                    <div class="flex items-center">
                        <i class="fas fa-user mr-3 text-blue-500"></i>
                        <span class="text-lg font-semibold text-gray-800">{{ $user->name }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-green-500"></i>
                        <span class="text-lg font-semibold text-gray-800">{{ $user->email }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Role</label>
                    <div class="flex items-center">
                        <i class="fas fa-user-tag mr-3 text-purple-500"></i>
                        <span class="text-lg font-semibold text-gray-800 uppercase
                            @if($user->role == 'admin') text-blue-600
                            @elseif($user->role == 'opd') text-yellow-600
                            @else text-green-600
                            @endif">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nomor Telepon</label>
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-3 text-indigo-500"></i>
                        <span class="text-lg font-semibold text-gray-800">{{ $user->nomor_telepon }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Alamat</label>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-red-500"></i>
                        <span class="text-lg font-semibold text-gray-800">{{ $user->alamat }}</span>
                    </div>
                </div>

                @if(Auth::user()->role == 'admin')
                    <div class="bg-yellow-50 p-4 rounded-lg shadow-sm border-2 border-yellow-200">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-1"></i>
                            Password (Admin Only)
                        </label>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-grow">
                                <i class="fas fa-key mr-3 text-yellow-600"></i>
                                <span id="password-display" class="text-lg font-mono font-semibold text-gray-800 bg-white px-3 py-1 rounded border">
                                    ••••••••
                                </span>
                                <span id="password-actual" class="text-lg font-mono font-semibold text-gray-800 bg-white px-3 py-1 rounded border hidden">
                                    {{ $user->plain_password ?? 'N/A' }}
                                </span>
                            </div>
                            <button id="toggle-password-show" class="ml-3 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                <i class="fas fa-eye"></i> <span>Show</span>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Dibuat</label>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt mr-3 text-teal-500"></i>
                        <span class="text-lg font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('user.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('user.edit', $user->id) }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password show/hide
    $('#toggle-password-show').click(function() {
        const $btn = $(this);
        const $icon = $btn.find('i');
        const $text = $btn.find('span');
        const $display = $('#password-display');
        const $actual = $('#password-actual');

        if ($display.hasClass('hidden')) {
            $display.removeClass('hidden');
            $actual.addClass('hidden');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
            $text.text('Show');
        } else {
            $display.addClass('hidden');
            $actual.removeClass('hidden');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
            $text.text('Hide');
        }
    });
});
</script>
@endpush

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
