<div x-data="aiAssistantWidget()" 
     class="fixed bottom-8 right-5 md:bottom-8 md:right-8 z-50 flex flex-col items-end"
     @keydown.escape.window="closeAllModals()">
    
    <!-- Assistant Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="bg-surface-container-lowest border border-outline-variant rounded-3xl shadow-2xl w-[360px] sm:w-[440px] h-[580px] max-h-[85vh] flex flex-col mb-4 overflow-hidden"
         x-cloak>
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary via-emerald-700 to-emerald p-4 flex items-center justify-between text-white shadow-md relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-primary-container p-1 shadow-sm">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h3 class="font-bold text-lg leading-tight">SiSampah AI</h3>
                        <span class="px-2 py-0.5 bg-emerald-400/30 text-white text-[10px] font-bold rounded-full border border-white/20">Vision v2.5</span>
                    </div>
                    <p class="text-xs text-white/80">Asisten Smart Recycling & Vision</p>
                </div>
            </div>
            
            <div class="flex items-center gap-1">
                <!-- Basket Button -->
                <button @click="isBasketOpen = true" class="relative text-white hover:text-white/80 p-2 rounded-xl hover:bg-white/10 transition-colors" title="Keranjang Setoran">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span x-show="basket.length > 0" class="absolute top-1 right-1 w-4 h-4 bg-amber-400 text-amber-950 font-extrabold text-[10px] rounded-full flex items-center justify-center shadow" x-text="basket.length"></span>
                </button>
                
                <!-- History Link -->
                <a href="{{ route('scan.history') }}" class="text-white hover:text-white/80 p-2 rounded-xl hover:bg-white/10 transition-colors" title="Riwayat Scan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </a>
                
                <!-- Close Button -->
                <button @click="isOpen = false" class="text-white hover:text-white/80 p-2 rounded-xl hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Dialogue Area -->
        <div class="flex-1 p-4 overflow-y-auto bg-slate-50 space-y-4" id="assistant-dialogue" x-ref="messagesBox">
            
            <!-- Welcome Message -->
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center flex-shrink-0 p-1 shadow-sm">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-3.5 max-w-[85%] text-sm text-on-surface border border-slate-200/80 shadow-sm space-y-2">
                    <p>Halo! Saya <strong>SiSampah AI Vision</strong>. Foto sampah Anda dengan menekan ikon kamera 📸 di bawah untuk menganalisis objek, estimasi harga, dan rekomendasi daur ulang!</p>
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <button @click="triggerCameraChoice('camera')" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-lg border border-emerald-200 transition-colors flex items-center gap-1">
                            📷 Foto Sampah
                        </button>
                        <button @click="triggerCameraChoice('gallery')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors flex items-center gap-1">
                            🖼️ Unggah Galeri
                        </button>
                    </div>
                </div>
            </div>

            <!-- Chat Messages Loop -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex gap-3" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                    <!-- Avatar -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm" 
                         :class="msg.role === 'user' ? 'bg-emerald text-white' : 'bg-white border-2 border-primary p-1'">
                        <span x-show="msg.role === 'user'">👤</span>
                        <img x-show="msg.role !== 'user'" src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain" alt="AI">
                    </div>
                    
                    <!-- Bubble Content -->
                    <div class="p-3.5 text-sm rounded-2xl max-w-[88%] space-y-2 shadow-sm"
                         :class="msg.role === 'user' ? 'bg-emerald text-white rounded-tr-none' : 'bg-white text-on-surface rounded-tl-none border border-slate-200/80'">
                        
                        <!-- Text message -->
                        <div class="whitespace-pre-wrap leading-relaxed" x-html="formatMessage(msg.text)"></div>
                        
                        <!-- Image Preview in bubble -->
                        <template x-if="msg.image">
                            <div class="relative rounded-xl overflow-hidden mt-2 border border-slate-200 max-h-48 group">
                                <img :src="msg.image" class="w-full h-full object-cover">
                                <template x-if="msg.visionResult">
                                    <div class="absolute inset-0 pointer-events-none">
                                        <template x-for="(obj, oIdx) in msg.visionResult.objects" :key="oIdx">
                                            <div class="absolute border-2 border-amber-400 bg-amber-400/20 rounded shadow-sm"
                                                 :style="`top:${obj.bounding_box[0]}%; left:${obj.bounding_box[1]}%; height:${obj.bounding_box[2] - obj.bounding_box[0]}%; width:${obj.bounding_box[3] - obj.bounding_box[1]}%`">
                                                <span class="absolute -top-5 left-0 bg-amber-500 text-amber-950 text-[10px] font-extrabold px-1.5 py-0.5 rounded shadow whitespace-nowrap">
                                                    <span x-text="obj.nama_objek"></span> (<span x-text="Math.round(obj.confidence)"></span>%)
                                                </span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Interactive Vision Card v2.0 -->
                        <template x-if="msg.visionResult">
                            <div class="mt-3 bg-slate-50 rounded-xl p-3.5 border border-slate-200 space-y-3 text-xs text-slate-800">
                                
                                <!-- Low Confidence / Unrecognized Alert -->
                                <template x-if="msg.visionResult.is_valid === false || msg.visionResult.is_recognized === false">
                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-amber-900 space-y-1">
                                        <div class="flex items-center gap-1.5 font-bold text-amber-950 text-xs">
                                            <span>⚠️</span> Validasi Gambar Perlu Perbaikan
                                        </div>
                                        <p class="text-[11px] leading-relaxed" x-text="msg.visionResult.unrecognized_message || 'Gambar belum dapat dianalisis secara optimal. Silakan ambil foto ulang dengan pencahayaan yang lebih baik.'"></p>
                                    </div>
                                </template>

                                <template x-if="msg.visionResult.is_valid !== false && msg.visionResult.is_recognized !== false">
                                    <div class="space-y-3">
                                        <!-- Header Badge & Image Validation -->
                                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                                <span class="font-extrabold text-emerald-800 uppercase tracking-wider text-[10px]">AI Vision v2.0 Analyzer</span>
                                            </div>
                                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded-md text-[10px]" x-text="`${msg.visionResult.object_count || (msg.visionResult.objects ? msg.visionResult.objects.length : 0)} Objek Terdeteksi`"></span>
                                        </div>

                                        <!-- Human Detection Card (If Human Present) -->
                                        <template x-if="msg.visionResult.human_detected && msg.visionResult.human_detected.detected">
                                            <div class="bg-blue-50/90 border border-blue-200 rounded-xl p-3 text-blue-900 space-y-1 text-[11px]">
                                                <div class="flex items-center justify-between font-bold text-blue-950">
                                                    <span>👤 Objek Manusia Terdeteksi</span>
                                                    <span class="px-1.5 py-0.5 bg-blue-200 text-blue-900 text-[10px] rounded" x-text="`Kepercayaan: ${msg.visionResult.human_detected.confidence}%`"></span>
                                                </div>
                                                <p class="text-[10px] text-blue-800 leading-snug" x-text="msg.visionResult.human_detected.privacy_note"></p>
                                            </div>
                                        </template>

                                        <!-- Objects Breakdown list -->
                                        <div class="space-y-2" x-show="msg.visionResult.objects && msg.visionResult.objects.length > 0">
                                            <template x-for="(obj, oIndex) in msg.visionResult.objects" :key="oIndex">
                                                <div class="bg-white p-2.5 rounded-lg border border-slate-200 space-y-1.5 shadow-2xs">
                                                    <div class="flex items-start justify-between">
                                                        <div>
                                                            <div class="flex items-center gap-1.5">
                                                                <h4 class="font-bold text-slate-900 text-xs" x-text="obj.nama_objek"></h4>
                                                                <template x-if="obj.ocr_code">
                                                                    <span class="px-1.5 py-0.5 bg-purple-100 text-purple-800 font-mono font-bold text-[9px] rounded border border-purple-200" x-text="`OCR: ${obj.ocr_code}`"></span>
                                                                </template>
                                                            </div>
                                                            <p class="text-[11px] text-slate-500" x-text="`Material: ${obj.material}`"></p>
                                                        </div>
                                                        <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 font-bold rounded text-[10px]" x-text="`Kategori: ${obj.kategori}`"></span>
                                                    </div>
                                                    
                                                    <!-- Metric tags -->
                                                    <div class="flex flex-wrap gap-1 text-[10px] pt-1">
                                                        <span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded font-semibold" x-text="`Kepercayaan AI: ${obj.confidence}%`"></span>
                                                        <span class="px-1.5 py-0.5 bg-amber-50 text-amber-700 rounded" x-text="`Kondisi: ${obj.kondisi}`"></span>
                                                        <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 rounded font-semibold" x-text="`Daur Ulang: ${obj.layak_didaur_ulang ? 'Ya' : 'Tidak'}`"></span>
                                                        <span class="px-1.5 py-0.5 bg-teal-50 text-teal-700 rounded font-semibold" x-text="`Layak Dijual: ${obj.layak_dijual ? 'Ya' : 'Tidak'}`"></span>
                                                    </div>

                                                    <div class="grid grid-cols-3 gap-1 pt-1.5 text-[10px] border-t border-slate-100">
                                                        <div>
                                                            <span class="text-slate-400 block">Est. Berat</span> 
                                                            <strong class="text-slate-800" x-text="`${obj.estimasi_berat_kg} Kg`"></strong>
                                                        </div>
                                                        <div>
                                                            <span class="text-slate-400 block">Harga/Kg</span> 
                                                            <strong class="text-slate-800" x-text="`Rp ${formatNumber(obj.harga_per_kg)}`"></strong>
                                                        </div>
                                                        <div>
                                                            <span class="text-slate-400 block">Est. Nilai</span> 
                                                            <strong class="text-emerald-700" x-text="`Rp ${formatNumber(obj.estimasi_saldo)}`"></strong>
                                                        </div>
                                                    </div>

                                                    <!-- Cara Memilah & Membersihkan -->
                                                    <template x-if="obj.cara_memilah || obj.cara_membersihkan">
                                                        <div class="pt-1.5 border-t border-slate-100 text-[10px] space-y-0.5 text-slate-700">
                                                            <template x-if="obj.cara_memilah">
                                                                <p><strong>Cara Memilah:</strong> <span x-text="obj.cara_memilah"></span></p>
                                                            </template>
                                                            <template x-if="obj.cara_membersihkan">
                                                                <p><strong>Cara Membersihkan:</strong> <span x-text="obj.cara_membersihkan"></span></p>
                                                            </template>
                                                        </div>
                                                    </template>

                                                    <!-- Saran AI Pemanfaatan Ulang -->
                                                    <template x-if="obj.saran_ai || obj.saran_pemanfaatan_ulang">
                                                        <div class="bg-amber-50/70 p-2 rounded text-[10px] text-amber-900">
                                                            <strong>💡 Saran AI:</strong> <span x-text="obj.saran_ai || obj.saran_pemanfaatan_ulang"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Total Summary Box -->
                                        <template x-if="msg.visionResult.objects && msg.visionResult.objects.length > 0">
                                            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white p-3 rounded-xl flex items-center justify-between shadow-sm">
                                                <div>
                                                    <p class="text-[10px] text-white/80 font-medium">TOTAL ESTIMASI SALDO</p>
                                                    <p class="text-base font-black" x-text="`Rp ${formatNumber(msg.visionResult.total_harga)}`"></p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-[10px] text-white/80">Est. Total Berat</p>
                                                    <p class="text-sm font-bold" x-text="`${msg.visionResult.total_berat} Kg`"></p>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- AI Multi Bank Sampah Smart Recommendation Card -->
                                        <template x-if="msg.visionResult.ai_bank_recommendation">
                                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-3 space-y-2 text-xs text-slate-800 shadow-xs">
                                                <div class="flex items-center justify-between font-bold text-emerald-950">
                                                    <span class="flex items-center gap-1.5"><i class="bi bi-geo-alt-fill text-emerald-600"></i> Rekomendasi & Perbandingan Bank Sampah</span>
                                                    <span class="px-1.5 py-0.5 bg-emerald-200 text-emerald-900 text-[10px] rounded font-bold" x-text="`${msg.visionResult.ai_bank_recommendation.distance_km} km`"></span>
                                                </div>

                                                <!-- Top 3 Comparison List -->
                                                <template x-if="msg.visionResult.ai_bank_recommendation.comparison_list">
                                                    <div class="space-y-1 bg-white p-2 rounded-lg border border-emerald-100 text-[11px]">
                                                        <template x-for="(item, bIdx) in msg.visionResult.ai_bank_recommendation.comparison_list" :key="bIdx">
                                                            <div class="flex items-center justify-between py-1 border-b border-slate-100 last:border-b-0">
                                                                <div class="flex items-center gap-1.5">
                                                                    <span x-text="item.is_recommended ? '🏆' : '🏬'"></span>
                                                                    <div>
                                                                        <span class="font-bold text-slate-900 block leading-tight" x-text="item.nama"></span>
                                                                        <span class="text-[9px] text-slate-500" x-text="`${item.distance_km} km • ~${item.est_travel_time_min} menit`"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <span class="font-bold text-emerald-700 block" x-text="`Rp ${formatNumber(item.harga_per_kg)}/kg`"></span>
                                                                    <span class="text-[9px] font-semibold px-1 rounded" :class="item.is_recommended ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'" x-text="item.is_recommended ? 'Terbaik' : 'Alternatif'"></span>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>

                                                <p class="text-[11px] text-slate-700 leading-snug italic font-medium" x-text="`🤖 Rekomendasi AI: ${msg.visionResult.ai_bank_recommendation.recommendation_text}`"></p>

                                                <div class="flex items-center justify-between pt-1 text-[10px]">
                                                    <span class="text-slate-500 font-medium" x-text="`Est. Tempuh: ~${msg.visionResult.ai_bank_recommendation.est_travel_time_min} Menit`"></span>
                                                    <a :href="msg.visionResult.ai_bank_recommendation.route_url" target="_blank" class="text-emerald-700 hover:text-emerald-900 font-extrabold flex items-center gap-1">
                                                        🗺️ Navigasi Rute →
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Eco impact info -->
                                        <template x-if="msg.visionResult.eco_impact && msg.visionResult.objects && msg.visionResult.objects.length > 0">
                                            <div class="bg-teal-50 p-2.5 rounded-lg border border-teal-200 text-[11px] text-teal-900 space-y-1">
                                                <strong class="block text-[11px] text-teal-950 flex items-center gap-1">
                                                    🌱 Dampak Lingkungan:
                                                </strong>
                                                <p class="text-[11px] leading-snug" x-text="`Pengurangan CO₂: ${msg.visionResult.eco_impact.co2_reduction_kg} kg | Hemat Energi: ${msg.visionResult.eco_impact.energy_saved_kwh} kWh | Lama Terurai: ${msg.visionResult.eco_impact.decomposition_years} tahun.`"></p>
                                            </div>
                                        </template>

                                        <!-- Action Buttons -->
                                        <template x-if="msg.visionResult.objects && msg.visionResult.objects.length > 0">
                                            <div class="space-y-1.5">
                                                <div class="grid grid-cols-2 gap-1.5 pt-1">
                                                    <button @click="openEduModal(msg.visionResult.objects[0])" class="py-2 px-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold rounded-lg text-[11px] transition-colors text-center">
                                                        📘 Pelajari Selengkapnya
                                                    </button>
                                                    <button @click="addToBasket(msg.visionResult)" class="py-2 px-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-[11px] transition-colors text-center shadow-xs">
                                                        🛒 Simpan ke Keranjang
                                                    </button>
                                                </div>
                                                <button @click="schedulePickupNow(msg.visionResult)" class="w-full py-2 bg-gradient-to-r from-primary to-emerald hover:from-primary-container hover:to-primary text-white font-extrabold rounded-lg text-xs transition-all shadow text-center flex items-center justify-center gap-1.5">
                                                    🚚 Jadwalkan Penjemputan
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                    </div>
                </div>
            </template>

            <!-- Loading Laser scanning overlay/indicator -->
            <div x-show="isLoading" class="flex gap-3" x-cloak>
                <div class="w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center flex-shrink-0 p-1 shadow-sm">
                    <img src="{{ asset('images/chatbot-icon.png') }}" class="w-full h-full object-contain animate-spin" alt="AI">
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-4 max-w-[85%] border border-slate-200 shadow-sm space-y-2">
                    <div class="flex items-center gap-2 text-xs text-emerald-800 font-bold">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        <span x-text="loadingText"></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-primary to-emerald h-full animate-pulse" style="width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-slate-200 relative z-20">
            <!-- Camera choices popover -->
            <div x-show="showCameraMenu" 
                 @click.away="showCameraMenu = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute bottom-16 left-4 bg-white border border-slate-200 rounded-2xl shadow-xl p-2 z-30 flex flex-col gap-1 w-48 text-xs font-semibold text-slate-700">
                <button @click="openWebcamModal()" class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 text-emerald-900 rounded-xl transition-colors">
                    <span>📷</span> Ambil Foto Kamera
                </button>
                <button @click="triggerGalleryInput()" class="flex items-center gap-2 px-3 py-2 hover:bg-slate-100 rounded-xl transition-colors">
                    <span>🖼️</span> Upload dari Galeri
                </button>
                <button @click="showCameraMenu = false" class="flex items-center gap-2 px-3 py-1.5 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                    <span>❌</span> Batal
                </button>
            </div>

            <!-- Hidden file input for gallery -->
            <input type="file" x-ref="galleryInput" accept="image/*" class="hidden" @change="handleFileSelect($event)">

            <form @submit.prevent="sendMessage" class="flex items-end gap-2">
                <!-- Camera Button -->
                <button type="button" 
                        @click="showCameraMenu = !showCameraMenu"
                        class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 flex items-center justify-center transition-all flex-shrink-0 shadow-2xs"
                        title="Scan Foto AI Vision">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>

                <div class="flex-1 bg-slate-100 rounded-2xl border border-slate-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all overflow-hidden relative">
                    <textarea x-model="inputText" 
                              @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                              rows="1" 
                              placeholder="Tanya AI atau scan foto..." 
                              class="w-full bg-transparent border-none focus:ring-0 resize-none py-2.5 px-3.5 text-sm text-slate-800 max-h-[90px] min-h-[40px]"
                              style="scrollbar-width: none;"></textarea>
                </div>

                <button type="submit" 
                        :disabled="isLoading || inputText.trim() === ''"
                        class="w-10 h-10 rounded-2xl bg-primary hover:bg-primary-container text-white flex items-center justify-center transition-transform hover:scale-105 disabled:opacity-40 disabled:cursor-not-allowed flex-shrink-0 shadow-md">
                    <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <div class="text-[10px] text-center text-slate-400 mt-1.5">
                SiSampah AI Vision • Computer Vision & Multimodal Chat
            </div>
        </div>
    </div>

    <!-- Toggle Floating Button -->
    <button @click="isOpen = !isOpen" 
            class="w-14 h-14 rounded-full bg-[#0A241B] border-2 border-[#2DD67B] text-[#2DD67B] flex items-center justify-center shadow-[0_0_20px_rgba(45,214,123,0.4)] hover:shadow-[0_0_30px_rgba(45,214,123,0.6)] transition-all duration-300 hover:scale-110 active:scale-95 relative z-50 animate-pulse-subtle">
        <img x-show="!isOpen" src="{{ asset('images/chatbot-icon.png') }}" class="w-9 h-9 object-contain" alt="Assistant">
        <svg x-show="isOpen" class="w-6 h-6 text-[#2DD67B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span x-show="!isOpen && unreadCount > 0" class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-[9px] text-white items-center justify-center font-bold" x-text="unreadCount"></span>
        </span>
    </button>

    <!-- Modal 1: Live Camera Modal -->
    <div x-show="isCameraModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" x-cloak>
        <div class="bg-white rounded-3xl overflow-hidden max-w-md w-full shadow-2xl space-y-4 p-5">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <span>📷</span> Live Camera Scanner
                </h3>
                <button @click="closeWebcamModal()" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            
            <div class="relative bg-black rounded-2xl overflow-hidden aspect-video flex items-center justify-center">
                <video x-ref="videoElement" autoplay playsinline class="w-full h-full object-cover"></video>
                <!-- Laser line animation -->
                <div class="absolute inset-0 border-2 border-emerald-500/50 pointer-events-none">
                    <div class="w-full h-0.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent shadow-[0_0_15px_#10b981] animate-laser-scan"></div>
                </div>
            </div>

            <div class="flex gap-3">
                <button @click="closeWebcamModal()" class="flex-1 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs">
                    Batal
                </button>
                <button @click="captureWebcamPhoto()" class="flex-1 py-2.5 bg-primary text-white font-extrabold rounded-xl text-xs shadow-md hover:bg-primary-container">
                    📸 Ambil Foto
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Edukasi AI Detail Modal -->
    <div x-show="isEduModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" x-cloak>
        <div class="bg-white rounded-3xl overflow-hidden max-w-lg w-full max-h-[85vh] flex flex-col shadow-2xl">
            <div class="p-5 bg-gradient-to-r from-primary to-emerald text-white flex items-center justify-between">
                <div>
                    <span class="text-[10px] bg-white/20 text-white font-bold px-2 py-0.5 rounded uppercase">Edukasi AI & RAG</span>
                    <h3 class="text-lg font-bold" x-text="eduData?.nama_objek || 'Edukasi Daur Ulang'"></h3>
                </div>
                <button @click="isEduModalOpen = false" class="text-white hover:text-white/70">✕</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-slate-700 leading-relaxed" x-show="eduData">
                <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                    <strong class="text-emerald-950 font-bold block mb-1">🌱 Asal Material:</strong>
                    <p x-text="eduData?.edukasi?.asal_material"></p>
                </div>
                
                <div class="bg-blue-50 p-3 rounded-xl border border-blue-200">
                    <strong class="text-blue-950 font-bold block mb-1">♻️ Tahap Proses Daur Ulang:</strong>
                    <p x-text="eduData?.edukasi?.proses_daur_ulang"></p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-amber-50 p-3 rounded-xl border border-amber-200">
                        <strong class="text-amber-950 font-bold block mb-1">💰 Manfaat Ekonomi:</strong>
                        <p x-text="eduData?.edukasi?.manfaat_ekonomi"></p>
                    </div>
                    <div class="bg-teal-50 p-3 rounded-xl border border-teal-200">
                        <strong class="text-teal-950 font-bold block mb-1">🌍 Manfaat Lingkungan:</strong>
                        <p x-text="eduData?.edukasi?.manfaat_lingkungan"></p>
                    </div>
                </div>

                <div class="bg-purple-50 p-3 rounded-xl border border-purple-200">
                    <strong class="text-purple-950 font-bold block mb-1">✨ Fakta Menarik:</strong>
                    <p x-text="eduData?.edukasi?.fakta_menarik"></p>
                </div>

                <!-- Simulated Tech Stack Footer -->
                <div class="pt-2 border-t border-slate-200">
                    <p class="text-[10px] text-slate-400 font-mono text-center">
                        Arsitektur Vision: YOLOv11 • ViT-H/14 • OCR • LLM RAG Engine
                    </p>
                </div>
            </div>
            
            <div class="p-4 bg-slate-50 border-t flex justify-end">
                <button @click="isEduModalOpen = false" class="py-2 px-5 bg-primary text-white font-bold rounded-xl text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 3: Deposit Basket ("Keranjang Setoran") Drawer/Modal -->
    <div x-show="isBasketOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" x-cloak>
        <div class="bg-white rounded-3xl overflow-hidden max-w-md w-full shadow-2xl flex flex-col max-h-[85vh]">
            <div class="p-4 bg-primary text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🛒</span>
                    <h3 class="font-bold text-base">Keranjang Setoran Sampah</h3>
                </div>
                <button @click="isBasketOpen = false" class="text-white hover:text-white/70">✕</button>
            </div>

            <div class="p-4 overflow-y-auto flex-1 space-y-3">
                <template x-if="basket.length === 0">
                    <div class="text-center py-8 text-slate-400 space-y-2">
                        <div class="text-3xl">🗑️</div>
                        <p class="text-xs">Keranjang setoran masih kosong.</p>
                    </div>
                </template>

                <template x-for="(bItem, bIdx) in basket" :key="bIdx">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                        <div>
                            <h4 class="font-bold text-slate-900" x-text="bItem.nama_objek"></h4>
                            <p class="text-slate-500 text-[11px]" x-text="`Est. Berat: ${bItem.estimasi_berat_kg} kg @ Rp ${formatNumber(bItem.harga_per_kg)}/kg`"></p>
                            <p class="text-emerald-700 font-extrabold text-xs" x-text="`Rp ${formatNumber(bItem.estimasi_saldo)}`"></p>
                        </div>
                        <button @click="removeFromBasket(bIdx)" class="text-rose-500 hover:text-rose-700 p-1 font-bold">
                            ✕
                        </button>
                    </div>
                </template>
            </div>

            <div class="p-4 bg-slate-50 border-t space-y-3">
                <div class="flex justify-between text-xs font-bold text-slate-900">
                    <span>Total Estimasi Saldo:</span>
                    <span class="text-emerald-700 text-sm" x-text="`Rp ${formatNumber(getBasketTotal())}`"></span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button @click="isBasketOpen = false; triggerCameraChoice('camera')" class="py-2.5 bg-slate-200 text-slate-800 font-bold rounded-xl text-xs">
                        ➕ Scan Lagi
                    </button>
                    <button @click="checkoutBasketToPickup()" :disabled="basket.length === 0" class="py-2.5 bg-primary text-white font-extrabold rounded-xl text-xs disabled:opacity-50 shadow">
                        🚚 Penjemputan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Badge Gamifikasi Popup -->
    <div x-show="unlockedBadge" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="fixed bottom-24 right-6 bg-gradient-to-r from-amber-400 to-amber-500 text-amber-950 p-4 rounded-2xl shadow-2xl z-50 flex items-center gap-3 border-2 border-white" 
         x-cloak>
        <span class="text-3xl">🏆</span>
        <div>
            <p class="text-[10px] uppercase tracking-wider font-extrabold text-amber-900">Lencana Baru Diperoleh!</p>
            <h4 class="font-black text-sm" x-text="unlockedBadge"></h4>
        </div>
    </div>
</div>

<style>
    @keyframes laserScan {
        0% { top: 0%; }
        50% { top: 100%; }
        100% { top: 0%; }
    }
    .animate-laser-scan {
        animation: laserScan 2s ease-in-out infinite;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('aiAssistantWidget', () => ({
            isOpen: false,
            isLoading: false,
            loadingText: 'Menganalisis foto dengan Computer Vision...',
            inputText: '',
            unreadCount: 0,
            messages: [],
            lastScanResult: null,
            
            showCameraMenu: false,
            isCameraModalOpen: false,
            isEduModalOpen: false,
            isBasketOpen: false,
            eduData: null,
            basket: [],
            unlockedBadge: null,

            init() {
                this.$watch('isOpen', val => {
                    if (val) {
                        this.unreadCount = 0;
                        setTimeout(() => this.scrollToBottom(), 100);
                    }
                });
                
                // Load local basket
                const saved = localStorage.getItem('sisampah_basket_items');
                if (saved) {
                    try { this.basket = JSON.parse(saved); } catch(e) {}
                }
            },

            closeAllModals() {
                this.showCameraMenu = false;
                this.isCameraModalOpen = false;
                this.isEduModalOpen = false;
                this.isBasketOpen = false;
                this.stopWebcam();
            },

            formatNumber(num) {
                return (num || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },

            formatMessage(text) {
                if (!text) return '';
                return text
                    .replace(/```([\s\S]*?)```/g, '<pre class="bg-slate-900 text-slate-100 p-3 rounded-xl overflow-x-auto text-xs my-2 font-mono border border-slate-800"><code>$1</code></pre>')
                    .replace(/`([^`]+)`/g, '<code class="bg-slate-200 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 px-1.5 py-0.5 rounded text-xs font-mono">$1</code>')
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    .replace(/^### (.*$)/gim, '<h3 class="font-bold text-base mt-2 mb-1">$1</h3>')
                    .replace(/^## (.*$)/gim, '<h2 class="font-bold text-lg mt-2 mb-1">$1</h2>')
                    .replace(/^\- (.*$)/gim, '• $1')
                    .replace(/\n/g, '<br>');
            },

            scrollToBottom() {
                if (this.$refs.messagesBox) {
                    this.$refs.messagesBox.scrollTop = this.$refs.messagesBox.scrollHeight;
                }
            },

            triggerCameraChoice(type) {
                this.showCameraMenu = false;
                if (type === 'camera') {
                    this.openWebcamModal();
                } else if (type === 'gallery') {
                    this.triggerGalleryInput();
                }
            },

            triggerGalleryInput() {
                this.$refs.galleryInput.click();
            },

            handleFileSelect(e) {
                const file = e.target.files[0];
                if (!file) return;
                const fileName = file.name || 'scan.jpg';
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.processVisionImage(event.target.result, fileName);
                };
                reader.readAsDataURL(file);
                e.target.value = '';
            },

            // WebCam Stream API
            async openWebcamModal() {
                this.isCameraModalOpen = true;
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                    if (this.$refs.videoElement) {
                        this.$refs.videoElement.srcObject = stream;
                    }
                } catch (e) {
                    console.warn('Webcam stream unavailable, falling back to file picker:', e);
                    this.isCameraModalOpen = false;
                    this.triggerGalleryInput();
                }
            },

            stopWebcam() {
                if (this.$refs.videoElement && this.$refs.videoElement.srcObject) {
                    const tracks = this.$refs.videoElement.srcObject.getTracks();
                    tracks.forEach(track => track.stop());
                    this.$refs.videoElement.srcObject = null;
                }
            },

            closeWebcamModal() {
                this.stopWebcam();
                this.isCameraModalOpen = false;
            },

            captureWebcamPhoto() {
                const video = this.$refs.videoElement;
                if (!video) return;
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/jpeg');
                this.closeWebcamModal();
                this.processVisionImage(dataUrl, 'webcam_capture.jpg');
            },

            async processVisionImage(base64Data, filename = 'scan.jpg') {
                // Add image preview user message
                this.messages.push({
                    role: 'user',
                    text: '📷 *Mengunggah foto sampah untuk dianalisis AI Vision...*',
                    image: base64Data
                });
                this.scrollToBottom();

                this.isLoading = true;
                this.loadingText = 'Computer Vision YOLOv11 & ViT sedang memproses foto...';

                try {
                    const res = await fetch('/chat/vision', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ image_base64: base64Data, filename: filename })
                    });
                    const data = await res.json();

                    if (data.success) {
                        this.lastScanResult = data.data;
                        const objCount = data.data.object_count || 1;
                        const firstObjName = data.data.objects[0]?.nama_objek || 'Sampah';

                        this.messages.push({
                            role: 'model',
                            text: `**Bot AI**: ${firstObjName} berhasil dikenali (${objCount} Objek Terdeteksi)!`,
                            visionResult: data.data
                        });

                        // Check Gamification badge
                        this.awardBadge('Scanner Pemula 🥉');
                        if (objCount > 1) this.awardBadge('Eco Hunter 🌿');

                    } else {
                        this.messages.push({ role: 'model', text: '⚠️ Gagal menganalisis gambar. Silakan coba lagi.' });
                    }
                } catch(err) {
                    console.error('Vision API error:', err);
                    this.messages.push({ role: 'model', text: '⚠️ Terjadi kesalahan koneksi saat memproses AI Vision.' });
                } finally {
                    this.isLoading = false;
                    setTimeout(() => this.scrollToBottom(), 100);
                }
            },

            async sendMessage() {
                if (this.inputText.trim() === '' || this.isLoading) return;

                const userText = this.inputText.trim();
                this.inputText = '';
                this.messages.push({ role: 'user', text: userText });
                this.scrollToBottom();

                this.isLoading = true;
                this.loadingText = 'SiSampah AI sedang berpikir...';

                try {
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: userText,
                            history: this.messages.slice(0, -1),
                            scan_context: this.lastScanResult
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.messages.push({ role: 'model', text: data.reply });
                        if (!this.isOpen) this.unreadCount++;
                    } else {
                        this.messages.push({ role: 'model', text: `⚠️ ${data.message}` });
                    }
                } catch (error) {
                    console.error('Chat error:', error);
                    this.messages.push({ role: 'model', text: '⚠️ Maaf, koneksi terputus. Coba lagi nanti.' });
                } finally {
                    this.isLoading = false;
                    setTimeout(() => this.scrollToBottom(), 100);
                }
            },

            openEduModal(obj) {
                this.eduData = obj;
                this.isEduModalOpen = true;
            },

            addToBasket(visionResult) {
                if (!visionResult || !visionResult.objects) return;
                visionResult.objects.forEach(obj => {
                    this.basket.push({
                        nama_objek: obj.nama_objek,
                        estimasi_berat_kg: obj.estimasi_berat_kg,
                        harga_per_kg: obj.harga_per_kg,
                        estimasi_saldo: obj.estimasi_saldo,
                        trash_category_id: obj.trash_category_id || ''
                    });
                });
                localStorage.setItem('sisampah_basket_items', JSON.stringify(this.basket));
                this.isBasketOpen = true;
                this.awardBadge('Plastic Master 🧴');
            },

            removeFromBasket(index) {
                this.basket.splice(index, 1);
                localStorage.setItem('sisampah_basket_items', JSON.stringify(this.basket));
            },

            getBasketTotal() {
                return this.basket.reduce((acc, item) => acc + (item.estimasi_saldo || 0), 0);
            },

            checkoutBasketToPickup() {
                const formatted = this.basket.map(item => ({
                    trash_category_id: item.trash_category_id || '',
                    perkiraan_berat: item.estimasi_berat_kg || 1.0
                }));
                window.sessionStorage.setItem('sisampah_pickup_basket', JSON.stringify(formatted));
                window.location.href = "{{ route('nasabah.pickup.form') }}";
            },

            schedulePickupNow(visionResult) {
                if (visionResult && visionResult.objects) {
                    const formatted = visionResult.objects.map(item => ({
                        trash_category_id: item.trash_category_id || '',
                        perkiraan_berat: item.estimasi_berat_kg || 0.5
                    }));
                    window.sessionStorage.setItem('sisampah_pickup_basket', JSON.stringify(formatted));
                }
                window.location.href = "{{ route('nasabah.pickup.form') }}";
            },

            awardBadge(name) {
                this.unlockedBadge = name;
                setTimeout(() => { this.unlockedBadge = null; }, 3500);
            }
        }));
    });
</script>
