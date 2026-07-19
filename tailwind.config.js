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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                surface: 'var(--color-surface)',
                'surface-dim': 'var(--color-surface-dim)',
                'surface-bright': 'var(--color-surface-bright)',
                'surface-container-lowest': 'var(--color-surface-container-lowest)',
                'surface-container-low': 'var(--color-surface-container-low)',
                'surface-container': 'var(--color-surface-container)',
                'surface-container-high': 'var(--color-surface-container-high)',
                'surface-container-highest': 'var(--color-surface-container-highest)',
                'on-surface': 'var(--color-on-surface)',
                'on-surface-variant': 'var(--color-on-surface-variant)',
                'inverse-surface': 'var(--color-inverse-surface)',
                'inverse-on-surface': 'var(--color-inverse-on-surface)',
                outline: 'var(--color-outline)',
                'outline-variant': 'var(--color-outline-variant)',
                'surface-tint': 'var(--color-surface-tint)',
                primary: 'var(--color-primary)',
                'on-primary': 'var(--color-on-primary)',
                'primary-container': 'var(--color-primary-container)',
                'on-primary-container': 'var(--color-on-primary-container)',
                'inverse-primary': 'var(--color-inverse-primary)',
                secondary: 'var(--color-secondary)',
                'on-secondary': 'var(--color-on-secondary)',
                'secondary-container': 'var(--color-secondary-container)',
                'on-secondary-container': 'var(--color-on-secondary-container)',
                tertiary: 'var(--color-tertiary)',
                'on-tertiary': 'var(--color-on-tertiary)',
                'tertiary-container': 'var(--color-tertiary-container)',
                'on-tertiary-container': 'var(--color-on-tertiary-container)',
                error: 'var(--color-error)',
                'on-error': 'var(--color-on-error)',
                'error-container': 'var(--color-error-container)',
                'on-error-container': 'var(--color-on-error-container)',
                background: 'var(--color-background)',
                'on-background': 'var(--color-on-background)',
                'surface-variant': 'var(--color-surface-variant)',
                'forest-emerald': 'var(--color-forest-emerald)',
                'soft-mint': 'var(--color-soft-mint)',
            },
            borderRadius: {
                sm: '0.25rem',
                DEFAULT: '0.5rem',
                md: '0.75rem',
                lg: '1rem',
                xl: '1.5rem',
                '2xl': '2rem',
                full: '9999px',
            },
            spacing: {
                unit: '4px',
                xs: '4px',
                sm: '8px',
                md: '16px',
                lg: '24px',
                xl: '32px',
                'container-margin': '20px',
                gutter: '16px',
            },
            boxShadow: {
                'ambient': '0 4px 20px 0 rgba(0, 0, 0, 0.06)',
            },
            keyframes: {
                'slide-in': {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                }
            },
            animation: {
                'slide-in': 'slide-in 0.4s ease-out',
                'fade-in': 'fade-in 0.4s ease-out',
            }
        },
    },

    plugins: [forms],
};
