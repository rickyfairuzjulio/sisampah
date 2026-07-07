@auth
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userId = {{ auth()->id() }};
        const role = '{{ auth()->user()->getRoleNames()->first() }}';
        const storageKey = `onboarding_done_user_${userId}`;
        
        // Start intro automatically if not done
        if (!localStorage.getItem(storageKey)) {
            // Give the UI a bit of time to settle (animations, etc)
            setTimeout(() => {
                startOnboarding(role);
            }, 1000);
        }

        // Expose function so user can restart it manually if they want
        window.restartOnboarding = () => startOnboarding(role);

        function startOnboarding(userRole) {
            const intro = introJs();
            
            intro.setOptions({
                nextLabel: 'Lanjut',
                prevLabel: 'Kembali',
                skipLabel: 'Lewati',
                doneLabel: 'Selesai',
                showProgress: true,
                showBullets: false,
                overlayOpacity: 0.7,
                steps: getStepsForRole(userRole)
            });

            intro.oncomplete(() => {
                localStorage.setItem(storageKey, 'true');
            });
            
            intro.onexit(() => {
                // If they exit manually, don't show it again automatically
                localStorage.setItem(storageKey, 'true');
            });

            // Start the tour
            intro.start();
        }

        function getStepsForRole(role) {
            if (role === 'nasabah') {
                return [
                    {
                        title: 'Selamat datang, Nasabah!',
                        intro: 'Aplikasi SiSampah membantu Anda menabung sampah dengan mudah dan transparan. Mari ikuti tur singkat fitur-fitur utama.'
                    },
                    {
                        element: document.querySelector('#card-saldo'),
                        title: 'Dompet SiSampah',
                        intro: 'Di sini Anda dapat melihat saldo terkini dari hasil setoran sampah Anda. Anda juga dapat menarik saldo kapan saja jika sudah memenuhi batas minimum.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#btn-pesan-jemput'),
                        title: 'Jadwalkan Penjemputan',
                        intro: 'Tidak perlu repot ke bank sampah, tekan tombol ini untuk meminta petugas menjemput sampah di lokasi Anda.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#history-table'),
                        title: 'Riwayat Setoran',
                        intro: 'Pantau semua detail riwayat setoran, berat, jenis sampah, dan penghasilan poin Anda di sini.',
                        position: 'top'
                    }
                ].filter(step => step.element || step.element === undefined); // Only include if element exists (or is intro screen)
            } 
            else if (role === 'petugas') {
                return [
                    {
                        title: 'Selamat Bertugas!',
                        intro: 'SiSampah membuat pencatatan lebih mudah. Mari kita lihat dashboard Anda.'
                    },
                    {
                        element: document.querySelector('#card-tugas'),
                        title: 'Tugas Hari Ini',
                        intro: 'Daftar penjemputan sampah yang harus Anda selesaikan hari ini akan muncul di area ini.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#btn-input-timbangan'),
                        title: 'Input Timbangan',
                        intro: 'Gunakan ini untuk memasukkan berat sampah. Aplikasi akan otomatis menghitung harga sesuai kategori yang Anda pilih.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#btn-setor-mandiri'),
                        title: 'Setor Mandiri',
                        intro: 'Jika nasabah datang langsung membawa sampah, Anda bisa mencatatnya dengan fitur Setor Mandiri.',
                        position: 'bottom'
                    }
                ].filter(step => step.element || step.element === undefined);
            }
            else if (role === 'admin') {
                return [
                    {
                        title: 'Halo, Admin!',
                        intro: 'Ini adalah pusat kendali Anda. Mari lihat fitur utamanya.'
                    },
                    {
                        element: document.querySelector('#stat-overview'),
                        title: 'Ringkasan Statistik',
                        intro: 'Pantau total sampah terkumpul, jumlah nasabah aktif, dan perputaran uang secara real-time.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#btn-kelola-harga'),
                        title: 'Harga Sampah',
                        intro: 'Update harga sampah berdasarkan jenisnya di sini. Harga ini akan berlaku seketika di semua petugas.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('#btn-validasi-tarik'),
                        title: 'Validasi Penarikan',
                        intro: 'Setujui atau tolak pengajuan penarikan saldo dari para nasabah.',
                        position: 'bottom'
                    }
                ].filter(step => step.element || step.element === undefined);
            }
            return [];
        }
    });
</script>
@endauth
