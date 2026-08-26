import React from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import SuperAdminHeroBanner from './sections/SuperAdminHeroBanner';
import SuperAdminKpiCards from './sections/SuperAdminKpiCards';
import SuperAdminChartsSection from './sections/SuperAdminChartsSection';
import PendingVerificationWidget from './sections/PendingVerificationWidget';
import TopPerformingUnitsTable from './sections/TopPerformingUnitsTable';

export default function SuperAdminDashboardPage({
    authData = {},
    statistics = {},
    charts = {},
    pendingVerifications = [],
    topUnits = [],
}) {
    return (
        <AdminAppLayout
            pageTitle="Dashboard Nasional"
            activeMenu="dashboard"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Nasional Super Admin */}
                <SuperAdminHeroBanner
                    authData={authData}
                    statistics={statistics}
                />

                {/* 2. 4 Kartu KPI Statistik Nasional */}
                <SuperAdminKpiCards
                    statistics={statistics}
                />

                {/* 3 & 4. Grid Side-by-Side: Grafik Tren Nasional (2 Cols) & Antrean Verifikasi (1 Col) */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    
                    {/* Left: 2 Charts */}
                    <div className="lg:col-span-2">
                        <SuperAdminChartsSection
                            charts={charts}
                        />
                    </div>

                    {/* Right: Pending Verification Widget */}
                    <div className="lg:col-span-1">
                        <PendingVerificationWidget
                            pendingVerifications={pendingVerifications}
                        />
                    </div>

                </div>

                {/* 5. Tabel Peringkat Top 5 Bank Sampah Terbaik */}
                <TopPerformingUnitsTable
                    topUnits={topUnits}
                />

            </div>
        </AdminAppLayout>
    );
}
