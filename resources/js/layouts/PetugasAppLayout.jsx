import React, { useState } from 'react';
import PetugasSidebarNav from './components/PetugasSidebarNav';
import PetugasTopNavBar from './components/PetugasTopNavBar';
import NasabahFooter from './components/NasabahFooter';

export default function PetugasAppLayout({
    children,
    pageTitle = 'Dashboard Manifes',
    activeMenu = 'manifest',
    authData = {},
}) {
    const [mobileOpen, setMobileOpen] = useState(false);

    return (
        <div className="flex h-screen w-full bg-slate-50 dark:bg-[#090D16] text-slate-900 dark:text-slate-100 overflow-hidden font-sans antialiased transition-colors duration-200">
            
            {/* 1. Desktop Sidebar Kiri (260px) */}
            <div className="hidden lg:block h-full shrink-0">
                <PetugasSidebarNav
                    activeMenu={activeMenu}
                    authData={authData}
                />
            </div>

            {/* 2. Mobile Drawer Sidebar */}
            {mobileOpen && (
                <div className="fixed inset-0 z-50 lg:hidden flex">
                    {/* Backdrop */}
                    <div 
                        className="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
                        onClick={() => setMobileOpen(false)}
                    />
                    {/* Drawer Content */}
                    <div className="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-[#0D131F] z-10 animate-slide-in">
                        <PetugasSidebarNav
                            activeMenu={activeMenu}
                            authData={authData}
                            onCloseMobile={() => setMobileOpen(false)}
                        />
                    </div>
                </div>
            )}

            {/* 3. Konten Utama Kanan (Scrollable Area) */}
            <div className="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-slate-50 dark:bg-[#090D16] transition-colors duration-200">
                
                {/* Header Topbar */}
                <PetugasTopNavBar
                    pageTitle={pageTitle}
                    authData={authData}
                    onOpenMobile={() => setMobileOpen(true)}
                />

                {/* Body Area Scrollable */}
                <main className="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 custom-scrollbar">
                    <div className="max-w-7xl mx-auto space-y-6">
                        {children}
                    </div>

                    {/* Shared Footer SiSampah 2026 */}
                    <NasabahFooter />
                </main>

            </div>

        </div>
    );
}
