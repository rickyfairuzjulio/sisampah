import React from 'react';
import { ArrowDownLeft, ArrowUpRight, PlusCircle, CheckCircle2, Wallet } from 'lucide-react';

export default function TreasuryLedgerTable() {
    const mutations = [
        {
            id: 1,
            date: '23 Agt 2026, 09:30 WIB',
            type: 'inflow',
            category: 'Penjualan Pengepul',
            description: 'Hasil penjualan 2.500 Kg Plastik PET ke PT Daur Ulang Nusantara',
            amount: 11250000,
            amountFormatted: '+Rp 11.250.000',
            balanceAfter: 'Rp 18.750.000',
        },
        {
            id: 2,
            date: '22 Agt 2026, 15:40 WIB',
            type: 'outflow',
            category: 'Payout Nasabah',
            description: 'Pencairan tabungan nasabah Dewi Lestari via Transfer BCA',
            amount: 100000,
            amountFormatted: '-Rp 100.000',
            balanceAfter: 'Rp 7.500.000',
        },
        {
            id: 3,
            date: '21 Agt 2026, 10:15 WIB',
            type: 'inflow',
            category: 'Top-Up Kas Operasional',
            description: 'Penambahan kas modal operasional dari Dana Kas Desa / Swadaya Unit',
            amount: 5000000,
            amountFormatted: '+Rp 5.000.000',
            balanceAfter: 'Rp 7.600.000',
        },
        {
            id: 4,
            date: '20 Agt 2026, 11:20 WIB',
            type: 'outflow',
            category: 'Payout Nasabah',
            description: 'Pencairan tabungan nasabah Ahmad Fauzi via Saldo DANA',
            amount: 50000,
            amountFormatted: '-Rp 50.000',
            balanceAfter: 'Rp 2.600.000',
        },
        {
            id: 5,
            date: '19 Agt 2026, 14:00 WIB',
            type: 'inflow',
            category: 'Penjualan Pengepul',
            description: 'Hasil penjualan 800 Kg Besi & Logam ke CV Logam Perkasa',
            amount: 7200000,
            amountFormatted: '+Rp 7.200.000',
            balanceAfter: 'Rp 2.650.000',
        },
    ];

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        <Wallet className="w-5 h-5" />
                    </div>
                    <div>
                        <h3 className="font-black text-lg text-slate-900 tracking-tight">
                            Buku Kas Mutasi Dana Unit Bank Sampah 📜
                        </h3>
                        <p className="text-xs text-slate-500">
                            Log pencatatan mutasi kas masuk dan kas keluar operasional
                        </p>
                    </div>
                </div>

                <span className="text-xs font-black text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 self-start sm:self-auto">
                    Arus Kas Bersih: +Rp 23.300.000
                </span>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs">
                    <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                            <th className="pb-3 px-3">Tanggal & Waktu</th>
                            <th className="pb-3 px-3">Kategori Mutasi</th>
                            <th className="pb-3 px-3">Deskripsi Transaksi</th>
                            <th className="pb-3 px-3 text-right">Nominal Arus Kas</th>
                            <th className="pb-3 px-3 text-right">Saldo Kas Akhir</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {mutations.map((row) => (
                            <tr key={row.id} className="hover:bg-slate-50/80 transition-colors">
                                <td className="py-3.5 px-3 font-semibold text-slate-500 whitespace-nowrap">
                                    {row.date}
                                </td>
                                <td className="py-3.5 px-3">
                                    <div className="flex items-center gap-1.5">
                                        {row.type === 'inflow' ? (
                                            <span className="p-1 rounded-lg bg-emerald-50 text-emerald-600">
                                                <ArrowDownLeft className="w-3.5 h-3.5" />
                                            </span>
                                        ) : (
                                            <span className="p-1 rounded-lg bg-rose-50 text-rose-600">
                                                <ArrowUpRight className="w-3.5 h-3.5" />
                                            </span>
                                        )}
                                        <span className="font-bold text-slate-800">{row.category}</span>
                                    </div>
                                </td>
                                <td className="py-3.5 px-3 font-medium text-slate-600">
                                    {row.description}
                                </td>
                                <td className={`py-3.5 px-3 text-right font-black ${
                                    row.type === 'inflow' ? 'text-emerald-700' : 'text-rose-700'
                                }`}>
                                    {row.amountFormatted}
                                </td>
                                <td className="py-3.5 px-3 text-right font-mono font-bold text-slate-900">
                                    {row.balanceAfter}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </div>
    );
}
