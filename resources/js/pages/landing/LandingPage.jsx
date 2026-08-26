import React from 'react';
import LandingNavbar from './sections/LandingNavbar';
import HeroSection from './sections/HeroSection';
import WasteMarquee from './sections/WasteMarquee';
import BentoFeaturesSection from './sections/BentoFeaturesSection';
import HowItWorksSection from './sections/HowItWorksSection';
import RealtimeImpactStats from './sections/RealtimeImpactStats';
import EducationArticlesSection from './sections/EducationArticlesSection';
import FaqAccordionSection from './sections/FaqAccordionSection';
import CtaBannerSection from './sections/CtaBannerSection';
import LandingFooter from './sections/LandingFooter';

export default function LandingPage({ articles = [], stats = {}, categories = [], authData = {} }) {
    return (
        <div className="min-h-screen bg-[#051410] text-white font-sans overflow-x-hidden antialiased selection:bg-[#22C55E] selection:text-white">
            
            {/* 1. Glassmorphism Sticky Navbar */}
            <LandingNavbar authData={authData} />

            {/* 2. Hero Section with Mockup Card */}
            <HeroSection authData={authData} stats={stats} />

            {/* 3. Waste Commodity Infinite Marquee */}
            <WasteMarquee categories={categories} />

            {/* 4. Asymmetric Bento Grid Features & Live Calculator */}
            <BentoFeaturesSection categories={categories} />

            {/* 5. 4-Step How It Works Section */}
            <HowItWorksSection />

            {/* 6. Real-Time Impact Aggregates from Database */}
            <RealtimeImpactStats stats={stats} />

            {/* 7. Latest Educational Articles from Database */}
            <EducationArticlesSection articles={articles} />

            {/* 8. Interactive FAQ Accordion */}
            <FaqAccordionSection />

            {/* 9. High-Conversion CTA Banner */}
            <CtaBannerSection authData={authData} />

            {/* 10. Multi-Column Footer */}
            <LandingFooter />

        </div>
    );
}
