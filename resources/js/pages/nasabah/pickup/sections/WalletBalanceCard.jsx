import React, { useState } from 'react';
import { Eye, EyeOff, ArrowUpRight, Plus, Truck, ShieldCheck, Sparkles, CreditCard } from 'lucide-react';

export default function WalletBalanceCard({
    authData = {},
    onOpenWithdrawModal,
    onOpenTopUpModal,
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const [showBalance, setShowBalance] = useState(true);

    const formatCurrency = (val) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(val || 0);
    };

    return (
        <div className="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white shadow-md p-6 sm:p-8 animate-slide-in select-none">
            
            {/* Ambient Background Glows & Card Pattern */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none" />
            <div className="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none" />
            
            <div className="relative z-10 space-y-6">
                
                {/* Top Row: Brand & Card Details */}
                <div className="flex items-center justify-between gap-4">
                    <div className="flex items-center gap-3">
                        {/* Golden Chip */}
                        <div className="w-10 h-7 rounded-lg bg-gradient-to-tr from-amber-300 via-amber-200 to-yellow-400 border border-amber-300/60 shadow-inner flex items-center justify-center">
                            <div className="w-6 h-4 border border-amber-500/40 rounded-sm" />
                        </div>
                        <div className="flex items-center gap-1.5 font-black text-lg tracking-tight">
                            <span className="text-white">SiSam</span>
                            <span className="text-emerald-300">pay</span>
                        </div>
                    </div>

                    <div className="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-emerald-100">
                        <ShieldCheck className="w-3.5 h-3.5 text-emerald-200" />
                        <span>Dompet Resmi Nasabah</span>
                    </div>
                </div>

                {/* Middle Row: Virtual Account & Balance */}
                <div className="space-y-2">
                    <div className="flex items-center gap-2">
                        <span className="text-xs font-semibold text-emerald-100/90 uppercase tracking-widest">
                            Saldo Aktif Tersedia
                        </span>
                        <button
                            type="button"
                            onClick={() => setShowBalance(!showBalance)}
                            className="text-emerald-200 hover:text-white transition-colors p-1 focus:outline-none"
                            title={showBalance ? 'Sembunyikan Saldo' : 'Tampilkan Saldo'}
                        >
                            {showBalance ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                        </button>
                    </div>

                    <div className="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white">
                        {showBalance ? formatCurrency(user.saldo || 0) : 'Rp ••••••••'}
                    </div>

                    <div className="flex items-center gap-3 pt-1 text-xs text-emerald-100/80 font-mono">
                        <span>{user.virtual_account || '8802 •••• •••• 4192'}</span>
                        <span>•</span>
                        <span className="font-sans font-medium">{user.name || 'Nasabah'} ({bankSampahName})</span>
                    </div>
                </div>

                {/* Bottom Row: Quick Action Buttons */}
                <div className="pt-2 flex flex-wrap items-center gap-3">
                    
                    {/* Tarik Saldo Button */}
                    <button
                        type="button"
                        onClick={onOpenWithdrawModal}
                        className="px-5 py-2.5 sm:py-3 rounded-2xl bg-white text-emerald-800 hover:bg-emerald-50 active:bg-emerald-100 font-extrabold text-xs sm:text-sm shadow-sm hover:shadow-md transition-all flex items-center gap-2 cursor-pointer hover:-translate-y-0.5"
                    >
                        <ArrowUpRight className="w-4 h-4 text-emerald-700" />
                        <span>Tarik Saldo</span>
                    </button>

                    {/* Top Up Saldo Button */}
                    <button
                        type="button"
                        onClick={onOpenTopUpModal}
                        className="px-5 py-2.5 sm:py-3 rounded-2xl bg-emerald-500/30 hover:bg-emerald-500/40 active:bg-emerald-500/50 text-white border border-white/20 font-extrabold text-xs sm:text-sm backdrop-blur-md transition-all flex items-center gap-2 cursor-pointer hover:-translate-y-0.5"
                    >
                        <Plus className="w-4 h-4 text-emerald-200" />
                        <span>Top Up Saldo</span>
                    </button>

                    {/* Link to Jemput Sampah */}
                    <a
                        href="/nasabah/jemput-sampah"
                        className="px-5 py-2.5 sm:py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-emerald-100 border border-white/15 font-bold text-xs sm:text-sm backdrop-blur-md transition-all flex items-center gap-2 hover:-translate-y-0.5"
                    >
                        <Truck className="w-4 h-4 text-emerald-300" />
                        <span>Jadwalkan Jemput</span>
                    </a>

                </div>

            </div>

        </div>
    );
}
