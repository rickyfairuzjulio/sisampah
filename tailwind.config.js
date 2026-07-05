import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                surface: '#f9f9f7',
                'surface-dim': '#dadad8',
                'surface-bright': '#f9f9f7',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f4f4f1',
                'surface-container': '#eeeeec',
                'surface-container-high': '#e8e8e6',
                'surface-container-highest': '#e2e3e0',
                'on-surface': '#1a1c1b',
                'on-surface-variant': '#3d4943',
                'inverse-surface': '#2f3130',
                'inverse-on-surface': '#f1f1ef',
                outline: '#6d7a73',
                'outline-variant': '#bccac1',
                'surface-tint': '#006c4e',
                primary: '#00694c',
                'on-primary': '#ffffff',
                'primary-container': '#008560',
                'on-primary-container': '#f5fff7',
                'inverse-primary': '#68dbae',
                secondary: '#57605e',
                'on-secondary': '#ffffff',
                'secondary-container': '#d9e2df',
                'on-secondary-container': '#5c6462',
                tertiary: '#795600',
                'on-tertiary': '#ffffff',
                'tertiary-container': '#986d00',
                'on-tertiary-container': '#fffbff',
                error: '#ba1a1a',
                'on-error': '#ffffff',
                'error-container': '#ffdad6',
                'on-error-container': '#93000a',
                background: '#f9f9f7',
                'on-background': '#1a1c1b',
                'surface-variant': '#e2e3e0',
                'forest-emerald': '#1D9E75',
                'soft-mint': '#F0F9F6',
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
            }
        },
    },

    plugins: [forms],
};
