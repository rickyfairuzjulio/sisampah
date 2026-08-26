import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import ReportsHeroBanner from './sections/ReportsHeroBanner';
import ReportsKpiCards from './sections/ReportsKpiCards';
import ReportsFilterToolbar from './sections/ReportsFilterToolbar';
import ReportsDataTable from './sections/ReportsDataTable';

export default function AdminReportsPage({
    authData = {},
    summary = {},
    transactionsList = [],
    rtList = [],
    rwList = [],
}) {
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [selectedRt, setSelectedRt] = useState('');
    const [selectedRw, setSelectedRw] = useState('');

    const handleApplyFilter = (e) => {
        if (e) e.preventDefault();
        const params = new URLSearchParams();
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);
        if (selectedRt) params.append('rt', selectedRt);
        if (selectedRw) params.append('rw', selectedRw);

        window.location.href = `/admin/laporan?${params.toString()}`;
    };

    const handleResetFilter = () => {
        window.location.href = '/admin/laporan';
    };

    const handleExportCSV = () => {
        const params = new URLSearchParams();
        if (startDate) params.append('start_date', startDate);
        if (endDate) params.append('end_date', endDate);
        if (selectedRt) params.append('rt', selectedRt);
        if (selectedRw) params.append('rw', selectedRw);

        window.location.href = `/admin/laporan/export?${params.toString()}`;
    };

    const handlePrintPDF = () => {
        window.print();
    };

    return (
        <AdminAppLayout
            pageTitle="Laporan"
            activeMenu="reports"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Laporan */}
                <ReportsHeroBanner
                    authData={authData}
                    summary={summary}
                    onExportCSV={handleExportCSV}
                    onPrintPDF={handlePrintPDF}
                />

                {/* 2. 4 Kartu KPI Ringkasan Laporan */}
                <ReportsKpiCards
                    summary={summary}
                />

                {/* 3. Filter Toolbar Rentang Tanggal & Wilayah */}
                <ReportsFilterToolbar
                    startDate={startDate}
                    setStartDate={setStartDate}
                    endDate={endDate}
                    setEndDate={setEndDate}
                    selectedRt={selectedRt}
                    setSelectedRt={setSelectedRt}
                    selectedRw={selectedRw}
                    setSelectedRw={setSelectedRw}
                    rtList={rtList}
                    rwList={rwList}
                    onApplyFilter={handleApplyFilter}
                    onResetFilter={handleResetFilter}
                />

                {/* 4. Tabel Rincian Data Transaksi */}
                <ReportsDataTable
                    transactions={transactionsList}
                />

            </div>
        </AdminAppLayout>
    );
}
