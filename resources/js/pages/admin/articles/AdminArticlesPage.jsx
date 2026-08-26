import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import ArticlesHeroBanner from './sections/ArticlesHeroBanner';
import ArticlesKpiCards from './sections/ArticlesKpiCards';
import ArticlesManagementGrid from './sections/ArticlesManagementGrid';
import CreateArticleModal from './sections/CreateArticleModal';
import EditArticleModal from './sections/EditArticleModal';

export default function AdminArticlesPage({
    authData = {},
    statistics = {},
    articlesList = [],
}) {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [selectedArticleToEdit, setSelectedArticleToEdit] = useState(null);

    const handleTogglePublish = (article) => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/articles/${article.id}/toggle-publish`;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    };

    const handleDeleteArticle = (article) => {
        if (confirm(`HAPUS ARTIKEL: Apakah Anda yakin ingin menghapus artikel "${article.title}"?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/super-admin/articles/${article.id}`;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    };

    return (
        <AdminAppLayout
            pageTitle="Edukasi & Artikel"
            activeMenu="articles"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Artikel */}
                <ArticlesHeroBanner
                    authData={authData}
                    statistics={statistics}
                    onOpenCreate={() => setIsCreateModalOpen(true)}
                />

                {/* 2. 4 Kartu KPI Statistik Artikel */}
                <ArticlesKpiCards
                    statistics={statistics}
                />

                {/* 3. Filter Kategori & Grid Manajemen Artikel */}
                <ArticlesManagementGrid
                    articles={articlesList}
                    onEditArticle={(a) => setSelectedArticleToEdit(a)}
                    onTogglePublish={handleTogglePublish}
                    onDeleteArticle={handleDeleteArticle}
                />

            </div>

            {/* Modal Dialogs */}
            <CreateArticleModal
                isOpen={isCreateModalOpen}
                onClose={() => setIsCreateModalOpen(false)}
            />

            <EditArticleModal
                isOpen={Boolean(selectedArticleToEdit)}
                onClose={() => setSelectedArticleToEdit(null)}
                article={selectedArticleToEdit}
            />
        </AdminAppLayout>
    );
}
