import React from 'react';
import { Award, Building2, Users, Scale, CheckCircle2, ChevronRight, Wallet } from 'lucide-react';

export default function TopPerformingUnitsTable({
    topUnits = [],
}) {
    const defaultTop = [
        {
            rank: 1,
            id: 1,
            nama: 'Bank Sampah Unit Melati Asri',
            city: 'Kota Semarang, Jawa Tengah',
            active_citizens: 1240,
            total_waste_tons: '45.8 Ton',
            total_savings_formatted: 'Rp 14.200.000',
            status: 'Sangat Aktif',
        },
        {
            rank: 2,
            id: 2,
            nama: 'Bank Sampah Hijau Lestari',
            city: 'Kota Yogyakarta, DIY',
            active_citizens: 980,
            total_waste_tons: '38.2 Ton',
            total_savings_formatted: 'Rp 11.850.000',
            status: 'Sangat Aktif',
        },
        {
            rank: 3,
            id: 3,
            nama: 'Bank Sampah Karya Bersama',
            city: 'Kota Surakarta, Jawa Tengah',
            active_citizens: 850,
            total_waste_tons: '31.5 Ton',
            total_savings_formatted: 'Rp 9.400.000',
            status: 'Aktif',
        },
        {
            rank: 4,
            id: 4,
            nama: 'Bank Sampah Mandiri Jaya',
            city: 'Kab. Sleman, DIY',
            active_citizens: 720,
            total_waste_tons: '26.4 Ton',
            total_savings_formatted: 'Rp 8.100.000',
            status: 'Aktif',
        },
        {
            rank: 5,
            id: 5,
            nama: 'Bank Sampah Barokah Resik',
            city: 'Kota Malang, Jawa Timur',
            active_citizens: 640,
            total_waste_tons: '22.1 Ton',
            total_savings_formatted: 'Rp 6.750.000',
            status: 'Aktif',
        },
    ];

    const list = topUnits.length > 0 ? topUnits : defaultTop;

    const getMedal = (rank) => {
        if (rank === 1) return '🥇 Juara 1';
        if (rank === 2) return '🥈 Juara 2';
        if (rank === 3) return '🥉 Juara 3';
        return `#${rank}`;
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Peringkat Top 5 Bank Sampah Terbaik Nasional 🏆
                    </h3>
                    <p className="text-xs text-slate-500">
                        Unit mitra dengan capaian tonase pemulihan dan partisipasi nasabah tertinggi di Indonesia
                    </p>
                </div>

                <a
                    href="/super-admin/master-bank-sampah"
                    className="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1 cursor-pointer"
                >
                    <span>Lihat Seluruh 24 Unit Mitra</span>
                    <ChevronRight className="w-4 h-4" />
                </a>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs">
                    <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                            <th className="pb-3 px-3">Peringkat</th>
                            <th className="pb-3 px-3">Unit Bank Sampah</th>
                            <th className="pb-3 px-3">Nasabah Terdaftar</th>
                            <th className="pb-3 px-3">Total Sampah Terkelola</th>
                            <th className="pb-3 px-3">Tabungan Mengendap</th>
                            <th className="pb-3 px-3">Status Operasional</th>
                            <th className="pb-3 px-3 text-right">Detail Unit</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {list.map((unit) => (
                            <tr key={unit.id} className="hover:bg-slate-50/80 transition-colors">
                                {/* Rank */}
                                <td className="py-3.5 px-3">
                                    <span className={`px-2.5 py-1 rounded-xl text-xs font-black ${
                                        unit.rank === 1 ? 'bg-amber-100 text-amber-900 border border-amber-300' :
                                        unit.rank === 2 ? 'bg-slate-200 text-slate-800' :
                                        unit.rank === 3 ? 'bg-amber-50 text-amber-800' :
                                        'bg-slate-100 text-slate-600'
                                    }`}>
                                        {getMedal(unit.rank)}
                                    </span>
                                </td>

                                {/* Unit Name & City */}
                                <td className="py-3.5 px-3">
                                    <div className="flex items-center gap-3">
                                        <div className="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0">
                                            <Building2 className="w-5 h-5 text-emerald-700" />
                                        </div>
                                        <div>
                                            <p className="font-extrabold text-xs text-slate-900 leading-tight">
                                                {unit.nama}
                                            </p>
                                            <p className="text-[10px] text-slate-500 mt-0.5">
                                                {unit.city}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {/* Nasabah */}
                                <td className="py-3.5 px-3 font-semibold text-slate-800 whitespace-nowrap">
                                    {unit.active_citizens.toLocaleString('id-ID')} Warga
                                </td>

                                {/* Total Sampah */}
                                <td className="py-3.5 px-3 font-black text-emerald-700 whitespace-nowrap">
                                    {unit.total_waste_tons}
                                </td>

                                {/* Tabungan Mengendap */}
                                <td className="py-3.5 px-3 font-bold text-purple-700 whitespace-nowrap">
                                    {unit.total_savings_formatted || 'Rp 10.000.000'}
                                </td>

                                {/* Status */}
                                <td className="py-3.5 px-3">
                                    <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                        <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                        <span>{unit.status}</span>
                                    </span>
                                </td>

                                {/* Action */}
                                <td className="py-3.5 px-3 text-right">
                                    <a
                                        href={`/super-admin/master-bank-sampah/${unit.id}`}
                                        className="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-[11px] transition-colors inline-flex items-center gap-1 cursor-pointer"
                                    >
                                        <span>Buka Profil</span>
                                        <ChevronRight className="w-3 h-3" />
                                    </a>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </div>
    );
}
