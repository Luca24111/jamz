document.querySelectorAll('[data-event-explorer]').forEach((explorer) => {
    const links = Array.from(explorer.querySelectorAll('[data-event-nav-link]'));
    const sections = Array.from(explorer.querySelectorAll('[data-event-section]'));

    if (links.length === 0 || sections.length === 0) {
        return;
    }

    const setActiveLink = (targetId) => {
        links.forEach((link) => {
            const isActive = link.dataset.target === targetId;
            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const activateFromHash = () => {
        const hash = window.location.hash.replace('#', '');

        if (!hash) {
            setActiveLink(sections[0].id);
            return;
        }

        const matchedSection = sections.find((section) => section.id === hash);

        if (matchedSection) {
            setActiveLink(matchedSection.id);
        }
    };

    links.forEach((link) => {
        link.addEventListener('click', () => {
            const targetId = link.dataset.target;

            if (targetId) {
                setActiveLink(targetId);
            }
        });
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            const visibleSections = entries
                .filter((entry) => entry.isIntersecting)
                .sort((left, right) => right.intersectionRatio - left.intersectionRatio);

            if (visibleSections[0]) {
                setActiveLink(visibleSections[0].target.id);
            }
        }, {
            rootMargin: '-18% 0px -42% 0px',
            threshold: [0.2, 0.4, 0.65],
        });

        sections.forEach((section) => observer.observe(section));
    }

    window.addEventListener('hashchange', activateFromHash);
    activateFromHash();
});
