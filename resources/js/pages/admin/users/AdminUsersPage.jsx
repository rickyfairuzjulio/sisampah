import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import UsersHeroBanner from './sections/UsersHeroBanner';
import UsersKpiCards from './sections/UsersKpiCards';
import UsersManagementTable from './sections/UsersManagementTable';
import CreateUserModal from './sections/CreateUserModal';
import EditUserModal from './sections/EditUserModal';

export default function AdminUsersPage({
    authData = {},
    statistics = {},
    usersList = [],
}) {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [createInitialRole, setCreateInitialRole] = useState('petugas');
    const [selectedUserToEdit, setSelectedUserToEdit] = useState(null);

    const handleOpenCreatePetugas = () => {
        setCreateInitialRole('petugas');
        setIsCreateModalOpen(true);
    };

    const handleOpenCreateNasabah = () => {
        setCreateInitialRole('nasabah');
        setIsCreateModalOpen(true);
    };

    const handleToggleStatus = (u) => {
        if (confirm(`Apakah Anda yakin ingin ${u.is_active ? 'menonaktifkan' : 'mengaktifkan'} akun ${u.name}?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${u.id}/toggle-status`;

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

    const handleDeleteUser = (u) => {
        if (confirm(`HAPUS PERMANEN: Apakah Anda yakin ingin menghapus akun ${u.name}? Tindakan ini tidak dapat dibatalkan.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${u.id}`;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);

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
            pageTitle="Pengguna"
            activeMenu="users"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Manajemen Pengguna */}
                <UsersHeroBanner
                    authData={authData}
                    statistics={statistics}
                    onOpenCreatePetugas={handleOpenCreatePetugas}
                    onOpenCreateNasabah={handleOpenCreateNasabah}
                />

                {/* 2. 4 Kartu KPI Statistik Pengguna */}
                <UsersKpiCards
                    statistics={statistics}
                />

                {/* 3. Filter Tab & Tabel Manajemen Pengguna */}
                <UsersManagementTable
                    users={usersList}
                    onEditUser={(u) => setSelectedUserToEdit(u)}
                    onToggleStatus={handleToggleStatus}
                    onDeleteUser={handleDeleteUser}
                />

            </div>

            {/* Modal Dialogs */}
            <CreateUserModal
                isOpen={isCreateModalOpen}
                onClose={() => setIsCreateModalOpen(false)}
                initialRole={createInitialRole}
            />

            <EditUserModal
                isOpen={Boolean(selectedUserToEdit)}
                onClose={() => setSelectedUserToEdit(null)}
                user={selectedUserToEdit}
            />
        </AdminAppLayout>
    );
}
