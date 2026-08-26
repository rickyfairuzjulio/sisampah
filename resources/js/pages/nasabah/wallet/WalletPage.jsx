import React, { useState } from 'react';
import { CheckCircle2, AlertCircle } from 'lucide-react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import WalletBalanceCard from './sections/WalletBalanceCard';
import WalletSummaryKpi from './sections/WalletSummaryKpi';
import WalletTransactionsFeed from './sections/WalletTransactionsFeed';
import WithdrawalModal from './sections/WithdrawalModal';

export default function WalletPage({
    authData = {},
    saldo = 0,
    walletStats = {},
    depositTransactions = [],
    withdrawals = [],
    csrfToken = '',
    sessionStatus = '',
    sessionError = '',
}) {
    const [isWithdrawOpen, setIsWithdrawOpen] = useState(false);

    return (
        <NasabahAppLayout
            pageTitle="SiSampay"
            activeMenu="wallet"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Flash Messages */}
                {sessionStatus && (
                    <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm animate-slide-in">
                        <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
                        <span>{sessionStatus}</span>
                    </div>
                )}

                {sessionError && (
                    <div className="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm animate-slide-in">
                        <AlertCircle className="w-5 h-5 text-red-600 shrink-0" />
                        <span>{sessionError}</span>
                    </div>
                )}

                {/* 2. Virtual Card SiSampay */}
                <WalletBalanceCard
                    authData={authData}
                    onOpenWithdrawModal={() => setIsWithdrawOpen(true)}
                />

                {/* 3. 3 Financial KPI Summary Cards */}
                <WalletSummaryKpi walletStats={walletStats} />

                {/* 4. Transactions Feed with Multi-Tabs */}
                <WalletTransactionsFeed
                    depositTransactions={depositTransactions}
                    withdrawals={withdrawals}
                    csrfToken={csrfToken}
                />

                {/* 5. Withdrawal Modal */}
                <WithdrawalModal
                    isOpen={isWithdrawOpen}
                    onClose={() => setIsWithdrawOpen(false)}
                    saldo={saldo}
                    csrfToken={csrfToken}
                />

            </div>
        </NasabahAppLayout>
    );
}
