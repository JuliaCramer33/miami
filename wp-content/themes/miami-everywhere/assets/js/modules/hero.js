/**
 * Hero Module
 *
 * Handles dynamic height calculations for the hero section based on viewport
 * and header/title dimensions.
 *
 * @package MiamiEverywhere
 */
export default class Hero {
	constructor() {
		this.hero = document.querySelector('.hero');
		this.header = document.querySelector('.site-header');
		this.titleBar = document.querySelector('.site-title');

		this.init();
	}

	init() {
		if (this.hero && this.header && this.titleBar) {
			this.setHeroHeight();
			this.bindEvents();
		}
	}

	setHeroHeight() {
		if (!this.hero || !this.header || !this.titleBar) return;

		const viewportHeight = window.innerHeight;
		const headerHeight = this.header.offsetHeight;
		const titleBarHeight = this.titleBar.offsetHeight;

		// Get WP Admin Bar height (if visible)
		const adminBar = document.getElementById('wpadminbar');
		const adminBarHeight = adminBar && window.getComputedStyle(adminBar).display !== 'none' ? adminBar.offsetHeight : 0;

		// Calculate 90vh minus admin bar (if visible), header, and site-title bar height
		const heroHeight = (viewportHeight * 0.95) - adminBarHeight - headerHeight - titleBarHeight;

		// Apply min and max constraints
		const finalHeight = Math.min(Math.max(heroHeight, 400), 800);

		this.hero.style.height = `${finalHeight}px`;
	}

	bindEvents() {
		let resizeTimer;
		window.addEventListener('resize', () => {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(() => this.setHeroHeight(), 250);
		});

		window.addEventListener('load', () => this.setHeroHeight());
	}
}
