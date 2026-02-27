/**
 * Entry point for the theme JavaScript.
 *
 * @package MiamiEverywhere
 */

// Import vendor libraries

// Import modules
import Navigation from './modules/navigation';
import Subnav from './modules/subnav';
import Hero from './modules/hero';
import './modules/a11y';
import TestimonialModal from './modules/testimonial-modal';
import ConditionalGallerySlider from './modules/conditional-gallery-slider';
import ScrollIndicatorLine from './modules/scroll-indicator-line';
import FadeInOnScroll from './modules/fadeInOnScroll';

// Initialize modules after DOM is ready, without jQuery
document.addEventListener('DOMContentLoaded', () => {
	// Initialize navigation
	// eslint-disable-next-line no-unused-vars
	const navigation = new Navigation();
	// Initialize subnav
	// eslint-disable-next-line no-unused-vars
	const subnav = new Subnav();
	subnav.init();
	// Initialize hero
	// eslint-disable-next-line no-unused-vars
	const hero = new Hero();
	// Initialize testimonial modal
	// eslint-disable-next-line no-unused-vars
	const testimonialModal = new TestimonialModal();

	// Example: Initialize gallery slider IF the container exists on initial load
	// Note: If loaded via AJAX, initialization needs to happen in AJAX success callback
	if (document.querySelector('#ajax-gallery-container')) {
		// Initialize directly if needed on load, or handle via AJAX callback
		// Assign to ignored var to satisfy no-new rule, constructor has side effects
		// eslint-disable-next-line no-unused-vars
		const gallerySliderInstance = new ConditionalGallerySlider(); // Or pass args if needed
	}

	new ScrollIndicatorLine();

	// Initialize fade-in effect
	// eslint-disable-next-line no-unused-vars
	const fadeInElements = new FadeInOnScroll();
});
