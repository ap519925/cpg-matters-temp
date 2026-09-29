# CPG Matters - Deployment Guide

This document provides instructions for deploying the CPG Matters Drupal 11 website to a production environment such as cPanel, or another LAMP stack server.

## Prerequisites

1.  **Hosting Environment:** A server running PHP 8.3+, a web server (Apache/Nginx), and a MySQL/MariaDB database server (e.g., cPanel).
2.  **Files Access:** SSH access or a robust FTP/File Manager to upload files.
3.  **Database Access:** Access to phpMyAdmin or a MySQL command-line client.
4.  **Composer:** SSH access recommending Composer installed globally, though you can upload the full `vendor` and `web/core` directories if SSH isn't available.

## 1. Code Deployment

1.  **Upload the Codebase:** Transfer all files from the project repository to your web server's document root (e.g., `public_html` or `www`).
    *   *Note:* Ensure that the document root of your web server points to the `web/` directory within the repository.
2.  **Install Dependencies (If using SSH):**
    ```bash
    composer install --no-dev --optimize-autoloader
    ```
3.  **Build the Theme Assets:**
    If you haven't compiled the assets locally, navigate to `web/themes/custom/cpg_theme` and run:
    ```bash
    npm install
    npm run build
    ```
    *Alternatively, you can just push the pre-compiled `dist/` folder.*

## 2. Database Import

A snapshot of the database is included as `cpg_matters_db_export.sql.gz` in the root of the repository.

1.  **Create a Database:** In your cPanel (or hosting control panel), create a new empty MySQL database and assign a user with full privileges to it. Note down the database name, username, and password.
2.  **Import via phpMyAdmin:**
    *   Open phpMyAdmin from your control panel.
    *   Select the newly created database from the left sidebar.
    *   Click on the **Import** tab at the top.
    *   Click **Choose File** and upload the `cpg_matters_db_export.sql.gz` file.
    *   Click **Go** (or **Import**) at the bottom of the page.
    *   *Wait for the success message.*

## 3. Configuration & Database Setup

1.  **Update settings.php:**
    *   Navigate to your configuration file, typically located at `web/sites/default/settings.php`.
    *   If the file doesn't exist, duplicate `default.settings.php` and rename it to `settings.php`.
    *   Update the database credentials array with the details created in Step 2:
        ```php
        $databases['default']['default'] = array (
          'database' => 'YOUR_DATABASE_NAME',
          'username' => 'YOUR_DATABASE_USER',
          'password' => 'YOUR_DATABASE_PASSWORD',
          'host' => 'localhost', // Or your database host address
          'port' => '3306',
          'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
          'driver' => 'mysql',
        );
        ```
    *   Update your `$settings['hash_salt']` if needed to be secure.
    *   Make sure `$settings['config_sync_directory']` points to the exported configuration, which by default is:
        ```php
        $settings['config_sync_directory'] = 'sites/default/files/sync';
        ```

## 4. Finalizing Deployment

Once the files, database, and settings are connected, you need to sync the latest configurations and clear the cache.

If you have **Drush** installed via SSH:

1.  **Import Configuration:**
    This pulls in the exact blocks, views, settings, and content types defined in `web/sites/default/files/sync`.
    ```bash
    drush config-import -y
    ```
2.  **Clear Caches:**
    ```bash
    drush cache-rebuild
    ```

If you **do not** have SSH access, you can perform these actions from the Drupal Admin UI:
1.  Log into your site at `yourdomain.com/user/login`.
2.  Navigate to **Configuration > Development > Configuration synchronization** (`/admin/config/development/configuration`).
3.  Review the changes and click **Import all**.
4.  Navigate to **Configuration > Development > Performance** (`/admin/config/development/performance`) and click **Clear all caches**.

## 5. Post-Deployment Checks

*   Verify the site loads correctly.
*   Verify the theme CSS and JS assets are loading (check network console for 404s).
*   Test that the main navigation and mobile menu toggle effectively.
*   Ensure that the custom logo and site branding appear correctly.
*   Verify permissions on the `web/sites/default/files` directory so Drupal can write uploaded images and aggregated CSS/JS files. (Usually `755` or `775`).
