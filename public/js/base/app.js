const navToggle = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.nav-menu');
const navBackdrop = document.querySelector('.nav-backdrop');
const navCloseTargets = document.querySelectorAll('[data-nav-close]');
const navLinks = document.querySelectorAll('.nav-menu .nav-link');

if (navToggle && navMenu) {
    const desktopNav = window.matchMedia('(min-width: 861px)');

    const setNavState = (isOpen, returnFocus = false) => {
        const isMobile = !desktopNav.matches;
        const shouldOpen = isMobile && isOpen;

        navMenu.classList.toggle('is-open', shouldOpen);
        if (navBackdrop) {
            navBackdrop.classList.toggle('is-open', shouldOpen);
        }
        navToggle.setAttribute('aria-expanded', String(shouldOpen));
        navMenu.setAttribute('aria-hidden', String(isMobile && !shouldOpen));
        navMenu.inert = isMobile && !shouldOpen;
        document.body.classList.toggle('nav-open', shouldOpen);

        if (shouldOpen) {
            const closeButton = navMenu.querySelector('[data-nav-close]');
            if (closeButton) {
                closeButton.focus({ preventScroll: true });
            }
        } else if (returnFocus && isMobile) {
            navToggle.focus({ preventScroll: true });
        }
    };

    navToggle.addEventListener('click', () => {
        const isOpen = !navMenu.classList.contains('is-open');
        setNavState(isOpen);
    });

    navCloseTargets.forEach((target) => {
        target.addEventListener('click', () => setNavState(false, true));
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', () => setNavState(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && navMenu.classList.contains('is-open')) {
            setNavState(false, true);
        }
    });

    desktopNav.addEventListener('change', () => setNavState(false));

    setNavState(false);
}
