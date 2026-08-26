import React, { useState } from 'react';
import PetugasAppLayout from '../../../layouts/PetugasAppLayout';
import PickupNasabahInfoCard from './sections/PickupNasabahInfoCard';
import WeighingItemsRepeater from './sections/WeighingItemsRepeater';
import WeighingPhotoEvidence from './sections/WeighingPhotoEvidence';
import WeighingSummaryCard from './sections/WeighingSummaryCard';

export default function WeighingFormPage({
    authData = {},
    targetNasabah = {},
    trashCategories = [],
    pendingItems = [],
    csrfToken = '',
}) {
    // Inisialisasi baris timbangan dari pending item atau default 1 baris
    const initialRows = (pendingItems && pendingItems.length > 0)
        ? pendingItems.map((p, idx) => ({
            id: `row-${idx}-${Date.now()}`,
            trash_category_id: p.trash_category_id || (trashCategories[0]?.id ?? ''),
            berat_kg: p.berat_kg || '',
        }))
        : [
            {
                id: `row-0-${Date.now()}`,
                trash_category_id: trashCategories[0]?.id ?? '',
                berat_kg: '',
            },
        ];

    const [items, setItems] = useState(initialRows);
    const [isSubmitting, setIsSubmitting] = useState(false);

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
            pageTitle="Input Timbangan"
            activeMenu="manifest"
            authData={authData}
        >
            <form
                action="/petugas/input-timbangan"
                method="POST"
                encType="multipart/form-data"
                onSubmit={handleSubmit}
                className="space-y-6 sm:space-y-8 animate-fade-in max-w-6xl mx-auto pb-8"
            >
                {/* CSRF & User ID */}
                <input type="hidden" name="_token" value={csrfToken} />
                <input type="hidden" name="user_id" value={targetNasabah?.id || ''} />

                {/* 1. Profil Nasabah Info Card */}
                <PickupNasabahInfoCard
                    targetNasabah={targetNasabah}
                />

                {/* 2. Grid Form: Repeater & Summary */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {/* Left 8 Cols: Repeater Items & Photo Upload */}
                    <div className="lg:col-span-8 space-y-6">
                        
                        <WeighingItemsRepeater
                            trashCategories={trashCategories}
                            items={items}
                            onAddItem={handleAddItem}
                            onRemoveItem={handleRemoveItem}
                            onUpdateItem={handleUpdateItem}
                        />

                        <WeighingPhotoEvidence />

                    </div>

                    {/* Right 4 Cols: Summary Card */}
                    <div className="lg:col-span-4">
                        <WeighingSummaryCard
                            totalWeight={totalWeight}
                            totalRupiah={totalRupiah}
                            totalPoints={totalPoints}
                            targetNasabah={targetNasabah}
                            isSubmitting={isSubmitting}
                        />
                    </div>

                </div>

            </form>
        </PetugasAppLayout>
    );
}
