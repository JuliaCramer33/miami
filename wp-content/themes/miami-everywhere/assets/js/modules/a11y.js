/**
 * Accessibility enhancements.
 *
 * @package MiamiEverywhere
 */

class Accessibility {
	/**
	 * Constructor.
	 */
	constructor() {
		this.skipLink = document.querySelector('.skip-link');
		this.focusableElements =
			'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';

		this.init();
	}

	/**
	 * Initialize accessibility features.
	 */
	init() {
		this.bindEvents();
		this.setupFocusableElements();
	}

	/**
	 * Bind event listeners.
	 */
	bindEvents() {
		// Skip link functionality
		if (this.skipLink) {
			this.skipLink.addEventListener('click', (e) => this.handleSkipLink(e));
		}

		// Handle keyboard navigation
		document.addEventListener('keydown', (e) => this.handleKeyboardNavigation(e));
	}

	/**
	 * Handle skip link click.
	 *
	 * @param {Event} event - The click event.
	 */
	handleSkipLink(event) {
		event.preventDefault();
		const targetId = this.skipLink.getAttribute('href').substring(1);
		const targetElement = document.getElementById(targetId);

		if (targetElement) {
			targetElement.setAttribute('tabindex', '-1');
			targetElement.focus();

			// Remove tabindex after blur
			targetElement.addEventListener(
				'blur',
				() => {
					targetElement.removeAttribute('tabindex');
				},
				{ once: true }
			);
		}
	}

	/**
	 * Handle keyboard navigation.
	 *
	 * @param {KeyboardEvent} event - The keyboard event.
	 */
	handleKeyboardNavigation(event) {
		// Add tab outline only when using keyboard
		if (event.key === 'Tab') {
			document.body.classList.add('user-is-tabbing');
		}
	}

	/**
	 * Setup focusable elements.
	 */
	setupFocusableElements() {
		// Remove outline for mouse users
		document.body.addEventListener('mousedown', () => {
			document.body.classList.remove('user-is-tabbing');
		});
	}
}

// Initialize accessibility features
// eslint-disable-next-line no-unused-vars
const accessibilitySetup = new Accessibility(); // Assign to variable to satisfy no-new rule
