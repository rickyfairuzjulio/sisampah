import React, { useState, useRef } from 'react';
import { Camera, Upload, X, Check, Image as ImageIcon } from 'lucide-react';

export default function WeighingPhotoEvidence() {
    const [previewUrl, setPreviewUrl] = useState(null);
    const fileInputRef = useRef(null);

    const handleFileChange = (e) => {
        const file = e.target.files?.[0];
        if (file) {
            const url = URL.createObjectURL(file);
            setPreviewUrl(url);
        }
    };

    const handleClearPhoto = () => {
        setPreviewUrl(null);
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    return (
        <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs space-y-4 select-none">
            
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-sm">
                        2
                    </div>
                    <div>
                        <h3 className="font-black text-base text-slate-900 tracking-tight">
                            Foto Bukti Timbangan (Opsional)
                        </h3>
                        <p className="text-xs text-slate-500">
                            Dokumentasikan foto skala timbangan riil atau nota di lokasi nasabah
                        </p>
                    </div>
                </div>

                <span className="text-[11px] font-bold text-slate-400">
                    Kamera / Berkas
                </span>
            </div>

            {/* Hidden actual file input */}
            <input
                ref={fileInputRef}
                type="file"
                name="foto_bukti"
                accept="image/*"
                capture="environment"
                onChange={handleFileChange}
                className="hidden"
            />

            {!previewUrl ? (
                <div
                    onClick={() => fileInputRef.current?.click()}
                    className="border-2 border-dashed border-slate-300 hover:border-emerald-500 hover:bg-emerald-50/30 rounded-2xl p-6 sm:p-8 text-center cursor-pointer transition-all space-y-3 group"
                >
                    <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 flex items-center justify-center mx-auto transition-transform shadow-2xs">
                        <Camera className="w-6 h-6" />
                    </div>
                    <div className="space-y-1">
                        <p className="text-xs sm:text-sm font-black text-slate-800 group-hover:text-emerald-800">
                            Ambil Foto Kamera atau Unggah Berkas
                        </p>
                        <p className="text-xs text-slate-400">
                            Format JPG, PNG (Maks. 2MB)
                        </p>
                    </div>
                </div>
            ) : (
                <div className="relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-900/5 max-h-72">
                    <img
                        src={previewUrl}
                        alt="Bukti Timbangan"
                        className="w-full h-full object-contain max-h-72"
                    />
                    <div className="absolute top-3 right-3 flex items-center gap-2">
                        <button
                            type="button"
                            onClick={handleClearPhoto}
                            className="p-2 rounded-xl bg-slate-900/80 hover:bg-rose-600 text-white backdrop-blur-md transition-colors shadow-sm cursor-pointer"
                            title="Hapus foto"
                        >
                            <X className="w-4 h-4" />
                        </button>
                    </div>
                    <div className="absolute bottom-3 left-3 px-3 py-1 rounded-xl bg-emerald-600/90 backdrop-blur-md text-white text-[11px] font-bold shadow-2xs flex items-center gap-1.5">
                        <Check className="w-3.5 h-3.5" />
                        <span>Foto Berhasil Dipilih</span>
                    </div>
                </div>
            )}

        </div>
    );
}
