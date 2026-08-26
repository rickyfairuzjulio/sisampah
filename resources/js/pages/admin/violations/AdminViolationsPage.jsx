import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import ViolationsHeroBanner from './sections/ViolationsHeroBanner';
import ViolationsKpiCards from './sections/ViolationsKpiCards';
import ViolationsAuditTable from './sections/ViolationsAuditTable';
import CreateViolationModal from './sections/CreateViolationModal';

export default function AdminViolationsPage({
    authData = {},
    statistics = {},
    violationsList = [],
}) {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [violations, setViolations] = useState(violationsList);

    const handleResolve = (item) => {
        if (confirm(`Selesaikan kasus untuk "${item.user_name}"? Status akan diubah menjadi Selesai.`)) {
            setViolations(prev => prev.map(v => v.id === item.id ? { ...v, status: 'resolved' } : v));
            alert('Kasus berhasil ditandai sebagai Selesai Ditangani.');
        }
    };

    return (
        <AdminAppLayout
            pageTitle="Pelanggaran"
            activeMenu="violations"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
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
            />
        </AdminAppLayout>
    );
}
