import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import FinanceHeroBanner from './sections/FinanceHeroBanner';
import FinanceKpiCards from './sections/FinanceKpiCards';
import PendingPayoutsTable from './sections/PendingPayoutsTable';
import TreasuryLedgerTable from './sections/TreasuryLedgerTable';
import TopUpKasModal from './sections/TopUpKasModal';
import ApprovePayoutModal from './sections/ApprovePayoutModal';
import RejectPayoutModal from './sections/RejectPayoutModal';

export default function AdminFinancePage({
    authData = {},
    treasury = {},
    pendingWithdrawals = [],
    approvedWithdrawals = [],
    rejectedWithdrawals = [],
}) {
    const [isTopUpOpen, setIsTopUpOpen] = useState(false);
    const [selectedWithdrawalToApprove, setSelectedWithdrawalToApprove] = useState(null);
    const [selectedWithdrawalToReject, setSelectedWithdrawalToReject] = useState(null);

    const handleApproveGateway = (item) => {
        if (confirm(`Apakah Anda yakin ingin memproses payout ${item.nominal_formatted} untuk ${item.user_name} via Payment Gateway Iris Midtrans secara otomatis?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/validasi-keuangan/${item.id}/approve-gateway`;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <AdminAppLayout
            pageTitle="Keuangan"
            activeMenu="finance"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Kas Operasional Unit */}
                <FinanceHeroBanner
                    authData={authData}
                    treasury={treasury}
                    onOpenTopUp={() => setIsTopUpOpen(true)}
                />

                {/* 2. 4 Kartu KPI Finansial Unit */}
                <FinanceKpiCards
                    treasury={treasury}
                />

                {/* 3. Antrean Permohonan Penarikan Saldo (Payout) */}
                <PendingPayoutsTable
                    pendingWithdrawals={pendingWithdrawals}
                    approvedWithdrawals={approvedWithdrawals}
                    rejectedWithdrawals={rejectedWithdrawals}
                    onApproveManual={(item) => setSelectedWithdrawalToApprove(item)}
                    onApproveGateway={handleApproveGateway}
                    onReject={(item) => setSelectedWithdrawalToReject(item)}
                />

                {/* 4. Buku Kas Mutasi Dana Unit Bank Sampah */}
                <TreasuryLedgerTable />

            </div>

            {/* Modal Dialogs */}
            <TopUpKasModal
                isOpen={isTopUpOpen}
                onClose={() => setIsTopUpOpen(false)}
            />

            <ApprovePayoutModal
                isOpen={Boolean(selectedWithdrawalToApprove)}
                onClose={() => setSelectedWithdrawalToApprove(null)}
                withdrawal={selectedWithdrawalToApprove}
            />

            <RejectPayoutModal
                isOpen={Boolean(selectedWithdrawalToReject)}
                onClose={() => setSelectedWithdrawalToReject(null)}
                withdrawal={selectedWithdrawalToReject}
            />
        </AdminAppLayout>
    );
}
