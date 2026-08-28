import React from 'react';
import { Heart, Trophy, Code2 } from 'lucide-react';

export default function NasabahFooter() {
    return (
        <footer className="w-full bg-white dark:bg-[#0D131F] border-t border-slate-200 dark:border-slate-800 mt-auto py-5 px-4 sm:px-6 lg:px-8 select-none transition-colors duration-200">
            <div className="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
                
                {/* Bagian Kiri: Copyright & Tim Pengembang */}
                <div className="flex flex-col sm:flex-row items-center sm:items-center gap-1.5 sm:gap-3 text-center sm:text-left">
                    <p className="font-medium text-slate-600 dark:text-slate-400">
                        © Copyright 2026 <strong className="text-slate-900 dark:text-white font-bold">SiSampah</strong>. Hak Cipta Dilindungi.
                    </p>
                    <span className="hidden sm:inline-block text-slate-300 dark:text-slate-700">•</span>
                    <p className="flex items-center gap-1 font-semibold text-slate-700 dark:text-slate-300">
                        <span>Dikembangkan oleh</span>
                        <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 font-bold border border-emerald-200 dark:border-emerald-800/80 text-[11px]">
                            <Code2 className="w-3 h-3" />
                            Bodrex Developer
                        </span>
                    </p>
                </div>

                {/* Bagian Kanan: Keterangan Lomba SWITF */}
                <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 dark:bg-[#111827] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-medium text-[11px] shadow-sm">
                    <Trophy className="w-3.5 h-3.5 text-amber-500 shrink-0" />
                    <span>Super Walisongo Information Technology Festival 2026</span>
                </div>

            </div>
        </footer>
    );
}
