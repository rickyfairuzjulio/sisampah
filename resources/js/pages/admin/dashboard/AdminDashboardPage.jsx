import React from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import AdminHeroBanner from './sections/AdminHeroBanner';
import AdminKpiGrid from './sections/AdminKpiGrid';
import UnitCashflowWidget from './sections/UnitCashflowWidget';
import AdminChartsSection from './sections/AdminChartsSection';
import PendingWithdrawalsCard from './sections/PendingWithdrawalsCard';
import RecentTransactionsFeed from './sections/RecentTransactionsFeed';

export default function AdminDashboardPage({
    authData = {},
    metrics = {},
    cashflow = {},
    chartSetoran = { labels: [], data: [] },
    chartJenisSampah = { labels: [], data: [] },
    pendingWithdrawals = [],
    recentTransactions = [],
}) {
    return (
        <AdminAppLayout
            pageTitle="Dashboard Operasional"
            activeMenu="dashboard"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Operasional & Status Kas Unit */}
                <AdminHeroBanner
                    authData={authData}
                    metrics={metrics}
                />

                {/* 2. 4 Kartu KPI Metrik Operasional */}
                <AdminKpiGrid
                    metrics={metrics}
                />

                {/* 3. Posisi Keuangan, Penjualan Pengepul & Stok Gudang */}
                <UnitCashflowWidget
                    cashflow={cashflow}
                    metrics={metrics}
                />

                {/* 4. Dua Grafik Analitik Realtime */}
                <AdminChartsSection
                    chartSetoran={chartSetoran}
                    chartJenisSampah={chartJenisSampah}
                />

                {/* 5. Grid Operasional: Validasi Penarikan Saldo & Log Setoran */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {/* Left 6 Cols: Antrean Validasi Penarikan Saldo (Pending Payouts) */}
                    <div className="lg:col-span-6">
                        <PendingWithdrawalsCard
                            pendingWithdrawals={pendingWithdrawals}
                        />
                    </div>

                    {/* Right 6 Cols: Log Aktivitas Setoran Terbaru */}
                    <div className="lg:col-span-6">
                        <RecentTransactionsFeed
                            recentTransactions={recentTransactions}
                        />
                    </div>

                </div>

            </div>
        </AdminAppLayout>
    );
}
