# CPG Matters - Drupal 11 Project

Welcome to the **CPG Matters** project repository! This is a modern, component-driven Drupal 11 website built to deliver insights, analysis, and innovation stories for the Consumer Packaged Goods industry.

## Technology Stack
- **Core:** Drupal 11 (PHP 8.3)
- **Local Development Environment:** DDEV
- **Theme:** Custom `cpg_theme` (SCSS, Twig Component-Based Design)
- **Database:** MariaDB
- **Key Modules:** Paragraphs, Webforms, Views

## Getting Started

### Prerequisites
- Docker Desktop or equivalent container runner.
- DDEV installed (`ddev --version`).

### Local Environment Setup
1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd cpg_project
   ```

2. **Start the DDEV environment:**
   ```bash
   ddev start
   ```

3. **Install dependencies (if not already managed):**
   ```bash
   ddev composer install
   ```

4. **Import the Database:**
   The project includes a recent database backup. Import it using:
   ```bash
   ddev import-db --file=cpg_project_backup.sql.gz
   ```

5. **Import Configuration:**
   Sync the Drupal configuration to ensure all fields, blocks, and settings are up to date:
   ```bash
   ddev drush cim -y
   ```

6. **Clear Caches:**
   ```bash
   ddev drush cr
   ```

You can now access your site locally at `http://cpg-project.ddev.site`. 

*(Login credentials: `admin` / `admin`)*

## Theme Development (`cpg_theme`)

The site’s frontend is fully custom and built from the ground up to match the CPG Matters mockup designs. It primarily utilizes CSS Grid/Flexbox and BEM architecture.

### SCSS Compilation
Styles are constructed via SCSS inside `web/themes/custom/cpg_theme/src/scss/`. To compile the SCSS down to CSS, you can run the following command from the root of the project:

```bash
ddev exec "cd /var/www/html/web/themes/custom/cpg_theme && npx sass src/scss/main.scss css/style.css --no-source-map"
```

### Key Custom Components
- **Dynamic Paragraphs:** Highly modular page construction using the Paragraphs module (e.g., `cpg_hero`, `cpg_column`, `cpg_card_grid`, `cpg_stats_bar`). These pieces are completely editable via the Drupal admin dashboard, making page building flexible for content editors.
- **Webforms Integration:** The custom SCSS directly targets internal Drupal Webforms classes to maintain pixel-perfect styling for the **Contact Us** and **Newsletter Subscription** forms without relying on hardcoded third-party scripts.
- **Responsive Layouts:** Implements specific breakpoint logic to cleanly reflow multi-column article grids, sidemenus, floating topics bars, and mobile off-canvas navigations.

## Deploying Changes
If you make configuration changes (like adding new fields, modifying views, or changing theme settings in the dashboard):
1. **Export the Configuration:** `ddev drush cex -y`
2. **Export the Database (as a backup snapshot):** `ddev export-db --file=cpg_project_backup.sql.gz`
3. Commit everything to Git and Push!

## Troubleshooting Windows Performance
If you are developing this on Windows and the site loads incredibly slowly across clicks:
This typically happens when DDEV mounts the project via standard NTFS Windows file sharing (Docker's 9P protocol). To dramatically speed up performance, ensure your project files reside exclusively within the WSL2 filesystem (`\\wsl$\Ubuntu\home\...`), and enable DDEV's Mutagen synchronization caching via `ddev config global --mutagen-enabled`.

## Project Narrative & Development Reflection

### Project Narrative
The **CPG Matters** project was conceived as a high-performance, component-driven digital publishing platform engineered for the Consumer Packaged Goods (CPG) industry. Built on Drupal 11 and PHP 8.3, the goal was to deliver an engaging media experience featuring industry insights, analysis, multi-tiered directories, and interactive reader services. The architecture balances deep editorial flexibility with strict visual branding—enabling content teams to assemble modular, pixel-perfect pages while accommodating real-world infrastructure constraints spanning containerized local development to shared production hosting.

---

### Reflection & Retrospective

#### What challenges were you trying to solve?
- **Component-Driven Editorial Freedom vs. Brand Consistency:** Content creators needed the agility to assemble varied landing pages (heroes, stat counters, multi-column card grids, accordions, and ad slots) without writing HTML or accidentally breaking design conventions. We resolved this by building a Paragraphs-based design system in `cpg_theme` that pairs structured Drupal backend entities with strict BEM CSS Grid and Flexbox components.
- **Complex Multi-Step Form Logic & State Preservation:** The site required an onboarding and newsletter registration funnel with a seamless "Finish Later" option. Standard Drupal Webform AJAX handlers can break when intercepting submission pipelines with custom redirects. To solve this, our custom `cpg_register` module captures partially completed forms into Drupal's `tempstore.private` and uses a custom AJAX callback with Drupal `RedirectCommand` to navigate users cleanly without data loss.
- **Specialized Data Architecture & Categorization:** The **Industry Dictionary** (`/industry-dictionary`) needed alphabetical indexing, term cross-referencing, and category filtering that proved cumbersome and slow within standard Drupal Views. We resolved this by developing a specialized `DictionaryController` that programmatically indexes all dictionary nodes into an alphabetized memory structure passed directly into a dedicated Twig template.
- **Dynamic Frontend Branding for Non-Developers:** Site administrators needed the ability to tweak accent colors, directory background tones, and brand headers without modifying stylesheets. We bridged backend configuration with frontend styles by exposing theme settings in the Drupal admin and injecting values dynamically as CSS Custom Properties (`--cpg-brand-color`) at runtime.

#### What, if any, technical limitations were you working within?
- **Restricted Production Hosting Environment:** The target production deployment was standard shared cPanel/FTP hosting without SSH command-line access or server-side Composer/Drush runtimes. This required every deployment package to be fully compiled, optimized (`composer install --no-dev --optimize-autoloader`), and self-contained prior to upload.
- **Early Adoption of Drupal 11 & PHP 8.3:** Developing on the cutting-edge Drupal 11 foundation meant working with newer core APIs and strictly adhering to PHP 8.3 typing and deprecation standards, while ensuring contributed modules (like Paragraphs and Webform) functioned harmoniously without legacy dependencies.
- **Windows File I/O Performance with Docker:** Running containerized local environments (DDEV/Docker) on Windows NTFS filesystems can suffer from significant I/O latency. We mitigated this by containerizing builds, adopting WSL2, and leveraging Mutagen file synchronization.
- **Asset Pipeline & Repository Hygiene:** To prevent bulky `node_modules` from bloating the Git repository or production deployments, we encapsulated Sass and Vite compilation within local tooling, committing only the compiled, minified CSS/JS distribution assets (`dist/`).

#### If you were collaborating with other developers how did you separate the work?
- **Clean Decoupling of Frontend and Backend:**
  - **Backend / Site Architecture:** Focused on Drupal's Configuration Management Initiative (`config/sync`), content type definitions, Paragraph schemas, taxonomy structures, and custom module hooks (`cpg_register`, `cpg_setup`).
  - **Frontend / Theme Development:** Focused within `web/themes/custom/cpg_theme/`, crafting Twig templates, BEM-structured SCSS partials, responsive breakpoints, and client-side interactions (search filters, mobile off-canvas menus).
- **Strict Configuration Management (CMI) Workflow:** To prevent database merge conflicts, all site configuration (views, fields, forms, blocks) was managed strictly through Drupal CMI (`drush cex` / `drush cim`). Developers never shared database dumps for schema updates—only code and YAML configuration were committed and merged.
- **Modular Custom Modules & Discrete Feature Branches:** Isolating unique business logic into distinct custom modules (`cpg_register` for form behavior and `cpg_setup` for initial entity scaffolding) allowed developers to work on discrete features in Git branches without touching shared codebase files.

#### What did you enjoy about the project?
- **Crafting a Bespoke, Modern CSS Architecture:** Building a custom theme from scratch using CSS Grid, Flexbox, and CSS Custom Properties—without the weight or visual homogenization of monolithic frameworks like Bootstrap—was rewarding. It resulted in a fast, lightweight, and responsive frontend with an authentic editorial feel.
- **Empowering Content Editors Through Paragraphs:** Designing an intuitive content-building experience where complex layouts can be stacked and reordered effortlessly like Lego bricks gave the CMS a modern, headless-like editorial agility.
- **Solving Deep Drupal Integration Puzzles:** Architecting custom solutions—such as intercepting Webform AJAX cycles via private temporary storage and building custom controllers for dictionary collation—provided an opportunity to leverage Drupal’s core hook and dependency injection architecture cleanly.
- **Developer Velocity with DDEV:** Having a consistent, containerized local environment mirroring production PHP 8.3 and MariaDB made testing and environment parity smooth.

#### What would you do differently if you could do it over?
- **Adopt Single Directory Components (SDC) from the Start:** While our custom theme uses modular Twig templates and SCSS partials, standardizing on Drupal 10/11's native Single Directory Components (SDC) from day one would have unified Twig, CSS, and JS into single component folders for even cleaner encapsulation.
- **Automate Deployment via CI/CD Pipelines:** Rather than packaging manual FTP/cPanel uploads, I would implement a GitHub Actions CI/CD pipeline to automatically execute linting, SCSS compilation, dependency optimization, and push artifact bundles directly to the hosting server via automated hooks.
- **Manage Secrets via the Key Module / `.env`:** External integration credentials (such as Constant Contact API tokens) should be handled from the very beginning using Drupal’s `key` module linked to environment variables, ensuring zero sensitive tokens ever enter configuration sync files.
- **Utilize Drupal Migrate API for Content Seeding:** Rather than maintaining database backup snapshots for starter content, I would build structured Drupal Migrate API fixtures to programmatically seed demo nodes, taxonomy terms, and sample media on demand.
