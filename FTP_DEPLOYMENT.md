# CPG Matters - FTP Deployment Guide

This document provides a highly detailed, step-by-step guide for deploying the CPG Matters Drupal 11 website to a remote web server using **only an FTP Client** (like FileZilla, Cyberduck, or WinSCP) and a standard hosting control panel (like cPanel, Plesk, etc.).

This guide assumes you do **not** have SSH/Command-Line access to the production server.

---

## Phase 1: Local Preparation

Because you are deploying via FTP without server command-line access, your local codebase needs to be 100% "production-ready" before you upload it. This means compiling your theme and installing all PHP dependencies locally.

1. **Compile Theme Assets (CSS/JS):**
   Open your local terminal (e.g., PowerShell or Command Prompt), navigate to the theme directory, and build the final assets.
   ```bash
   cd web/themes/custom/cpg_theme
   npm install
   npm run build
   ```
   *Verify that the `dist/css/main.css` file was generated properly.*

2. **Install PHP Dependencies via Composer:**
   From the main project root (`cpg_project/cpg`), run composer to download all required Drupal core and vendor files.
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
   *This ensures your `vendor/`, `web/core/`, and `web/modules/contrib/` directory are completely filled out.*

3. **Export Your Local Database:**
   If using DDEV locally, run:
   ```bash
   ddev export-db --gzip > cpg_matters_db_export.sql.gz
   ```
   *(If you already have `cpg_project_backup.sql.gz` in your root folder, you can use that.)*

---

## Phase 2: Transferring Files to the Server

Drupal consists of thousands of small files (especially within the `vendor` and `core` directories). Transferring them one by one via FTP can take a very long time and increases the risk of a corrupted transfer.

We highly recommend **Method A** if your hosting provides a File Manager (like in cPanel). If not, use **Method B**.

### Method A: The Zip Method (Recommended & Faster)
1. Locally, select all files and folders in your `cpg/` directory (including `.htaccess`, `vendor/`, `web/`, etc.) and compress them into a single file named `cpg_build.zip`.
2. Connect to your web server using your FTP client.
3. Upload `cpg_build.zip` to the directory *above* your public web root (if allowed) or directly into your `public_html` directory.
4. Log into your hosting account's Control Panel (e.g., cPanel).
5. Open the **File Manager**.
6. Locate `cpg_build.zip` and use the built-in "Extract" tool to unzip the contents.
7. *Note regarding the Web Root:* Drupal 11 expects the document root to be the `web/` folder. If your hosting forces the document root to be `public_html` and you cannot change it:
   - You must place the **contents** of your local `cpg/` folder directly into `public_html`. (Or move them using the File Manager after extracting).

### Method B: The Direct FTP Method (Slower)
1. Open your FTP client and connect to your web server using your hostname, FTP username, and password.
2. In the right pane (remote server), navigate to your desired document root (e.g., `public_html` or a custom sub-directory).
3. In the left pane (local computer), navigate to your `cpg/` project directory.
4. Select all files and folders—ensure you have **hidden files visible** so that `.htaccess` is included.
5. Drag and upload them to the remote server. 
   *(Note: This process may take 30+ minutes. Ensure your computer does not go to sleep during the transfer.)*

---

## Phase 3: Database Setup on the Server

1. **Create the Remote Database:**
   - Log into your hosting Control Panel.
   - Look for "MySQL Databases".
   - Create a new database (e.g., `cpgmatters_prod`).
   - Create a new MySQL User and generate a secure password. Keep this password safe.
   - Add the User to the Database and grant them **All Privileges**.

2. **Import the Database:**
   - From your hosting Control Panel, open **phpMyAdmin**.
   - On the left sidebar, click on your newly created database.
   - Click the **Import** tab at the top.
   - Click **Choose File** and select your local database export (e.g. `cpg_project_backup.sql.gz`).
   - Click **Go** (or Import) at the bottom. Wait for the green success message.

---

## Phase 4: Connecting the Code to the Database

You must now update Drupal's configuration to point to the remote database you just created.

1. **Edit the Settings File via FTP:**
   - In your FTP client, navigate on the remote server to: `web/sites/default/`.
   - Look for `settings.php`. *(If it doesn't exist, duplicate `default.settings.php` and rename it to `settings.php`)*.
   - Right-click `settings.php` and select **View/Edit** (this will open the file in your local text editor).

2. **Update Database Credentials:**
   Scroll to the bottom of the file and locate the `$databases` array. Update it with your *remote* credentials:
   ```php
   $databases['default']['default'] = array (
     'database' => 'your_remote_db_name',
     'username' => 'your_remote_db_user',
     'password' => 'your_remote_db_password',
     'host' => 'localhost', // Often localhost, but your host may provide a specific database hostname (e.g., db.hostgator.com)
     'port' => '3306',
     'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
     'driver' => 'mysql',
   );
   ```

3. **Save and Upload:**
   Save the file. Your FTP client should prompt you to upload the modified file back to the server. Click **Yes**.

---

## Phase 5: Finalizing the Deployment

1. **Set File Permissions:**
   Drupal requires certain directories to be writable to generate CSS/JS aggregations and upload images.
   - Through your FTP client, navigate to `web/sites/default/`.
   - Locate the `files` directory.
   - Right-click it, select **File Permissions** (or CHMOD).
   - Change the permissions to `755` or `775` (ensure it applied to directories underneath).

2. **Clear Drupal Cache:**
   Because you don't have SSH to run `drush cr`, you must clear the cache through the Drupal interface to finalize the theme rendering and paths.
   - Visit your remote website in a browser: `https://yourdomain.com/user/login`.
   - Log in using your admin credentials (the same ones from your local environment).
   - In the administrative toolbar, click **Configuration > Development > Performance**.
   - Click the **Clear all caches** button.

### Congratulations!
Your site should now be fully functional on the new web server using the FTP deployment method. Check your theme styling and click through a few articles to ensure URLs and images are properly loading.
