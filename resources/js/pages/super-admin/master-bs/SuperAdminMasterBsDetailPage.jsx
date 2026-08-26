import React, { useState } from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import MasterBsDetailHeader from './sections/MasterBsDetailHeader';
import UnitPerformanceCards from './sections/UnitPerformanceCards';
import UnitDetailTabs from './sections/UnitDetailTabs';
import EditBankSampahModal from './sections/EditBankSampahModal';
import ToggleStatusModal from './sections/ToggleStatusModal';

export default function SuperAdminMasterBsDetailPage({
    authData = {},
    unitDetail = {},
    admins = [],
    petugas = [],
    prices = [],
    transactions = [],
    csrfToken = '',
}) {
    const [isEditOpen, setIsEditOpen] = useState(false);
    const [isStatusOpen, setIsStatusOpen] = useState(false);

    const handleDelete = () => {
        if (confirm(`HAPUS PERMANEN: Apakah Anda yakin ingin menghapus unit bank sampah "${unitDetail.nama}" dari sistem?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/super-admin/master-bank-sampah/${unitDetail.id}`;

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;
            form.appendChild(tokenInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <AdminAppLayout
            pageTitle={`Unit: ${unitDetail.nama}`}
            activeMenu="master_bs"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Header Detail */}
                <MasterBsDetailHeader
                    unitDetail={unitDetail}
                    onOpenEditModal={() => setIsEditOpen(true)}
                    onOpenStatusModal={() => setIsStatusOpen(true)}
                    onDeleteUnit={handleDelete}
                />

                {/* 2. 4 Kartu Metrik Performa */}
                <UnitPerformanceCards unitDetail={unitDetail} />

                {/* 3. Tabulasi Informasi */}
                <UnitDetailTabs
                    unitDetail={unitDetail}
                    admins={admins}
                    petugas={petugas}
                    prices={prices}
                    transactions={transactions}
                />
            </div>

            {/* Modals */}
            <EditBankSampahModal
                isOpen={isEditOpen}
                onClose={() => setIsEditOpen(false)}
                bankSampah={unitDetail}
                csrfToken={csrfToken}
            />

            <ToggleStatusModal
                isOpen={isStatusOpen}
                onClose={() => setIsStatusOpen(false)}
                bankSampah={unitDetail}
                csrfToken={csrfToken}
            />
        </AdminAppLayout>
    );
}
