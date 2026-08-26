import React, { useState } from 'react';
import AdminAppLayout from '../../../layouts/AdminAppLayout';
import InventoryHeroBanner from './sections/InventoryHeroBanner';
import WarehouseStockGrid from './sections/WarehouseStockGrid';
import UpcyclingProductsGrid from './sections/UpcyclingProductsGrid';
import MaterialLedgerTable from './sections/MaterialLedgerTable';
import RecordOfftakerSaleModal from './sections/RecordOfftakerSaleModal';
import RecordUpcyclingModal from './sections/RecordUpcyclingModal';

export default function AdminInventoryPage({
    authData = {},
    stockData = {},
}) {
    const [isSaleModalOpen, setIsSaleModalOpen] = useState(false);
    const [isUpcyclingModalOpen, setIsUpcyclingModalOpen] = useState(false);
    const [selectedCategoryToSell, setSelectedCategoryToSell] = useState(null);

    const handleSellCategory = (cat) => {
        setSelectedCategoryToSell(cat);
        setIsSaleModalOpen(true);
    };

    return (
        <AdminAppLayout
            pageTitle="Inventaris"
            activeMenu="inventory"
            authData={authData}
        >
            <div className="space-y-6 sm:space-y-8 animate-fade-in max-w-7xl mx-auto pb-8">
                
                {/* 1. Hero Banner Inventaris Gudang */}
                <InventoryHeroBanner
                    authData={authData}
                    stockData={stockData}
                    onOpenSaleModal={() => {
                        setSelectedCategoryToSell(null);
                        setIsSaleModalOpen(true);
                    }}
                    onOpenUpcyclingModal={() => setIsUpcyclingModalOpen(true)}
                />

                {/* 2. Grid Stok Fisik Gudang per Kategori */}
                <WarehouseStockGrid
                    categories={stockData?.categories || []}
                    onSellCategory={handleSellCategory}
                />

                {/* 3. Katalog Produk Daur Ulang & Ekonomi Sirkular */}
                <UpcyclingProductsGrid />

                {/* 4. Buku Besar Sirkulasi Material & Log Mutasi */}
                <MaterialLedgerTable />

            </div>

            {/* Modal Form Catat Jual ke Pengepul */}
            <RecordOfftakerSaleModal
                isOpen={isSaleModalOpen}
                onClose={() => setIsSaleModalOpen(false)}
                selectedCategory={selectedCategoryToSell}
                onSuccess={(data) => {
                    alert(`Penjualan ${data.weightKg} Kg ${data.category} ke ${data.buyerName} berhasil dicatat! Kas unit bertambah Rp ${data.totalRevenue.toLocaleString('id-ID')}.`);
                }}
            />

            {/* Modal Form Catat Olah Karya / Kompos */}
            <RecordUpcyclingModal
                isOpen={isUpcyclingModalOpen}
                onClose={() => setIsUpcyclingModalOpen(false)}
                onSuccess={(data) => {
                    alert(`Pengalihan ${data.rawWeightKg} Kg ${data.rawCategory} menjadi ${data.outputQty} ${data.outputUnit} ${data.productType} berhasil dicatat!`);
                }}
            />
        </AdminAppLayout>
    );
}
