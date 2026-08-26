import React from 'react';
import { Users, Truck, Wallet, CheckCircle2 } from 'lucide-react';

export default function UsersKpiCards({
    statistics = {},
}) {
    const totalNasabah = statistics?.total_nasabah || 128;
    const totalPetugas = statistics?.total_petugas || 4;
    const totalTabungan = statistics?.total_tabungan_formatted || 'Rp 14.200.000';
    const activeCount = statistics?.active_users_count || 132;

    const cards = [
        {
            title: 'Warga Nasabah Terdaftar',
            value: `${totalNasabah} Warga`,
            subtitle: 'Tersebar di RT 01 - RT 06',
            icon: Users,
            accentColor: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-200/80',
            badge: 'Warga Binaan',
            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        },
        {
            title: 'Armada Petugas Lapangan',
            value: `${totalPetugas} Petugas`,
            subtitle: 'Driver armada & teller pos timbang',
            icon: Truck,
            accentColor: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-200/80',
            badge: 'Armada Siaga',
            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200',
        },
        {
            title: 'Tabungan Mengendap Warga',
            value: totalTabungan,
            subtitle: 'Total saldo dompet nasabah unit',
            icon: Wallet,
            accentColor: 'text-purple-600',
            bgColor: 'bg-purple-50',
            borderColor: 'border-purple-200/80',
            badge: 'Kas Simpanan',
            badgeColor: 'bg-purple-100 text-purple-800 border-purple-200',
        },
        {
            title: 'Tingkat Keaktifan Pengguna',
            value: `${activeCount} Akun`,
            subtitle: 'Status aktif bertransaksi & bertugas',
            icon: CheckCircle2,
            accentColor: 'text-teal-600',
            bgColor: 'bg-teal-50',
            borderColor: 'border-teal-200/80',
            badge: '100% Aktif',
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
