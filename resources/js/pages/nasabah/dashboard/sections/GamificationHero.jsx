import React from 'react';
import { Sparkles, Trophy } from 'lucide-react';

export default function GamificationHero({ authData = {}, gamification = {} }) {
    const user = authData?.user || {};
    const firstName = user?.name ? user.name.split(' ')[0] : 'Nasabah';

    const level = gamification?.level || 1;
    const badgeName = gamification?.badge_name || 'Warga Peduli';
    const badgeIcon = gamification?.badge_icon || '🥉';
    const currentXp = gamification?.current_xp || 0;
    const nextXp = gamification?.next_xp || 100;
    const xpPercent = Math.min(Math.max(gamification?.xp_percentage || 0, 0), 100);

    const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

    return (
        <section className="bg-white dark:bg-[#111827] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6 transition-colors duration-200">
            
            {/* Left: Avatar & Greeting */}
            <div className="flex items-center gap-4 w-full md:w-auto">
                <div className="relative shrink-0">
                    <div className="w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 flex items-center justify-center text-3xl shadow-sm">
                        {badgeIcon}
                    </div>
                    <span className="absolute -bottom-2 -right-1.5 bg-slate-900 dark:bg-slate-950 text-white text-[10px] font-black px-2 py-0.5 rounded-full border border-slate-700 dark:border-slate-800 shadow-sm">
                        LV {level}
                    </span>
                </div>

                <div className="space-y-1 min-w-0">
                    <div className="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 px-2.5 py-0.5 rounded-full text-xs font-bold border border-emerald-100 dark:border-emerald-800/60">
                        <Sparkles className="w-3 h-3" />
                        <span>Nasabah Terverifikasi</span>
                    </div>
                    <h2 className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight truncate">
                        Halo, {firstName}! 👋
                    </h2>
                    <p className="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium">
                        Mari kelola sampah Anda dan kumpulkan poin lingkungan hari ini.
                    </p>
                </div>
            </div>

            {/* Right: Level Progress Bar Box */}
            <div className="w-full md:w-80 bg-slate-50 dark:bg-[#0D131F] border border-slate-200/80 dark:border-slate-800 rounded-xl p-3.5 space-y-2">
                <div className="flex items-center justify-between text-xs">
                    <span className="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <Trophy className="w-3.5 h-3.5 text-amber-500" />
                        {badgeName}
                    </span>
                    <span className="font-bold text-emerald-600 dark:text-emerald-400">
                        {formatNumber(currentXp)} / {formatNumber(nextXp)} XP
                    </span>
                </div>

                {/* Progress Bar Container */}
                <div className="w-full h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div
                        className="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-500"
                        style={{ width: `${xpPercent}%` }}
                    />
                </div>

                <div className="flex justify-between items-center text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                    <span>Level {level}</span>
                    {level < 4 ? (
                        <span>{100 - xpPercent}% menuju Level {level + 1}</span>
                    ) : (
                        <span className="text-emerald-600 dark:text-emerald-400 font-bold">Maksimal Level 🎉</span>
                    )}
                </div>
            </div>

        </section>
    );
}
