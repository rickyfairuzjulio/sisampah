import React, { useState } from 'react';
import { HelpCircle, ChevronDown, Sparkles } from 'lucide-react';

export default function FaqAccordionSection() {
    const [openIndex, setOpenIndex] = useState(0); // First one open by default

    const faqs = [
        {
            question: 'Bagaimana cara mendaftar sebagai nasabah di SiSampah?',
            answer: 'Pendaftaran sangat mudah dan 100% gratis! Klik tombol "Mulai Gratis", lengkapi nama, email, kata sandi, dan pilih Unit Bank Sampah terdekat di domisili Anda. Setelah mendaftar, Anda langsung dapat meminta penjemputan sampah.',
        },
        {
            question: 'Berapa batas minimal berat sampah untuk meminta penjemputan ke rumah?',
            answer: 'Sebagian besar unit bank sampah menetapkan batas minimal penjemputan mulai dari 5 Kg (gabungan anorganik seperti botol plastik, kardus, atau kaleng). Jika di bawah 5 Kg, Anda juga bisa menyetorkan langsung secara mandiri ke pos unit terdekat.',
        },
        {
            question: 'Bagaimana sistem pencairan saldo dari hasil penjualan sampah?',
            answer: 'Setiap kali sampah berhasil ditimbang dan divalidasi oleh petugas armada, saldo langsung masuk ke dompet digital SiSampah Pay Anda. Saldo tersebut dapat dicairkan ke rekening bank/e-wallet atau digunakan untuk iuran kas RT/RW setempat.',
        },
        {
            question: 'Bagaimana cara mendaftarkan organisasi bank sampah baru di desa kami?',
            answer: 'Pengurus desa, karang taruna, atau komunitas dapat mengeklik tombol "Daftarkan Bank Sampah". Isi formulir legalitas, tentukan koordinat lokasi di peta GPS, dan upload dokumen pendukung. Tim kami akan memverifikasi dalam waktu 1x24 jam kerja.',
        },
        {
            question: 'Apakah layanan penjemputan sampah ini dipungut biaya operasional?',
            answer: 'Layanan penjemputan armada adalah bagian dari ekosistem bank sampah dan tidak memungut biaya tunai kepada nasabah. Anda justru mendapatkan penghasilan dari setiap sampah bernilai ekonomis yang Anda setorkan.',
        },
    ];

    const toggleFaq = (index) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <section id="faq" className="relative py-20 lg:py-28 bg-[#051410] border-t border-white/[0.08] overflow-hidden">
            
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 relative z-10">
                
                {/* Section Header */}
                <div className="text-center space-y-4">
                    <div className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                        <HelpCircle className="w-3.5 h-3.5" />
                        <span>FAQ & PUSAT BANTUAN</span>
                    </div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                        Pertanyaan yang Sering <br className="hidden sm:block" />
                        <span className="text-[#22C55E]">Ditanyakan Warga.</span>
                    </h2>
                    <p className="text-sm sm:text-base text-white/70 leading-relaxed max-w-xl mx-auto">
                        Punya pertanyaan seputar operasional, harga komoditas, atau cara kerja sistem? Temukan jawabannya di bawah ini.
                    </p>
                </div>

                {/* Accordion List */}
                <div className="space-y-4">
                    {faqs.map((faq, idx) => {
                        const isOpen = openIndex === idx;
                        return (
                            <div 
                                key={idx}
                                className={`rounded-2xl border transition-all duration-300 overflow-hidden ${
                                    isOpen 
                                        ? 'bg-[#061E17] border-emerald-500/40 shadow-xl' 
                                        : 'bg-[#041611]/80 border-white/10 hover:border-white/20'
                                }`}
                            >
                                <button
                                    onClick={() => toggleFaq(idx)}
                                    className="w-full text-left p-5 sm:p-6 flex items-center justify-between gap-4 focus:outline-none"
                                >
                                    <span className="text-base sm:text-lg font-bold text-white tracking-tight">
                                        {faq.question}
                                    </span>
                                    <div className={`w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300 ${
                                        isOpen 
                                            ? 'bg-emerald-500/20 text-emerald-400 rotate-180' 
                                            : 'bg-white/5 text-white/60'
                                    }`}>
                                        <ChevronDown className="w-4 h-4" />
                                    </div>
                                </button>

                                {isOpen && (
                                    <div className="px-5 sm:px-6 pb-6 pt-1 text-sm text-white/70 leading-relaxed border-t border-white/5 animate-fade-in">
                                        {faq.answer}
                                    </div>
                                )}
                            </div>
                        );
                    })}
                </div>

            </div>
        </section>
    );
}
