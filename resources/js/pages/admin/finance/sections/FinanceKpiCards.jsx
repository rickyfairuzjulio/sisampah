import React from 'react';
import { Wallet, CreditCard, Truck, ArrowUpRight, ArrowDownRight, Banknote } from 'lucide-react';

export default function FinanceKpiCards({
    treasury = {},
}) {
    const kasUnit = treasury?.kas_unit_formatted || 'Rp 18.750.000';
    const totalSaldoNasabah = treasury?.total_saldo_nasabah_formatted || 'Rp 14.200.000';
    const totalPenjualan = treasury?.total_penjualan_pengepul_formatted || 'Rp 24.500.000';
    const totalPayout = treasury?.total_payout_disetujui_formatted || 'Rp 13.750.000';

    const cards = [
        {
            title: 'Kas Siap Pakai Unit',
            value: kasUnit,
            subtitle: 'Dana tunai & rekening kasir unit',
            icon: Wallet,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Kas Likuid',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Tabungan Warga Nasabah',
            value: totalSaldoNasabah,
            subtitle: 'Total saldo dompet belum ditarik',
            icon: CreditCard,
            accentColor: 'text-purple-600',
            bgColor: 'bg-purple-50',
            borderColor: 'border-purple-200/80',
            badge: 'Liabilitas Unit',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
        },
        {
            title: 'Kas Masuk Jual Pengepul',
            value: totalPenjualan,
            subtitle: 'Pendapatan riil dari pabrik daur ulang',
            icon: Truck,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Pemasukan Riil',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
        },
        {
            title: 'Total Payout Dicairkan',
            value: totalPayout,
            subtitle: 'Akumulasi dana telah dibayarkan',
            icon: Banknote,
            accentColor: 'text-rose-600',
            bgColor: 'bg-rose-50',
            borderColor: 'border-rose-200/80',
            badge: 'Pengeluaran Kas',
            badgeColor: 'bg-rose-100 text-rose-800 border-rose-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 select-none">
            {cards.map((item, idx) => {
                const IconComponent = item.icon;
                return (
                    <div
                        key={idx}
                        className={`bg-white border ${item.borderColor} rounded-3xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4`}
                    >
                        <div className="flex items-center justify-between">
                            <div className={`w-11 h-11 rounded-2xl flex items-center justify-center font-bold ${item.bgColor} ${item.accentColor} shadow-2xs`}>
                                <IconComponent className="w-5 h-5" />
                            </div>
                            <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${item.badgeColor}`}>
                                {item.badge}
                            </span>
                        </div>

                        <div className="space-y-1">
                            <p className="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {item.title}
                            </p>
                            <h3 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {item.value}
                            </h3>
                            <p className="text-xs text-slate-400 font-medium truncate">
                                {item.subtitle}
                            </p>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
