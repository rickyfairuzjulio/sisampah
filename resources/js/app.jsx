import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

// 1. Initialize Inertia.js SPA for Inertia routes
const hasInertiaRoot = document.getElementById('app') || document.querySelector('script[data-page]');
if (hasInertiaRoot) {
    createInertiaApp({
        resolve: (name) => {
            const pages = import.meta.glob('./pages/**/*.jsx', { eager: true });
            let page = pages[`./pages/${name}.jsx`];
            if (!page) {
                const normalizedTarget = `./pages/${name}.jsx`.toLowerCase();
                const matchedKey = Object.keys(pages).find(k => k.toLowerCase() === normalizedTarget);
                if (matchedKey) {
                    page = pages[matchedKey];
                }
            }
            if (!page) {
                throw new Error(`Inertia page component "${name}" not found in ./pages/ directory.`);
            }
            return page.default || page;
        },
        setup({ el, App, props }) {
            createRoot(el).render(<App {...props} />);
        },
        progress: {
            color: '#10B981',
            showSpinner: true,
        },
    });
}

// Helper to safely parse JSON attributes
const parseDataAttr = (element, attrName, defaultValue = {}) => {
    try {
        const val = element.getAttribute(attrName);
        return val ? JSON.parse(val) : defaultValue;
    } catch (e) {
        console.warn(`Failed to parse ${attrName}:`, e);
        return defaultValue;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mount Landing Page Island
    const landingEl = document.getElementById('landing-app');
    if (landingEl) {
        import('./pages/landing/LandingPage').then(({ default: LandingPage }) => {
            const articles = parseDataAttr(landingEl, 'data-articles', []);
            const stats = parseDataAttr(landingEl, 'data-stats', {});
            const categories = parseDataAttr(landingEl, 'data-categories', []);
            const authData = parseDataAttr(landingEl, 'data-auth', {});

            createRoot(landingEl).render(
                <LandingPage
                    articles={articles}
                    stats={stats}
                    categories={categories}
                    authData={authData}
                />
            );
        });
    }

    // 2. Mount Nasabah Dashboard Island
    const nasabahDashboardEl = document.getElementById('nasabah-dashboard-app');
    if (nasabahDashboardEl) {
        import('./pages/nasabah/dashboard/NasabahDashboardPage').then(({ default: NasabahDashboardPage }) => {
            const authData = parseDataAttr(nasabahDashboardEl, 'data-auth', {});
            const gamification = parseDataAttr(nasabahDashboardEl, 'data-gamification', {});
            const kpiData = parseDataAttr(nasabahDashboardEl, 'data-kpi', {});
            const impact = parseDataAttr(nasabahDashboardEl, 'data-impact', {});
            const chartData = parseDataAttr(nasabahDashboardEl, 'data-chart', {});
            const prices = parseDataAttr(nasabahDashboardEl, 'data-prices', []);
            const recentTransactions = parseDataAttr(nasabahDashboardEl, 'data-transactions', []);
            const leaderboard = parseDataAttr(nasabahDashboardEl, 'data-leaderboard', []);
            const bankSampahs = parseDataAttr(nasabahDashboardEl, 'data-banksampahs', []);

            createRoot(nasabahDashboardEl).render(
                <NasabahDashboardPage
                    authData={authData}
                    gamification={gamification}
                    kpiData={kpiData}
                    impact={impact}
                    chartData={chartData}
                    prices={prices}
                    recentTransactions={recentTransactions}
                    leaderboard={leaderboard}
                    bankSampahs={bankSampahs}
                />
            );
        });
    }

    // 3. Mount Login Page Island
    const loginEl = document.getElementById('login-app');
    if (loginEl) {
        import('./pages/auth/LoginPage').then(({ default: LoginPage }) => {
            const csrfToken = loginEl.getAttribute('data-csrf') || '';
            const oldEmail = loginEl.getAttribute('data-old-email') || '';
            const errors = parseDataAttr(loginEl, 'data-errors', {});
            const status = loginEl.getAttribute('data-status') || '';

            createRoot(loginEl).render(
                <LoginPage
                    csrfToken={csrfToken}
                    oldEmail={oldEmail}
                    errors={errors}
                    status={status}
                />
            );
        });
    }

    // 4. Mount Register Page Island
    const registerEl = document.getElementById('register-app');
    if (registerEl) {
        import('./pages/auth/RegisterPage').then(({ default: RegisterPage }) => {
            const csrfToken = registerEl.getAttribute('data-csrf') || '';
            const oldData = parseDataAttr(registerEl, 'data-old', {});
            const errors = parseDataAttr(registerEl, 'data-errors', {});
            const bankSampahs = parseDataAttr(registerEl, 'data-banksampahs', []);

            createRoot(registerEl).render(
                <RegisterPage
                    csrfToken={csrfToken}
                    oldData={oldData}
                    errors={errors}
                    bankSampahs={bankSampahs}
                />
            );
        });
    }

    // 5. Mount Price Catalog Page Island
    const priceCatalogEl = document.getElementById('price-catalog-app');
    if (priceCatalogEl) {
        import('./pages/nasabah/prices/PriceCatalogPage').then(({ default: PriceCatalogPage }) => {
            const authData = parseDataAttr(priceCatalogEl, 'data-auth', {});
            const selectedBankSampah = parseDataAttr(priceCatalogEl, 'data-selected-bs', {});
            const nearbyBankSampahs = parseDataAttr(priceCatalogEl, 'data-nearby-bs', []);
            const radiusKm = parseFloat(priceCatalogEl.getAttribute('data-radius') || '5');
            const selectedBsId = parseInt(priceCatalogEl.getAttribute('data-selected-bs-id') || '1', 10);
            const activeCategory = priceCatalogEl.getAttribute('data-active-category') || 'all';
            const prices = parseDataAttr(priceCatalogEl, 'data-prices', []);
            const categoryCounts = parseDataAttr(priceCatalogEl, 'data-counts', {});

            createRoot(priceCatalogEl).render(
                <PriceCatalogPage
                    authData={authData}
                    selectedBankSampah={selectedBankSampah}
                    nearbyBankSampahs={nearbyBankSampahs}
                    radiusKm={radiusKm}
                    selectedBsId={selectedBsId}
                    activeCategory={activeCategory}
                    prices={prices}
                    categoryCounts={categoryCounts}
                />
            );
        });
    }

    // 6. Mount Nasabah Profile Page Island
    const profileEl = document.getElementById('nasabah-profile-app');
    if (profileEl) {
        import('./pages/nasabah/profile/ProfilePage').then(({ default: ProfilePage }) => {
            const authData = parseDataAttr(profileEl, 'data-auth', {});
            const csrfToken = profileEl.getAttribute('data-csrf') || '';
            const sessionStatus = profileEl.getAttribute('data-status') || '';
            const errors = parseDataAttr(profileEl, 'data-errors', {});

            createRoot(profileEl).render(
                <ProfilePage
                    authData={authData}
                    csrfToken={csrfToken}
                    sessionStatus={sessionStatus}
                    errors={errors}
                />
            );
        });
    }

    // 7. Mount Pickup Booking Page Island
    const pickupEl = document.getElementById('pickup-booking-app');
    if (pickupEl) {
        import('./pages/nasabah/pickup/PickupBookingPage').then(({ default: PickupBookingPage }) => {
            const authData = parseDataAttr(pickupEl, 'data-auth', {});
            const bankSampah = parseDataAttr(pickupEl, 'data-bank-sampah', {});
            const trashCategories = parseDataAttr(pickupEl, 'data-categories', []);
            const pickupHistory = parseDataAttr(pickupEl, 'data-history', []);
            const csrfToken = pickupEl.getAttribute('data-csrf') || '';
            const sessionStatus = pickupEl.getAttribute('data-status') || '';
            const sessionError = pickupEl.getAttribute('data-error') || '';
            const errors = parseDataAttr(pickupEl, 'data-errors', {});

            createRoot(pickupEl).render(
                <PickupBookingPage
                    authData={authData}
                    bankSampah={bankSampah}
                    trashCategories={trashCategories}
                    pickupHistory={pickupHistory}
                    csrfToken={csrfToken}
                    sessionStatus={sessionStatus}
                    sessionError={sessionError}
                    errors={errors}
                />
            );
        });
    }

    // 8. Mount Digital Wallet (SiSampay) Page Island
    const walletEl = document.getElementById('wallet-app');
    if (walletEl) {
        import('./pages/nasabah/wallet/WalletPage').then(({ default: WalletPage }) => {
            const authData = parseDataAttr(walletEl, 'data-auth', {});
            const saldo = parseFloat(walletEl.getAttribute('data-saldo') || '0');
            const walletStats = parseDataAttr(walletEl, 'data-stats', {});
            const depositTransactions = parseDataAttr(walletEl, 'data-deposits', []);
            const withdrawals = parseDataAttr(walletEl, 'data-withdrawals', []);
            const csrfToken = walletEl.getAttribute('data-csrf') || '';
            const sessionStatus = walletEl.getAttribute('data-status') || '';
            const sessionError = walletEl.getAttribute('data-error') || '';

            createRoot(walletEl).render(
                <WalletPage
                    authData={authData}
                    saldo={saldo}
                    walletStats={walletStats}
                    depositTransactions={depositTransactions}
                    withdrawals={withdrawals}
                    csrfToken={csrfToken}
                    sessionStatus={sessionStatus}
                    sessionError={sessionError}
                />
            );
        });
    }

    // 9. Mount Environmental Certificate Page Island
    const certEl = document.getElementById('certificate-app');
    if (certEl) {
        import('./pages/nasabah/certificate/CertificatePage').then(({ default: CertificatePage }) => {
            const authData = parseDataAttr(certEl, 'data-auth', {});
            const stats = parseDataAttr(certEl, 'data-stats', {});
            const impact = parseDataAttr(certEl, 'data-impact', {});
            const certificateDetails = parseDataAttr(certEl, 'data-details', {});
            const badges = parseDataAttr(certEl, 'data-badges', []);

            createRoot(certEl).render(
                <CertificatePage
                    authData={authData}
                    stats={stats}
                    impact={impact}
                    certificateDetails={certificateDetails}
                    badges={badges}
                />
            );
        });
    }

    // 10. Mount Education Page Island
    const eduEl = document.getElementById('education-app');
    if (eduEl) {
        import('./pages/nasabah/education/EducationPage').then(({ default: EducationPage }) => {
            const authData = parseDataAttr(eduEl, 'data-auth', {});
            const allArticles = parseDataAttr(eduEl, 'data-articles', []);
            const featuredArticle = parseDataAttr(eduEl, 'data-featured', null);
            const categories = parseDataAttr(eduEl, 'data-categories', []);

            createRoot(eduEl).render(
                <EducationPage
                    authData={authData}
                    allArticles={allArticles}
                    featuredArticle={featuredArticle}
                    categories={categories}
                />
            );
        });
    }

    // 11. Mount Petugas Dashboard Manifest Island
    const petugasDashEl = document.getElementById('petugas-dashboard-app');
    if (petugasDashEl) {
        import('./pages/petugas/dashboard/PetugasDashboardPage').then(({ default: PetugasDashboardPage }) => {
            const authData = parseDataAttr(petugasDashEl, 'data-auth', {});
            const kpiData = parseDataAttr(petugasDashEl, 'data-kpi', {});
            const pickupManifest = parseDataAttr(petugasDashEl, 'data-manifest', []);
            const recentWeighings = parseDataAttr(petugasDashEl, 'data-recent', []);

            createRoot(petugasDashEl).render(
                <PetugasDashboardPage
                    authData={authData}
                    kpiData={kpiData}
                    pickupManifest={pickupManifest}
                    recentWeighings={recentWeighings}
                />
            );
        });
    }

    // 12. Mount Weighing Input Form Island
    const weighingEl = document.getElementById('weighing-form-app');
    if (weighingEl) {
        import('./pages/petugas/weighing/WeighingFormPage').then(({ default: WeighingFormPage }) => {
            const authData = parseDataAttr(weighingEl, 'data-auth', {});
            const targetNasabah = parseDataAttr(weighingEl, 'data-target', {});
            const trashCategories = parseDataAttr(weighingEl, 'data-categories', []);
            const pendingItems = parseDataAttr(weighingEl, 'data-pending', []);
            const csrfToken = weighingEl.getAttribute('data-csrf') || '';

            createRoot(weighingEl).render(
                <WeighingFormPage
                    authData={authData}
                    targetNasabah={targetNasabah}
                    trashCategories={trashCategories}
                    pendingItems={pendingItems}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 13. Mount Self Deposit Form Island
    const selfDepEl = document.getElementById('self-deposit-app');
    if (selfDepEl) {
        import('./pages/petugas/self-deposit/SelfDepositPage').then(({ default: SelfDepositPage }) => {
            const authData = parseDataAttr(selfDepEl, 'data-auth', {});
            const trashCategories = parseDataAttr(selfDepEl, 'data-categories', []);
            const registeredNasabahs = parseDataAttr(selfDepEl, 'data-nasabahs', []);
            const csrfToken = selfDepEl.getAttribute('data-csrf') || '';

            createRoot(selfDepEl).render(
                <SelfDepositPage
                    authData={authData}
                    trashCategories={trashCategories}
                    registeredNasabahs={registeredNasabahs}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 14. Mount Petugas Profile Page Island
    const petugasProfileEl = document.getElementById('petugas-profile-app');
    if (petugasProfileEl) {
        import('./pages/petugas/profile/PetugasProfilePage').then(({ default: PetugasProfilePage }) => {
            const authData = parseDataAttr(petugasProfileEl, 'data-auth', {});
            const officerStats = parseDataAttr(petugasProfileEl, 'data-stats', {});
            const csrfToken = petugasProfileEl.getAttribute('data-csrf') || '';
            const sessionStatus = petugasProfileEl.getAttribute('data-status') || '';
            const errors = parseDataAttr(petugasProfileEl, 'data-errors', {});

            createRoot(petugasProfileEl).render(
                <PetugasProfilePage
                    authData={authData}
                    officerStats={officerStats}
                    csrfToken={csrfToken}
                    sessionStatus={sessionStatus}
                    errors={errors}
                />
            );
        });
    }

    // 15. Mount Admin Dashboard Island
    const adminDashEl = document.getElementById('admin-dashboard-app');
    if (adminDashEl) {
        import('./pages/admin/dashboard/AdminDashboardPage').then(({ default: AdminDashboardPage }) => {
            const authData = parseDataAttr(adminDashEl, 'data-auth', {});
            const metrics = parseDataAttr(adminDashEl, 'data-metrics', {});
            const cashflow = parseDataAttr(adminDashEl, 'data-cashflow', {});
            const chartSetoran = parseDataAttr(adminDashEl, 'data-chart-setoran', { labels: [], data: [] });
            const chartJenisSampah = parseDataAttr(adminDashEl, 'data-chart-jenis', { labels: [], data: [] });
            const pendingWithdrawals = parseDataAttr(adminDashEl, 'data-withdrawals', []);
            const recentTransactions = parseDataAttr(adminDashEl, 'data-recent', []);

            createRoot(adminDashEl).render(
                <AdminDashboardPage
                    authData={authData}
                    metrics={metrics}
                    cashflow={cashflow}
                    chartSetoran={chartSetoran}
                    chartJenisSampah={chartJenisSampah}
                    pendingWithdrawals={pendingWithdrawals}
                    recentTransactions={recentTransactions}
                />
            );
        });
    }

    // 16. Mount Admin Inventory Island
    const adminInventoryEl = document.getElementById('admin-inventory-app');
    if (adminInventoryEl) {
        import('./pages/admin/inventory/AdminInventoryPage').then(({ default: AdminInventoryPage }) => {
            const authData = parseDataAttr(adminInventoryEl, 'data-auth', {});
            const stockData = parseDataAttr(adminInventoryEl, 'data-stock', {});

            createRoot(adminInventoryEl).render(
                <AdminInventoryPage
                    authData={authData}
                    stockData={stockData}
                />
            );
        });
    }

    // 17. Mount Admin Finance Island
    const adminFinanceEl = document.getElementById('admin-finance-app');
    if (adminFinanceEl) {
        import('./pages/admin/finance/AdminFinancePage').then(({ default: AdminFinancePage }) => {
            const authData = parseDataAttr(adminFinanceEl, 'data-auth', {});
            const treasury = parseDataAttr(adminFinanceEl, 'data-treasury', {});
            const pendingWithdrawals = parseDataAttr(adminFinanceEl, 'data-pending', []);
            const approvedWithdrawals = parseDataAttr(adminFinanceEl, 'data-approved', []);
            const rejectedWithdrawals = parseDataAttr(adminFinanceEl, 'data-rejected', []);

            createRoot(adminFinanceEl).render(
                <AdminFinancePage
                    authData={authData}
                    treasury={treasury}
                    pendingWithdrawals={pendingWithdrawals}
                    approvedWithdrawals={approvedWithdrawals}
                    rejectedWithdrawals={rejectedWithdrawals}
                />
            );
        });
    }

    // 18. Mount Admin Trash Price Island
    const adminPriceEl = document.getElementById('admin-trash-price-app');
    if (adminPriceEl) {
        import('./pages/admin/prices/AdminTrashPricePage').then(({ default: AdminTrashPricePage }) => {
            const authData = parseDataAttr(adminPriceEl, 'data-auth', {});
            const statistics = parseDataAttr(adminPriceEl, 'data-statistics', {});
            const categoryList = parseDataAttr(adminPriceEl, 'data-categories', []);

            createRoot(adminPriceEl).render(
                <AdminTrashPricePage
                    authData={authData}
                    statistics={statistics}
                    categoryList={categoryList}
                />
            );
        });
    }

    // 19. Mount Admin Users Island
    const adminUsersEl = document.getElementById('admin-users-app');
    if (adminUsersEl) {
        import('./pages/admin/users/AdminUsersPage').then(({ default: AdminUsersPage }) => {
            const authData = parseDataAttr(adminUsersEl, 'data-auth', {});
            const statistics = parseDataAttr(adminUsersEl, 'data-statistics', {});
            const usersList = parseDataAttr(adminUsersEl, 'data-users', []);

            createRoot(adminUsersEl).render(
                <AdminUsersPage
                    authData={authData}
                    statistics={statistics}
                    usersList={usersList}
                />
            );
        });
    }

    // 20. Mount Admin Articles Island
    const adminArticlesEl = document.getElementById('admin-articles-app');
    if (adminArticlesEl) {
        import('./pages/admin/articles/AdminArticlesPage').then(({ default: AdminArticlesPage }) => {
            const authData = parseDataAttr(adminArticlesEl, 'data-auth', {});
            const statistics = parseDataAttr(adminArticlesEl, 'data-statistics', {});
            const articlesList = parseDataAttr(adminArticlesEl, 'data-articles', []);

            createRoot(adminArticlesEl).render(
                <AdminArticlesPage
                    authData={authData}
                    statistics={statistics}
                    articlesList={articlesList}
                />
            );
        });
    }

    // 21. Mount Admin Violations Island
    const adminViolationsEl = document.getElementById('admin-violations-app');
    if (adminViolationsEl) {
        import('./pages/admin/violations/AdminViolationsPage').then(({ default: AdminViolationsPage }) => {
            const authData = parseDataAttr(adminViolationsEl, 'data-auth', {});
            const statistics = parseDataAttr(adminViolationsEl, 'data-statistics', {});
            const violationsList = parseDataAttr(adminViolationsEl, 'data-violations', []);

            createRoot(adminViolationsEl).render(
                <AdminViolationsPage
                    authData={authData}
                    statistics={statistics}
                    violationsList={violationsList}
                />
            );
        });
    }

    // 22. Mount Admin Reports Island
    const adminReportsEl = document.getElementById('admin-reports-app');
    if (adminReportsEl) {
        import('./pages/admin/reports/AdminReportsPage').then(({ default: AdminReportsPage }) => {
            const authData = parseDataAttr(adminReportsEl, 'data-auth', {});
            const summary = parseDataAttr(adminReportsEl, 'data-summary', {});
            const transactionsList = parseDataAttr(adminReportsEl, 'data-transactions', []);
            const rtList = parseDataAttr(adminReportsEl, 'data-rt', []);
            const rwList = parseDataAttr(adminReportsEl, 'data-rw', []);

            createRoot(adminReportsEl).render(
                <AdminReportsPage
                    authData={authData}
                    summary={summary}
                    transactionsList={transactionsList}
                    rtList={rtList}
                    rwList={rwList}
                />
            );
        });
    }

    // 23. Mount Super Admin Dashboard Island
    const superAdminDashboardEl = document.getElementById('super-admin-dashboard-app');
    if (superAdminDashboardEl) {
        import('./pages/super-admin/dashboard/SuperAdminDashboardPage').then(({ default: SuperAdminDashboardPage }) => {
            const authData = parseDataAttr(superAdminDashboardEl, 'data-auth', {});
            const statistics = parseDataAttr(superAdminDashboardEl, 'data-statistics', {});
            const charts = parseDataAttr(superAdminDashboardEl, 'data-charts', {});
            const pendingVerifications = parseDataAttr(superAdminDashboardEl, 'data-pending', []);
            const topUnits = parseDataAttr(superAdminDashboardEl, 'data-top-units', []);

            createRoot(superAdminDashboardEl).render(
                <SuperAdminDashboardPage
                    authData={authData}
                    statistics={statistics}
                    charts={charts}
                    pendingVerifications={pendingVerifications}
                    topUnits={topUnits}
                />
            );
        });
    }

    // 24. Mount Super Admin Verification Index Island
    const superAdminVerifIndexEl = document.getElementById('super-admin-verification-index-app');
    if (superAdminVerifIndexEl) {
        import('./pages/super-admin/verification/SuperAdminVerificationIndexPage').then(({ default: SuperAdminVerificationIndexPage }) => {
            const authData = parseDataAttr(superAdminVerifIndexEl, 'data-auth', {});
            const stats = parseDataAttr(superAdminVerifIndexEl, 'data-stats', {});
            const registrations = parseDataAttr(superAdminVerifIndexEl, 'data-registrations', []);
            const statusFilter = parseDataAttr(superAdminVerifIndexEl, 'data-status-filter', 'all');
            const searchQuery = parseDataAttr(superAdminVerifIndexEl, 'data-search-query', '');

            createRoot(superAdminVerifIndexEl).render(
                <SuperAdminVerificationIndexPage
                    authData={authData}
                    stats={stats}
                    registrations={registrations}
                    statusFilter={statusFilter}
                    searchQuery={searchQuery}
                />
            );
        });
    }

    // 25. Mount Super Admin Verification Detail Island
    const superAdminVerifDetailEl = document.getElementById('super-admin-verification-detail-app');
    if (superAdminVerifDetailEl) {
        import('./pages/super-admin/verification/SuperAdminVerificationDetailPage').then(({ default: SuperAdminVerificationDetailPage }) => {
            const authData = parseDataAttr(superAdminVerifDetailEl, 'data-auth', {});
            const bankSampah = parseDataAttr(superAdminVerifDetailEl, 'data-bank-sampah', {});
            const documents = parseDataAttr(superAdminVerifDetailEl, 'data-documents', []);
            const verifications = parseDataAttr(superAdminVerifDetailEl, 'data-verifications', []);
            const csrfToken = superAdminVerifDetailEl.getAttribute('data-csrf-token') || '';

            createRoot(superAdminVerifDetailEl).render(
                <SuperAdminVerificationDetailPage
                    authData={authData}
                    bankSampah={bankSampah}
                    documents={documents}
                    verifications={verifications}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 26. Mount Super Admin Master Bank Sampah Index Island
    const superAdminMasterBsIndexEl = document.getElementById('super-admin-master-bs-index-app');
    if (superAdminMasterBsIndexEl) {
        import('./pages/super-admin/master-bs/SuperAdminMasterBsIndexPage').then(({ default: SuperAdminMasterBsIndexPage }) => {
            const authData = parseDataAttr(superAdminMasterBsIndexEl, 'data-auth', {});
            const stats = parseDataAttr(superAdminMasterBsIndexEl, 'data-stats', {});
            const bankSampahs = parseDataAttr(superAdminMasterBsIndexEl, 'data-bank-sampahs', []);
            const provinsiList = parseDataAttr(superAdminMasterBsIndexEl, 'data-provinsi-list', []);
            const kabupatenList = parseDataAttr(superAdminMasterBsIndexEl, 'data-kabupaten-list', []);
            const csrfToken = superAdminMasterBsIndexEl.getAttribute('data-csrf-token') || '';

            createRoot(superAdminMasterBsIndexEl).render(
                <SuperAdminMasterBsIndexPage
                    authData={authData}
                    stats={stats}
                    bankSampahs={bankSampahs}
                    provinsiList={provinsiList}
                    kabupatenList={kabupatenList}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 27. Mount Super Admin Master Bank Sampah Detail Island
    const superAdminMasterBsDetailEl = document.getElementById('super-admin-master-bs-detail-app');
    if (superAdminMasterBsDetailEl) {
        import('./pages/super-admin/master-bs/SuperAdminMasterBsDetailPage').then(({ default: SuperAdminMasterBsDetailPage }) => {
            const authData = parseDataAttr(superAdminMasterBsDetailEl, 'data-auth', {});
            const unitDetail = parseDataAttr(superAdminMasterBsDetailEl, 'data-unit-detail', {});
            const admins = parseDataAttr(superAdminMasterBsDetailEl, 'data-admins', []);
            const petugas = parseDataAttr(superAdminMasterBsDetailEl, 'data-petugas', []);
            const prices = parseDataAttr(superAdminMasterBsDetailEl, 'data-prices', []);
            const transactions = parseDataAttr(superAdminMasterBsDetailEl, 'data-transactions', []);
            const csrfToken = superAdminMasterBsDetailEl.getAttribute('data-csrf-token') || '';

            createRoot(superAdminMasterBsDetailEl).render(
                <SuperAdminMasterBsDetailPage
                    authData={authData}
                    unitDetail={unitDetail}
                    admins={admins}
                    petugas={petugas}
                    prices={prices}
                    transactions={transactions}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 28. Mount Super Admin Map Island
    const superAdminMapEl = document.getElementById('super-admin-map-app');
    if (superAdminMapEl) {
        import('./pages/super-admin/map/SuperAdminMapPage').then(({ default: SuperAdminMapPage }) => {
            const authData = parseDataAttr(superAdminMapEl, 'data-auth', {});
            const bankSampahs = parseDataAttr(superAdminMapEl, 'data-bank-sampahs', []);
            const gisStats = parseDataAttr(superAdminMapEl, 'data-gis-stats', {});
            const blankSpots = parseDataAttr(superAdminMapEl, 'data-blank-spots', []);

            createRoot(superAdminMapEl).render(
                <SuperAdminMapPage
                    authData={authData}
                    bankSampahs={bankSampahs}
                    gisStats={gisStats}
                    blankSpots={blankSpots}
                />
            );
        });
    }

    // 29. Mount Super Admin Config Island
    const superAdminConfigEl = document.getElementById('super-admin-config-app');
    if (superAdminConfigEl) {
        import('./pages/super-admin/config/SuperAdminConfigPage').then(({ default: SuperAdminConfigPage }) => {
            const authData = parseDataAttr(superAdminConfigEl, 'data-auth', {});
            const settings = parseDataAttr(superAdminConfigEl, 'data-settings', {});
            const configStats = parseDataAttr(superAdminConfigEl, 'data-config-stats', {});
            const rtList = parseDataAttr(superAdminConfigEl, 'data-rt-list', []);
            const rwList = parseDataAttr(superAdminConfigEl, 'data-rw-list', []);
            const csrfToken = superAdminConfigEl.getAttribute('data-csrf-token') || '';

            createRoot(superAdminConfigEl).render(
                <SuperAdminConfigPage
                    authData={authData}
                    settings={settings}
                    configStats={configStats}
                    rtList={rtList}
                    rwList={rwList}
                    csrfToken={csrfToken}
                />
            );
        });
    }

    // 30. Mount Super Admin Audit Logs Island
    const superAdminAuditLogsEl = document.getElementById('super-admin-audit-logs-app');
    if (superAdminAuditLogsEl) {
        import('./pages/super-admin/audit-logs/SuperAdminAuditLogsPage').then(({ default: SuperAdminAuditLogsPage }) => {
            const authData = parseDataAttr(superAdminAuditLogsEl, 'data-auth', {});
            const logs = parseDataAttr(superAdminAuditLogsEl, 'data-logs', []);
            const auditStats = parseDataAttr(superAdminAuditLogsEl, 'data-audit-stats', {});

            createRoot(superAdminAuditLogsEl).render(
                <SuperAdminAuditLogsPage
                    authData={authData}
                    logs={logs}
                    auditStats={auditStats}
                />
            );
        });
    }
});
