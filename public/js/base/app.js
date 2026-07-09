const navToggle = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.nav-menu');
const navBackdrop = document.querySelector('.nav-backdrop');
const navCloseTargets = document.querySelectorAll('[data-nav-close]');
const navLinks = document.querySelectorAll('.nav-menu .nav-link');

if (navToggle && navMenu) {
    const desktopNav = window.matchMedia('(min-width: 861px)');

    const setNavState = (isOpen) => {
        navMenu.classList.toggle('is-open', isOpen);
        if (navBackdrop) {
            navBackdrop.classList.toggle('is-open', isOpen);
        }
        navToggle.setAttribute('aria-expanded', String(isOpen));
        navMenu.setAttribute('aria-hidden', String(!isOpen));
        document.body.classList.toggle('nav-open', isOpen);
    };

    navToggle.addEventListener('click', () => {
        const isOpen = !navMenu.classList.contains('is-open');
        setNavState(isOpen);
    });

    navCloseTargets.forEach((target) => {
        target.addEventListener('click', () => setNavState(false));
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', () => setNavState(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && navMenu.classList.contains('is-open')) {
            setNavState(false);
        }
    });

    desktopNav.addEventListener('change', (event) => {
        if (event.matches) {
            setNavState(false);
        }
    });
}
