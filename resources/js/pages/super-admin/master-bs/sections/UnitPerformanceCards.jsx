import React from 'react';

export default function UnitPerformanceCards({ unitDetail = {} }) {
    const cards = [
        {
            label: 'Total Warga Nasabah',
            value: (unitDetail.nasabah_count || 0).toLocaleString('id-ID'),
            unit: 'Nasabah',
            desc: 'Warga aktif menabung sampah',
            icon: 'bi-people-fill',
            color: 'text-sky-600 bg-sky-50 border-sky-200',
        },
        {
            label: 'Petugas Lapangan',
            value: (unitDetail.petugas_count || 0).toLocaleString('id-ID'),
            unit: 'Petugas',
            desc: 'Driver armada & timbangan',
            icon: 'bi-truck',
            color: 'text-indigo-600 bg-indigo-50 border-indigo-200',
        },
        {
            label: 'Total Sampah Terkelola',
            value: unitDetail.total_berat_ton || '45,8 Ton',
            unit: '',
            desc: 'Akumulasi daur ulang masuk',
            icon: 'bi-recycle',
            color: 'text-emerald-600 bg-emerald-50 border-emerald-200',
        },
        {
            label: 'Saldo Kas Unit',
            value: unitDetail.kas_unit_formatted || 'Rp 18.750.000',
            unit: '',
            desc: 'Posisi likuiditas kas lokal',
            icon: 'bi-wallet2',
            color: 'text-amber-600 bg-amber-50 border-amber-200',
        },
    ];

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {cards.map((c, idx) => (
                <div
                    key={idx}
                    className="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-3"
                >
                    <div className="flex items-center justify-between">
                        <span className="text-xs font-bold text-slate-500">{c.label}</span>
                        <div className={`w-8 h-8 rounded-xl flex items-center justify-center text-sm border ${c.color}`}>
                            <i className={`bi ${c.icon}`} />
                        </div>
                    </div>

                    <div className="flex items-baseline gap-1.5">
                        <span className="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            {c.value}
                        </span>
                        {c.unit && <span className="text-xs font-bold text-slate-400">{c.unit}</span>}
                    </div>

                    <p className="text-[11px] text-slate-400 font-medium">
                        {c.desc}
                    </p>
                </div>
            ))}
        </div>
    );
}
