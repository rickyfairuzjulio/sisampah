import React, { useState } from 'react';
import PetugasAppLayout from '../../../layouts/PetugasAppLayout';
import SelfDepositHeroBanner from './sections/SelfDepositHeroBanner';
import NasabahLookupSection from './sections/NasabahLookupSection';
import TrashItemsInputTable from './sections/TrashItemsInputTable';
import PhotoEvidenceSection from './sections/PhotoEvidenceSection';
import DepositSummaryCard from './sections/DepositSummaryCard';

export default function SelfDepositPage({
    authData = {},
    trashCategories = [],
    registeredNasabahs = [],
    csrfToken = '',
}) {
    const [selectedEmail, setSelectedEmail] = useState('');
    const [items, setItems] = useState([
        {
            id: `row-0-${Date.now()}`,
            trash_category_id: trashCategories[0]?.id ?? '',
            berat_kg: '',
        },
    ]);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const selectedNasabah = registeredNasabahs.find(
        (n) => (n.email || '').toLowerCase() === (selectedEmail || '').toLowerCase()
    );

    const handleAddItem = () => {
        setItems([
            ...items,
            {
                id: `row-${items.length}-${Date.now()}`,
                trash_category_id: trashCategories[0]?.id ?? '',
                berat_kg: '',
            },
        ]);
    };

    const handleRemoveItem = (index) => {
        if (items.length <= 1) return;
        setItems(items.filter((_, idx) => idx !== index));
    };

    const handleUpdateItem = (index, field, value) => {
        const updated = [...items];
        updated[index][field] = value;
        setItems(updated);
    };

    // Kalkulasi Total
    let totalWeight = 0;
    let totalRupiah = 0;
    let totalPoints = 0;

    items.forEach((item) => {
        const cat = trashCategories.find((c) => String(c.id) === String(item.trash_category_id));
        const price = cat ? Number(cat.harga_per_kg) : 0;
        const weight = parseFloat(item.berat_kg) || 0;
        totalWeight += weight;
        totalRupiah += weight * price;
        totalPoints += Math.round(weight * 15);
    });

    const handleSubmit = () => {
        setIsSubmitting(true);
    };

    return (
        <PetugasAppLayout
            pageTitle="Setor Mandiri"
            activeMenu="self_deposit"
            authData={authData}
        >
            <form
                action="/petugas/setor-mandiri"
                method="POST"
                encType="multipart/form-data"
                onSubmit={handleSubmit}
                className="space-y-6 sm:space-y-8 animate-fade-in max-w-6xl mx-auto pb-8"
            >
                {/* CSRF Token */}
                <input type="hidden" name="_token" value={csrfToken} />

                {/* 1. Hero Banner */}
                <SelfDepositHeroBanner
                    authData={authData}
                />

                {/* 2. Grid Form: Nasabah Lookup, Table, Photo, and Summary */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {/* Left 8 Cols: Nasabah, Table, Photo */}
                    <div className="lg:col-span-8 space-y-6">
                        
                        <NasabahLookupSection
                            registeredNasabahs={registeredNasabahs}
                            selectedEmail={selectedEmail}
                            onSelectEmail={(email) => setSelectedEmail(email)}
                        />

                        <TrashItemsInputTable
                            trashCategories={trashCategories}
                            items={items}
                            onAddItem={handleAddItem}
                            onRemoveItem={handleRemoveItem}
                            onUpdateItem={handleUpdateItem}
                        />

                        <PhotoEvidenceSection />

                    </div>

                    {/* Right 4 Cols: Summary Card */}
                    <div className="lg:col-span-4">
                        <DepositSummaryCard
                            totalWeight={totalWeight}
                            totalRupiah={totalRupiah}
                            totalPoints={totalPoints}
                            selectedNasabah={selectedNasabah}
                            isSubmitting={isSubmitting}
                        />
                    </div>

                </div>

            </form>
        </PetugasAppLayout>
    );
}
