/**
 * Sub Navigation
 *
 * Creates submenu toggle buttons and handles mobile/tablet submenu toggling.
 */
export default class SubNav {
	constructor() {
		// Align breakpoint with main navigation logic ($breakpoint-lg)
		this.mobileBreakpoint = 992; // Use 992px
		this.navContainer = document.querySelector('.main-navigation');
		this.clickHandler = this.handleNavClick.bind(this);
	}

	init() {
		if (!this.navContainer) {
			return;
		}

		// Always create the toggle buttons on initialization
		this.setupToggleButtons();

		// Add the delegated click listener for mobile toggling
		this.navContainer.addEventListener('click', this.clickHandler);
	}

	setupToggleButtons() {
		if (!this.navContainer) return; // Guard clause

		const parentItems = this.navContainer.querySelectorAll('.menu-item-has-children');

		parentItems.forEach((item) => { // Removed unused 'index' parameter
			// Check if toggle already exists before creating
			if (!item.querySelector('.submenu-toggle')) {
				const toggle = document.createElement('button');
				toggle.className = 'submenu-toggle';
				// Start with aria-expanded false, CSS will control visibility
				toggle.setAttribute('aria-expanded', 'false');
				toggle.innerHTML = '<span class="screen-reader-text">Toggle submenu</span>';

				// Insert the button after the link within the list item
				const link = item.querySelector(':scope > a');
				if (link) {
					// Insert after the link element
					link.parentNode.insertBefore(toggle, link.nextSibling);
				} else {
					// Fallback: append to the list item if no link found (less ideal)
					item.appendChild(toggle);
				}
			} else {
				// Ensure existing toggles have correct initial aria state
				const existingToggle = item.querySelector('.submenu-toggle');
				if (existingToggle) {
					existingToggle.setAttribute('aria-expanded', 'false');
				}
			}
			// Ensure parent item doesn't have is-expanded initially
			item.classList.remove('is-expanded');
		});
	}

	handleNavClick(event) {
		// --- IMPORTANT: Only handle clicks below the mobile breakpoint ---
		if (window.innerWidth >= this.mobileBreakpoint) {
			// If on desktop, ensure default link behavior isn't prevented
			// (though ideally CSS would hide the button or make it non-interactive)
			return;
		}

		const { target } = event;
		// Find the closest menu item that has children
		const parentItem = target.closest('.menu-item-has-children');

		// Check if the click was on our toggle button OR directly on the parent link itself
		if (
			target.classList.contains('submenu-toggle') ||
			(parentItem &&
				target.tagName === 'A' &&
				target.closest('.menu-item-has-children') === parentItem &&
				target === parentItem.querySelector(':scope > a'))
		) {
			// Prevent default link behavior only if we are handling the toggle
			event.preventDefault();
			this.toggleSubmenu(parentItem);
		}
	}

	toggleSubmenu(item) {
		if (!item) return;

		// Toggle the class on the parent list item
		const isExpanded = item.classList.toggle('is-expanded');
		const toggle = item.querySelector('.submenu-toggle');
		if (toggle) {
			toggle.setAttribute('aria-expanded', isExpanded);
		}
	}

	// Removed checkViewportSize, handleResize, cleanupSubnavigation, initialized flag, resetExpandedStates
	// as the setup now happens once on load and cleanup isn't needed.
}
