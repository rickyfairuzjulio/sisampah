import React, { useEffect, useRef } from 'react';
import { MapPin, Truck, ExternalLink } from 'lucide-react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default function GisRadiusMapCard({ bankSampahs = [], authData = {} }) {
    const mapContainerRef = useRef(null);
    const mapInstanceRef = useRef(null);

    const userBankSampah = bankSampahs.find(
        (b) => b.id === authData?.bank_sampah_id
    ) || bankSampahs[0] || {
        nama: 'Bank Sampah Unit Melati',
        latitude: -6.8915,
        longitude: 107.6107,
        radius_layanan: 5.0,
        alamat: 'Jl. Melati No. 12, Desa Lestari',
    };

    useEffect(() => {
        if (!mapContainerRef.current) return;

        // Cleanup existing map instance
        if (mapInstanceRef.current) {
            mapInstanceRef.current.remove();
            mapInstanceRef.current = null;
        }

        const lat = parseFloat(userBankSampah.latitude) || -6.8915;
        const lng = parseFloat(userBankSampah.longitude) || 107.6107;
        const radiusKm = parseFloat(userBankSampah.radius_layanan) || 5.0;

        const map = L.map(mapContainerRef.current, {
            center: [lat, lng],
            zoom: 12,
            scrollWheelZoom: false,
        });

        mapInstanceRef.current = map;

        // OpenStreetMap CartoDB Voyager tiles
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            maxZoom: 19,
        }).addTo(map);

        // Custom Emerald Marker Icon
        const customIcon = L.divIcon({
            className: 'custom-leaflet-marker',
            html: `
                <div style="background-color: #16A34A; width: 34px; height: 34px; border-radius: 50%; border: 3px solid #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
            `,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
        });

        // Add Marker
        L.marker([lat, lng], { icon: customIcon })
            .addTo(map)
            .bindPopup(`
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 4px;">
                    <strong style="font-size: 13px; color: #0F172A; display: block;">${userBankSampah.nama}</strong>
                    <span style="font-size: 11px; color: #64748B;">${userBankSampah.alamat || 'Pusat Operasional Unit'}</span>
                    <div style="margin-top: 6px; font-size: 11px; color: #16A34A; font-weight: bold;">
                        Radius Penjemputan: ${radiusKm} KM
                    </div>
                </div>
            `)
            .openPopup();

        // Add Service Radius Circle
        L.circle([lat, lng], {
            color: '#16A34A',
            fillColor: '#22C55E',
            fillOpacity: 0.15,
            radius: radiusKm * 1000,
            weight: 2,
            dashArray: '5, 5',
        }).addTo(map);

        return () => {
            if (mapInstanceRef.current) {
                mapInstanceRef.current.remove();
                mapInstanceRef.current = null;
            }
        };
    }, [userBankSampah]);

    return (
        <section className="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
            
            {/* Header Toolbar */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div className="space-y-1">
                    <h3 className="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <MapPin className="w-5 h-5 text-emerald-600" />
                        <span>Lokasi Bank Sampah & Radius Penjemputan</span>
                    </h3>
                    <p className="text-xs text-slate-500">
                        Cakupan radius layanan penjemputan armada ke pemukiman rumah Anda ({userBankSampah.nama}).
                    </p>
                </div>

                <a
                    href="/nasabah/jemput-sampah"
                    className="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all shrink-0"
                >
                    <Truck className="w-4 h-4" />
                    <span>Pesan Penjemputan</span>
                </a>
            </div>

            {/* Map Container */}
            <div className="relative w-full h-[320px] sm:h-[380px] rounded-xl overflow-hidden border border-slate-200 z-10">
                <div ref={mapContainerRef} className="w-full h-full" />
            </div>

            <div className="flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 pt-1">
                <div className="flex items-center gap-4">
                    <span className="flex items-center gap-1.5">
                        <span className="w-3 h-3 rounded-full bg-emerald-600 border border-white inline-block shadow-sm" />
                        <span>Pos Bank Sampah</span>
                    </span>
                    <span className="flex items-center gap-1.5">
                        <span className="w-3 h-3 rounded-full bg-emerald-500/30 border border-emerald-500 inline-block" />
                        <span>Area Jangkauan ({userBankSampah.radius_layanan || 5.0} KM)</span>
                    </span>
                </div>
                <span className="text-[11px] text-slate-400">
                    GPS terintegrasi akurat
                </span>
            </div>

        </section>
    );
}
