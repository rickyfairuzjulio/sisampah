import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Core Brand Colors
                primary: '#22C55E',
                'primary-dark': '#16A34A',
                mint: '#34D399',
                warning: '#F59E0B',
                danger: '#EF4444',
                
                // Semantic / Theming Colors (Mapped from CSS)
                background: 'var(--color-background)',
                surface: 'var(--color-surface)',
                card: 'var(--color-card)',
                sidebar: 'var(--color-sidebar)',
                navbar: 'var(--color-navbar)',
                'hover-bg': 'var(--color-hover)',
                'border-color': 'var(--color-border)',
                
                // Text Colors
                'text-primary': 'var(--color-text-primary)',
                'text-secondary': 'var(--color-text-secondary)',
                'text-muted': 'var(--color-text-muted)',
                'text-success': 'var(--color-text-success)',
            },
            borderRadius: {
                sm: '0.25rem',
                DEFAULT: '0.5rem',
                md: '0.75rem',
                lg: '1rem',
                xl: '1.25rem',
                '2xl': '1.5rem',
                'btn': '0.75rem', // 12px for Buttons/Inputs
                'card': '1rem', // 16px for Cards
                full: '9999px',
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'DEFAULT': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1)',
                'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
                'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02)',
                'glow-green': '0 4px 14px 0 rgba(16, 185, 129, 0.2)',
                'glow-green-sm': '0 2px 8px 0 rgba(16, 185, 129, 0.15)',
            },
            keyframes: {
                'slide-in': {
                    '0%': { opacity: '0', transform: 'translateY(6px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
            animation: {
                'slide-in': 'slide-in 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
                'fade-in': 'fade-in 0.3s ease-out',
            }
        },
    },

    plugins: [forms],
};
