import React from 'react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import CertificateHeroBanner from './sections/CertificateHeroBanner';
import EcoImpactSummaryGrid from './sections/EcoImpactSummaryGrid';
import DigitalCertificateCanvas from './sections/DigitalCertificateCanvas';
import BadgesShowcaseSection from './sections/BadgesShowcaseSection';

export default function CertificatePage({
    authData = {},
    stats = {},
    impact = {},
    certificateDetails = {},
    badges = [],
}) {
    return (
        <NasabahAppLayout
            pageTitle="Sertifikat"
            activeMenu="certificate"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Hero Banner */}
                <CertificateHeroBanner
                    stats={stats}
                    certificateDetails={certificateDetails}
                />

                {/* 2. 4 Eco Impact Metric Cards */}
                <EcoImpactSummaryGrid
                    stats={stats}
                    impact={impact}
                />

                {/* 3. A4 Digital Certificate Canvas */}
                <DigitalCertificateCanvas
                    authData={authData}
                    stats={stats}
                    impact={impact}
                    certificateDetails={certificateDetails}
                />

                {/* 4. Badges Showcase Roadmap */}
                <BadgesShowcaseSection
                    badges={badges}
                    stats={stats}
                />

            </div>
        </NasabahAppLayout>
    );
}
