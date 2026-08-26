import React from 'react';
import PetugasAppLayout from '../../../layouts/PetugasAppLayout';
import PetugasHeroBanner from './sections/PetugasHeroBanner';
import PetugasKpiStats from './sections/PetugasKpiStats';
import PickupManifestList from './sections/PickupManifestList';
import RecentWeighingHistory from './sections/RecentWeighingHistory';

export default function PetugasDashboardPage({
    authData = {},
    kpiData = {},
    pickupManifest = [],
    recentWeighings = [],
}) {
    return (
        <PetugasAppLayout
            pageTitle="Dashboard Manifes"
            activeMenu="manifest"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner */}
                <PetugasHeroBanner 
                    authData={authData}
                />

                {/* 2. 3 KPI Statistik Harian */}
                <PetugasKpiStats 
                    kpiData={kpiData}
                />

                {/* 3. Grid Manifes Jemput & Riwayat Penimbangan */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {/* Left 8 Cols: Daftar Manifes Jemput */}
                    <div className="lg:col-span-8">
                        <PickupManifestList 
                            pickupManifest={pickupManifest}
                        />
                    </div>

                    {/* Right 4 Cols: Riwayat Selesai Hari Ini */}
                    <div className="lg:col-span-4">
                        <RecentWeighingHistory 
                            recentWeighings={recentWeighings}
                        />
                    </div>

                </div>

            </div>
        </PetugasAppLayout>
    );
}
