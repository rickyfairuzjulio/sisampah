import React, { useState } from 'react';
import AdminSidebarNav from './components/AdminSidebarNav';
import AdminTopNavBar from './components/AdminTopNavBar';
import NasabahFooter from './components/NasabahFooter';

export default function AdminAppLayout({
    pageTitle = 'Dashboard Operasional',
    activeMenu = 'dashboard',
    authData = {},
    children,
}) {
    const [mobileOpen, setMobileOpen] = useState(false);

    return (
        <div className="bg-[#F8FAFC] text-slate-600 font-sans antialiased min-h-screen flex flex-col lg:flex-row">
            
            {/* 1. Desktop Persistent Left Sidebar (260px) - FIXED ON VIEWPORT (TIDAK IKUT SCROLL) */}
            <div className="hidden lg:block fixed left-0 top-0 h-screen w-[260px] z-50">
                <AdminSidebarNav
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
                        <AdminSidebarNav
                            activeMenu={activeMenu}
                            authData={authData}
                            onCloseMobile={() => setMobileOpen(false)}
                        />
                    </div>
                </div>
            )}

            {/* 3. Main Content Wrapper */}
            <div className="flex-1 lg:ml-[260px] min-h-screen flex flex-col bg-[#F8FAFC] w-full min-w-0">
                
                {/* Topbar Bersih Tanpa Search Bar (Sticky Top) */}
                <AdminTopNavBar
                    pageTitle={pageTitle}
                    authData={authData}
                    onOpenMobile={() => setMobileOpen(true)}
                />

                {/* Page Content Viewport */}
                <main className="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6 sm:space-y-8 w-full flex-1">
                    {children}
                </main>

                {/* Shared Nasabah Footer (Copyright, Bodrex Developer, SWITF) */}
                <NasabahFooter />
            </div>

        </div>
    );
}
