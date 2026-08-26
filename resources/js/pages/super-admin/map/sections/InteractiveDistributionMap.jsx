import React, { useEffect, useRef } from 'react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default function InteractiveDistributionMap({
    bankSampahs = [],
    selectedUnit = null,
    onSelectUnit,
    showRadius = true,
}) {
    const mapContainerRef = useRef(null);
    const mapInstanceRef = useRef(null);
    const markersLayerRef = useRef(null);
    const circlesLayerRef = useRef(null);

    // 1. Initialize Leaflet Map
    useEffect(() => {
        if (!mapContainerRef.current) return;

        if (!mapInstanceRef.current) {
            const map = L.map(mapContainerRef.current, {
                center: [-6.9928, 110.3541],
                zoom: 11,
                zoomControl: false,
            });

            // Clean, modern light CartoDB Voyager tiles
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                maxZoom: 19,
            }).addTo(map);

            // Add Zoom Control at top right
            L.control.zoom({ position: 'topright' }).addTo(map);

            markersLayerRef.current = L.layerGroup().addTo(map);
            circlesLayerRef.current = L.layerGroup().addTo(map);

            mapInstanceRef.current = map;
        }

        return () => {
            if (mapInstanceRef.current) {
                mapInstanceRef.current.remove();
                mapInstanceRef.current = null;
            }
        };
    }, []);

    // 2. Render Markers and Radius Circles
    useEffect(() => {
        const map = mapInstanceRef.current;
        if (!map || !markersLayerRef.current || !circlesLayerRef.current) return;

        markersLayerRef.current.clearLayers();
        circlesLayerRef.current.clearLayers();

        const bounds = L.latLngBounds();

        bankSampahs.forEach((bs) => {
            const lat = parseFloat(bs.latitude) || -6.9928;
            const lng = parseFloat(bs.longitude) || 110.3541;
            const latLng = [lat, lng];
            bounds.extend(latLng);

            const isSelected = selectedUnit?.id === bs.id;
            const statusColor = bs.status === 'aktif' ? '#059669' : bs.status === 'libur' ? '#D97706' : '#E11D48';

            // Custom Pin Icon
            const iconHtml = `
                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: ${isSelected ? '38px' : '30px'};
                    height: ${isSelected ? '38px' : '30px'};
                    background-color: ${statusColor};
                    color: white;
                    border: 3px solid white;
                    border-radius: 50%;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
                    font-size: ${isSelected ? '14px' : '11px'};
                    font-weight: 900;
                    cursor: pointer;
                    transition: transform 0.2s;
                ">
                    🏢
                </div>
            `;

            const customIcon = L.divIcon({
                html: iconHtml,
                className: 'custom-pin-marker',
                iconSize: [isSelected ? 38 : 30, isSelected ? 38 : 30],
                iconAnchor: [isSelected ? 19 : 15, isSelected ? 19 : 15],
            });

            const marker = L.marker(latLng, { icon: customIcon });

            // Popup
            marker.bindPopup(`
                <div style="font-family: inherit; padding: 4px; max-width: 220px;">
                    <strong style="font-size: 13px; color: #0F172A; display: block;">${bs.nama}</strong>
                    <span style="font-size: 11px; color: #64748B;">${bs.desa || ''}, ${bs.kecamatan || ''}</span>
                    <div style="margin-top: 6px; font-size: 11px; font-weight: bold; color: ${statusColor};">
                        ● ${bs.status === 'aktif' ? 'Aktif Beroperasi' : bs.status === 'libur' ? 'Libur Sementara' : 'Nonaktif/Suspend'}
                    </div>
                </div>
            `);

            marker.on('click', () => {
                if (onSelectUnit) onSelectUnit(bs);
                map.flyTo(latLng, 14, { duration: 0.8 });
            });

            markersLayerRef.current.addLayer(marker);

            // Radius Circle
            if (showRadius) {
                const radiusMeters = (bs.radius_layanan || 5.0) * 1000;
                const circle = L.circle(latLng, {
                    radius: radiusMeters,
                    color: statusColor,
                    fillColor: statusColor,
                    fillOpacity: isSelected ? 0.18 : 0.08,
                    weight: isSelected ? 2 : 1,
                    dashArray: isSelected ? null : '4, 4',
                });
                circlesLayerRef.current.addLayer(circle);
            }
        });

        // Fit map to markers bounds if multiple units
        if (bankSampahs.length > 0 && !selectedUnit) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 13 });
        }
    }, [bankSampahs, selectedUnit, showRadius, onSelectUnit]);

    return (
        <div className="relative rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm bg-slate-100 min-h-[560px] h-full flex flex-col">
            <div ref={mapContainerRef} className="w-full flex-1 z-0 min-h-[560px]" />
        </div>
    );
}
