import React from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';

export default function CatalogPagination({
    currentPage = 1,
    totalPages = 1,
    onPageChange,
}) {
    if (totalPages <= 1) return null;

    return (
        <div className="flex items-center justify-center gap-2 pt-4 select-none">
            <button
                onClick={() => onPageChange(currentPage - 1)}
                disabled={currentPage <= 1}
                className="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors shadow-sm flex items-center gap-1"
            >
                <ChevronLeft className="w-4 h-4" />
                <span>Sebelumnya</span>
            </button>

            <div className="flex items-center gap-1.5">
                {Array.from({ length: totalPages }).map((_, idx) => {
                    const pageNum = idx + 1;
                    const isActive = pageNum === currentPage;

                    return (
                        <button
                            key={pageNum}
                            onClick={() => onPageChange(pageNum)}
                            className={`w-9 h-9 rounded-xl text-xs font-black transition-all shadow-sm ${
                                isActive
                                    ? 'bg-emerald-600 text-white'
                                    : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50'
                            }`}
                        >
                            {pageNum}
                        </button>
                    );
                })}
            </div>

            <button
                onClick={() => onPageChange(currentPage + 1)}
                disabled={currentPage >= totalPages}
                className="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors shadow-sm flex items-center gap-1"
            >
                <span>Selanjutnya</span>
                <ChevronRight className="w-4 h-4" />
            </button>
        </div>
    );
}
