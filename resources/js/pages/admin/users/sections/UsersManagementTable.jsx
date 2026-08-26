import React, { useState } from 'react';
import { Users, Truck, UserCheck, UserX, Edit3, Trash2, Phone, MapPin, CheckCircle2, AlertCircle, Sparkles, Wallet } from 'lucide-react';

export default function UsersManagementTable({
    users = [],
    onEditUser,
    onToggleStatus,
    onDeleteUser,
}) {
    const [activeTab, setActiveTab] = useState('all');

    const defaultUsers = [
        {
            id: 1,
            name: 'Joko Widodo (Pak RT)',
            email: 'petugas1@sisampah.id',
            phone: '081234567891',
            role: 'petugas',
            role_label: 'Petugas Lapangan',
            rt_rw: 'RT 01 - RT 03',
            address: 'Jl. Melati No. 12, RW 02',
            total_pickups: '142 Ritase',
            is_active: true,
            created_at_formatted: '12 Jan 2026',
        },
        {
            id: 2,
            name: 'Bambang Supriyanto',
            email: 'petugas2@sisampah.id',
            phone: '081234567892',
            role: 'petugas',
            role_label: 'Petugas Lapangan',
            rt_rw: 'RT 04 - RT 06',
            address: 'Jl. Anggrek No. 5, RW 02',
            total_pickups: '98 Ritase',
            is_active: true,
            created_at_formatted: '15 Jan 2026',
        },
        {
            id: 3,
            name: 'Dewi Lestari',
            email: 'dewi.lestari@gmail.com',
            phone: '081298765432',
            role: 'nasabah',
            role_label: 'Warga Nasabah',
            rt_rw: 'RT 01 / RW 02',
            address: 'Jl. Mawar No. 8',
            saldo_formatted: 'Rp 150.000',
            points: '1.500 Poin',
            is_active: true,
            created_at_formatted: '18 Jan 2026',
        },
        {
            id: 4,
            name: 'Ahmad Fauzi',
            email: 'ahmad.fauzi@gmail.com',
            phone: '081345678901',
            role: 'nasabah',
            role_label: 'Warga Nasabah',
            rt_rw: 'RT 02 / RW 02',
            address: 'Jl. Kenanga No. 22',
            saldo_formatted: 'Rp 85.000',
            points: '850 Poin',
            is_active: true,
            created_at_formatted: '20 Jan 2026',
        },
        {
            id: 5,
            name: 'Siti Rahmawati',
            email: 'siti.rahma@gmail.com',
            phone: '081567890123',
            role: 'nasabah',
            role_label: 'Warga Nasabah',
            rt_rw: 'RT 03 / RW 02',
            address: 'Jl. Melati Barat No. 14',
            saldo_formatted: 'Rp 320.000',
            points: '3.200 Poin',
            is_active: true,
            created_at_formatted: '22 Jan 2026',
        },
    ];

    const userList = users.length > 0 ? users : defaultUsers;

    const filteredUsers = userList.filter((u) => {
        if (activeTab === 'all') return true;
        if (activeTab === 'petugas') return u.role === 'petugas';
        if (activeTab === 'nasabah') return u.role === 'nasabah';
        if (activeTab === 'inactive') return !u.is_active;
        return true;
    });

    const petugasCount = userList.filter((u) => u.role === 'petugas').length;
    const nasabahCount = userList.filter((u) => u.role === 'nasabah').length;
    const inactiveCount = userList.filter((u) => !u.is_active).length;

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-2xs space-y-5 select-none">
            
            {/* Header & Role Filters */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 className="font-black text-lg text-slate-900 tracking-tight">
                        Daftar Pengguna Unit Bank Sampah 📋
                    </h3>
                    <p className="text-xs text-slate-500">
                        Kelola data keanggotaan nasabah warga dan armada petugas penjemputan
                    </p>
                </div>

                {/* Filter Tabs */}
                <div className="flex flex-wrap items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/80">
                    <button
                        type="button"
                        onClick={() => setActiveTab('all')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                            activeTab === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        Semua ({userList.length})
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('petugas')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'petugas' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <Truck className="w-3.5 h-3.5" />
                        <span>Petugas ({petugasCount})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('nasabah')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'nasabah' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <Users className="w-3.5 h-3.5" />
                        <span>Nasabah ({nasabahCount})</span>
                    </button>

                    <button
                        type="button"
                        onClick={() => setActiveTab('inactive')}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 ${
                            activeTab === 'inactive' ? 'bg-rose-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-900'
                        }`}
                    >
                        <UserX className="w-3.5 h-3.5" />
                        <span>Nonaktif ({inactiveCount})</span>
                    </button>
                </div>
            </div>

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="w-full text-left text-xs">
                    <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                            <th className="pb-3 px-3">Pengguna & Peran</th>
                            <th className="pb-3 px-3">Kontak & Wilayah</th>
                            <th className="pb-3 px-3">Performa / Keuangan</th>
                            <th className="pb-3 px-3">Status Akun</th>
                            <th className="pb-3 px-3">Bergabung</th>
                            <th className="pb-3 px-3 text-right">Aksi Kelola</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {filteredUsers.map((u) => {
                            const isPetugas = u.role === 'petugas';
                            return (
                                <tr key={u.id} className="hover:bg-slate-50/80 transition-colors">
                                    {/* Profil & Role */}
                                    <td className="py-3.5 px-3">
                                        <div className="flex items-center gap-3">
                                            {u.avatar_url ? (
                                                <img
                                                    src={u.avatar_url}
                                                    alt={u.name}
                                                    className="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0"
                                                />
                                            ) : (
                                                <div className={`w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 ${
                                                    isPetugas ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800'
                                                }`}>
                                                    {u.name ? u.name.charAt(0).toUpperCase() : 'U'}
                                                </div>
                                            )}
                                            <div>
                                                <p className="font-extrabold text-xs text-slate-900 leading-tight">
                                                    {u.name}
                                                </p>
                                                <p className="text-[10px] text-slate-400 font-mono mt-0.5">
                                                    {u.email}
                                                </p>
                                                <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[9px] font-extrabold mt-1 border ${
                                                    isPetugas ? 'bg-blue-50 text-blue-800 border-blue-200' : 'bg-emerald-50 text-emerald-800 border-emerald-200'
                                                }`}>
                                                    {isPetugas ? <Truck className="w-2.5 h-2.5 text-blue-600" /> : <Users className="w-2.5 h-2.5 text-emerald-600" />}
                                                    <span>{u.role_label}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {/* Kontak & Wilayah */}
                                    <td className="py-3.5 px-3">
                                        <div className="space-y-0.5">
                                            <span className="text-slate-800 font-semibold flex items-center gap-1">
                                                <Phone className="w-3 h-3 text-slate-400" />
                                                <span>{u.phone}</span>
                                            </span>
                                            <span className="text-slate-500 font-medium text-[11px] flex items-center gap-1">
                                                <MapPin className="w-3 h-3 text-slate-400" />
                                                <span>{u.rt_rw}</span>
                                            </span>
                                            <span className="text-[10px] text-slate-400 block truncate max-w-[180px]">
                                                {u.address}
                                            </span>
                                        </div>
                                    </td>

                                    {/* Performa / Saldo */}
                                    <td className="py-3.5 px-3">
                                        {isPetugas ? (
                                            <div className="space-y-0.5">
                                                <span className="text-xs font-black text-blue-700 block">
                                                    {u.total_pickups || '120 Ritase'}
                                                </span>
                                                <span className="text-[10px] text-slate-400 font-medium">
                                                    Penjemputan Armada
                                                </span>
                                            </div>
                                        ) : (
                                            <div className="space-y-0.5">
                                                <span className="text-xs font-black text-emerald-700 block">
                                                    {u.saldo_formatted || 'Rp 0'}
                                                </span>
                                                <span className="text-[10px] text-purple-700 font-bold flex items-center gap-1">
                                                    <Sparkles className="w-2.5 h-2.5" />
                                                    <span>{u.points || '0 Pts'}</span>
                                                </span>
                                            </div>
                                        )}
                                    </td>

                                    {/* Status */}
                                    <td className="py-3.5 px-3">
                                        {u.is_active ? (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                                <CheckCircle2 className="w-3 h-3 text-emerald-600" />
                                                <span>Aktif</span>
                                            </span>
                                        ) : (
                                            <span className="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200 inline-flex items-center gap-1">
                                                <AlertCircle className="w-3 h-3 text-rose-600" />
                                                <span>Nonaktif</span>
                                            </span>
                                        )}
                                    </td>

                                    {/* Bergabung */}
                                    <td className="py-3.5 px-3 font-medium text-slate-500 whitespace-nowrap">
                                        {u.created_at_formatted}
                                    </td>

                                    {/* Aksi */}
                                    <td className="py-3.5 px-3 text-right">
                                        <div className="flex items-center justify-end gap-1.5">
                                            <button
                                                type="button"
                                                onClick={() => onEditUser && onEditUser(u)}
                                                className="p-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-colors cursor-pointer"
                                                title="Edit Informasi User"
                                            >
                                                <Edit3 className="w-4 h-4" />
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => onToggleStatus && onToggleStatus(u)}
                                                className={`p-1.5 rounded-xl transition-colors cursor-pointer ${
                                                    u.is_active ? 'bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-700' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                                                }`}
                                                title={u.is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun'}
                                            >
                                                {u.is_active ? <UserX className="w-4 h-4" /> : <UserCheck className="w-4 h-4" />}
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() => onDeleteUser && onDeleteUser(u)}
                                                className="p-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition-colors cursor-pointer"
                                                title="Hapus Akun"
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>

        </div>
    );
}
