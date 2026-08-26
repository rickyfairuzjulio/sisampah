import React, { useState } from 'react';
import { AlertCircle, CheckCircle2 } from 'lucide-react';
import NasabahAppLayout from '../../../layouts/NasabahAppLayout';
import PickupHeroBanner from './sections/PickupHeroBanner';
import BankSampahPartnerCard from './sections/BankSampahPartnerCard';
import TrashItemsRepeater from './sections/TrashItemsRepeater';
import PickupLocationMap from './sections/PickupLocationMap';
import PickupScheduleDetails from './sections/PickupScheduleDetails';
import PickupHistoryList from './sections/PickupHistoryList';

export default function PickupBookingPage({
    authData = {},
    bankSampah = {},
    trashCategories = [],
    pickupHistory = [],
    csrfToken = '',
    sessionStatus = '',
    sessionError = '',
    errors = {},
}) {
    const user = authData?.user || {};

    // Initial items state
    const defaultCategoryId = trashCategories[0]?.id || '';
    const [items, setItems] = useState([
        { trash_category_id: defaultCategoryId, perkiraan_berat: '5.0' },
    ]);

    const [userLat, setUserLat] = useState(bankSampah.latitude || -6.8915);
    const [userLng, setUserLng] = useState(bankSampah.longitude || 107.6107);
    const [isSubmitting, setIsSubmitting] = useState(false);

    // Handlers for repeater
    const handleAddItem = () => {
        setItems((prev) => [
            ...prev,
            { trash_category_id: defaultCategoryId, perkiraan_berat: '2.0' },
        ]);
    };

    const handleRemoveItem = (index) => {
        if (items.length <= 1) return;
        setItems((prev) => prev.filter((_, idx) => idx !== index));
    };

    const handleItemChange = (index, field, value) => {
        setItems((prev) =>
            prev.map((it, idx) => (idx === index ? { ...it, [field]: value } : it))
        );
    };

    const handleLocationChange = (lat, lng) => {
        setUserLat(lat);
        setUserLng(lng);
    };

    return (
        <NasabahAppLayout
            pageTitle="Jadwalkan Penjemputan"
            activeMenu="pickup"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-5xl mx-auto pb-8">
                
                {/* 1. Flash Messages */}
                {sessionStatus && (
                    <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm animate-slide-in">
                        <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
                        <span>{sessionStatus}</span>
                    </div>
                )}

                {sessionError && (
                    <div className="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm animate-slide-in">
                        <AlertCircle className="w-5 h-5 text-red-600 shrink-0" />
                        <span>{sessionError}</span>
                    </div>
                )}

                {/* 2. Hero Banner */}
                <PickupHeroBanner />

                {/* 3. Partner Bank Sampah Card */}
                <BankSampahPartnerCard bankSampah={bankSampah} />

                {/* 4. Native Booking Form */}
                <form 
                    method="POST" 
                    action="/jemput-sampah" 
                    onSubmit={() => setIsSubmitting(true)}
                    className="space-y-6 sm:space-y-8"
                >
                    <input type="hidden" name="_token" value={csrfToken} />
                    <input type="hidden" name="bank_sampah_id" value={bankSampah.id || ''} />

                    {/* Step 1: Trash Items Dynamic Repeater */}
                    <TrashItemsRepeater
                        items={items}
                        trashCategories={trashCategories}
                        onAddItem={handleAddItem}
                        onRemoveItem={handleRemoveItem}
                        onItemChange={handleItemChange}
                    />

                    {/* Step 2: Interactive Leaflet Map & GPS */}
                    <PickupLocationMap
                        bankSampah={bankSampah}
                        userLat={userLat}
                        userLng={userLng}
                        onLocationChange={handleLocationChange}
                    />

                    {/* Step 3: Address, Time Slot & Submit Action */}
                    <PickupScheduleDetails
                        user={user}
                        items={items}
                        trashCategories={trashCategories}
                        isSubmitting={isSubmitting}
                    />
                </form>

                {/* 5. Recent Pickup Tracking History */}
                <PickupHistoryList pickupHistory={pickupHistory} />

            </div>
        </NasabahAppLayout>
    );
}
