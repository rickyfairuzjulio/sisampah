import React, { useState, useMemo } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import MapHeroBanner from './sections/MapHeroBanner';
import MapKpiCards from './sections/MapKpiCards';
import MapFilterControls from './sections/MapFilterControls';
import InteractiveDistributionMap from './sections/InteractiveDistributionMap';
import UnitMapDrawer from './sections/UnitMapDrawer';
import BlankSpotInsights from './sections/BlankSpotInsights';

export default function SuperAdminMapPage({
    authData = {},
    bankSampahs = [],
    gisStats = {},
    blankSpots = [],
}) {
    const [statusFilter, setStatusFilter] = useState('all');
    const [showRadius, setShowRadius] = useState(true);
    const [searchQuery, setSearchQuery] = useState('');
    const [selectedProvinsi, setSelectedProvinsi] = useState('');
    const [selectedUnit, setSelectedUnit] = useState(null);

    // List of unique provinces
    const provinsiList = useMemo(() => {
        return Array.from(new Set(bankSampahs.map((b) => b.provinsi).filter(Boolean)));
    }, [bankSampahs]);

    // Filtered units
    const filteredUnits = useMemo(() => {
        return bankSampahs.filter((bs) => {
            if (statusFilter !== 'all' && bs.status !== statusFilter) {
                return false;
            }
            if (selectedProvinsi && bs.provinsi !== selectedProvinsi) {
                return false;
            }
            if (searchQuery.trim()) {
                const q = searchQuery.toLowerCase();
                const matchName = (bs.nama || '').toLowerCase().includes(q);
                const matchKode = (bs.kode_bank || '').toLowerCase().includes(q);
                const matchKec = (bs.kecamatan || '').toLowerCase().includes(q);
                if (!matchName && !matchKode && !matchKec) {
                    return false;
                }
            }
            return true;
        });
    }, [bankSampahs, statusFilter, selectedProvinsi, searchQuery]);

    const handleLocateMe = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    alert(`Lokasi GPS Anda terdeteksi di: Lat ${pos.coords.latitude.toFixed(4)}, Lng ${pos.coords.longitude.toFixed(4)}`);
                },
                () => alert('Gagal mengakses GPS browser.')
            );
        }
    };

    return (
        <AdminAppLayout
            pageTitle="Peta Sebaran GIS"
            activeMenu="map"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Hero Banner */}
                <MapHeroBanner />

                {/* 2. 4 Kartu KPI Geospasial */}
                <MapKpiCards gisStats={gisStats} />

                {/* 3. Filter Controls & Toolbar */}
                <MapFilterControls
                    statusFilter={statusFilter}
                    onStatusChange={setStatusFilter}
                    showRadius={showRadius}
                    onToggleRadius={setShowRadius}
                    searchQuery={searchQuery}
                    onSearchChange={setSearchQuery}
                    selectedProvinsi={selectedProvinsi}
                    onProvinsiChange={setSelectedProvinsi}
                    provinsiList={provinsiList}
                    onLocateMe={handleLocateMe}
                />

                {/* 4. Split Interactive Map + Flyout Drawer */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                    <div className="lg:col-span-2 min-h-[560px]">
                        <InteractiveDistributionMap
                            bankSampahs={filteredUnits}
                            selectedUnit={selectedUnit}
                            onSelectUnit={(unit) => setSelectedUnit(unit)}
                            showRadius={showRadius}
                        />
                    </div>

                    <div className="lg:col-span-1 min-h-[560px]">
                        <UnitMapDrawer
                            unit={selectedUnit}
                            onClose={() => setSelectedUnit(null)}
                        />
                    </div>
                </div>

                {/* 5. Blank Spot Analysis & Recommendation */}
                <BlankSpotInsights insights={blankSpots} />
            </div>
        </AdminAppLayout>
    );
}
