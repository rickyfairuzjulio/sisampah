import React from 'react';
import { Scale, Wallet, Banknote, Sparkles, ShieldCheck, ArrowRight } from 'lucide-react';

export default function DepositSummaryCard({
    totalWeight = 0,
    totalRupiah = 0,
    totalPoints = 0,
    selectedNasabah = null,
    isSubmitting = false,
}) {
    const isUnitMember = selectedNasabah?.is_followed_bank ?? true;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-6 select-none sticky top-24">
            
            <div className="space-y-1 pb-3 border-b border-slate-100">
                <h3 className="font-black text-lg text-slate-900 tracking-tight">
                    Ringkasan Setoran Mandiri
                </h3>
                <p className="text-xs text-slate-500">
                    Kalkulasi nilai transaksi di pos Bank Sampah
                </p>
            </div>

            {/* Metrics List */}
            <div className="space-y-3.5">
                
                {/* Total Weight */}
                <div className="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                    <div className="flex items-center gap-2 text-xs font-bold text-slate-600">
                        <Scale className="w-4 h-4 text-slate-400" />
                        <span>Total Berat</span>
                    </div>
                    <span className="font-black text-sm sm:text-base text-slate-900">
                        {totalWeight.toFixed(1)} Kg
                    </span>
                </div>

                {/* Total Points */}
                <div className="flex items-center justify-between p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/70">
                    <div className="flex items-center gap-2 text-xs font-bold text-amber-800">
                        <Sparkles className="w-4 h-4 text-amber-600" />
                        <span>Poin Lingkungan</span>
                    </div>
                    <span className="font-black text-sm sm:text-base text-amber-900">
                        +{totalPoints} Poin
                    </span>
                </div>

                {/* Total Rupiah */}
                <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-1">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2 text-xs font-bold text-emerald-800">
                            {isUnitMember ? <Wallet className="w-4 h-4 text-emerald-600" /> : <Banknote className="w-4 h-4 text-amber-600" />}
                            <span>{isUnitMember ? 'Total Kredit SiSampay' : 'Total Bayar CASH Tunai'}</span>
                        </div>
                    </div>
                    <p className="font-black text-2xl text-emerald-900 tracking-tight">
                        Rp {totalRupiah.toLocaleString('id-ID')}
                    </p>
                    <p className="text-[11px] text-emerald-700 font-medium">
                        {isUnitMember ? 'Otomatis masuk ke dompet digital SiSampay' : 'Diselesaikan secara tunai di pos teller'}
                    </p>
                </div>

            </div>

            {/* Target Ledger / Cash Note */}
            <div className="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1">
                <div className="flex items-center gap-1.5 font-bold text-slate-800">
                    <ShieldCheck className="w-4 h-4 text-emerald-600 shrink-0" />
                    <span>{isUnitMember ? 'Kredit Otomatis SiSampay' : 'Pengeluaran Kas Tunai Unit'}</span>
                </div>
                <p className="text-[11px] text-slate-500 leading-relaxed">
                    {isUnitMember
                        ? `Saldo Rp ${totalRupiah.toLocaleString('id-ID')} akan otomatis masuk ke akun nasabah.`
                        : `Petugas menyerahkan Rp ${totalRupiah.toLocaleString('id-ID')} tunai kepada nasabah. Kas unit akan berkurang otomatis.`
                    }
                </p>
            </div>

            {/* Submit Button */}
            <button
                type="submit"
                disabled={isSubmitting || totalWeight <= 0}
                className={`w-full py-3.5 rounded-2xl font-black text-sm flex items-center justify-center gap-2 transition-all shadow-md ${
                    totalWeight > 0 && !isSubmitting
                        ? 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white hover:scale-[1.01] cursor-pointer'
                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'
                }`}
            >
                <span>{isSubmitting ? 'Memproses Transaksi...' : 'Proses & Simpan Transaksi'}</span>
                <ArrowRight className="w-4 h-4" />
            </button>

        </div>
    );
}
