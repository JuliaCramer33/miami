/**
 * Scroll Indicator Line Module
 *
 * Positions and animates a single line connecting the hero icon
 * to the intro section icon based on scroll progress.
 *
 * @package MiamiEverywhere
 */
export default class ScrollIndicatorLine {
	constructor() {
		this.lineElement = document.querySelector('.scroll-indicator-line');
		this.lineInnerElement = document.querySelector('.scroll-indicator-line__inner');
		this.startElement = document.querySelector('.hero__icon img');
		this.endElement = document.querySelector('.intro__line-end-icon');
		this.mainElement = document.querySelector('.site-main');

		if (!this.lineElement || !this.lineInnerElement || !this.startElement || !this.endElement || !this.mainElement) {
			if (this.lineElement) this.lineElement.style.display = 'none';
			return;
		}

		this.isDesktop = window.matchMedia(`(min-width: 768px)`).matches;
		this.boundUpdateLine = this.updateLine.bind(this);
		this.boundHandleScroll = this.handleScroll.bind(this);
		this.ticking = false;
		this.animationStartScrollPos = 0;
		this.animationEndScrollPos = 0;

		this.init();
	}

	init() {
		this.updateLine();
		window.addEventListener('scroll', this.boundHandleScroll);
		window.addEventListener('resize', this.debounce(this.boundUpdateLine, 250));
		this.toggleVisibility();
	}

	toggleVisibility() {
		this.isDesktop = window.matchMedia(`(min-width: 768px)`).matches;
		this.lineElement.style.display = this.isDesktop ? 'block' : 'none';
	}

	updateLine() {
		this.toggleVisibility();
		if (!this.isDesktop) return;
		if (!this.lineElement || !this.startElement || !this.endElement || !this.mainElement) return;

		const mainRect = this.mainElement.getBoundingClientRect();
		const startRect = this.startElement.getBoundingClientRect();
		const endRect = this.endElement.getBoundingClientRect();
		const scrollY = window.scrollY || window.pageYOffset;
		const viewportHeight = window.innerHeight;

		const startTop = startRect.bottom - mainRect.top;
		const endTop = endRect.top - mainRect.top;
		const startLeft = startRect.left + startRect.width / 2 - mainRect.left;
		const lineHeight = Math.max(0, endTop - startTop);

		this.lineElement.style.top = `${startTop}px`;
		this.lineElement.style.left = `${startLeft}px`;
		this.lineElement.style.height = `${lineHeight}px`;

		this.animationStartScrollPos = scrollY + startRect.top - viewportHeight * 0.5;
		this.animationEndScrollPos = scrollY + endRect.top - viewportHeight * 0.5;

		this.handleScroll();
	}

	handleScroll() {
		if (!this.isDesktop) return;

		if (!this.ticking) {
			window.requestAnimationFrame(() => {
				this.calculateScale();
				this.ticking = false;
			});
			this.ticking = true;
		}
	}

	calculateScale() {
		if (!this.lineInnerElement || !this.startElement || !this.endElement) return;

		const scrollY = window.scrollY || window.pageYOffset;

		let progress = 0;
		if (this.animationEndScrollPos > this.animationStartScrollPos) {
			progress = (scrollY - this.animationStartScrollPos) / (this.animationEndScrollPos - this.animationStartScrollPos);
		}

		progress = Math.max(0, Math.min(1, progress));

		this.lineInnerElement.style.transform = `scaleY(${progress})`;
	}

	debounce(func, wait) {
		let timeout;
		return function executedFunction(...args) {
			const later = () => {
				clearTimeout(timeout);
				func.apply(this, args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}
}
