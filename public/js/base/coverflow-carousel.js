class CoverflowCarousel {
    constructor(element, config = {}) {
        this.element = element;
        this.track = element.querySelector('[data-carousel-track]');
        this.slides = Array.from(element.querySelectorAll('[data-carousel-slide]'));
        this.dots = Array.from(element.querySelectorAll('[data-carousel-dot]'));
        this.prevButton = element.querySelector('[data-carousel-prev]');
        this.nextButton = element.querySelector('[data-carousel-next]');
        this.activeIndex = 0;
        this.touchStartX = 0;
        this.touchDeltaX = 0;
        this.config = {
            transitionMs: Number(element.dataset.carouselTransition || config.transitionMs || 480),
            swipeThreshold: config.swipeThreshold || 42,
            ...config,
        };

        if (!this.track || this.slides.length === 0) {
            return;
        }

        this.bindEvents();
        this.render();
    }

    bindEvents() {
        this.prevButton?.addEventListener('click', () => this.goTo(this.activeIndex - 1));
        this.nextButton?.addEventListener('click', () => this.goTo(this.activeIndex + 1));

        this.slides.forEach((slide, index) => {
            slide.addEventListener('click', (event) => {
                const interactiveTarget = event.target.closest('a, button');

                if (index !== this.activeIndex) {
                    event.preventDefault();
                    this.goTo(index);
                    return;
                }

                if (!interactiveTarget) {
                    slide.querySelector('a')?.click();
                }
            });
        });

        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goTo(index));
        });

        this.element.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                this.goTo(this.activeIndex - 1);
            }

            if (event.key === 'ArrowRight') {
                event.preventDefault();
                this.goTo(this.activeIndex + 1);
            }
        });

        this.element.addEventListener('touchstart', (event) => {
            this.touchStartX = event.changedTouches[0]?.clientX ?? 0;
            this.touchDeltaX = 0;
        }, { passive: true });

        this.element.addEventListener('touchmove', (event) => {
            const currentX = event.changedTouches[0]?.clientX ?? 0;
            this.touchDeltaX = currentX - this.touchStartX;
        }, { passive: true });

        this.element.addEventListener('touchend', () => {
            // Se lo swipe supera la soglia, scorriamo di una card.
            if (Math.abs(this.touchDeltaX) < this.config.swipeThreshold) {
                return;
            }

            this.goTo(this.touchDeltaX > 0 ? this.activeIndex - 1 : this.activeIndex + 1);
        }, { passive: true });
    }

    goTo(index) {
        if (this.slides.length === 0) {
            return;
        }

        const normalizedIndex = (index + this.slides.length) % this.slides.length;
        this.activeIndex = normalizedIndex;
        this.render();
    }

    render() {
        const total = this.slides.length;

        this.slides.forEach((slide, index) => {
            slide.classList.remove('is-active', 'is-prev', 'is-next', 'is-far-prev', 'is-far-next', 'is-hidden');

            // Calcoliamo la distanza minima in un carosello circolare.
            const forwardDistance = (index - this.activeIndex + total) % total;
            const backwardDistance = (this.activeIndex - index + total) % total;

            if (index === this.activeIndex) {
                slide.classList.add('is-active');
                slide.setAttribute('aria-current', 'true');
            } else if (backwardDistance === 1) {
                slide.classList.add('is-prev');
                slide.removeAttribute('aria-current');
            } else if (forwardDistance === 1) {
                slide.classList.add('is-next');
                slide.removeAttribute('aria-current');
            } else if (backwardDistance === 2) {
                slide.classList.add('is-far-prev');
                slide.removeAttribute('aria-current');
            } else if (forwardDistance === 2) {
                slide.classList.add('is-far-next');
                slide.removeAttribute('aria-current');
            } else {
                slide.classList.add('is-hidden');
                slide.removeAttribute('aria-current');
            }
        });

        this.dots.forEach((dot, index) => {
            dot.classList.toggle('is-active', index === this.activeIndex);

            if (index === this.activeIndex) {
                dot.setAttribute('aria-current', 'true');
            } else {
                dot.removeAttribute('aria-current');
            }
        });
    }
}

document.querySelectorAll('[data-carousel-id]').forEach((carouselElement) => {
    new CoverflowCarousel(carouselElement);
});
