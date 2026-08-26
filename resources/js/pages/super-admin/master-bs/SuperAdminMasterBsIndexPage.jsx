import React, { useState, useMemo } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import MasterBsHeroBanner from './sections/MasterBsHeroBanner';
import MasterBsKpiCards from './sections/MasterBsKpiCards';
import MasterBsFilterBar from './sections/MasterBsFilterBar';
import MasterBsTable from './sections/MasterBsTable';
import CreateBankSampahModal from './sections/CreateBankSampahModal';
import EditBankSampahModal from './sections/EditBankSampahModal';
import ToggleStatusModal from './sections/ToggleStatusModal';

export default function SuperAdminMasterBsIndexPage({
    authData = {},
    stats = {},
    bankSampahs = [],
    provinsiList = [],
    kabupatenList = [],
    csrfToken = '',
}) {
    const [activeFilter, setActiveFilter] = useState('all');
    const [searchQuery, setSearchQuery] = useState('');
    const [selectedProvinsi, setSelectedProvinsi] = useState('');

    // Modals state
    const [isCreateOpen, setIsCreateOpen] = useState(false);
    const [selectedBsForEdit, setSelectedBsForEdit] = useState(null);
    const [selectedBsForStatus, setSelectedBsForStatus] = useState(null);

    // Client-side filtering
    const filteredBankSampahs = useMemo(() => {
        return bankSampahs.filter((bs) => {
            // Status match
            if (activeFilter !== 'all' && bs.status !== activeFilter) {
                return false;
            }
            // Provinsi match
            if (selectedProvinsi && bs.provinsi !== selectedProvinsi) {
                return false;
            }
            // Search query match
            if (searchQuery.trim()) {
                const q = searchQuery.toLowerCase();
                const matchName = (bs.nama || '').toLowerCase().includes(q);
                const matchKode = (bs.kode_bank || '').toLowerCase().includes(q);
                const matchPj = (bs.penanggung_jawab || '').toLowerCase().includes(q);
                const matchKec = (bs.kecamatan || '').toLowerCase().includes(q);
                if (!matchName && !matchKode && !matchPj && !matchKec) {
                    return false;
                }
            }
            return true;
        });
    }, [bankSampahs, activeFilter, selectedProvinsi, searchQuery]);

    return (
        <AdminAppLayout
            pageTitle="Master Bank Sampah"
            activeMenu="master_bs"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Hero Banner */}
                <MasterBsHeroBanner onOpenCreateModal={() => setIsCreateOpen(true)} />

                {/* 2. 4 Kartu KPI */}
                <MasterBsKpiCards
                    stats={stats}
                    activeFilter={activeFilter}
                    onSelectFilter={(key) => setActiveFilter(key)}
                />

                {/* 3. Filter Bar */}
                <MasterBsFilterBar
                    activeFilter={activeFilter}
                    onSelectFilter={(key) => setActiveFilter(key)}
                    stats={stats}
                    searchQuery={searchQuery}
                    onSearchChange={setSearchQuery}
                    selectedProvinsi={selectedProvinsi}
                    onProvinsiChange={setSelectedProvinsi}
                    provinsiList={provinsiList}
                />

                {/* 4. Tabel Direktori */}
                <MasterBsTable
                    bankSampahs={filteredBankSampahs}
                    onOpenEditModal={(bs) => setSelectedBsForEdit(bs)}
                    onOpenStatusModal={(bs) => setSelectedBsForStatus(bs)}
                />
            </div>

            {/* Modals */}
            <CreateBankSampahModal
                isOpen={isCreateOpen}
                onClose={() => setIsCreateOpen(false)}
                csrfToken={csrfToken}
            />

            <EditBankSampahModal
                isOpen={!!selectedBsForEdit}
                onClose={() => setSelectedBsForEdit(null)}
                bankSampah={selectedBsForEdit}
                csrfToken={csrfToken}
            />

            <ToggleStatusModal
                isOpen={!!selectedBsForStatus}
                onClose={() => setSelectedBsForStatus(null)}
                bankSampah={selectedBsForStatus}
                csrfToken={csrfToken}
            />
        </AdminAppLayout>
    );
}
