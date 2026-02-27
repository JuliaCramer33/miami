# Miami Everywhere — WordPress Site (wp-content)

Overview of the Miami Everywhere website codebase for developers. This directory contains the custom theme, custom plugin, and supporting assets used by the site. The site runs on WordPress and is designed to be developed locally (e.g., Local by Flywheel).

---

## What’s in This Directory

- `themes/miami-everywhere/` — Custom theme (primary codebase)
- `plugins/` — Plugins, including custom `core-block-custom-breakpoints`
- `uploads/` — Media (typically not version-controlled)

No GitHub Actions or deployment workflows are present in this project snapshot.

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| **CMS** | WordPress |
| **Theme** | Custom theme `miami-everywhere` (PHP, block-based) |
| **Styling** | SCSS → built with `10up-toolkit` → `dist/css/style.css`, `dist/css/editor-style.css` |
| **Scripts** | JavaScript (ES modules) via `10up-toolkit` → `dist/js/main.js` (+ `main.asset.php`) |
| **Blocks** | ACF blocks registered in PHP (per-block `register.php` files) |
| **Custom fields** | Advanced Custom Fields Pro (ACF) |
| **Local dev** | Intended for Local by Flywheel (or similar local WP stack) |
| **Node** | Node 18 (package specifies `>=18.14.2`) |
| **Composer** | Used by theme for autoloading and PHP tooling |

---

## Theme: `miami-everywhere`

- **Namespace:** `MiamiEverywhere`
- **Text domain:** `miami-everywhere`
- **Composer autoloader:** theme expects `vendor/autoload.php` (run `composer install` in the theme)
- **Styles:** `assets/scss/` → `dist/css/style.css` and `dist/css/editor-style.css`
- **Scripts:** `assets/js/main.js` → `dist/js/main.js` with `dist/js/main.asset.php`
- **Fonts/externals:** Adobe Fonts (Typekit) enqueued; Splide used via npm and imported via SCSS
- **Menus:** `primary`, `footer`, `footer-utility`, `main-campus`, `social`
- **Block styles:** Registers custom styles (e.g., Button `outline` default and `offset`; Image `circle-styled`; Columns `no-gap`)
- **Editor features:** `theme.json` defines color palette, gradients, typography, and block-level settings
- **SVG support:** Upload allowed + admin display fixes

### Custom Post Types (in theme)

| Post type | Slug | Purpose |
|-----------|------|---------|
| Testimonial | `testimonial` | Student/Story testimonials (no public archive) |

### Taxonomies

- **Testimonials:** `story_type` (hierarchical)

### ACF Blocks (PHP-registered)

Registered under `themes/miami-everywhere/includes/Blocks/<block-name>/register.php`:

- `featured-testimonial`
- `related-stories`
- `stats`
- `image-overlap-card`
- `image-card-grid`

Block category: “Miami Everywhere” (`miami-blocks`).

### Patterns

- Example pattern in `themes/miami-everywhere/patterns/example-pattern.php`

### Theme behavior (high level)

- Enqueues compiled assets from `dist/` with dependency/version data read from generated `*.asset.php` files.
- Localizes `miami-everywhere-main` script with `miamiAjax` (includes `ajaxUrl` and a nonce).
- Adds SVG upload support and fixes SVG thumbnails in admin.
- Uses `theme.json` for design tokens (palette, gradients, typography).

---

## Custom Plugin

- `plugins/core-block-custom-breakpoints/` — Customizes Core Columns behavior with Bootstrap 5 breakpoints.
  - Built with `@wordpress/scripts` (scripts: `start`, `build`, `plugin-zip`, etc.).
  - Block name: `cspglobal/core-block-custom-breakpoints`
  - Depends on Bootstrap 5 and `@10up/block-components`.

---

## Spin-Up Process

### Prerequisites

- Local by Flywheel (or equivalent local WordPress stack)
- PHP 7.4+
- Node.js 18+ (theme requires `>=18.14.2`)
- npm 7+
- Composer (for theme autoloading and PHP tools)

### 1. Get the site running locally

1. Ensure your WordPress root is something like:
   - `…/Local Sites/miami/app/public/`
2. In Local, use an existing site or create one and point it at this `public` folder.
3. Start the site so you have a working WP install and database.

### 2. Install PHP dependencies (theme)

```bash
cd wp-content/themes/miami-everywhere
composer install
```

### 3. Build theme assets

```bash
cd wp-content/themes/miami-everywhere
npm ci
npm run build
```

Produces:
- `dist/css/style.css`
- `dist/css/editor-style.css`
- `dist/js/main.js`
- `dist/js/main.asset.php` (and `style.asset.php` as configured)

Dev server/watch:

```bash
npm run start
# or
npm run watch
```

### 4. Build plugin assets (`core-block-custom-breakpoints`)

```bash
cd wp-content/plugins/core-block-custom-breakpoints
npm ci
npm run build
```

### 5. WordPress configuration

- Ensure **Advanced Custom Fields Pro** is active (theme expects ACF for blocks/options).
- Activate theme **Miami Everywhere** and required plugins.
- Set permalinks (e.g., “Post name”) so custom routes behave as expected.

### 6. Development commands (theme)

From `themes/miami-everywhere`:

- `npm run start` — watch mode for JS/CSS via 10up Toolkit
- `npm run build` — production build of assets to `dist/`
- `npm run lint` — lint SCSS/JS/PHP
- `npm run format` — format JS/SCSS

From `plugins/core-block-custom-breakpoints`:

- `npm run start` — dev mode for the block
- `npm run build` — production build

---

## Repo structure (wp-content)

```text
wp-content/
├── plugins/
│   ├── core-block-custom-breakpoints/
│   │   ├── src/
│   │   ├── package.json
│   │   └── (build output under build/)
│   ├── advanced-custom-fields-pro/
│   ├── wordpress-seo/
│   └── … (other plugins)
├── themes/
│   └── miami-everywhere/
│       ├── assets/           # SCSS, JS, vendor, images, icons
│       ├── dist/             # Built CSS/JS (generated)
│       ├── includes/         # Blocks, post types, setup, classes, ACF config
│       │   ├── Blocks/
│       │   ├── PostTypes/
│       │   └── Setup/
│       ├── patterns/
│       ├── template-parts/
│       ├── templates/
│       ├── functions.php
│       ├── theme.json
│       ├── style.css
│       ├── package.json
│       └── composer.json
└── uploads/                  # Media
```

---

## Quick reference for outside developers

- **Where templates live:** `themes/miami-everywhere/` (`templates/`, `template-parts/`).
- **Where to add blocks:** `themes/miami-everywhere/includes/Blocks/<block-name>/` with a `register.php` that calls `acf_register_block_type` (registered on init).
- **Where CPTs are defined:** `themes/miami-everywhere/includes/PostTypes/` (Testimonial + `story_type` taxonomy).
- **Build before testing:** Run `npm run build` in the theme and in `core-block-custom-breakpoints` so `dist/`/`build/` are up to date.
- **Local URL:** `http://miami.local` (from theme config). Use your actual Local domain if different.

This should be enough for an outside developer to understand the stack, what’s built, and how to spin up the site locally.

# miami