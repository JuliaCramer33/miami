/**
 * Module: Fade In On Scroll
 *
 * Uses IntersectionObserver to add a class to elements when they enter the viewport,
 * triggering a CSS fade-in animation.
 *
 * @package MiamiEverywhere
 */
export default class FadeInOnScroll {
  constructor(selector = '.js-fade-in', options = {}) {
    this.elementsToObserve = document.querySelectorAll(selector);
    if (!this.elementsToObserve.length) {
      // console.log('FadeInOnScroll: No elements found to observe with selector:', selector);
      return; // No elements found, exit early
    }

    const defaultOptions = {
      root: null, // relative to document viewport
      rootMargin: '0px', // margin around root. Values similar to CSS margin property
      threshold: 0, // percentage of target's visibility the observer waits for (0 = 1px visible)
    };

    this.observerOptions = { ...defaultOptions, ...options };
    this.observer = new IntersectionObserver(this.handleIntersection.bind(this), this.observerOptions);

    this.init();
  }

  init() {
    this.elementsToObserve.forEach((element) => {
      this.observer.observe(element);
    });
  }

  handleIntersection(entries, observer) {
    entries.forEach((entry) => {
      // If the element is intersecting (visible)
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        // Optional: Stop observing the element once it's visible
        // to prevent re-triggering and save resources.
        observer.unobserve(entry.target);
      }
    });
  }

  // Method to disconnect the observer if needed (e.g., on route change in SPA)
  disconnect() {
    if (this.observer) {
      this.observer.disconnect();
    }
  }
}
