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
