import React, { useState } from 'react';
import PetugasAppLayout from '../../../layouts/PetugasAppLayout';
import PetugasProfileHeroCard from './sections/PetugasProfileHeroCard';
import PetugasPerformanceStats from './sections/PetugasPerformanceStats';
import PetugasInfoForm from './sections/PetugasInfoForm';
import PetugasSecurityForm from './sections/PetugasSecurityForm';

export default function PetugasProfilePage({
    authData = {},
    officerStats = {},
    csrfToken = '',
    sessionStatus = '',
    errors = {},
}) {
    const user = authData?.user || {};
    const bankSampahName = authData?.bank_sampah_name || 'Unit Melati Asri';
    const [avatarPreview, setAvatarPreview] = useState(null);

    const handleAvatarChange = (e) => {
        const file = e.target.files?.[0];
        if (file) {
            const url = URL.createObjectURL(file);
            setAvatarPreview(url);
        }
    };

    return (
        <PetugasAppLayout
            pageTitle="Profil Petugas"
            activeMenu=""
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Hero Avatar & Identity Banner */}
                <PetugasProfileHeroCard
                    user={user}
                    bankSampahName={bankSampahName}
                    avatarPreview={avatarPreview}
                    onAvatarChange={handleAvatarChange}
                />

                {/* 2. Rekap Performa Kinerja Seumur Hidup */}
                <PetugasPerformanceStats
                    officerStats={officerStats}
                />

                {/* 3. Form Informasi Pribadi */}
                <PetugasInfoForm
                    user={user}
                    csrfToken={csrfToken}
                    sessionStatus={sessionStatus}
                    errors={errors}
                />

                {/* 4. Form Keamanan Kata Sandi */}
                <PetugasSecurityForm
                    csrfToken={csrfToken}
                    errors={errors}
                />

            </div>
        </PetugasAppLayout>
    );
}
