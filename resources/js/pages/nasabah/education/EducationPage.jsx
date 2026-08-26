import React, { useState } from 'react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import EducationHeroBanner from './sections/EducationHeroBanner';
import EducationCategoryFilter from './sections/EducationCategoryFilter';
import FeaturedArticleCard from './sections/FeaturedArticleCard';
import ArticleCardsGrid from './sections/ArticleCardsGrid';
import SortingCheatSheetSection from './sections/SortingCheatSheetSection';
import ArticleReaderModal from './sections/ArticleReaderModal';

export default function EducationPage({
    authData = {},
    allArticles = [],
    featuredArticle = null,
    categories = [],
}) {
    const [selectedCategory, setSelectedCategory] = useState('all');
    const [activeReaderArticle, setActiveReaderArticle] = useState(null);

    // Client-side filtering logic
    const filteredArticles = allArticles.filter((article) => {
        if (selectedCategory === 'all') return true;
        const cat = (article.kategori || '').toLowerCase();
        if (selectedCategory === 'organik') {
            return cat.includes('organik') || cat.includes('kompos');
        }
        if (selectedCategory === 'plastik') {
            return cat.includes('plastik') || cat.includes('anorganik');
        }
        if (selectedCategory === 'kreasi') {
            return cat.includes('kreasi') || cat.includes('daur ulang');
        }
        if (selectedCategory === 'zerowaste') {
            return cat.includes('zero') || cat.includes('tips') || cat.includes('lingkungan');
        }
        return true;
    });

    return (
        <NasabahAppLayout
            pageTitle="Edukasi"
            activeMenu="edukasi"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Hero Banner */}
                <EducationHeroBanner />

                {/* 2. Category Filter Pills */}
                <EducationCategoryFilter
                    categories={categories}
                    selectedCategory={selectedCategory}
                    onSelectCategory={(catId) => setSelectedCategory(catId)}
                />

                {/* 3. Featured Article Card (shown when category is 'all' or when relevant) */}
                {selectedCategory === 'all' && featuredArticle && (
                    <FeaturedArticleCard
                        article={featuredArticle}
                        onReadArticle={(art) => setActiveReaderArticle(art)}
                    />
                )}

                {/* 4. Grid of Articles */}
                <ArticleCardsGrid
                    articles={filteredArticles}
                    onReadArticle={(art) => setActiveReaderArticle(art)}
                />

                {/* 5. 3W Sorting Cheat Sheet */}
                <SortingCheatSheetSection />

                {/* 6. Article Reader Modal */}
                <ArticleReaderModal
                    isOpen={!!activeReaderArticle}
                    article={activeReaderArticle}
                    onClose={() => setActiveReaderArticle(null)}
                />

            </div>
        </NasabahAppLayout>
    );
}
