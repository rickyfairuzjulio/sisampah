import React, { useState } from 'react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import PriceCatalogHero from './sections/PriceCatalogHero';
import UnitSelectorToolbar from './sections/UnitSelectorToolbar';
import CategoryPillsFilter from './sections/CategoryPillsFilter';
import PriceCardGrid from './sections/PriceCardGrid';
import MaxPriceTipsCard from './sections/MaxPriceTipsCard';
import CatalogPagination from './sections/CatalogPagination';

export default function PriceCatalogPage({
    authData = {},
    selectedBankSampah = {},
    nearbyBankSampahs = [],
    radiusKm = 5,
    selectedBsId = 1,
    activeCategory: initialCategory = 'all',
    prices: initialPrices = [],
    categoryCounts = {},
}) {
    const [activeCategory, setActiveCategory] = useState(initialCategory);
    const [pricesList, setPricesList] = useState(initialPrices);
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 12;

    // Filter items based on active category
    const filteredPrices = pricesList.filter((item) => {
        if (activeCategory === 'all') return true;
        if (activeCategory === 'favorites') return item.is_favorite;
        return item.kategori === activeCategory;
    });

    // Pagination calculations
    const totalPages = Math.ceil(filteredPrices.length / itemsPerPage);
    const paginatedPrices = filteredPrices.slice(
        (currentPage - 1) * itemsPerPage,
        currentPage * itemsPerPage
    );

    const handleCategorySelect = (catKey) => {
        setActiveCategory(catKey);
        setCurrentPage(1);
    };

    const handleToggleFavorite = (itemId, isFav) => {
        setPricesList((prev) =>
            prev.map((item) =>
                item.id === itemId ? { ...item, is_favorite: isFav } : item
            )
        );
    };

    return (
        <NasabahAppLayout
            pageTitle="Katalog Harga Sampah"
            activeMenu="prices"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in">
                
                {/* 1. Hero Banner */}
                <PriceCatalogHero />

                {/* 2. Unit & Radius Selector Toolbar */}
                <UnitSelectorToolbar
                    selectedBankSampah={selectedBankSampah}
                    nearbyBankSampahs={nearbyBankSampahs}
                    radiusKm={radiusKm}
                    selectedBsId={selectedBsId}
                    activeCategory={activeCategory}
                />

                {/* 3. Filter Tabs (Pills Bar - Tanpa Search Bar) */}
                <CategoryPillsFilter
                    activeCategory={activeCategory}
                    categoryCounts={categoryCounts}
                    onSelectCategory={handleCategorySelect}
                />

                {/* 4. Grid Kartu Harga (4 Kolom Responsive) */}
                <PriceCardGrid
                    prices={paginatedPrices}
                    activeCategory={activeCategory}
                    onToggleFavorite={handleToggleFavorite}
                />

                {/* 5. Paginasi */}
                <CatalogPagination
                    currentPage={currentPage}
                    totalPages={totalPages}
                    onPageChange={setCurrentPage}
                />

                {/* 6. Edukasi Tips Nilai Maksimal */}
                <MaxPriceTipsCard />

            </div>
        </NasabahAppLayout>
    );
}
