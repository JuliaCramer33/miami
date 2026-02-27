/**
 * Navigation Module
 *
 * Handles primary site navigation, including mobile menu toggle
 * and responsive behavior.
 *
 * @package MiamiEverywhere
 */
export default class Navigation {
  constructor() {
    this.navToggle = document.querySelector('.site-header__nav-toggle');
    this.mainNav = document.querySelector('.main-navigation');
    this.siteTitle = document.querySelector('.site-title');
    this.isOpen = false;
    this.desktopBreakpoint = window.matchMedia('(min-width: 992px)');

    this.init();
  }

  init() {
    if (!this.navToggle || !this.mainNav) return;

    if (!this.desktopBreakpoint.matches) {
      this.setTopPosition();
    }

    this.bindEvents();
    this.handleResize();
  }

  bindEvents() {
    this.navToggle.addEventListener('click', (e) => {
      e.preventDefault();
      this.toggleMenu();
    });

    this.desktopBreakpoint.addEventListener('change', () => this.handleResize());
  }

  handleResize() {
    const isDesktopNow = this.desktopBreakpoint.matches;

    if (isDesktopNow && this.isOpen) {
      this.toggleMenu();
    }

    if (!isDesktopNow) {
      this.setTopPosition();
    } else {
      // eslint-disable-next-line no-lonely-if
      if (this.mainNav) {
        this.mainNav.style.top = '';
      }
    }
  }

  setTopPosition() {
    if (!this.mainNav || !this.siteTitle) return;
    const header = document.querySelector('.site-header');
    const adminBar = document.querySelector('#wpadminbar');
    if (!header) return;

    const headerHeight = header.offsetHeight;
    const siteTitleHeight = this.siteTitle.offsetHeight;
    const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
    const totalOffset = headerHeight + siteTitleHeight + adminBarHeight;
    this.mainNav.style.top = `${totalOffset}px`;
  }

  toggleMenu() {
    this.isOpen = !this.isOpen;
    if (this.navToggle) {
      this.navToggle.setAttribute('aria-expanded', this.isOpen);
      this.navToggle.classList.toggle('is-active');
    }
    if (this.mainNav) {
      this.mainNav.classList.toggle('is-open');
    }
    document.body.classList.toggle('menu-open');
  }
}
