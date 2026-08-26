import React, { useState, useMemo } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import AuditLogsHeroBanner from './sections/AuditLogsHeroBanner';
import AuditLogsKpiCards from './sections/AuditLogsKpiCards';
import AuditLogsFilterBar from './sections/AuditLogsFilterBar';
import AuditLogsTable from './sections/AuditLogsTable';
import AuditDiffModal from './sections/AuditDiffModal';

export default function SuperAdminAuditLogsPage({
    authData = {},
    logs = [],
    auditStats = {},
}) {
    const [activeCategory, setActiveCategory] = useState('all');
    const [selectedAction, setSelectedAction] = useState('all');
    const [selectedPeriod, setSelectedPeriod] = useState('all');
    const [searchQuery, setSearchQuery] = useState('');
    const [selectedLogForDiff, setSelectedLogForDiff] = useState(null);

    // Client-side filtering
    const filteredLogs = useMemo(() => {
        return logs.filter((log) => {
            // Category filter from KPI card
            if (activeCategory === 'auth' && !log.action.includes('BANK_SAMPAH')) return false;
            if (activeCategory === 'finance' && !log.action.includes('WITHDRAWAL')) return false;
            if (activeCategory === 'config' && (!log.action.includes('SETTINGS') && !log.action.includes('PRICE'))) return false;

            // Action dropdown filter
            if (selectedAction !== 'all' && !log.action.includes(selectedAction)) {
                return false;
            }

            // Search Query
            if (searchQuery.trim()) {
                const q = searchQuery.toLowerCase();
                const matchActor = (log.actor_name || '').toLowerCase().includes(q);
                const matchIp = (log.ip_address || '').toLowerCase().includes(q);
                const matchAction = (log.action || '').toLowerCase().includes(q);
                const matchReason = (log.reason || '').toLowerCase().includes(q);
                if (!matchActor && !matchIp && !matchAction && !matchReason) {
                    return false;
                }
            }

            return true;
        });
    }, [logs, activeCategory, selectedAction, searchQuery]);

    const handleExportCSV = () => {
        let csvContent = 'data:text/csv;charset=utf-8,Waktu,IP Address,Aktor,Role,Aksi,Entitas,Deskripsi\n';
        logs.forEach((l) => {
            const row = `"${l.created_at_formatted}","${l.ip_address}","${l.actor_name}","${l.actor_role}","${l.action}","${l.entity_type} #${l.entity_id}","${(l.reason || '').replace(/"/g, '""')}"`;
            csvContent += row + '\n';
        });
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `audit_logs_${new Date().toISOString().slice(0, 10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    return (
        <AdminAppLayout
            pageTitle="Audit Log Sistem"
            activeMenu="audit_logs"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Hero Banner */}
                <AuditLogsHeroBanner onExportLogs={handleExportCSV} />

                {/* 2. 4 Kartu KPI Keamanan */}
                <AuditLogsKpiCards
                    auditStats={auditStats}
                    activeCategory={activeCategory}
                    onSelectCategory={setActiveCategory}
                />

                {/* 3. Filter Bar */}
                <AuditLogsFilterBar
                    selectedAction={selectedAction}
                    onActionChange={setSelectedAction}
                    selectedPeriod={selectedPeriod}
                    onPeriodChange={setSelectedPeriod}
                    searchQuery={searchQuery}
                    onSearchChange={setSearchQuery}
                />

                {/* 4. Tabel Rekam Jejak Audit */}
                <AuditLogsTable
                    logs={filteredLogs}
                    onOpenDiffModal={(log) => setSelectedLogForDiff(log)}
                />
            </div>

            {/* Modal Diff Inspector */}
            <AuditDiffModal
                isOpen={!!selectedLogForDiff}
                onClose={() => setSelectedLogForDiff(null)}
                log={selectedLogForDiff}
            />
        </AdminAppLayout>
    );
}
