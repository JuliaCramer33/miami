# Miami Everywhere SCSS

This is an SCSS version of the Miami Everywhere WordPress theme. It has been converted from the original CSS-based theme to take advantage of SCSS features like:

- Proper nesting of selectors
- Using variables in media queries
- Better maintainability of styles
- Improved modularity and organization

## SCSS Structure

The SCSS files are organized in the following structure:

```
assets/scss/
├── base/          # Base styles for HTML elements
├── components/    # Component-specific styles
├── global/        # Global styles
├── layout/        # Layout components
├── settings/      # Variables and settings
│   └── _variables.scss  # SCSS variables
└── utilities/     # Utility classes
```

## Development Setup

This theme uses npm and 10up-toolkit for SCSS compilation. To get started with development:

1. Install dependencies:
   ```
   npm install
   ```

2. Start the development server:
   ```
   npm start
   ```

3. Build for production:
   ```
   npm run build
   ```

## Converting from CSS Variables to SCSS Variables

The theme now uses SCSS variables (e.g., `$color-primary`) which are also output as CSS custom properties (e.g., `--color-primary`) for backward compatibility. This approach allows us to:

- Use variables in media queries (which isn't possible with CSS variables)
- Maintain compatibility with existing code that uses CSS variables
- Improve the maintainability of the codebase

## Original Theme Documentation

# Miami Everywhere WordPress Theme

A modern, accessible WordPress theme built with modern CSS and JavaScript.

## Features

- Modern CSS with custom properties (variables)
- Modular CSS architecture
- Responsive design
- Accessibility-ready
- Custom post types for testimonials
- Block editor support
- JavaScript modules for enhanced functionality

## Theme Structure

```
miami-everywhere/
├── dist/                  # Compiled assets (JS)
├── includes/              # PHP includes
│   ├── post-types/        # Custom post type definitions
│   │   └── testimonials.php
│   └── setup/             # Theme setup files
│       └── theme-setup.php
├── src/                   # Source files
│   ├── css/               # CSS files
│   │   ├── components.css # Component styles
│   │   ├── editor-style.css # Block editor styles
│   │   ├── layouts.css    # Layout styles
│   │   └── style.css      # Main styles and variables
│   └── js/                # JavaScript files
│       ├── frontend/      # Frontend JavaScript
│       │   ├── modules/   # JavaScript modules
│       │   │   ├── font-loading.js
│       │   │   └── smooth-scroll.js
│       │   └── index.js   # Main frontend entry point
│       ├── editor/        # Block editor JavaScript
│       └── navigation.js  # Navigation functionality
├── functions.php          # Theme functions
├── index.php              # Main template file
├── package.json           # NPM package configuration
└── style.css              # Theme metadata
```

## Development

### Prerequisites

- Node.js (v14+)
- npm or yarn
- Local WordPress development environment

### Getting Started

1. Clone this repository into your WordPress themes directory
2. Navigate to the theme directory and install dependencies:

```bash
cd wp-content/themes/miami-everywhere
npm install
```

3. Start the development server:

```bash
npm run watch
```

This will start a development server with hot reloading.

### Building for Production

To build the assets for production, run:

```bash
npm run build
```

This will compile and optimize all assets for production use.

## CSS Architecture

The theme uses a modular CSS approach with the following files:

- **style.css**: Core styles and CSS custom properties (variables)
- **components.css**: Reusable UI components (buttons, cards, forms, etc.)
- **layouts.css**: Layout utilities and grid system
- **editor-style.css**: Styles specific to the WordPress block editor

## JavaScript Architecture

JavaScript is organized into modules:

- **navigation.js**: Handles mobile navigation and menu functionality
- **frontend/index.js**: Main entry point for frontend JavaScript
- **frontend/modules/**: Individual functionality modules
  - **font-loading.js**: Handles Adobe Fonts loading states
  - **smooth-scroll.js**: Provides smooth scrolling for anchor links

## WordPress Integration

The theme integrates with WordPress through:

- Custom post types (testimonials)
- Block editor support
- Navigation menus
- Widget areas

## Accessibility

The theme is built with accessibility in mind, including:

- Proper heading hierarchy
- ARIA attributes for interactive elements
- Skip links
- Keyboard navigation support
- Screen reader text utilities
- Focus management

## Browser Support

The theme supports all modern browsers, including:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

This theme is licensed under the GPL-2.0-or-later license.

## Credits

- Built by Julia Cramer
- Uses Adobe Fonts (Typekit) for typography
- Uses modern-normalize for CSS reset

# 10up Theme

## Working with `theme.json`

The default theme scaffold now ships with a very basic version of the `theme.json` file. This is to ensure all the side-affects of introducing this file are there from the beginning of a project and therefore set projects up for success if they want to adopt more features through the `theme.json` mechanism.

### Basics of `theme.json`

The `theme.json` file allows you to take control of your blocks in both the editor and the frontend. The file is structured in a `settings` and a `styles` section where you can define options on a global level and then override them / adjust them on a block level.

The values that you provide in the `theme.json` file will be added both on the frontend and in the editor as [CSS custom properties following a fixed naming scheme](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/#css-custom-properties-presets-custom).

### 🙋 FAQ

<details>
<summary>Where has the `.wp-block-group__inner-container` gone?</summary>
<br />

Core has made the decision to drop the additional inner container of the group block. The rationale behind that decision is that the additional `div` semantically isn't necessary and modern layout techniques don't rely on it anymore. The container is still present for _legacy_ themes (themes without a `theme.json` file).

For new builds it is suggested that we use the `settings.layout.contentWidth` and `settings.layout.wideWidth` options of the `theme.json` for this. The group block has an option in the editor to allow editors to inherit the width for its inner elements.

<img width="1904" alt="Screen Shot 2021-10-20 at 12 45 15" src="https://user-images.githubusercontent.com/20684594/138079160-44a28c10-417b-4769-905d-cd5c104e78c0.png">

```json
{
	"version": 1,
	"settings": {
		"layout": {
			"contentSize": "800px",
			"wideSize": "900px"
		}
	}
}
```

For this, there isn't even any custom CSS needed.

There isn't the best story for responsive overrides in here but the recommendation at this point in time would be using `clamp` as we have officially dropped the IE11 support and that would allow us to have a fluid with scale here for the elements.
[https://caniuse.com/css-math-functions](https://caniuse.com/css-math-functions)

If we need to use different content widths here we can stick to the core way and apply the `max-width` settings to the children of the group block instead of the wrapper element.

```css
.wp-block-group > * {
	max-width: var(--site-max-width);
}
```

If there are instances where we really cannot get by with styling the child blocks directly there is a hook in PHP that allows us to filter the block editor settings and therefore allows us to override the underlying `supportsLayout` property:

```php
add_filter(
	'block_editor_settings_all',
	'remove_layout_support_from_editor_settings'
);

/**
 * This function sets the `supportsLayout` option in the editor settings to false
 * Therefore it adds back the `wp-block-group__inner-container` element
 *
 * As a side effect of this change the `contentWidth` and `wideWidth` defined in the theme.json
 * no longer have any effect and all the blocks in the editor won't have any width restrictions
 * applied to them. So that needs to do be manually done by the theme.
 *
 * @param array $settings block editor settings
 */
function remove_layout_support_from_editor_settings( $settings ) {
	$settings['supportsLayout'] = false;
	return $settings;
}
```

</details>

<details>
<summary>Where can I find documentation for `theme.json`</summary>

### Core Handbook

You can find the Core Documentation here: [https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/). This should give you an overview of the options that are available and be a starting point for you to explore. In the Code examples you will get ones for `WordPress` and ones for `Gutenberg`. The ones for WordPress always are for the version in Core and therefore what we would want to look at.

### Code completion and validation

Additionally you can add inline documentation & code completion to your editor by adding the `JSON Schema` to your editor.

For VSCode you can add the following to your Settings. But other editors also support this and you can find more information on the topic here: [https://json.schemastore.org](https://json.schemastore.org)

```json
{
	"json.schemas": [
		{
			"fileMatch": ["/theme.json"],
			"url": "https://json.schemastore.org/theme-v1.json"
		}
	]
}
```

</details>

<sub>\* for 10uppers, reach out to Fabian for any questions / guidance / support in regards to `theme.json`</sub>

# Performance Utilities

The theme now supports `ct.css`. Uh what?
`ct.css` is a diagnostic stylesheet that exposes potential performance issues in your pages `<head>` element. `ct.css` will return color-coded visual cues with regards to render blocking elements in the theme. This provides a great way for engineers to debug and identify problem resources.

You can activate `ct.css` on any page load by including `?debug_perf=1` in the URL.

Considering we do not want to load script everywhere throughout the theme, we have provided engineeers with a way to trigger the `ct.css` output by using a query param.

<sub>\* for 10uppers, reach out to Daine for any questions / guidance / support in regards to `ct.css`</sub>

## Coding Standards

This theme follows the [10up coding standards](https://10up.github.io/Engineering-Best-Practices/) with the following specific configurations:

### Indentation and Formatting

- **CSS files**: Use tabs for indentation
- **PHP and HTML files**: Use 4 spaces for indentation
- **JSON, YAML, and similar files**: Use 2 spaces for indentation
- All files should have a newline at the end
- Trailing whitespace should be trimmed

### Editor Configuration

The project includes several configuration files to ensure consistent coding standards:

- `.editorconfig`: Defines basic editor settings like indentation style and line endings
- `.stylelintrc`: Configures CSS linting rules
- `.prettierrc`: Sets code formatting rules
- `.vscode/settings.json`: Provides VS Code-specific settings

### Setting Up Your Editor

For the best development experience, make sure your editor respects these configuration files:

#### VS Code

1. Install the following extensions:
   - EditorConfig for VS Code
   - Prettier - Code formatter
   - stylelint
   - ESLint

2. The workspace settings will automatically configure VS Code to use tabs for CSS files and the correct formatting options.

#### Other Editors

For other editors, please ensure they support:
- EditorConfig
- Prettier
- stylelint
- ESLint

### Pre-commit Hooks (Optional)

To enforce these standards, you can set up pre-commit hooks using Husky and lint-staged. This will automatically format and lint your code before each commit.

```bash
npm install --save-dev husky lint-staged
```

Then add the following to your package.json:

```json
"husky": {
  "hooks": {
    "pre-commit": "lint-staged"
  }
},
"lint-staged": {
  "*.css": [
    "stylelint --fix"
  ],
  "*.js": [
    "eslint --fix"
  ],
  "*.php": [
    "php -l"
  ]
}
```

## Social Menu Setup

### Creating the Social Menu

1. In WordPress admin, go to **Appearance > Menus**
2. Create a new menu by clicking "create a new menu"
3. Give it a name like "Social Links Menu"
4. Add custom links to your social media profiles:
   - **URL**: Your social media profile URL (e.g., `https://facebook.com/your-page`)
   - **Link Text**: Name of the platform (e.g., "Facebook")
5. For each menu item, you can optionally add CSS classes in the "CSS Classes" field (optional):
   - facebook
   - twitter (or x)
   - linkedin
   - instagram
   - youtube
   - etc.
6. Under "Menu Settings", check "Social Links Menu" as the display location
7. Click "Save Menu"

The theme will automatically detect which social platform each link points to based on the URL. It will display the appropriate SVG icon for each platform.

### Available Social Icons

The following social platforms are supported with built-in SVG icons:

- Facebook
- Twitter/X
- LinkedIn
- Instagram
- YouTube

If you link to other platforms, the theme will try to display a generic icon.

### Accessibility

Each social icon includes the link text as a screen-reader-only element, ensuring that the menu is accessible to all users.

## Setting Up Menus

The theme has three menu locations that can be managed through WordPress admin:

### Primary Menu
The main navigation for your site.

### Main Campus Menu
A dedicated menu for Main Campus links. This appears in the mobile navigation.

### Social Links Menu 
The social media icons menu. This also appears in the mobile navigation.

## Setting Up the Social Menu

The social menu is displayed in both the mobile navigation and the footer. Here's how to set it up:

1. Go to **Appearance > Menus** in your WordPress admin
2. Create a new menu (e.g., "Social Links Menu")
3. Add links to your social media profiles
4. For each link, in the Navigation Label, add HTML code that includes both the text and SVG image:
   ```html
   <span class="visually-hidden">Facebook</span><img src="/wp-content/themes/miami-everywhere/dist/images/icons/facebook.svg" alt="Facebook" width="24" height="24">
   ```
5. Repeat for each social platform, using the correct SVG path:
   - `/wp-content/themes/miami-everywhere/dist/images/icons/facebook.svg`
   - `/wp-content/themes/miami-everywhere/dist/images/icons/twitter-x.svg`
   - `/wp-content/themes/miami-everywhere/dist/images/icons/instagram.svg`
   - `/wp-content/themes/miami-everywhere/dist/images/icons/linkedin.svg`
   - `/wp-content/themes/miami-everywhere/dist/images/icons/youtube.svg`
6. Under "Menu Settings", select "Social Links Menu" as the display location
7. Save your menu

The theme will automatically display these social links in both the mobile menu and the footer.

## Setting Up the Main Campus Menu

1. Go to **Appearance > Menus** in your WordPress admin
2. Create a new menu (e.g., "Main Campus Menu")
3. Add your Main Campus link(s)
4. Under "Menu Settings", select "Main Campus Menu" as the display location
5. Save your menu

The Main Campus link will appear as a highlighted button in the mobile menu.
