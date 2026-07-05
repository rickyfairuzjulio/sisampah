import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Toggle password field visibility
 * @param {string} inputId - The input element ID
 * @param {HTMLElement} btn - The toggle button element
 */
window.togglePassword = function(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeShow = document.getElementById(inputId + '-eye-show');
    const eyeHide = document.getElementById(inputId + '-eye-hide');

    if (!input) return;

    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';

    // Animate icon swap
    if (isPassword) {
        eyeShow.classList.add('hidden');
        eyeHide.classList.remove('hidden');
        btn.setAttribute('aria-label', 'Hide password');
    } else {
        eyeHide.classList.add('hidden');
        eyeShow.classList.remove('hidden');
        btn.setAttribute('aria-label', 'Show password');
    }
};

/**
 * Auto-dismiss flash messages after 4s
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-4px)';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });
});
