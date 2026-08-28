import { useState, useEffect } from 'react';

export function useTheme() {
    const [isDark, setIsDark] = useState(() => {
        if (typeof window === 'undefined') return false;
        const saved = localStorage.getItem('theme');
        if (saved) return saved === 'dark';
        return window.matchMedia('(prefers-color-scheme: dark)').matches;
    });

    useEffect(() => {
        const root = document.documentElement;
        if (isDark) {
            root.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            root.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }

        // Custom event for multi-component sync
        window.dispatchEvent(new Event('theme-changed'));
    }, [isDark]);

    useEffect(() => {
        const handleSync = () => {
            const currentIsDark = document.documentElement.classList.contains('dark');
            if (currentIsDark !== isDark) {
                setIsDark(currentIsDark);
            }
        };

        window.addEventListener('theme-changed', handleSync);
        window.addEventListener('storage', handleSync);
        return () => {
            window.removeEventListener('theme-changed', handleSync);
            window.removeEventListener('storage', handleSync);
        };
    }, [isDark]);

    const toggleTheme = () => {
        setIsDark((prev) => !prev);
    };

    return { isDark, toggleTheme, setIsDark };
}

export default useTheme;
