import React from 'react';
import { Heart, Trophy, Code2 } from 'lucide-react';

export default function NasabahFooter() {
    return (
        <footer className="w-full bg-white border-t border-slate-200 mt-auto py-5 px-4 sm:px-6 lg:px-8 select-none">
            <div className="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                
                {/* Bagian Kiri: Copyright & Tim Pengembang */}
                <div className="flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left">
                    <p className="font-medium text-slate-600">
                        © Copyright 2026 <strong className="text-slate-900 font-bold">SiSampah</strong>. Hak Cipta Dilindungi.
                    </p>
                    <span className="hidden sm:inline-block text-slate-300">•</span>
                    <p className="flex items-center gap-1 font-semibold text-slate-700">
                        <span>Dikembangkan oleh</span>
                        <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 text-[11px]">
                            <Code2 className="w-3 h-3" />
                            Bodrex Developer
                        </span>
                    </p>
                </div>

                {/* Bagian Kanan: Keterangan Lomba SWITF */}
                <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 text-slate-700 border border-slate-200 font-medium text-[11px] shadow-sm">
                    <Trophy className="w-3.5 h-3.5 text-amber-500 shrink-0" />
                    <span>Super Walisongo Information Technology Festival 2026</span>
                </div>

            </div>
        </footer>
    );
}
