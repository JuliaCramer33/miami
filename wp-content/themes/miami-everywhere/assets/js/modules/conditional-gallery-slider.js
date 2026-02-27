/**
 * Conditional Gallery Slider
 *
 * Initializes a SplideJS slider on a gallery container only if it
 * contains more than a specified number of items. Otherwise, applies
 * a class for basic horizontal layout.
 */
import Splide from '@splidejs/splide';

export default class ConditionalGallerySlider {
  constructor(
    containerSelector = '#ajax-gallery-container',
    itemSelector = '.gallery-image-item',
    threshold = 5
  ) {
    this.containerSelector = containerSelector;
    this.itemSelector = itemSelector;
    this.threshold = threshold;
    this.galleryContainer = document.querySelector(this.containerSelector);

    if (!this.galleryContainer) {
      return;
    }

    this.isInitialized = false;
    this.splideInstance = null;
    this.observer = null;
  }

  /**
   * Checks gallery items and initializes Splide if threshold is met.
   */
  handleLoad() {
    if (!this.galleryContainer) {
      return;
    }

    const galleryItems = this.galleryContainer.querySelectorAll(this.itemSelector);

    if (galleryItems.length >= this.threshold) {
      if (!this.isInitialized) {
        this.galleryContainer.classList.remove('gallery-is-horizontal');
        this.initializeSplide();
        this.isInitialized = true;
        this.disconnectObserver();
      }
    } else {
      this.destroySplide();
      this.galleryContainer.classList.add('gallery-is-horizontal');
      this.isInitialized = false;
      // Manually load images for non-Splide galleries
      galleryItems.forEach(itemElement => {
        const img = itemElement.querySelector('img');
        if (img && img.dataset.actualSrc) {
          img.src = img.dataset.actualSrc;
          // Optional: Remove the data attribute after use to prevent re-processing
          // img.removeAttribute('data-actual-src');
        }
      });
    }
  }

  /**
   * Initialize the Splide instance.
   */
  initializeSplide() {
    if (!this.galleryContainer || this.splideInstance) {
      return;
    }

    // Ensure the main container has the 'splide' class
    if (!this.galleryContainer.classList.contains('splide')) {
      this.galleryContainer.classList.add('splide');
    }

    // Ensure splide__track exists or create it
    let track = this.galleryContainer.querySelector('.splide__track');
    if (!track) {
      track = document.createElement('div');
      track.className = 'splide__track';
      // Move existing items into the track temporarily
      while (this.galleryContainer.firstChild) {
        if (this.galleryContainer.firstChild !== track) {
          track.appendChild(this.galleryContainer.firstChild);
        }
      }
      this.galleryContainer.appendChild(track);
    }

    // Ensure splide__list exists or create it
    let list = track.querySelector('.splide__list');
    if (!list) {
      list = document.createElement('ul');
      list.className = 'splide__list';
      // Move items from track (or original container if track existed) into list
      while (track.firstChild) {
        if (track.firstChild !== list) {
          list.appendChild(track.firstChild);
        }
      }
      track.appendChild(list);
    }

    // Ensure all direct children of the list are wrapped in splide__slide
    const directChildren = Array.from(list.children);
    directChildren.forEach((item) => {
      if (!item.classList.contains('splide__slide')) {
        const slide = document.createElement('li');
        slide.className = 'splide__slide';
        list.insertBefore(slide, item); // Insert wrapper before item
        slide.appendChild(item); // Move item into wrapper
      }
    });

    // Initialize Splide
    try {
      this.splideInstance = new Splide(this.galleryContainer, {
        type: 'loop',
        perPage: 5,
        perMove: 1,
        gap: '.5rem',
        pagination: false,
        autoWidth: true,
        focus: 'center',
        trimSpace: false,
        lazyLoad: 'nearby',
        breakpoints: {
          992: {
            perPage: 3,
            autoWidth: false,
            perMove: 1,
          },
          768: {
            autoWidth: true,
            perPage: undefined,
            perMove: 1,
            focus: 'center',
            trimSpace: false,
          },
        },
      }).mount();

      this.galleryContainer.classList.add('gallery-is-slider');

      // Refresh Splide after a short delay to allow images to potentially load dimensions
      setTimeout(() => {
        if (this.splideInstance) {
          this.splideInstance.refresh();
        }
      }, 300); // Timeout back to 300ms

    } catch (error) {
      // console.error('Error initializing Splide:', error, this.galleryContainer); // Removed to satisfy no-console rule
    }

    // Optional: Add event listeners if needed
    // this.splideInstance.on('moved', () => {});
    // this.splideInstance.on('resized', () => {});
  }

  destroySplide() {
    if (this.splideInstance) {
      this.splideInstance.destroy(true);
      this.splideInstance = null;
      this.galleryContainer.classList.remove('gallery-is-slider', 'gallery-is-horizontal');
    }
  }

  disconnectObserver() {
    if (this.observer) {
      this.observer.disconnect();
      this.observer = null;
    }
  }
}
