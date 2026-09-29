# CPG Matters — Content & Administration Guide

> This guide explains how to update every major section of the CPG Matters website through the Drupal admin dashboard (Gin theme). No coding is required for routine content changes.

---

## Table of Contents

1. [Accessing the Admin Dashboard](#1-accessing-the-admin-dashboard)
2. [Managing Articles (Blog Posts)](#2-managing-articles-blog-posts)
3. [Editing Pages (About, Contact, White Papers)](#3-editing-pages-about-contact-white-papers)
4. [Working with Paragraphs (Page Builder)](#4-working-with-paragraphs-page-builder)
5. [Managing the Header & Navigation](#5-managing-the-header--navigation)
6. [Managing the Footer](#6-managing-the-footer)
7. [Managing Ad Banners](#7-managing-ad-banners)
8. [Managing the Newsletter Signup Block](#8-managing-the-newsletter-signup-block)
9. [Managing the Directory (Industry Listings)](#9-managing-the-directory-industry-listings)
10. [Managing the Dictionary](#10-managing-the-dictionary)
11. [Managing Taxonomy (Categories & Tags)](#11-managing-taxonomy-categories--tags)
12. [Managing Webforms (Contact & Newsletter)](#12-managing-webforms-contact--newsletter)
13. [Managing Search Results](#13-managing-search-results)
14. [Site Branding & Theme Settings](#14-site-branding--theme-settings)
15. [Managing Blocks & Regions](#15-managing-blocks--regions)
16. [SCSS & Styling (For Developers)](#16-scss--styling-for-developers)
17. [Deploying Changes (For Developers)](#17-deploying-changes-for-developers)

---

## 1. Accessing the Admin Dashboard

| Detail       | Value                                                |
|-------------|------------------------------------------------------|
| **URL**     | `https://your-domain.com/admin` (or `/user/login`)  |
| **Local**   | `http://cpg-project.ddev.site/admin`                 |
| **Login**   | `admin` / `admin` (local dev only)                   |
| **Theme**   | Gin (modern dashboard UI with sidebar navigation)    |

Once logged in, the admin toolbar appears at the top of every page. Use it to navigate to Content, Structure, Appearance, and Configuration.

---

## 2. Managing Articles (Blog Posts)

Articles are the core content of the site — they appear on the front page, in search results, and in the sidebar "Recent Articles" block.

### Creating a New Article

1. Go to **Content → Add content → Article** (`/node/add/article`)
2. Fill in the following fields:

| Field                     | Purpose                                      | Required |
|--------------------------|----------------------------------------------|----------|
| **Title**                | The article headline                         | ✅       |
| **Body**                 | Main article content (WYSIWYG editor)        | ✅       |
| **Image**                | Featured/hero image displayed at the top     | Recommended |
| **Featured Image Caption** | Caption text below the featured image      | Optional |
| **Summary / Lead Text**  | Short intro shown in article teasers         | Recommended |
| **Author Name**          | Displayed on the article page                | Optional |
| **Read Time**            | e.g. "5 min read" — shown in teasers         | Optional |
| **Tags**                 | Select a category tag (e.g. Sustainability)  | Recommended |
| **Sections** (Paragraphs)| Add rich content blocks below the body       | Optional |

3. Click **Save** to publish.

### Editing an Existing Article

- Go to **Content** (`/admin/content`), find the article, and click **Edit**.
- Or navigate to the article on the frontend and click the **Edit** tab in the toolbar.

### Front Page Display

The front page uses the **Frontpage** view, which automatically lists the most recent published articles. No manual curation is needed — just publish articles and they appear.

---

## 3. Editing Pages (About, Contact, White Papers)

The site has several "Basic page" nodes that serve as key landing pages. Each uses the **Paragraphs** system for modular, drag-and-drop content building.

| Page           | Path              | How to Edit                                      |
|---------------|-------------------|--------------------------------------------------|
| **About Us**  | `/about-us`       | Content → find "About Us" → Edit                |
| **Contact**   | `/contact`        | Content → find "Contact" → Edit                 |
| **White Papers** | `/white-papers` | Content → find "White Papers" → Edit           |

### Editing a Page

1. Go to **Content** (`/admin/content`)
2. Filter by **Type: Basic page** to quickly find it
3. Click **Edit** next to the page
4. Modify the **Sections** field — this contains all the Paragraph components that make up the page
5. Click **Save**

> **Important:** The visual layout of these pages is controlled by the Paragraph components within the "Sections" field. See Section 4 below for details on each Paragraph type.

---

## 4. Working with Paragraphs (Page Builder)

Paragraphs are the drag-and-drop building blocks used to construct pages. When editing any page or article, the **Sections** field lets you add, reorder, and remove Paragraph components.

### Available Paragraph Types

| Paragraph Type       | What It Does                                                  | Key Fields                            |
|---------------------|---------------------------------------------------------------|---------------------------------------|
| **Hero Banner**      | Full-width banner with title, subtitle, CTA button, and background image | Title, Subtitle, Button Link, Image |
| **Text Block**       | Simple rich text content                                      | Body Text                             |
| **Card**             | A single card with icon, image, title, description, and link  | Icon/Emoji, Image, Title, Description, Link |
| **Card Grid**        | A titled section containing multiple Cards                    | Section Title, Subtitle, Cards        |
| **Call to Action**   | Highlighted banner with title, text, and button               | Title, Description, Button Link       |
| **Multi-Column Layout** | 2 or 3 column layout — each column holds nested Paragraphs | Columns (each with nested content)   |
| **Column**           | A single column inside Multi-Column Layout                    | Column Content (nested Paragraphs)    |
| **Features/Grid Section** | Section with title + grid of Feature Items               | Section Title, Subtitle, Feature Items |
| **Feature/Grid Item**| Individual feature with icon, title, description              | Icon, Title, Description              |
| **Statistics Bar**   | Horizontal bar showing key numbers/stats                      | Section Title, Statistics             |
| **Statistic Item**   | A single stat (number + label + description)                  | Value/Number, Label, Description      |
| **Accordion / FAQ**  | Expandable FAQ section                                        | Section Title, FAQ Items              |
| **Accordion Item**   | Single FAQ question/answer                                    | Question, Answer                      |
| **Blockquote / Testimonial** | Styled quote with attribution and optional photo      | Quote Text, Attribution, Role, Photo  |
| **Media & Text**     | Side-by-side layout with image and text                       | Title, Image, Text Content            |
| **Image**            | Standalone image                                              | Image                                 |
| **Video Embed**      | Embedded video (YouTube/Vimeo URL or embed code)              | Title, Embed Code/URL                 |
| **Team Grid**        | Grid of team member cards                                     | Section Title, Subtitle, Members      |
| **Team Member**      | Individual team member card                                   | Name, Role, Bio, Photo                |
| **Company Card**     | Company/brand listing card                                    | Company Name, Logo, Description, Industry, Website |
| **Directory Grid**   | Grid of Company Cards                                         | Section Title, Subtitle, Listings     |
| **Section Divider**  | A horizontal line break between sections                      | *(none)*                              |

### How to Add a Paragraph

1. While editing a page or article, scroll to the **Sections** field
2. Click **Add Sections** (or the dropdown arrow) to see available types
3. Select a type (e.g., "Hero Banner")
4. Fill in the fields
5. Drag to reorder paragraphs using the handle on the left
6. Click **Save** on the page

### Tips

- **Nesting:** Some Paragraphs support nesting. For example, `Card Grid` contains `Card` items, and `Multi-Column Layout` contains `Column` items which themselves hold other Paragraphs.
- **Icons/Emojis:** Fields labeled "Icon/Emoji" accept emoji characters (e.g. 🌱, 📦) or text. These render directly in the frontend.
- **Links:** Link fields accept both internal paths (`/about-us`) and external URLs (`https://example.com`).

---

## 5. Managing the Header & Navigation

### Site Logo & Name

1. Go to **Appearance → Settings → CPG Matters Theme** (`/admin/appearance/settings/cpg_theme`)
2. Upload or change the **Logo image**
3. The **Site name** and **Slogan** are set at **Configuration → System → Basic site settings** (`/admin/config/system/site-information`)

### Main Navigation Menu

1. Go to **Structure → Menus → Main navigation** (`/admin/structure/menu/manage/main`)
2. Click **Add link** to add a new menu item
3. Drag items to reorder or nest them (for dropdowns)
4. Click **Save**

The main navigation appears in the header on desktop and inside the mobile navigation drawer on smaller screens.

### Mobile Navigation

The mobile hamburger menu and drawer are automatic — they mirror the **Main navigation** menu and any blocks placed in the **Mobile Drawer Navigation** region. No separate configuration is needed.

---

## 6. Managing the Footer

The footer is divided into **four columns** plus a **bottom bar**. Each column is powered by a separate Drupal menu:

| Footer Region       | Menu Name              | Admin Path                                           |
|---------------------|------------------------|------------------------------------------------------|
| **Column 1 (About)**| About CPG Matters      | `/admin/structure/menu/manage/footer-about`          |
| **Column 2 (Resources)** | Resources          | `/admin/structure/menu/manage/footer-resources`      |
| **Column 3 (Topics)** | Topics               | `/admin/structure/menu/manage/footer-topics`         |
| **Column 4 (Connect)** | Connect              | `/admin/structure/menu/manage/footer-connect`        |
| **Bottom Bar**       | Footer                 | `/admin/structure/menu/manage/footer`                |

### Editing Footer Links

1. Go to **Structure → Menus** and select the appropriate footer menu
2. Click **Add link** or edit existing items
3. Drag to reorder
4. Click **Save**

---

## 7. Managing Ad Banners

Ad banners are custom blocks of type **Ad Banner**. They can be placed in designated ad regions.

### Creating/Editing an Ad Banner

1. Go to **Structure → Block layout → Content blocks** (`/admin/content/block`)
2. Find the existing ad banner or click **Add content block → Ad Banner**
3. Fill in:
   - **Ad Image** — the banner creative (upload a JPG/PNG)
   - **Ad Link** — the click-through URL
   - **Ad Size** — e.g. `728x90`, `300x250`, or `160x600`
4. Click **Save**

### Placing an Ad Banner

1. Go to **Structure → Block layout** (`/admin/structure/block`)
2. Make sure you're viewing the **CPG Matters Theme** tab
3. Click **Place block** in the appropriate region:
   - **Top Banner Ad (728x90)** — leaderboard above the content
   - **Sidebar First (Skyscraper 160x600)** — left sidebar
   - **Sidebar Second (Rectangle 300x250)** — right sidebar
4. Select the ad banner block you created
5. Click **Save block** and then **Save blocks**

---

## 8. Managing the Newsletter Signup Block

The Newsletter Signup block appears in the right sidebar and on various pages.

### Editing the Newsletter Block

1. Go to **Structure → Block layout → Content blocks** (`/admin/content/block`)
2. Find the **Newsletter Signup** block and click **Edit**
3. Modify the **Subtitle** field (e.g., "Get the latest CPG insights delivered to your inbox")
4. Click **Save**

The newsletter form itself is a Webform — see [Section 12](#12-managing-webforms-contact--newsletter).

---

## 9. Managing the Directory (Industry Listings)

The Directory page displays **Directory Listing** nodes in a searchable, filterable grid.

### Adding a New Listing

1. Go to **Content → Add content → Directory Listing** (`/node/add/directory_listing`)
2. Fill in:

| Field             | Purpose                                |
|------------------|----------------------------------------|
| **Title**        | Company/organization name              |
| **Contact Name** | Primary contact person                 |
| **Website**      | Company website URL                    |
| **Expertise**    | Select relevant expertise tags         |
| **Sections**     | Optional: add Paragraphs for detail    |

3. Click **Save**

### Directory View Configuration

The directory listing page is powered by the **CPG Industry Directory** view. To modify filters, sort order, or displayed fields:

1. Go to **Structure → Views → CPG Industry Directory** (`/admin/structure/views/view/directory`)
2. Modify the view configuration
3. Click **Save**

---

## 10. Managing the Dictionary

Dictionary pages display industry terminology in an A–Z format.

### Adding a New Term

1. Go to **Content → Add content → Dictionary Term** (`/node/add/dictionary_term`)
2. Fill in:

| Field                 | Purpose                                    |
|----------------------|-------------------------------------------|
| **Title**            | The term (abbreviation or keyword)         |
| **Full Name / Subtitle** | The expanded form of the term          |
| **Body**             | Full definition                            |
| **Also Known As**    | Alternate names for the term               |
| **Category**         | Select a Dictionary Category               |
| **Example**          | Usage example                              |
| **Related Articles Link** | Link to relevant articles on the site |

3. Click **Save**

---

## 11. Managing Taxonomy (Categories & Tags)

Taxonomy vocabularies are used to categorize and tag content across the site.

| Vocabulary            | Used By                 | Admin Path                                      |
|-----------------------|-------------------------|------------------------------------------------|
| **Tags**              | Articles (main category) | `/admin/structure/taxonomy/manage/tags`         |
| **Article Category**  | Article categorization   | `/admin/structure/taxonomy/manage/article_category` |
| **Dictionary Category** | Dictionary terms       | `/admin/structure/taxonomy/manage/dictionary_category` |
| **Expertise**         | Directory listings       | `/admin/structure/taxonomy/manage/expertise`    |

### Adding a New Tag/Term

1. Navigate to the vocabulary via the paths above
2. Click **Add term**
3. Enter the term **Name** (and optional description)
4. Click **Save**

> **Note for Articles:** When you assign a tag from the "Tags" vocabulary to an article, the theme automatically maps it to an icon:
> - 🌱 Sustainability, 🛒 E-Commerce, 💡 Innovation, 📦 Supply Chain
> - 📱 Marketing, 💰 Finance, 🔧 Technology, 👔 Leadership
> - 🏪 Retail, 🏭 Manufacturing, 📈 Default

---

## 12. Managing Webforms (Contact & Newsletter)

The site uses Drupal **Webform** module for forms. The two primary webforms are:

| Webform                  | Purpose                     | Path                                          |
|-------------------------|-----------------------------|-----------------------------------------------|
| **Contact Us**          | Main contact form            | `/admin/structure/webform/manage/contact_us`  |
| **Newsletter Subscription** | Email signup form        | `/admin/structure/webform/manage/newsletter`  |

### Editing a Webform

1. Go to **Structure → Webforms** (`/admin/structure/webform`)
2. Click **Build** next to the webform to modify fields
3. Click **Settings** to change confirmation messages, email handlers, etc.
4. Click **Results** to view submissions

### Viewing Submissions

All form submissions are stored in Drupal. Go to:
- **Structure → Webforms → [form name] → Results**
- Or the global submissions view at `/admin/structure/webform/manage/contact_us/results/submissions`

---

## 13. Managing Search Results

The search results page is powered by the **Search Results** view.

### Modifying the Search Results Display

1. Go to **Structure → Views → Search Results** (`/admin/structure/views/view/search_results`)
2. You can modify:
   - Which fields are shown in results
   - Sort order (relevance vs. date)
   - Number of results per page
   - Contextual filters
3. Click **Save**

---

## 14. Site Branding & Theme Settings

### Brand Colors (Admin-Editable)

The theme supports CSS custom properties that can be overridden from theme settings:

1. Go to **Appearance → Settings → CPG Matters Theme** (`/admin/appearance/settings/cpg_theme`)
2. Adjust available color settings:

| Setting                    | Default   | Affects                                    |
|---------------------------|-----------|---------------------------------------------|
| **Brand Color**           | `#C41E3A` | Buttons, links, accents, category tags      |
| **Brand Dark Color**      | `#9B1730` | Hover states, gradients                     |
| **Text Color**            | `#1A1A1A` | Body text                                    |
| **Footer Background**     | `#1A1A1A` | Footer section background                   |
| **Header Border Width**   | `4px`     | Red accent bar under the header             |
| **Directory Card BG**     | `#E8F1FC` | Background of directory listing cards       |
| **White Papers Card BG**  | `#FFFFFF` | Background of white paper cards             |

3. Click **Save configuration**

### Logo

1. Go to **Appearance → Settings → CPG Matters Theme**
2. Uncheck **"Use the logo supplied by the theme"** (if checked)
3. Upload your custom logo image
4. Click **Save configuration**

---

## 15. Managing Blocks & Regions

Blocks are placed into **Regions** to control where they appear on the page.

### Theme Regions

| Region                    | Description                                    |
|--------------------------|------------------------------------------------|
| **Header**               | Site branding area                              |
| **Header Search**        | Search form in header                           |
| **Header Actions**       | Subscribe button, phone number                  |
| **Primary Menu**         | Main navigation links                           |
| **Hero Section**         | Full-width hero area (used by some pages)       |
| **Top Banner Ad**        | Leaderboard ad banner (728×90)                  |
| **Sidebar First**        | Left sidebar (topics flyout, skyscraper ads)    |
| **Main Content**         | Primary content area                            |
| **Sidebar Second**       | Right sidebar (newsletter, ads, recent articles)|
| **Mobile Flyout Topics** | Topic sidebar for mobile                        |
| **Mobile Drawer Navigation** | Mobile hamburger menu content               |
| **Footer About**         | Footer column 1                                 |
| **Footer Resources**     | Footer column 2                                 |
| **Footer Topics**        | Footer column 3                                 |
| **Footer Connect**       | Footer column 4                                 |
| **Footer Bottom**        | Copyright / legal links bar                     |

### Moving or Adding Blocks

1. Go to **Structure → Block layout** (`/admin/structure/block`)
2. Ensure you're on the **CPG Matters Theme** tab
3. Click **Place block** in the desired region
4. Select a block (existing or create new)
5. Configure visibility (e.g., show on specific pages only)
6. Click **Save blocks**

---

## 16. SCSS & Styling (For Developers)

The theme's styles are written in SCSS and live in:

```
web/themes/custom/cpg_theme/src/scss/
```

### File Reference

| File                    | Purpose                                              |
|------------------------|------------------------------------------------------|
| `main.scss`            | Entry point that imports all partials                 |
| `_variables.scss`      | SCSS variables (spacing, breakpoints)                |
| `_base.scss`           | Global resets and typography                         |
| `_layout.scss`         | Core layout grid                                     |
| `_header.scss`         | Header, navigation, mobile menu, hamburger           |
| `_footer.scss`         | Footer columns and bottom bar                        |
| `_articles.scss`       | Article teaser cards                                 |
| `_article-full.scss`   | Full article page layout                             |
| `_sidebar.scss`        | Sidebar blocks and newsletter                        |
| `_paragraphs.scss`     | All paragraph type styles                            |
| `_directory.scss`      | Directory listing page                               |
| `_dictionary.scss`     | Dictionary page                                      |
| `_whitepapers.scss`    | White papers page                                    |
| `_search-results.scss` | Search results page                                  |
| `_contact_page.scss`   | Contact page                                         |
| `_about.scss`          | About Us page                                        |
| `_register.scss`       | Registration multi-step form                         |
| `_sitemap.scss`        | Sitemap page                                         |
| `_columns.scss`        | Multi-column layout system                           |
| `_admin-colors.scss`   | CSS custom property overrides for admin-editable colors |
| `_drupal-overrides.scss` | Fixes for Drupal core markup quirks                |

### Compiling SCSS

Run this from the project root:

```bash
ddev exec "cd /var/www/html/web/themes/custom/cpg_theme && npx sass src/scss/main.scss css/style.css --no-source-map"
```

After compiling, clear Drupal's cache:

```bash
ddev drush cr
```

---

## 17. Deploying Changes (For Developers)

After making any changes through the dashboard or code:

### Step 1: Export Configuration
```bash
ddev drush cex -y
```
This saves all Drupal configuration (content types, views, blocks, etc.) to `web/sites/default/files/sync/`.

### Step 2: Export Database Backup
```bash
ddev export-db --file=db.sql.gz
```

### Step 3: Commit & Push
```bash
git add -A
git commit -m "Describe your changes here"
git push
```

### On Another Machine / Production

```bash
# Pull the latest code
git pull

# Install dependencies
ddev composer install   # or: composer install --no-dev

# Import the database (if needed)
ddev import-db --file=db.sql.gz

# Import configuration
ddev drush cim -y

# Clear caches
ddev drush cr
```

---

## Quick Reference: Common Tasks

| Task                            | Where to Go                                           |
|--------------------------------|-------------------------------------------------------|
| Add a new article              | Content → Add content → Article                      |
| Edit the homepage              | Content → find homepage node → Edit                  |
| Change navigation links        | Structure → Menus → Main navigation                  |
| Update footer links            | Structure → Menus → (footer menu name)               |
| Change the logo                | Appearance → Settings → CPG Matters Theme            |
| Change brand colors            | Appearance → Settings → CPG Matters Theme            |
| Add a new ad banner            | Structure → Block layout → Content blocks → Add      |
| View contact form submissions  | Structure → Webforms → Contact Us → Results          |
| Add a new taxonomy tag         | Structure → Taxonomy → Tags → Add term               |
| Add a directory listing        | Content → Add content → Directory Listing            |
| Add a dictionary term          | Content → Add content → Dictionary Term              |
| Rearrange blocks on page       | Structure → Block layout                              |
| Clear all caches               | Configuration → Development → Performance → Clear    |
