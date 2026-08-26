import React from 'react';
import AdminAppLayout from '@/layouts/AdminAppLayout';
import ConfigHeroBanner from './sections/ConfigHeroBanner';
import ConfigKpiCards from './sections/ConfigKpiCards';
import ConfigTabs from './sections/ConfigTabs';

export default function SuperAdminConfigPage({
    authData = {},
    settings = {},
    configStats = {},
    rtList = [],
    rwList = [],
    csrfToken = '',
}) {
    return (
        <AdminAppLayout
            pageTitle="Konfigurasi Wilayah & Sistem"
            activeMenu="region"
            authData={authData}
        >
            <div className="space-y-7 pb-16">
                {/* 1. Hero Banner */}
                <ConfigHeroBanner />

                {/* 2. 4 Kartu KPI Parameter */}
                <ConfigKpiCards configStats={configStats} />

                {/* 3. Tabulasi Form Parameter */}
                <ConfigTabs
                    settings={settings}
                    rtList={rtList}
                    rwList={rwList}
                    csrfToken={csrfToken}
                />
            </div>
        </AdminAppLayout>
    );
}
