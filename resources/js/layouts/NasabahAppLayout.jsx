import React, { useState } from 'react';
import SidebarNav from './components/SidebarNav';
import TopNavBar from './components/TopNavBar';
import NasabahFooter from './components/NasabahFooter';
import AiChatbotWidget from '@/components/AiChatbotWidget';

export default function NasabahAppLayout({
    children,
    pageTitle = 'Dashboard Nasabah',
    activeMenu = 'dashboard',
    authData = {},
}) {
    const [mobileOpen, setMobileOpen] = useState(false);

    return (
        <div className="bg-[#F8FAFC] dark:bg-[#090D16] text-slate-600 dark:text-slate-300 font-sans antialiased min-h-screen flex flex-col lg:flex-row relative transition-colors duration-200">
            
            {/* 1. Desktop Persistent Left Sidebar (260px) */}
            <div className="hidden lg:block fixed left-0 top-0 h-screen w-[260px] z-50">
                <SidebarNav
                    activeMenu={activeMenu}
                    authData={authData}
                />
            </div>

            {/* 2. Mobile Responsive Drawer */}
            {mobileOpen && (
                <div className="lg:hidden fixed inset-0 z-50 flex">
                    {/* Backdrop */}
                    <div
                        className="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
                        onClick={() => setMobileOpen(false)}
                    />

                    {/* Drawer Content */}
                    <div className="relative w-[260px] max-w-[80vw] h-full z-10 animate-slide-in">
                        <SidebarNav
                            activeMenu={activeMenu}
                            authData={authData}
                            onCloseMobile={() => setMobileOpen(false)}
                        />
                    </div>
                </div>
            )}

            {/* 3. Main Content Wrapper */}
            <div className="flex-1 lg:ml-[260px] min-h-screen flex flex-col bg-[#F8FAFC] dark:bg-[#090D16] w-full min-w-0 transition-colors duration-200">
                
                {/* Topbar Header */}
                <TopNavBar
                    pageTitle={pageTitle}
                    authData={authData}
                    onOpenMobile={() => setMobileOpen(true)}
                />

                {/* Dynamic Page Content */}
                <main className="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6 sm:space-y-8 w-full flex-1">
                    {children}
                </main>

                {/* Shared Nasabah Footer */}
                <NasabahFooter />

            </div>

            {/* 4. SiSampah AI Vision & Assistant Floating Widget */}
            <AiChatbotWidget />

        </div>
    );
}
