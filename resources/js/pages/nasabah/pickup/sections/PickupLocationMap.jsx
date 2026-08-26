import React, { useEffect, useRef, useState } from 'react';
import { MapContainer, TileLayer, Marker, Circle, useMapEvents } from 'react-leaflet';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { MapPin, Navigation, Compass, AlertTriangle, CheckCircle2 } from 'lucide-react';

// Custom icons
const houseIcon = L.divIcon({
    className: 'custom-house-marker',
    html: `<div style="background-color: #16A34A; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4); border: 3px solid white;">
             <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
           </div>`,
    iconSize: [36, 36],
    iconAnchor: [18, 18],
});

const bankIcon = L.divIcon({
    className: 'custom-bank-marker',
    html: `<div style="background-color: #0F172A; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3); border: 2px solid white;">
             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
           </div>`,
    iconSize: [32, 32],
    iconAnchor: [16, 16],
});

function MapClickHandler({ onLocationSelect }) {
    useMapEvents({
        click(e) {
            onLocationSelect(e.latlng.lat, e.latlng.lng);
        },
    });
    return null;
}

export default function PickupLocationMap({
    bankSampah = {},
    userLat = -6.8915,
    userLng = 107.6107,
    onLocationChange,
}) {
    const [lat, setLat] = useState(userLat);
    const [lng, setLng] = useState(userLng);
    const [isLocating, setIsLocating] = useState(false);
    const mapRef = useRef(null);

    const bankLat = bankSampah.latitude || -6.8915;
    const bankLng = bankSampah.longitude || 107.6107;
    const maxRadiusKm = bankSampah.radius_layanan || 5.0;

    // Haversine distance formula
    const calculateDistance = (lat1, lon1, lat2, lon2) => {
        const R = 6371; // km
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLon = (lon2 - lon1) * (Math.PI / 180);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) *
                Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    };

    const currentDistance = calculateDistance(bankLat, bankLng, lat, lng);
    const isWithinRadius = currentDistance <= maxRadiusKm;

    const handleSelectLocation = (newLat, newLng) => {
        setLat(newLat);
        setLng(newLng);
        if (onLocationChange) {
            onLocationChange(newLat, newLng);
        }
    };

    const handleDetectGPS = () => {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung deteksi lokasi otomatis.');
            return;
        }

        setIsLocating(true);
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const newLat = pos.coords.latitude;
                const newLng = pos.coords.longitude;
                handleSelectLocation(newLat, newLng);
                setIsLocating(false);
                if (mapRef.current) {
                    mapRef.current.flyTo([newLat, newLng], 16);
                }
            },
            (err) => {
                console.warn('Geolocation failed:', err);
                setIsLocating(false);
                alert('Gagal mendeteksi lokasi otomatis. Silakan klik langsung pada peta.');
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            
            {/* Hidden native form inputs */}
            <input type="hidden" name="koordinat_lat" value={lat} />
            <input type="hidden" name="koordinat_lng" value={lng} />

            {/* Step Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                <div className="flex items-center gap-3.5">
                    <div className="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shrink-0 shadow-md">
                        2
                    </div>
                    <div>
                        <h3 className="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                            Titik Lokasi Rumah & Peta GPS
                        </h3>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Geser pin atau klik pada peta untuk menentukan lokasi penjemputan armada yang akurat.
                        </p>
                    </div>
                </div>

                {/* GPS Auto Detect Button */}
                <button
                    type="button"
                    onClick={handleDetectGPS}
                    disabled={isLocating}
                    className="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-xs shadow-2xs flex items-center justify-center gap-2 transition-colors cursor-pointer shrink-0"
                >
                    <Navigation className={`w-4 h-4 text-emerald-600 ${isLocating ? 'animate-spin' : ''}`} />
                    <span>{isLocating ? 'Mendeteksi GPS...' : '🎯 Gunakan Lokasi GPS Saya'}</span>
                </button>
            </div>

            {/* Interactive Leaflet Map Container */}
            <div className="relative rounded-2xl overflow-hidden border border-slate-200 shadow-inner h-80 sm:h-96 z-0">
                <MapContainer
                    center={[lat, lng]}
                    zoom={15}
                    scrollWheelZoom={false}
                    className="w-full h-full"
                    ref={mapRef}
                >
                    <TileLayer
                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    />

                    {/* Bank Sampah Service Radius Boundary */}
                    <Circle
                        center={[bankLat, bankLng]}
                        radius={maxRadiusKm * 1000}
                        pathOptions={{
                            color: '#16A34A',
                            fillColor: '#22C55E',
                            fillOpacity: 0.1,
                            weight: 2,
                            dashArray: '6, 6',
                        }}
                    />

                    {/* Bank Sampah Basecamp Marker */}
                    <Marker position={[bankLat, bankLng]} icon={bankIcon} />

                    {/* Nasabah Home Location Marker (Draggable) */}
                    <Marker
                        position={[lat, lng]}
                        icon={houseIcon}
                        draggable={true}
                        eventHandlers={{
                            dragend: (e) => {
                                const marker = e.target;
                                const position = marker.getLatLng();
                                handleSelectLocation(position.lat, position.lng);
                            },
                        }}
                    />

                    <MapClickHandler onLocationSelect={handleSelectLocation} />
                </MapContainer>

                {/* Floating Map Legend Indicator */}
                <div className="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl shadow-md border border-slate-200 text-[11px] font-semibold text-slate-700 flex items-center gap-3 z-[1000]">
                    <div className="flex items-center gap-1.5">
                        <span className="w-2.5 h-2.5 rounded-full bg-emerald-600" />
                        <span>Rumah Anda (Pin)</span>
                    </div>
                    <div className="flex items-center gap-1.5">
                        <span className="w-2.5 h-2.5 rounded-full bg-slate-900" />
                        <span>Basecamp Bank Sampah</span>
                    </div>
                </div>
            </div>

            {/* Distance & Boundary Validation Status Bar */}
            <div className={`p-4 rounded-2xl border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 ${
                isWithinRadius 
                    ? 'bg-emerald-50/70 border-emerald-200 text-emerald-900' 
                    : 'bg-red-50/70 border-red-200 text-red-900'
            }`}>
                <div className="flex items-center gap-2.5 text-xs">
                    <Compass className={`w-4 h-4 shrink-0 ${isWithinRadius ? 'text-emerald-600' : 'text-red-600'}`} />
                    <span>
                        <strong>Koordinat:</strong> {lat.toFixed(6)}, {lng.toFixed(6)}
                    </span>
                    <span className="text-slate-300">•</span>
                    <span>
                        <strong>Jarak ke Basecamp:</strong> {currentDistance.toFixed(2)} KM
                    </span>
                </div>

                <div className="text-xs font-black">
                    {isWithinRadius ? (
                        <span className="inline-flex items-center gap-1 text-emerald-700">
                            <CheckCircle2 className="w-3.5 h-3.5" />
                            <span>Dalam Radius Layanan (Maks. {maxRadiusKm} KM) ✓</span>
                        </span>
                    ) : (
                        <span className="inline-flex items-center gap-1 text-red-600">
                            <AlertTriangle className="w-3.5 h-3.5" />
                            <span>Di luar radius layanan (Maks. {maxRadiusKm} KM)</span>
                        </span>
                    )}
                </div>
            </div>

        </div>
    );
}
