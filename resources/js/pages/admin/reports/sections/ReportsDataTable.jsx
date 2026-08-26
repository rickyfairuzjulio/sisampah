import React from 'react';
import { FileSpreadsheet, CheckCircle2, Truck, User } from 'lucide-react';

export default function ReportsDataTable({
    transactions = [],
}) {
    const defaultTx = [
        {
            id: 1,
            date_formatted: '24 Agt 2026, 09:30',
            user_name: 'Dewi Lestari',
            user_rt_rw: 'RT 01 / RW 02',
            category_name: 'Plastik Botol PET Bersih',
            berat_kg: 18.5,
            total_rp_formatted: 'Rp 74.000',
            tipe_setoran: 'jemput',
            petugas_name: 'Pak Joko (Driver 01)',
            status: 'selesai',
        },
        {
            id: 2,
            date_formatted: '24 Agt 2026, 08:45',
            user_name: 'Budi Santoso',
            user_rt_rw: 'RT 02 / RW 02',
            category_name: 'Kardus Box Cokelat Bagus',
            berat_kg: 32.0,
            total_rp_formatted: 'Rp 80.000',
            tipe_setoran: 'mandiri',
            petugas_name: 'Bambang (Pos Timbang)',
            status: 'selesai',
        },
        {
            id: 3,
            date_formatted: '23 Agt 2026, 16:15',
            user_name: 'Ahmad Fauzi',
            user_rt_rw: 'RT 03 / RW 02',
            category_name: 'Minyak Jelantah Murni',
            berat_kg: 12.0,
            total_rp_formatted: 'Rp 90.000',
            tipe_setoran: 'jemput',
            petugas_name: 'Pak Joko (Driver 01)',
            status: 'selesai',
        },
        {
            id: 4,
            date_formatted: '23 Agt 2026, 14:00',
            user_name: 'Siti Rahmawati',
            user_rt_rw: 'RT 05 / RW 02',
            category_name: 'Besi Padat & Logam',
            berat_kg: 25.4,
            total_rp_formatted: 'Rp 127.000',
            tipe_setoran: 'jemput',
            petugas_name: 'Pak Joko (Driver 01)',
            status: 'selesai',
        },
    ];

    const txList = transactions.length > 0 ? transactions : defaultTx;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Rincian Transaksi Operasional Timbangan 📋
                    </h3>
                    <p className="text-xs text-slate-500">
                        Daftar lengkap nota timbangan dan perputaran saldo nasabah yang terfilter ({txList.length} Transaksi)
                    </p>
                </div>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs">
                    <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                            <th className="pb-3 px-3">Waktu Transaksi</th>
                            <th className="pb-3 px-3">Warga Nasabah</th>
                            <th className="pb-3 px-3">Kategori Material</th>
                            <th className="pb-3 px-3">Berat (Kg)</th>
                            <th className="pb-3 px-3">Nilai Setoran (Rp)</th>
                            <th className="pb-3 px-3">Metode & Petugas</th>
                            <th className="pb-3 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {txList.map((tx) => (
                            <tr key={tx.id} className="hover:bg-slate-50/80 transition-colors">
                                {/* Waktu */}
                                <td className="py-3.5 px-3 font-semibold text-slate-700 whitespace-nowrap">
                                    {tx.date_formatted}
                                </td>

                                {/* Warga Nasabah */}
                                <td className="py-3.5 px-3">
                                    <div className="space-y-0.5">
                                        <p className="font-extrabold text-xs text-slate-900 leading-tight">
                                            {tx.user_name}
                                        </p>
                                        <span className="text-[10px] text-slate-400 font-medium">
                                            {tx.user_rt_rw}
                                        </span>
                                    </div>
                                </td>

                                {/* Kategori */}
                                <td className="py-3.5 px-3">
                                    <span className="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                        {tx.category_name}
                                    </span>
                                </td>

                                {/* Berat */}
                                <td className="py-3.5 px-3 font-black text-slate-900 whitespace-nowrap">
                                    {Number(tx.berat_kg).toFixed(1)} Kg
                                </td>

                                {/* Nilai */}
                                <td className="py-3.5 px-3 font-black text-emerald-700 whitespace-nowrap">
                                    {tx.total_rp_formatted}
                                </td>

                                {/* Metode & Petugas */}
                                <td className="py-3.5 px-3">
                                    <div className="space-y-0.5">
                                        <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-extrabold border ${
                                            tx.tipe_setoran === 'jemput' ? 'bg-blue-50 text-blue-800 border-blue-200' : 'bg-purple-50 text-purple-800 border-purple-200'
                                        }`}>
                                            {tx.tipe_setoran === 'jemput' ? <Truck className="w-2.5 h-2.5 text-blue-600" /> : <User className="w-2.5 h-2.5 text-purple-600" />}
                                            <span className="capitalize">{tx.tipe_setoran}</span>
                                        </span>
                                        <p className="text-[10px] text-slate-400 truncate max-w-[130px]">
                                            {tx.petugas_name}
                                        </p>
                                    </div>
                                </td>

                                {/* Status */}
                                <td className="py-3.5 px-3 text-right">
                                    <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                        <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                        <span>Selesai</span>
                                    </span>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </div>
    );
}
