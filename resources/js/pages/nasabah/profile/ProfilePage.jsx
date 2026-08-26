import React, { useState } from 'react';
import { CheckCircle2 } from 'lucide-react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import ProfileHeroHeader from './sections/ProfileHeroHeader';
import PersonalInfoForm from './sections/PersonalInfoForm';
import PasswordSecurityForm from './sections/PasswordSecurityForm';
import DangerZoneSection from './sections/DangerZoneSection';

export default function ProfilePage({
    authData = {},
    csrfToken = '',
    sessionStatus = '',
    errors = {},
}) {
    const user = authData?.user || {};

    return (
        <NasabahAppLayout
            pageTitle="Pengaturan Profil"
            activeMenu=""
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Flash Success Alert */}
                {sessionStatus && (
                    <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm animate-slide-in">
                        <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
                        <span>{sessionStatus}</span>
                    </div>
                )}

                {/* 2. Profile Hero Header */}
                <ProfileHeroHeader
                    authData={authData}
                />

                {/* 3. Personal Info & RT/RW Address Form */}
                <PersonalInfoForm
                    user={user}
                    csrfToken={csrfToken}
                    errors={errors}
                />

                {/* 4. Password Security Form */}
                <PasswordSecurityForm
                    csrfToken={csrfToken}
                    errors={errors}
                />

                {/* 5. Danger Zone (Delete Account) */}
                <DangerZoneSection
                    csrfToken={csrfToken}
                    errors={errors}
                />

            </div>
        </NasabahAppLayout>
    );
}
