@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Validasi Keuangan - Penarikan Dana</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Pengajuan Penarikan Pending</h2>

                @if($withdrawals->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Nama Nasabah</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Nominal</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Metode</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $withdrawal->user->name }}</td>
                                        <td class="px-4 py-3 text-right text-sm text-gray-900">Rp {{ number_format($withdrawal->nominal, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($withdrawal->metode) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <button onclick="openApproveModal('{{ $withdrawal->id }}')" class="text-green-600 hover:text-green-900 font-semibold text-sm mr-2">
                                                Setujui
                                            </button>
                                            <button onclick="openRejectModal('{{ $withdrawal->id }}')" class="text-red-600 hover:text-red-900 font-semibold text-sm">
                                                Tolak
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $withdrawals->links() }}
                    </div>
                @else
                    <p class="text-gray-600">Tidak ada pengajuan penarikan yang pending</p>
                @endif
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Penarikan Disetujui (10 Terakhir)</h2>
                <div class="space-y-4">
                    @forelse($approved as $withdrawal)
                        <div class="border-l-4 border-green-500 pl-4 py-2">
                            <p class="font-semibold text-gray-900 text-sm">{{ $withdrawal->user->name }}</p>
                            <p class="text-sm text-gray-600">Rp {{ number_format($withdrawal->nominal, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $withdrawal->updated_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-600 text-sm">Belum ada penarikan yang disetujui</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Setujui Penarikan Dana</h2>
        <p class="text-gray-600 mb-6">Unggah foto resi pembayaran untuk konfirmasi.</p>

        <form id="approveForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="foto_resi" class="block text-sm font-semibold text-gray-900 mb-2">Foto Resi Pembayaran</label>
                <input type="file" id="foto_resi" name="foto_resi" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <p class="text-sm text-gray-600 mt-2">Format: JPEG, PNG, JPG (Max: 2MB)</p>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeApproveModal()" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                    Setujui
                </button>
            </div>
        </form>
    </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tolak Penarikan Dana</h2>

        <form id="rejectForm" method="POST" class="space-y-4">
            @csrf
            @method('POST')

            <div>
                <label for="catatan_admin" class="block text-sm font-semibold text-gray-900 mb-2">Alasan Penolakan</label>
                <textarea id="catatan_admin" name="catatan_admin" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Jelaskan alasan penolakan..."></textarea>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(withdrawalId) {
        document.getElementById('approveForm').action = '/admin/validasi-keuangan/' + withdrawalId;
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    function openRejectModal(withdrawalId) {
        document.getElementById('rejectForm').action = '/admin/validasi-keuangan/' + withdrawalId + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection
