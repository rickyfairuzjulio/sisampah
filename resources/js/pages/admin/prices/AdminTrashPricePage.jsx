import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import TrashPriceHeroBanner from './sections/TrashPriceHeroBanner';
import TrashPriceKpiCards from './sections/TrashPriceKpiCards';
import TrashPriceCatalogGrid from './sections/TrashPriceCatalogGrid';
import CreatePriceCategoryModal from './sections/CreatePriceCategoryModal';
import EditPriceModal from './sections/EditPriceModal';
import PriceTrendModal from './sections/PriceTrendModal';

export default function AdminTrashPricePage({
    authData = {},
    statistics = {},
    categoryList = [],
}) {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [selectedCategoryToEdit, setSelectedCategoryToEdit] = useState(null);
    const [selectedCategoryTrend, setSelectedCategoryTrend] = useState(null);

    return (
        <AdminAppLayout
            pageTitle="Harga"
            activeMenu="prices"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Acuan Harga Sampah */}
                <TrashPriceHeroBanner
                    authData={authData}
                    statistics={statistics}
                    onOpenCreateModal={() => setIsCreateModalOpen(true)}
                />

                {/* 2. 4 Kartu KPI Statistik Harga */}
                <TrashPriceKpiCards
                    statistics={statistics}
                />

                {/* 3. Filter Pil Kategori & Grid Katalog Harga */}
                <TrashPriceCatalogGrid
                    categories={categoryList}
                    onEditPrice={(cat) => setSelectedCategoryToEdit(cat)}
                    onViewTrend={(cat) => setSelectedCategoryTrend(cat)}
                />

            </div>

            {/* Modal Dialogs */}
            <CreatePriceCategoryModal
                isOpen={isCreateModalOpen}
                onClose={() => setIsCreateModalOpen(false)}
            />

            <EditPriceModal
                isOpen={Boolean(selectedCategoryToEdit)}
                onClose={() => setSelectedCategoryToEdit(null)}
                category={selectedCategoryToEdit}
            />

            <PriceTrendModal
                isOpen={Boolean(selectedCategoryTrend)}
                onClose={() => setSelectedCategoryTrend(null)}
                category={selectedCategoryTrend}
            />
        </AdminAppLayout>
    );
}
