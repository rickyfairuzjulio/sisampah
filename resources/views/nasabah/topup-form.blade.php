<x-app-layout title="Top Up Saldo">
    @push('styles')
    <!-- Midtrans Snap JS (Sandbox) -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="topUpHandler()">


        <div class="max-w-xl mx-auto space-y-6">
            <!-- Header with Back Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('nasabah.wallet') }}" class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-on-surface">💳 Top Up Saldo</h1>
                    <p class="text-sm text-on-surface-variant">Isi saldo dompet digital Anda menggunakan payment gateway Midtrans</p>
                </div>
            </div>

            <!-- Error Alerts -->
            <template x-if="errorMessage">
                <x-alert type="error" title="Kesalahan" dismissible @dismiss="errorMessage = ''" class="animate-slide-in">
                    <span x-text="errorMessage"></span>
                </x-alert>
            </template>

            @if(session('error'))
                <x-alert type="error" title="Kesalahan" dismissible class="animate-slide-in">
                    {{ session('error') }}
                </x-alert>
            @endif

            <!-- Top Up Card -->
            <x-card class="relative overflow-hidden">
                <!-- Decorative Top Border Gradient -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-primary to-forest-emerald"></div>

                <div class="pt-2">
                    <h2 class="text-lg font-bold text-on-surface mb-1">Pilih Nominal Top Up</h2>
                    <p class="text-xs text-on-surface-variant mb-6">Pilih dari nominal instan di bawah ini atau masukkan nominal khusus.</p>

                    <!-- Instant Nominal Selection Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                        <template x-for="preset in presets" :key="preset.value">
                            <button type="button"
                                    @click="nominal = preset.value"
                                    :class="nominal == preset.value ? 'border-primary bg-primary/5 text-primary ring-2 ring-primary/20' : 'border-outline-variant hover:border-primary text-on-surface bg-surface-container-low'"
                                    class="py-3 px-4 border rounded-xl font-bold text-sm transition-all duration-200 text-center">
                                <span x-text="preset.label"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Custom Nominal Form -->
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-2">Nominal Custom (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-on-surface-variant font-semibold text-sm">Rp</span>
                                </div>
                                <input type="number" 
                                       x-model.number="nominal" 
                                       required 
                                       min="10000" 
                                       max="10000000" 
                                       step="5000"
                                       placeholder="Minimal Rp 10.000"
                                       class="block w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary rounded-xl font-bold text-base text-on-surface transition-shadow">
                            </div>
                            <p class="mt-1.5 text-xs text-on-surface-variant">Minimal top-up adalah Rp 10.000. Maksimal Rp 10.000.000.</p>
                        </div>

                        <!-- Pay Button -->
                        <button type="submit" 
                                :disabled="isLoading || nominal < 10000"
                                :class="isLoading || nominal < 10000 ? 'opacity-60 cursor-not-allowed bg-outline-variant text-on-surface-variant' : 'bg-primary text-on-primary hover:bg-primary-container hover:shadow-lg active:scale-[0.98]'"
                                class="w-full py-3.5 rounded-xl font-bold text-base flex items-center justify-center gap-2 transition-all shadow-sm">
                            <template x-if="isLoading">
                                <svg class="animate-spin h-5 w-5 text-current" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <span x-text="isLoading ? 'Memproses Transaksi...' : 'Bayar Sekarang'"></span>
                        </button>
                    </form>
                </div>
            </x-card>

            <!-- Quick FAQ -->
            <x-card class="bg-surface-container-low border border-outline-variant">
                <h3 class="font-bold text-sm text-on-surface mb-2">💡 Informasi Tambahan</h3>
                <ul class="list-disc list-inside text-xs text-on-surface-variant space-y-1.5">
                    <li>Semua pembayaran menggunakan Midtrans Sandbox (lingkungan simulasi/testing).</li>
                    <li>Metode yang tersedia meliputi E-Wallet (GoPay, ShopeePay) dan Virtual Account (BCA, Mandiri, BRI, BNI).</li>
                    <li>Selesai membayar, mohon tunggu sebentar untuk pembaruan status saldo dompet Anda secara real-time.</li>
                </ul>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        function topUpHandler() {
            return {
                nominal: 50000,
                isLoading: false,
                errorMessage: '',
                presets: [
                    { value: 10000, label: 'Rp 10.000' },
                    { value: 20000, label: 'Rp 20.000' },
                    { value: 50000, label: 'Rp 50.000' },
                    { value: 100000, label: 'Rp 100.000' },
                    { value: 200000, label: 'Rp 200.000' },
                    { value: 500000, label: 'Rp 500.000' }
                ],
                submitForm() {
                    if (this.nominal < 10000) {
                        this.errorMessage = 'Nominal top-up minimal adalah Rp 10.000';
                        return;
                    }
                    
                    this.isLoading = true;
                    this.errorMessage = '';

                    fetch('{{ route("nasabah.topup.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ nominal: this.nominal })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.isLoading = false;
                        if (data.status === 'success' && data.token) {
                            // Trigger Midtrans Snap Popup
                            window.snap.pay(data.token, {
                                onSuccess: (result) => {
                                    this.checkLocalStatus(data.topup_id);
                                },
                                onPending: (result) => {
                                    this.checkLocalStatus(data.topup_id);
                                },
                                onError: (result) => {
                                    this.errorMessage = 'Pembayaran gagal. Silakan coba kembali.';
                                },
                                onClose: () => {
                                    this.errorMessage = 'Widget pembayaran ditutup. Anda bisa menyelesaikan pembayaran nanti.';
                                }
                            });
                        } else {
                            this.errorMessage = data.message || 'Ggal memproses transaksi.';
                        }
                    })
                    .catch(error => {
                        this.isLoading = false;
                        this.errorMessage = 'Terjadi kesalahan sistem. Silakan coba lagi.';
                        console.error('Topup Error:', error);
                    });
                },
                checkLocalStatus(topupId) {
                    this.isLoading = true;
                    // Poll database status check a few times
                    let attempts = 0;
                    const interval = setInterval(() => {
                        attempts++;
                        fetch(`/nasabah/topup/${topupId}/status`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    clearInterval(interval);
                                    window.location.href = '{{ route("nasabah.wallet") }}?success=Top-up+berhasil!+Saldo+Anda+telah+diperbarui.';
                                } else if (data.status === 'failed' || data.status === 'expired') {
                                    clearInterval(interval);
                                    this.isLoading = false;
                                    this.errorMessage = 'Pembayaran terdeteksi gagal atau kedaluwarsa.';
                                } else if (attempts >= 10) {
                                    // Stop polling after 10 attempts (5 seconds) and fallback redirect
                                    clearInterval(interval);
                                    window.location.href = '{{ route("nasabah.wallet") }}';
                                }
                            })
                            .catch(err => console.error(err));
                    }, 500);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
