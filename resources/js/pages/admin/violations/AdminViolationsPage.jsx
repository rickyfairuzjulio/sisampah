import React, { useState } from 'react';
import { router } from '@inertiajs/react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import ViolationsHeroBanner from './sections/ViolationsHeroBanner';
import ViolationsKpiCards from './sections/ViolationsKpiCards';
import ViolationsAuditTable from './sections/ViolationsAuditTable';
import CreateViolationModal from './sections/CreateViolationModal';

export default function AdminViolationsPage({
    authData = {},
    statistics = {},
    violationsList = [],
    usersDropdown = [],
    csrfToken = '',
}) {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [violations, setViolations] = useState(violationsList);
    const [alertMessage, setAlertMessage] = useState(null);

    const handleResolve = async (item) => {
        const note = prompt(`Masukkan catatan penyelesaian sanksi untuk "${item.user_name}":`, 'Kasus telah diklarifikasi dan diselesaikan dengan warga.');
        if (note === null) return;

        try {
            const token = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch(`/admin/pelanggaran/${item.id}/resolve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    catatan_penyelesaian: note,
                    sanksi: item.sanction,
                }),
            });

            const resData = await response.json();
            if (response.ok && resData.success) {
                setViolations(prev => prev.map(v => v.id === item.id ? { ...v, status: 'resolved', catatan_penyelesaian: note } : v));
                setAlertMessage({ type: 'success', text: resData.message || 'Kasus berhasil diselesaikan.' });
                setTimeout(() => setAlertMessage(null), 4000);
            } else {
                alert(resData.message || 'Gagal menyelesaikan kasus.');
            }
        } catch (err) {
            console.error('Error resolving violation:', err);
            alert('Terjadi kesalahan jaringan.');
        }
    };

    return (
        <AdminAppLayout
            pageTitle="Pelanggaran"
            activeMenu="violations"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                {alertMessage && (
                    <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold animate-slide-in flex items-center justify-between">
                        <span>{alertMessage.text}</span>
                        <button onClick={() => setAlertMessage(null)} className="text-emerald-600 hover:text-emerald-900 font-black cursor-pointer">×</button>
                    </div>
                )}
                
                {/* 1. Hero Banner Pelanggaran & Audit */}
                <ViolationsHeroBanner
                    authData={authData}
                    statistics={statistics}
                    onOpenCreate={() => setIsCreateModalOpen(true)}
                />

                {/* 2. 4 Kartu KPI Statistik Pelanggaran */}
                <ViolationsKpiCards
                    statistics={statistics}
                />

                {/* 3. Filter Tab & Tabel Catatan Audit */}
                <ViolationsAuditTable
                    violations={violations}
                    onResolveViolation={handleResolve}
                />

            </div>

            {/* Modal Dialogs */}
            <CreateViolationModal
                isOpen={isCreateModalOpen}
                onClose={() => setIsCreateModalOpen(false)}
                usersDropdown={usersDropdown}
                csrfToken={csrfToken}
                onSuccess={(msg) => {
                    router.reload({ only: ['statistics', 'violationsList'] });
                }}
            />
        </AdminAppLayout>
    );
}
