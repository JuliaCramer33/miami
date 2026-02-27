/**
 * Testimonial Modal Handling
 */
import ConditionalGallerySlider from './conditional-gallery-slider'; // Import the new module

export default class TestimonialModal {
  constructor() {
    this.modal = document.getElementById('testimonial-modal');

    if (!this.modal) {
      return; // Exit if modal element not found
    }

    // Cache key elements (UPDATED SELECTORS)
    this.contentWrapper = this.modal.querySelector('.testimonial-modal__content-wrapper');
    this.closeButton = this.modal.querySelector('.testimonial-modal__close');
    this.nameElement = this.modal.querySelector('.testimonial-modal__hero-name');
    this.classElement = this.modal.querySelector('.testimonial-modal__hero-detail--class .value');
    this.majorElement = this.modal.querySelector('.testimonial-modal__hero-detail--major .value');
    this.minorElement = this.modal.querySelector('.testimonial-modal__hero-detail--minor .value');
    this.headerImageContainer = this.modal.querySelector('.testimonial-modal__hero-image');
    this.mainContentElement = this.modal.querySelector('.testimonial-modal__content-body');
    this.pullQuoteElement = this.modal.querySelector(
      '.testimonial-modal__quote-content blockquote'
    );
    this.quoteCiteElement = this.modal.querySelector('.testimonial-modal__quote-cite');
    this.galleryElement = this.modal.querySelector('.testimonial-modal__gallery-slider');
    this.gallerySectionElement = this.modal.querySelector('.testimonial-modal__section--gallery');

    // Add instance property for the gallery slider
    this.gallerySlider = null;

    this.init();
  }

  init() {
    // Instantiate the gallery slider if the element exists
    if (this.galleryElement) {
      this.gallerySlider = new ConditionalGallerySlider(
        '.testimonial-modal__gallery-slider', // UPDATED selector for the container
        '.gallery-image-item',
        4
      );
    }

    this.bindEvents();
  }

  bindEvents() {
    // Open Modal Listener
    document.body.addEventListener('click', (event) => this.handleOpenClick(event));

    // Close Modal Listeners
    if (this.closeButton) {
      this.closeButton.addEventListener('click', () => this.hideModal());
    }

    // Close modal on Escape key
    document.addEventListener('keydown', (event) => this.handleEscapeKey(event));
  }

  handleOpenClick(event) {
    const link = event.target.closest('.js-open-testimonial-modal');
    if (!link) return; // Click was not on a trigger link

    event.preventDefault();

    const { testimonialId } = link.dataset;
    const { storyType } = link.dataset;

    if (!testimonialId || !storyType) {
      return;
    }

    // Check if miamiAjax object is available (defined globally via wp_localize_script)
    if (typeof miamiAjax === 'undefined' || !miamiAjax.ajaxUrl || !miamiAjax.nonce) {
      return;
    }

    this.showModal();
    this.setLoadingState(true);

    // Prepare data for AJAX request
    const formData = new FormData();
    formData.append('action', 'get_testimonial_story'); // Matches PHP action hook
    formData.append('nonce', miamiAjax.nonce); // Get nonce from localized script
    formData.append('testimonial_id', testimonialId);
    formData.append('story_type', storyType);

    // Perform AJAX request using Fetch API
    fetch(miamiAjax.ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then((result) => {
        this.setLoadingState(false);
        if (result.success) {
          this.populateModal(result.data);
        } else {
          this.displayError(`Could not load testimonial details. ${result.data.message || ''}`);
        }
      })
      .catch(() => {
        this.setLoadingState(false);
        this.displayError(`Could not load testimonial details. Please try again later.`);
      });
  }

  handleEscapeKey(event) {
    if (event.key === 'Escape' && this.modal.classList.contains('is-open')) {
      this.hideModal();
    }
  }

  showModal() {
    this.modal.classList.add('is-open');
    document.body.classList.add('modal-open');
    if (this.contentWrapper) {
      this.contentWrapper.scrollTop = 0;
    }
  }

  hideModal() {
    this.modal.classList.remove('is-open');
    document.body.classList.remove('modal-open');
    // Optional: Clear content after fade out animation completes?
    // setTimeout(() => { this.clearModalContent(); }, 300); // Match transition duration
  }

  setLoadingState(isLoading) {
    if (isLoading) {
      this.contentWrapper.classList.add('loading');
      this.clearModalContent(); // Clear previous content immediately
    } else {
      this.contentWrapper.classList.remove('loading');
    }
  }

  clearModalContent() {
    if (this.nameElement) this.nameElement.textContent = 'Loading...';
    if (this.classElement) this.classElement.textContent = '';
    if (this.majorElement) this.majorElement.textContent = '';
    if (this.minorElement) this.minorElement.textContent = '';
    if (this.headerImageContainer) this.headerImageContainer.innerHTML = '';
    if (this.mainContentElement) this.mainContentElement.innerHTML = '';
    if (this.pullQuoteElement) this.pullQuoteElement.textContent = ''; // Clear blockquote text
    if (this.quoteCiteElement) this.quoteCiteElement.textContent = '';
    if (this.galleryElement) this.galleryElement.innerHTML = '';

    // Hide gallery section when clearing
    if (this.gallerySectionElement) {
      this.gallerySectionElement.style.display = 'none';
    }

    // Hide elements that might not have content
    if (this.minorElement) this.minorElement.closest('li').style.display = 'none';
    // UPDATED: Need to find the section to hide the pull quote
    const quoteSection = this.modal.querySelector('.testimonial-modal__section--quote');
    if (quoteSection) {
      quoteSection.style.display = 'none';
    }
  }

  populateModal(data) {
    if (!data) {
      return;
    }

    // Populate header/meta
    if (this.nameElement) this.nameElement.textContent = data.name || '';
    if (this.quoteCiteElement) this.quoteCiteElement.textContent = data.name || ''; // Populate cite too

    this.populateDetailItem(this.classElement, data.formatted_year);
    this.populateDetailItem(this.majorElement, data.major);
    this.populateDetailItem(this.minorElement, data.minor);

    // Populate header image
    if (this.headerImageContainer && data.header_image_url) {
      const img = document.createElement('img');
      img.src = data.header_image_url;
      img.alt = data.name ? `${data.name} - Header Image` : 'Testimonial Header Image';
      img.className = 'w-full h-full object-cover';
      this.headerImageContainer.innerHTML = '';
      this.headerImageContainer.appendChild(img);
    } else if (this.headerImageContainer) {
      this.headerImageContainer.innerHTML = '';
    }

    // Populate main content
    if (this.mainContentElement && data.main_content) {
      this.mainContentElement.innerHTML = data.main_content;
    } else if (this.mainContentElement) {
      this.mainContentElement.innerHTML = '';
    }

    // Populate pull quote
    // UPDATED: Reference quote section directly
    const quoteSection = this.modal.querySelector('.testimonial-modal__section--quote');
    if (quoteSection) {
      if (this.pullQuoteElement && data.pull_quote) {
        this.pullQuoteElement.innerHTML = data.pull_quote;
        quoteSection.style.display = 'block';
      } else {
        quoteSection.style.display = 'none';
      }
    }

    // Populate gallery
    if (this.gallerySectionElement) {
      if (this.galleryElement && data.gallery_html && data.gallery_html.trim() !== '') {
        this.galleryElement.innerHTML = data.gallery_html;
        this.gallerySectionElement.style.display = ''; // Reset display to make section visible
        if (this.gallerySlider) {
          // Defer the handleLoad call
          requestAnimationFrame(() => {
            this.gallerySlider.handleLoad(); // Check if slider should initialize
          });
        }
      } else {
        // No gallery HTML, hide the whole section and clear inner element
        if (this.galleryElement) {
          this.galleryElement.innerHTML = '';
        }
        this.gallerySectionElement.style.display = 'none';
        // Also destroy slider if it was somehow initialized before
        if (this.gallerySlider) {
          this.gallerySlider.destroySplide();
        }
      }
    }
  }

  populateDetailItem(element, value) {
    const listItem = element ? element.closest('li') : null;
    if (element && value) {
      element.textContent = value;
      // Ensure it's visible if previously hidden (use default block/flex display)
      if (listItem && listItem.style.display === 'none') {
        listItem.style.display = ''; // Reset to default display (inherits flex from CSS)
      }
    } else if (listItem) {
      listItem.style.display = 'none'; // Keep hiding if no value
    }
  }

  displayError(message) {
    if (this.nameElement) this.nameElement.textContent = 'Error';
    if (this.mainContentElement) this.mainContentElement.innerHTML = `<p>${message}</p>`;
    // Optionally clear/hide other fields too
  }
}

// Note: Instantiation (`new TestimonialModal();`) should happen
// in your main JS file after importing this class.
