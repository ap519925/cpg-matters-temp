# CPG Matters - Technical Processes and Workflows

This document outlines the core technical processes, custom codeflows, and background operations driving the CPG Matters Drupal 11 application. It is primarily intended for developers and site architects managing the custom theme and modules. 

For routine administration, please refer to the `CONTENT_GUIDE.md`.

---

## 1. Custom Module: `cpg_register`

The `cpg_register` module handles custom webform interactions and dynamic page rendering that falls outside standard Drupal or Views functionality.

### 1.1 Webform "Finish Later" Process
The site utilizes a multi-step registration framework, primarily involving altering the standard Drupal Webform behavior.
- **Hook:** `cpg_register_webform_submission_form_alter()`
- **Process:** When users interact with the "Finish Later" mechanism in multi-step webforms (such as the Registration or Newsletter onboarding flow), this module intercepts the form submission.
- **State Capture:** It intercepts the partially filled data and safely persists it into Drupal's `tempstore.private` keyed by `cpg_register` and `step1_data`.
- **AJAX Redirection:** Standard Webform AJAX logic attempts to break when injecting custom redirects. To bypass this, the module implements a dummy AJAX callback (`cpg_register_dummy_ajax_callback()`) that gracefully returns a `RedirectCommand` to push the user to the Registration Complete routing (`/registration-complete`).

### 1.2 Dictionary Aggregation & Rendering
The **Industry Dictionary** (`/industry-dictionary`) bypasses standard Drupal Views in favor of a specialized controller to accommodate its complex alphabetical sorting and categorization needs.
- **Controller:** `DictionaryController::content()`
- **Process:** 
  1. Queries all published `dictionary_term` nodes.
  2. Aggregates and structures the term variables (abbreviations, full names, examples).
  3. Iterates and groups the nodes into an array structured by their first alphabetical letter (A, B, C...).
  4. Generates an array of available letters and current taxonomical `dictionary_category` terms for dynamic filtering.
  5. Passes the data to the custom Twig template: `cpg-dictionary-page.html.twig`.

---

## 2. Custom Module: `cpg_setup`

The `cpg_setup` module is a utility module originally responsible for bootstrapping the application's foundational taxonomies, blocks, and dummy content.

### 2.1 Installation State (`cpg_setup.install`)
When enabled (or upon site initialization), `hook_install()` executes the following sequenced processes:
1. **Vocabulary Generation:** Establishes the `article_category` schema and seeds initial terms (e.g., Sustainability, E-Commerce).
2. **Block Entities:** Programmatically defines custom Block Content Types, specifically the `newsletter`, `ad_banner`, and `footer_column` types.
3. **Block Instantiation & Placement:** Spawns sample default blocks under these types and injects them into the `cpg_theme` regions. 
4. **Node Seeding:** Drafts and publishes default dummy `article` nodes linked to the created taxonomies to populate standard Views right out of the box.

*(Note: Legacy individual PHP migration and setup scripts, formally found in this directory, have been successfully executed, merged into core configuration, and removed to eliminate technical debt.)*

---

## 3. Theming & Styling Processes (`cpg_theme`)

The presentation layer operates completely independently of heavy framework libraries, relying purely on custom compiled CSS Grid, Flexbox layouts, and Twig overrides.

### 3.1 Template Preprocessing (`cpg_theme.theme`)
The `.theme` file contains logic defining how node-level variables are delivered to Twig wrappers. Routine preprocess operations generally involve capturing region statuses, deriving absolute URL paths for specific nodes to inject deeply into paragraphs, and converting certain boolean variables.

### 3.2 SCSS Compilation Flow
SCSS is strictly modularized within `web/themes/custom/cpg_theme/src/scss`.
- **Workflow:** Updates should exclusively be done in the individual `_partial.scss` files. Global variables and breakpoints live in `_variables.scss`.
- **Compilation Tooling:** The package strictly avoids Node/NPM overhead on the filesystem layout by executing `npx sass` independently inside the DDEV container.
- **Cache Invalidation:** Always execute a Drupal Cache Rebuild (`drush cr`) following a compilation.
- **Process execution:**
  ```bash
  ddev exec "cd /var/www/html/web/themes/custom/cpg_theme && npx sass src/scss/main.scss css/style.css --no-source-map"
  ```

### 3.3 Dynamic Admin Configurations
The backend theme settings (`/admin/appearance/settings/cpg_theme`) act as a bridge between the front-end layout and the CMS user.
- Modifications made in these theme settings (such as Site Logos, Red Accent overrides, Base Directory BG variables) are injected natively as CSS Custom Properties (e.g., `--cpg-brand-color`) into the `#page-wrapper` hierarchy via `_admin-colors.scss`.

---

## 4. Architectural Workflows

### 4.1 Paragraphs Strategy
Heavy reliance is placed on the **Paragraphs** module over standard WYSIWYG capabilities for structured landing pages.
- Data structures like Hero Banners, 3-Column Grids, Text Features, and Accordions are tightly bound to pre-mapped entities.
- **Process:** Editors string together paragraph components inside the layout canvas. Drupal loops these elements and passes them to specific templates in `web/themes/custom/cpg_theme/templates/paragraphs/`. The theme then renders them using predefined CSS Grid rules.

### 4.2 Synchronization
To ensure local test environments and upper stage/production bounds stay equivalent:
- Configuration is strictly exported to `web/sites/default/files/sync/`. 
- New fields, views, blocks, or formatters generated on any instance MUST be captured (`drush cex`) and subsequently committed to source control for reliable re-deployment.
