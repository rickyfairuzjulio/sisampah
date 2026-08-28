import React from 'react';
import { Trophy, Award, Lightbulb, CheckCircle2 } from 'lucide-react';

export default function CommunityLeaderboard({ leaderboard = [], authData = {} }) {
    const currentUserId = authData?.user?.id;

    const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

    const getRankStyle = (index) => {
        if (index === 0) return 'bg-amber-400 text-amber-950 font-black shadow-sm';
        if (index === 1) return 'bg-slate-300 text-slate-900 font-bold';
        if (index === 2) return 'bg-amber-700 text-white font-bold';
        return 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-medium';
    };

    return (
        <div className="space-y-6">
            
            {/* Leaderboard Card */}
            <div className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4 transition-colors duration-200">
                <div className="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 className="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <Trophy className="w-4 h-4 text-amber-500" />
                        <span>Papan Peringkat Warga</span>
                    </h3>
                    <span className="text-[11px] text-slate-400 dark:text-slate-500 font-medium">Top 5 Unit</span>
                </div>

                <div className="space-y-2.5">
                    {leaderboard.length > 0 ? (
                        leaderboard.map((entry, idx) => {
                            const isMe = entry.user_id === currentUserId;
                            return (
                                <div
                                    key={idx}
                                    className={`flex items-center gap-3 p-2.5 sm:p-3 rounded-xl transition-colors ${
                                        isMe 
                                            ? 'bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800' 
                                            : 'bg-slate-50 dark:bg-[#0D131F] border border-transparent dark:border-slate-800/60'
                                    }`}
                                >
                                    <div className="relative shrink-0">
                                        <span className={`w-7 h-7 rounded-full flex items-center justify-center text-xs ${getRankStyle(idx)}`}>
                                            {idx + 1}
                                        </span>
                                    </div>

                                    <div className="flex-1 min-w-0">
                                        <p className="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 truncate flex items-center gap-1">
                                            <span>{entry.user?.name || 'Warga'}</span>
                                            {isMe && (
                                                <span className="text-[9px] bg-emerald-600 dark:bg-emerald-500 text-white dark:text-slate-950 px-1.5 py-0.2 rounded-full font-bold">
                                                    Anda
                                                </span>
                                            )}
                                        </p>
                                        <p className="text-[11px] text-slate-400 dark:text-slate-500 truncate">
                                            {entry.badge_name || 'Warga Peduli'}
                                        </p>
                                    </div>

                                    <div className="text-right shrink-0">
                                        <span className="font-black text-xs sm:text-sm text-slate-800 dark:text-slate-200 block">
                                            {formatNumber(entry.total_poin_lingkungan || 0)}
                                        </span>
                                        <span className="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">
                                            XP
                                        </span>
                                    </div>
                                </div>
                            );
                        })
                    ) : (
                        <div className="py-6 text-center text-slate-400 dark:text-slate-500 text-xs">
                            Belum ada data peringkat unit
                        </div>
                    )}
                </div>
            </div>

            {/* Quick Tips Card */}
            <div className="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/40 dark:to-slate-900 border border-emerald-200 dark:border-emerald-800/80 rounded-2xl p-5 shadow-sm space-y-3 transition-colors duration-200">
                <h4 className="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5">
                    <Lightbulb className="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                    <span>Tips Mengoptimalkan Saldo</span>
                </h4>
                <ul className="space-y-2 text-xs text-emerald-950 dark:text-slate-300 font-medium">
                    <li className="flex items-start gap-2">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
                        <span>Bersihkan botol dan kardus sebelum disetorkan untuk nilai jual maksimal.</span>
                    </li>
                    <li className="flex items-start gap-2">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
                        <span>Kumpulkan minimal 5 kg agar armada dapat menjemput langsung ke rumah.</span>
                    </li>
                    <li className="flex items-start gap-2">
                        <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
                        <span>Setor rutin mingguan untuk mempercepat kenaikan Level Badge XP Anda.</span>
                    </li>
                </ul>
            </div>

        </div>
    );
}
