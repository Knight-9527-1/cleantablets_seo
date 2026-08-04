# BunJoin Child WordPress Theme

This repository is the deployable WordPress child theme for BunJoin, a B2B cleaning tablet OEM/ODM and private label manufacturer website.

The repository root is the theme root. After Hostinger deploys this repository to:

```text
public_html/wp-content/themes/bunjoin-child/
```

WordPress should see:

```text
public_html/wp-content/themes/bunjoin-child/style.css
```

Do not deploy this repository inside another nested `bunjoin-child` or `cleantablets_seo` folder.

## Theme Assumptions

- Parent theme slug: `hostinger-ai-theme`
- Child theme name: `BunJoin Child`
- Text domain: `bunjoin-child`
- The parent theme is not included or modified by this repository.
- The child theme includes both PHP fallback templates and valid block templates for compatibility with classic or block-oriented parent behavior.
- Multilingual support is designed for the free Polylang plugin with English, Chinese, and Spanish.
- The theme outputs lightweight SEO tags for managed pages: title, meta description, canonical, Open Graph, Twitter summary tags, hreflang, and neutral JSON-LD organization data.

## Included Site Structure

Navigation:

- Home
- Products
- Capabilities
- Quality
- About Us
- Insights
- Contact Us
- Request a Quote button

Product pages:

- Washing Machine Cleaner Tablets
- Dishwasher Cleaner Tablets
- Coffee Machine Cleaner Tablets
- Ice Machine Cleaner Tablets
- Garbage Disposal Cleaner Tablets
- Bottle Cleaner Tablets

The theme avoids unverified claims about factory area, production capacity, certificates, patents, customer names, founding year, or sales data. Placeholder sections are included so verified information can be added later.

## Main Files

```text
style.css
functions.php
theme.json
header.php
footer.php
front-page.php
page.php
home.php
archive.php
single.php
search.php
404.php
searchform.php
templates/
parts/
patterns/
template-parts/
assets/js/theme.js
assets/images/cleaning-tablets-illustration.svg
```

## Page Initialization

The theme does not automatically change the live database, homepage setting, menus, or existing content.

After deploying and activating the child theme, go to:

```text
WordPress Admin -> Appearance -> BunJoin Setup
```

Click:

```text
Create Missing BunJoin Pages
```

This action is idempotent:

- It only creates pages that do not already exist by slug.
- If Polylang is active and `en`, `zh`, and `es` are configured, it creates only missing translated pages and links them as translations.
- It stores a private `_bunjoin_page_key` value so translated pages can render the correct theme-managed page even when free Polylang requires unique slugs such as `zh-products` or `es-products`.
- It does not overwrite existing pages.
- It does not overwrite menus.
- It does not set the front page automatically.

Recommended slugs:

```text
/products/
/capabilities/
/quality/
/about-us/
/insights/
/contact-us/
/washing-machine-cleaner-tablets/
/dishwasher-cleaner-tablets/
/coffee-machine-cleaner-tablets/
/ice-machine-cleaner-tablets/
/garbage-disposal-cleaner-tablets/
/bottle-cleaner-tablets/
```

Recommended Polylang languages:

```text
English: en
Chinese: zh
Spanish: es
```

## Managed Page Rendering

The theme renders the Home, Products, Capabilities, Quality, About Us, Insights, Contact Us, and product detail pages from theme templates and PHP renderers.

For these managed pages, the theme does not automatically append the saved WordPress editor body. This prevents older Hostinger AI Theme block content from appearing below the new BunJoin theme sections and creating a duplicated homepage or duplicated landing page.

Standard WordPress pages that do not match the managed slugs still render their editor content normally.

## Multilingual SEO

The theme includes lightweight multilingual SEO support:

- English is the primary language.
- Chinese and Spanish are secondary languages.
- Public managed pages output localized SEO titles and descriptions.
- Managed pages output `hreflang` alternates for `en_US`, `zh_CN`, `es_ES`, plus `x-default`.
- The header includes a compact language switcher.
- The theme does not claim certifications, factory area, capacity, patents, founding year, customer names, or sales data.

If a full SEO plugin is installed later, review duplicate meta output and disable one source if needed.

## Logo

The header reads the WordPress Custom Logo setting.

If no custom logo is configured, the header displays temporary text:

```text
BunJoin
```

Set the real logo in:

```text
Appearance -> Customize -> Site Identity
```

or the equivalent Site Editor area provided by the active WordPress version.

## Contact Form

The contact page includes a built-in RFQ form with:

- Name
- Company
- Business Email
- Country/Market
- Product Type
- Service Type
- Estimated Order Quantity
- Formula Requirements
- Packaging Requirements
- Target Launch Date
- Message

Security and handling:

- Uses a WordPress nonce.
- Sanitizes all submitted fields.
- Validates required fields and business email format.
- Includes a honeypot field.
- Sends to the WordPress administrator email from `Settings -> General`.
- Does not depend on paid plugins.
- Does not hardcode a recipient email address.

If the form validates but email fails, check the WordPress mail configuration or add a transactional SMTP plugin.

## Products Are Catalog-Only

The Products section is intentionally not a retail store:

- No cart flow.
- No checkout flow.
- No public price table.
- No add-to-cart buttons.
- Product cards link to detail pages and RFQ.
- Product detail pages reserve specifications, packaging, MOQ, documents, samples, and quotation notes.

If WooCommerce is installed, the child theme removes default WooCommerce price and add-to-cart actions on the front end and uses `woocommerce.php` as a catalog-only fallback template.

## Cache Refresh

After Hostinger deploys the latest commit:

1. Clear Hostinger cache.
2. Clear any WordPress cache plugin cache.
3. Clear browser cache or test in a private window.
4. In WordPress, visit `Appearance -> Themes` and confirm `BunJoin Child` is no longer marked as broken.
5. Preview first, then activate only when ready.

## Rollback

If the child theme causes problems after activation:

1. In WordPress Admin, switch back to `hostinger-ai-theme`.
2. On Hostinger/GitHub deployment, redeploy the previous known good commit if needed.
3. Do not delete the parent theme.

From the repository, a non-destructive local rollback can be prepared with:

```bash
git revert <commit-sha>
git push origin main
```

Use `git revert` rather than force-pushing or rewriting shared history.

## Content Still Needed

Replace placeholders only with verified information:

- Real logo and brand assets
- Business email, phone, and address
- Factory photos and equipment details
- Factory area and production capacity
- Confirmed certifications or audit documents
- MOQ and lead time rules by product and packaging
- Product specification sheets
- COA/SDS examples or document policies
- Approved customer case studies or anonymized project stories
