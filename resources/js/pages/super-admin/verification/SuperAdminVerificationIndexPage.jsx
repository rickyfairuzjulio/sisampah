import React, { useState } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import VerificationHeroBanner from './sections/VerificationHeroBanner';
import VerificationKpiCards from './sections/VerificationKpiCards';
import VerificationQueueTable from './sections/VerificationQueueTable';

export default function SuperAdminVerificationIndexPage({
    authData = {},
    stats = {},
    registrations = [],
    statusFilter = 'all',
    searchQuery = '',
}) {
    const [selectedFilter, setSelectedFilter] = useState(statusFilter || 'all');

    const totalPending = (stats.total_submitted || 0) + (stats.under_review || 0);

    return (
        <AdminAppLayout
            pageTitle="Verifikasi Bank Sampah"
            activeMenu="verification"
            authData={authData}
        >
            <div className="space-y-7 pb-12">
                {/* 1. Hero Banner */}
                <VerificationHeroBanner totalPending={totalPending} />

                {/* 2. 4 Kartu KPI Pipeline */}
                <VerificationKpiCards
                    stats={stats}
                    activeFilter={selectedFilter}
                    onSelectFilter={(key) => setSelectedFilter(key)}
                />

                {/* 3. Filter Tab & Tabel Antrean Pendaftaran */}
                <VerificationQueueTable
                    registrations={registrations}
                    stats={stats}
                    activeFilter={selectedFilter}
                    onSelectFilter={(key) => setSelectedFilter(key)}
                />
            </div>
        </AdminAppLayout>
    );
}
