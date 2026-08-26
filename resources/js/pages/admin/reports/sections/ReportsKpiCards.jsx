import React from 'react';
import { Scale, Wallet, Truck, TrendingUp } from 'lucide-react';

export default function ReportsKpiCards({
    summary = {},
}) {
    const tonase = summary?.total_tonase_formatted || '45.820 Kg';
    const nilaiWarga = summary?.total_nilai_formatted || 'Rp 137.460.000';
    const penjualan = summary?.total_penjualan_formatted || 'Rp 184.250.000';
    const surplus = summary?.net_surplus_formatted || 'Rp 46.790.000';

    const cards = [
        {
            title: 'Total Sampah Dikelola',
            value: tonase,
            subtitle: 'Akumulasi seluruh jenis material',
            icon: Scale,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Tonase Bersih',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Total Saldo Setoran Warga',
            value: nilaiWarga,
            subtitle: 'Kredit dompet yang disalurkan ke nasabah',
            icon: Wallet,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Beban Pembelian',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
        },
        {
            title: 'Penjualan ke Pengepul',
            value: penjualan,
            subtitle: 'Pendapatan kotor offtaker pabrik daur ulang',
            icon: Truck,
            accentColor: 'text-purple-600',
            bgColor: 'bg-purple-50',
            borderColor: 'border-purple-200/80',
            badge: 'Pemasukan Unit',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
        },
        {
            title: 'Margin Surplus Bersih',
            value: surplus,
            subtitle: 'Selisih keuntungan operasional kas unit',
            icon: TrendingUp,
            accentColor: 'text-teal-600',
            bgColor: 'bg-teal-50',
            borderColor: 'border-teal-200/80',
            badge: '+34% Margin',
            badgeColor: 'bg-teal-100 text-teal-800 border-teal-200',
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
