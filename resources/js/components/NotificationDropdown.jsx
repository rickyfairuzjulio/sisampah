import React, { useState, useEffect, useRef } from 'react';
import { router } from '@inertiajs/react';
import {
    Bell,
    ShieldCheck,
    Truck,
    Wallet,
    CreditCard,
    Tag,
    LayoutDashboard,
    Boxes,
    ClipboardCheck,
    CheckCircle2,
    AlertCircle,
    Info,
    CheckCheck,
    X,
    ExternalLink
} from 'lucide-react';

const iconMap = {
    ShieldCheck,
    Truck,
    Wallet,
    CreditCard,
    Tag,
    LayoutDashboard,
    Boxes,
    ClipboardCheck,
    CheckCircle2,
    AlertCircle,
    Info,
};

export default function NotificationDropdown() {
    const [isOpen, setIsOpen] = useState(false);
    const [notifications, setNotifications] = useState([]);
    const [unreadCount, setUnreadCount] = useState(0);
    const [isLoading, setIsLoading] = useState(false);
    const dropdownRef = useRef(null);

    const fetchNotifications = async () => {
        try {
            const res = await fetch('/api/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            if (res.ok) {
                const data = await res.json();
                setNotifications(data.notifications || []);
                setUnreadCount(data.unread_count || 0);
            }
        } catch (err) {
            console.error('Failed to fetch notifications:', err);
        }
    };

    useEffect(() => {
        fetchNotifications();
        // Poll every 30s for real-time updates
        const interval = setInterval(fetchNotifications, 30000);
        return () => clearInterval(interval);
    }, []);

    // Close on click outside
    useEffect(() => {
        const handleClickOutside = (e) => {
            if (dropdownRef.current && !dropdownRef.current.contains(e.target)) {
                setIsOpen(false);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const markAllRead = async () => {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            await fetch('/api/notifications/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({}),
            });
            setUnreadCount(0);
            setNotifications((prev) => prev.map((n) => ({ ...n, is_read: true })));
        } catch (err) {
            console.error('Failed to mark all notifications as read:', err);
        }
    };

    const handleItemClick = async (notif) => {
        try {
            if (!notif.is_read) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/api/notifications/read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ id: notif.id }),
                });
                setNotifications((prev) =>
                    prev.map((n) => (n.id === notif.id ? { ...n, is_read: true } : n))
                );
                setUnreadCount((prev) => Math.max(0, prev - 1));
            }
        } catch (err) {
            console.error('Failed to mark notif as read:', err);
        }

        setIsOpen(false);

        if (notif.url) {
            if (notif.url.startsWith('http://') || notif.url.startsWith('https://')) {
                const currentOrigin = window.location.origin;
                if (notif.url.startsWith(currentOrigin)) {
                    const path = notif.url.replace(currentOrigin, '');
                    router.visit(path);
                } else {
                    window.location.href = notif.url;
                }
            } else {
                router.visit(notif.url);
            }
        }
    };

    const getTypeStyles = (type) => {
        switch (type) {
            case 'warning':
                return {
                    bg: 'bg-amber-50 dark:bg-amber-950/50 border-amber-200 dark:border-amber-800 text-amber-600 dark:text-amber-400',
                    badge: 'bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300',
                };
            case 'success':
                return {
                    bg: 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400',
                    badge: 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300',
                };
            case 'danger':
                return {
                    bg: 'bg-rose-50 dark:bg-rose-950/50 border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400',
                    badge: 'bg-rose-100 dark:bg-rose-900/60 text-rose-800 dark:text-rose-300',
                };
            default:
                return {
                    bg: 'bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400',
                    badge: 'bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300',
                };
        }
    };

    return (
        <div className="relative" ref={dropdownRef}>
            {/* Bell Trigger Button */}
            <button
                type="button"
                onClick={() => {
                    setIsOpen(!isOpen);
                    if (!isOpen) fetchNotifications();
                }}
                className={`w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-all cursor-pointer relative ${
                    isOpen
                        ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 ring-2 ring-emerald-400'
                        : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800'
                }`}
                title="Pusat Notifikasi"
                aria-expanded={isOpen}
            >
                <Bell className={`w-4 h-4 sm:w-4.5 sm:h-4.5 ${unreadCount > 0 ? 'animate-wiggle text-emerald-600 dark:text-emerald-400' : ''}`} />

                {unreadCount > 0 && (
                    <span className="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 bg-rose-500 text-white text-[10px] font-black rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-900 shadow-xs animate-scale-in">
                        {unreadCount > 9 ? '9+' : unreadCount}
                    </span>
                )}
            </button>

            {/* Dropdown Panel */}
            {isOpen && (
                <div className="absolute right-0 mt-2.5 w-[340px] sm:w-[380px] bg-white dark:bg-[#111827] rounded-2xl shadow-2xl border border-slate-200/90 dark:border-slate-800 z-50 overflow-hidden animate-slide-in select-none">
                    
                    {/* Header */}
                    <div className="px-4 py-3.5 bg-slate-50/90 dark:bg-[#0D131F] border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <span className="font-extrabold text-sm text-slate-900 dark:text-white">Notifikasi</span>
                            {unreadCount > 0 ? (
                                <span className="px-2 py-0.5 rounded-full bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 text-[10px] font-bold">
                                    {unreadCount} baru
                                </span>
                            ) : (
                                <span className="px-2 py-0.5 rounded-full bg-slate-200/80 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-semibold">
                                    Semua dibaca
                                </span>
                            )}
                        </div>

                        {unreadCount > 0 && (
                            <button
                                type="button"
                                onClick={markAllRead}
                                className="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 hover:underline cursor-pointer"
                            >
                                <CheckCheck className="w-3.5 h-3.5" />
                                <span>Tandai Semua Dibaca</span>
                            </button>
                        )}
                    </div>

                    {/* Notification List */}
                    <div className="max-h-[380px] overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/80">
                        {notifications.length === 0 ? (
                            <div className="py-10 px-4 text-center">
                                <div className="w-12 h-12 mx-auto rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-2 shadow-2xs">
                                    <CheckCircle2 className="w-6 h-6" />
                                </div>
                                <p className="text-xs font-bold text-slate-800 dark:text-slate-200">Tidak ada notifikasi baru</p>
                                <p className="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">Semua aktivitas dan transaksi Anda telah up to date.</p>
                            </div>
                        ) : (
                            notifications.map((notif) => {
                                const styles = getTypeStyles(notif.type);
                                const IconComponent = iconMap[notif.icon] || Info;

                                return (
                                    <div
                                        key={notif.id}
                                        onClick={() => handleItemClick(notif)}
                                        className={`p-3.5 flex items-start gap-3 transition-colors cursor-pointer relative group ${
                                            notif.is_read
                                                ? 'bg-white dark:bg-[#111827] hover:bg-slate-50 dark:hover:bg-slate-800/60 opacity-80'
                                                : 'bg-emerald-50/40 dark:bg-emerald-950/30 hover:bg-emerald-50/70 dark:hover:bg-emerald-950/50'
                                        }`}
                                    >
                                        {/* Icon */}
                                        <div className={`w-9 h-9 rounded-xl border flex items-center justify-center shrink-0 ${styles.bg}`}>
                                            <IconComponent className="w-4 h-4" />
                                        </div>

                                        {/* Content */}
                                        <div className="min-w-0 flex-1">
                                            <div className="flex items-center justify-between gap-1 mb-0.5">
                                                <h4 className={`text-xs font-bold truncate ${notif.is_read ? 'text-slate-700 dark:text-slate-300' : 'text-slate-900 dark:text-white font-extrabold'}`}>
                                                    {notif.title}
                                                </h4>
                                                <span className="text-[10px] text-slate-400 dark:text-slate-500 font-medium shrink-0">
                                                    {notif.time}
                                                </span>
                                            </div>
                                            <p className="text-[11px] text-slate-600 dark:text-slate-400 leading-snug line-clamp-2">
                                                {notif.message}
                                            </p>
                                        </div>

                                        {/* Unread indicator / Arrow */}
                                        <div className="self-center shrink-0">
                                            {!notif.is_read ? (
                                                <span className="w-2 h-2 rounded-full bg-emerald-600 dark:bg-emerald-400 inline-block ring-2 ring-emerald-200 dark:ring-emerald-900"></span>
                                            ) : (
                                                <ExternalLink className="w-3.5 h-3.5 text-slate-300 dark:text-slate-600 group-hover:text-slate-500 dark:group-hover:text-slate-400 transition-colors" />
                                            )}
                                        </div>
                                    </div>
                                );
                            })
                        )}
                    </div>

                    {/* Footer */}
                    <div className="p-2.5 bg-slate-50/80 dark:bg-[#0D131F] border-t border-slate-100 dark:border-slate-800 text-center">
                        <span className="text-[10px] text-slate-400 dark:text-slate-500 font-semibold">
                            SiSampah Realtime Notification Feed
                        </span>
                    </div>

                </div>
            )}
        </div>
    );
}
