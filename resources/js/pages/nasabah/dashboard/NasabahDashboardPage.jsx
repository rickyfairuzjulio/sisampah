import React, { useState } from 'react';
import NasabahAppLayout from '@/layouts/NasabahAppLayout';
import GamificationHero from './sections/GamificationHero';
import WalletAndKpiSection from './sections/WalletAndKpiSection';
import GisRadiusMapCard from './sections/GisRadiusMapCard';
import CarbonImpactSection from './sections/CarbonImpactSection';
import LivePricesMiniTable from './sections/LivePricesMiniTable';
import RecentTransactionsList from './sections/RecentTransactionsList';
import CommunityLeaderboard from './sections/CommunityLeaderboard';
import RatingModal from './components/RatingModal';

export default function NasabahDashboardPage({
    authData = {},
    gamification = {},
    kpiData = {},
    impact = {},
    chartData = {},
    prices = [],
    recentTransactions = [],
    leaderboard = [],
    bankSampahs = [],
}) {
    const [ratingModalOpen, setRatingModalOpen] = useState(false);
    const [selectedTrxId, setSelectedTrxId] = useState(null);

    const handleOpenRatingModal = (trxId) => {
        setSelectedTrxId(trxId);
        setRatingModalOpen(true);
    };

    return (
        <NasabahAppLayout
            pageTitle="Dashboard Nasabah"
            activeMenu="dashboard"
            authData={authData}
        >
            {/* 1. Sapaan & Gamifikasi Level */}
            <GamificationHero
                authData={authData}
                gamification={gamification}
            />

            {/* 2. SiSampah Pay & 3 KPI + 4 Quick Actions */}
            <WalletAndKpiSection
                kpiData={kpiData}
            />

            {/* 3. Peta GIS Radius Penjemputan */}
            <GisRadiusMapCard
                bankSampahs={bankSampahs}
                authData={authData}
            />

            {/* 4. Dampak Karbon & Grafik Bulanan */}
            <CarbonImpactSection
                impact={impact}
                chartData={chartData}
            />

            {/* 5. Bagian Bawah: Harga, Riwayat Setoran & Papan Peringkat */}
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                {/* Kolom Kiri (8 Kolom): Harga Terkini & Riwayat Transaksi */}
                <div className="lg:col-span-8 space-y-6">
                    <LivePricesMiniTable
                        prices={prices}
                    />
                    <RecentTransactionsList
                        recentTransactions={recentTransactions}
                        onOpenRatingModal={handleOpenRatingModal}
                    />
                </div>

                {/* Kolom Kanan (4 Kolom): Leaderboard & Tips */}
                <div className="lg:col-span-4">
                    <CommunityLeaderboard
                        leaderboard={leaderboard}
                        authData={authData}
                    />
                </div>

            </div>

            {/* 6. Modal Dialog Ulasan & Rating Bintang */}
            <RatingModal
                isOpen={ratingModalOpen}
                transactionId={selectedTrxId}
                onClose={() => setRatingModalOpen(false)}
            />

        </NasabahAppLayout>
    );
}
