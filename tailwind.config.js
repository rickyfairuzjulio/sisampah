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
                xl: '1.25rem', // 20px for Cards
                '2xl': '1.5rem', // 24px for Modals
                'btn': '16px', // 16px for Buttons/Inputs
                'card': '20px',
                full: '9999px', // Chips
            },
            boxShadow: {
                'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01)',
                'glow-green': '0 0 15px rgba(34, 197, 94, 0.4)',
                'glow-green-sm': '0 4px 14px 0 rgba(34, 197, 94, 0.39)',
            },
            keyframes: {
                'slide-in': {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'ripple': {
                    '0%': { transform: 'scale(0.8)', opacity: '1' },
                    '100%': { transform: 'scale(2.4)', opacity: '0' },
                }
            },
            animation: {
                'slide-in': 'slide-in 0.4s ease-out',
                'fade-in': 'fade-in 0.4s ease-out',
                'ripple': 'ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite',
            }
        },
    },

    plugins: [forms],
};
