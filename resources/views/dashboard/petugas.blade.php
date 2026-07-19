<!-- Officer Dashboard -->
<x-app-layout title="Dashboard Petugas">
    <div class="space-y-6">
        <!-- Today Status -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-1">Rute Penjemputan Hari Ini</h2>
                    <p class="text-blue-100">12 dari 15 lokasi selesai • 80% progres</p>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold">1,850 kg</p>
                    <p class="text-blue-100">Total terkumpul</p>
                </div>
            </div>
        </div>

        <!-- Quick Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-card hover class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="font-semibold text-on-surface">Pending Penjemputan</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">3</p>
            </x-card>

            <x-card hover class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 2.75a.75.75 0 00-.75.75v2.5H4.5a2.75 2.75 0 000 5.5h2.91v2.5a.75.75 0 001.5 0v-2.5h2.91a2.75 2.75 0 000-5.5H11v-2.5a.75.75 0 00-.75-.75H8.16z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-on-surface">Setoran Mandiri</h3>
                <p class="text-3xl font-bold text-yellow-600 mt-2">2</p>
            </x-card>

            <x-card hover class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-on-surface">Total Transaksi</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">12</p>
            </x-card>
        </div>

        <!-- Pickup Schedule -->
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-on-surface">📍 Jadwal Penjemputan</h3>
                <div class="flex gap-2">
                    <x-button variant="outline" size="sm">Filter</x-button>
                    <x-button variant="ghost" size="sm">⋯</x-button>
                </div>
            </div>
            <div class="space-y-2">
                @php
                    $pickups = [
                        ['location' => 'RT 01 RW 02', 'address' => 'Jl. Merdeka No. 45', 'status' => 'pending', 'time' => '09:30', 'amount' => '50 kg'],
                        ['location' => 'RT 02 RW 02', 'address' => 'Jl. Sudirman No. 12', 'status' => 'completed', 'time' => '08:45', 'amount' => '75 kg'],
                        ['location' => 'RT 03 RW 02', 'address' => 'Jl. Ahmad Yani No. 88', 'status' => 'in_progress', 'time' => '09:15', 'amount' => '65 kg'],
                        ['location' => 'RT 04 RW 02', 'address' => 'Jl. Gatot Subroto', 'status' => 'pending', 'time' => '10:00', 'amount' => '45 kg'],
                    ]
                @endphp
                @foreach($pickups as $pickup)
                    <div class="flex items-center justify-between p-4 bg-surface-container rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background-color: {{ $pickup['status'] === 'completed' ? '#d1fae5' : ($pickup['status'] === 'in_progress' ? '#dbeafe' : '#fef3c7') }}">
                                @switch($pickup['status'])
                                    @case('completed')
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        @break
                                    @case('in_progress')
                                        <svg class="w-6 h-6 text-blue-600 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        @break
                                    @default
                                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                @endswitch
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-on-surface">{{ $pickup['location'] }}</p>
                                <p class="text-sm text-on-surface-variant">{{ $pickup['address'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-on-surface">{{ $pickup['amount'] }}</p>
                            <p class="text-sm text-on-surface-variant">{{ $pickup['time'] }}</p>
                        </div>
                        <x-button variant="ghost" size="sm" class="ml-4">→</x-button>
                    </div>
                @endforeach
            </div>
        </x-card>

        <!-- Quick Input Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-card>
                <h3 class="text-lg font-bold text-on-surface mb-4">🔬 Input Timbangan</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-1">Kategori Sampah</label>
                        <select class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            <option>-- Pilih Kategori --</option>
                            <option>Plastik</option>
                            <option>Kertas</option>
                            <option>Metal</option>
                            <option>Kaca</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-1">Berat (kg)</label>
                        <input type="number" placeholder="0 kg" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <x-button class="w-full">Catat Data</x-button>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-lg font-bold text-on-surface mb-4">📸 Dokumentasi</h3>
                <div class="border-2 border-dashed border-outline-variant rounded-lg p-8 text-center hover:bg-surface-container transition-colors cursor-pointer">
                    <svg class="w-12 h-12 text-on-surface-variant mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <p class="text-sm font-medium text-on-surface">Ambil atau Upload Foto</p>
                    <p class="text-xs text-on-surface-variant mt-1">Bukti transaksi penjemputan</p>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
