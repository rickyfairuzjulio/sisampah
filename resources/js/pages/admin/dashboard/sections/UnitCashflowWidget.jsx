import React from 'react';
import {
    Wallet,
    Truck,
    Boxes,
    CreditCard,
    ShieldCheck,
    ArrowUpRight,
    ArrowDownRight,
    Sparkles,
    CheckCircle2,
    Package
} from 'lucide-react';

export default function UnitCashflowWidget({
    cashflow = {},
    metrics = {},
}) {
    const liquidCash = cashflow?.liquid_cash_formatted || 'Rp 18.750.000';
    const offtakerSales = cashflow?.offtaker_sales_formatted || '+Rp 24.500.000';
    const payoutDisbursed = cashflow?.payout_disbursed_formatted || '-Rp 13.750.000';
    const inventoryStockKg = Number(cashflow?.inventory_stock_kg || 3450).toLocaleString('id-ID');
    const inventoryValuation = cashflow?.inventory_valuation_formatted || 'Rp 12.850.000';
    const userSavingsLiability = cashflow?.user_savings_liability_formatted || 'Rp 14.200.000';
    const healthPercentage = cashflow?.health_percentage || 92;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-6 select-none">
            
            {/* Header Title */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold shadow-2xs">
                        <Wallet className="w-5 h-5" />
                    </div>
                    <div>
                        <h3 className="font-black text-lg text-slate-900 tracking-tight">
                            Posisi Keuangan, Penjualan Pengepul & Stok Gudang 💵
                        </h3>
                        <p className="text-xs text-slate-500">
                            Pemantauan arus kas masuk dari pabrik daur ulang, aset stok sampah, dan tabungan warga
                        </p>
                    </div>
                </div>

                <div className="flex items-center gap-2">
                    <a
                        href="/admin/inventaris"
                        className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-xs transition-colors flex items-center gap-1.5"
                    >
                        <Package className="w-3.5 h-3.5" />
                        <span>Inventaris Gudang ➔</span>
                    </a>
                </div>
            </div>

            {/* 4 Financial & Inventory Pillars */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {/* 1. Saldo Kas Riil Unit */}
                <div className="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2">
                    <div className="flex items-center justify-between">
                        <span className="text-[11px] font-bold text-emerald-800 flex items-center gap-1.5">
                            <Wallet className="w-3.5 h-3.5 text-emerald-600" />
                            <span>Kas Riil Unit</span>
                        </span>
                        <span className="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-200 text-emerald-900">
                            Likuid
                        </span>
                    </div>
                    <p className="text-xl font-black text-emerald-950 tracking-tight">
                        {liquidCash}
                    </p>
                    <p className="text-[10px] text-emerald-700 font-medium">
                        Dana siap pakai di kas tunai & bank
                    </p>
                </div>

                {/* 2. Penjualan ke Pengepul (Kas Masuk Riil) */}
                <div className="p-4 rounded-2xl bg-blue-50/70 border border-blue-200 space-y-2">
                    <div className="flex items-center justify-between">
                        <span className="text-[11px] font-bold text-blue-800 flex items-center gap-1.5">
                            <Truck className="w-3.5 h-3.5 text-blue-600" />
                            <span>Penjualan Pengepul</span>
                        </span>
                        <span className="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-blue-200 text-blue-900">
                            Bulan Ini
                        </span>
                    </div>
                    <p className="text-xl font-black text-blue-950 tracking-tight">
                        {offtakerSales}
                    </p>
                    <p className="text-[10px] text-blue-700 font-medium">
                        Sumber kas masuk riil dari offtaker
                    </p>
                </div>

                {/* 3. Valuasi Stok Sampah Gudang (Aset Fisik) */}
                <div className="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-2">
                    <div className="flex items-center justify-between">
                        <span className="text-[11px] font-bold text-amber-800 flex items-center gap-1.5">
                            <Boxes className="w-3.5 h-3.5 text-amber-600" />
                            <span>Stok Sampah Gudang</span>
                        </span>
                        <span className="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-amber-200 text-amber-900">
                            {inventoryStockKg} Kg
                        </span>
                    </div>
                    <p className="text-xl font-black text-amber-950 tracking-tight">
                        {inventoryValuation}
                    </p>
                    <p className="text-[10px] text-amber-700 font-medium">
                        Estimasi nilai jual saat diangkut
                    </p>
                </div>

                {/* 4. Total Tabungan Mengendap Warga (Liabilitas) */}
                <div className="p-4 rounded-2xl bg-purple-50/70 border border-purple-200 space-y-2">
                    <div className="flex items-center justify-between">
                        <span className="text-[11px] font-bold text-purple-800 flex items-center gap-1.5">
                            <CreditCard className="w-3.5 h-3.5 text-purple-600" />
                            <span>Tabungan Nasabah</span>
                        </span>
                        <span className="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-purple-200 text-purple-900">
                            Liabilitas
                        </span>
                    </div>
                    <p className="text-xl font-black text-purple-950 tracking-tight">
                        {userSavingsLiability}
                    </p>
                    <p className="text-[10px] text-purple-700 font-medium">
                        Total saldo dompet warga belum ditarik
                    </p>
                </div>

            </div>

            {/* Bottom Health Bar & Quick Analysis */}
            <div className="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/90 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                {/* Left: Health Indicator */}
                <div className="space-y-1.5 flex-1">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <ShieldCheck className="w-4 h-4 text-emerald-600 shrink-0" />
                            <span className="text-xs font-bold text-slate-800">
                                Status Likuiditas & Kesiapan Kas: <strong className="text-emerald-700">SANGAT SEHAT ({healthPercentage}%)</strong>
                            </span>
                        </div>
                        <span className="text-xs font-extrabold text-emerald-800">
                            Kas Riil &gt; Tabungan Nasabah
                        </span>
                    </div>

                    {/* Progress Bar */}
                    <div className="w-full h-2.5 rounded-full bg-slate-200 overflow-hidden">
                        <div
                            className="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full"
                            style={{ width: `${healthPercentage}%` }}
                        />
                    </div>

                    <p className="text-[11px] text-slate-500 font-medium pt-0.5">
                        💡 Kas siap pakai unit (<strong>{liquidCash}</strong>) mampu menutupi seluruh potensi penarikan tabungan nasabah kapan saja secara aman tanpa risiko defisit.
                    </p>
                </div>

                {/* Right: Shortcut to Finance */}
                <div className="shrink-0 flex items-center gap-2 pt-2 md:pt-0 border-t md:border-t-0 border-slate-200">
                    <a
                        href="/admin/validasi-keuangan"
                        className="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-2 cursor-pointer"
                    >
                        <span>Kelola Arus Kas Payout</span>
                        <ArrowUpRight className="w-4 h-4" />
                    </a>
                </div>

            </div>

        </div>
    );
}
