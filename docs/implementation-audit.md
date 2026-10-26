# WeightLossAffordable enhancement — audit, implementation map and handoff

**Status:** deployable plugin source and distributable packages prepared. This checkout is a source ZIP, not a runnable WordPress installation. The additions are implemented without replacing or editing the supplied WeightLossAffordable parent theme, editing third-party plugin source, or creating substitute product/quiz/result data. A WordPress staging site is still required for configuration and end-to-end acceptance.

## 1. Audit inventory

### Supplied files

The repository initially contained only `wp-content.zip` (about 1.8 MB uncompressed). Its archive contains:

- `themes/weightloss-affordable/`, parent theme source marked **WeightLossAffordable 2.0.0**, requiring WordPress 6.6+ and PHP 7.4+.
- `plugins/weightloss-affordable-core/`, **WeightLossAffordable Core 2.0.0**, including Elementor widgets, service/treatment/package/review/team post types, enquiry form, translation functionality and demo importer.
- `themes/nuestrarx/` and `plugins/nuestrarx-core/`, reference implementation source. NuestraRx Core is marked **1.1.0**, GPL-2.0-or-later, WordPress 6.6+ and PHP 7.4+.
- Nested plugin/theme ZIPs are present in the archive as well as unpacked source. No child-theme ZIP, WordPress database, `wp-config.php`, production credentials, Elementor export/template, or separate client approval/asset package was supplied.

### WeightLossAffordable frontend

- The supplied theme's `front-page.php` renders the Elementor page canvas when the homepage is configured as an Elementor-built page; otherwise it renders its own complete homepage.
- The fallback homepage's source order is Hero → Intro → Services → Journey (`A SIMPLE STARTING POINT` / `A clearer path, one step at a time.`) → Approach → Pricing → Resource Explorer → Reviews → FAQ → Contact. The Resource Explorer is a distinct interactive library and is not modified or removed.
- The parent theme contains the existing fonts, color tokens, layout system, logo, responsive rules and homepage sections. Its resource presentation is implemented in the theme source. The WLA Core plugin registers 13 Elementor widgets when Elementor is present.
- The archive does **not** reveal which theme is currently active, whether the Core plugin is active, which page is the live homepage, whether the homepage uses Elementor, or whether Elementor Pro is installed. Those require WordPress administrator access.

### NuestraRx product and quiz reference

- NuestraRx Core registers `nrx_treatment` records and includes editable treatment fields for images, descriptions, plans/prices, product references, compliance visibility, purchase/consultation URLs and optional WooCommerce IDs. Its adapter can read its internal product records or WooCommerce according to its saved product-source setting.
- Treatment records are explicitly initialized through the plugin's administrator setup flow; no WordPress database or initialized production records were supplied. The website's public content cannot prove which records, prices, approval states or commerce configuration are active in the client's database.
- NuestraRx Core includes a configurable quiz engine (`[nrx_quiz]`): published/draft configurations, question/choice editing, field types, ordering/duplication/deletion, conditions, preview/publish/revisions, validation, server-side evaluation, and a secure submission handler. The source includes default configuration, but the live published quiz and its clinical review status are stored in the unavailable WordPress database.
- Public inspection covered homepage chunks on both domains, the semaglutide and tirzepatide detail pages, the intake entry point, and the linked `/resources/` route. At audit time, the public WeightLossAffordable domain returned Spanish NuestraRx-branded homepage/treatment content very similar to NuestraRx, while the supplied WLA 2.0 theme source is a separate editorial design. The live homepage exposes two treatment choices, multi-step journey messaging, FAQ/resources, patient transformation claims with named stories and measurements, written patient testimonials, and audio testimonial players; it did not expose a verified video-testimonial source. Public availability is not proof of testimonial consent, substantiation, or clinical/legal approval, so none of those claims/assets were copied into the new components. The public semaglutide/tirzepatide detail pages show monthly, quarterly and six-month plan options with prices that should be read from the actual live product source rather than copied or frozen in templates. The public `/resources/` URL returned 404 at audit time; the supplied WLA theme nevertheless contains a Resource Explorer section and resource data model. The public intake exposed only its initial BMI/start state and numbered phase markers, not the complete conditional flow or a completed submission. Both public domains returned substantially overlapping homepage/intake content. Public output does not establish active theme, product records, quiz version, integrations, or testimonial permissions.
- NuestraRx Core source includes optional clinical webhooks signed with HMAC, optional encrypted intake storage, email notifications, and a WooCommerce adapter. Whether webhooks, secrets, email delivery, downstream CRM, payment, scheduling, or other integrations are configured and working is **not verifiable** from source files. No payment processor or CRM credentials/configuration were supplied.

### Missing approvals and access

Production WordPress administrator/staging access, active theme/plugin/version report, database backup, Elementor page data, product catalog export, published quiz configuration and review sign-off, verified quote/intake URL, integration test credentials, approved patient outcome content, approved testimonial videos/captions/posters, compliance review, and any clinical copy approvals were not supplied. No medical claims, prices, results or testimonials were seeded by this implementation.

## 2. Implementation map

The new `WeightLossAffordable Experience` plugin provides one Elementor widget (`Experience Section`) and equivalent shortcodes. Its styles follow the supplied WLA theme's forest/sage/sand palette, serif/sans hierarchy, rounded cards and restrained spacing. Existing theme sections and URLs are untouched.

| Component | Recommended placement | Editable source |
| --- | --- | --- |
| Treatment Plans | Homepage after the existing Pricing/Approach content and before the Resource Explorer; preserve the Resource Explorer's existing place and design. | Published `nrx_treatment` records when NuestraRx Core is active, otherwise existing `wla_treatment` records. Existing source owns prices, plans and URLs. |
| Get a Quote | A prominent CTA near Treatment Plans and/or existing Journey; the CTA links to the verified secure intake. Optionally embed the existing quiz in Elementor. | Elementor widget heading, description, mode and URL. Quiz questions/branching stay in NuestraRx Core's quiz editor. |
| Results | Adjacent to or in place of no existing section only after the owner chooses; best placed beside the existing Reviews section. | Existing WLA Reviews records. Empty when no approved records exist. |
| Video Testimonials | Beside Reviews/Results on the homepage or treatment detail page when genuine approved media exists. | Private `Video Testimonials` WordPress content type; poster via featured image, video URL and optional WebVTT caption track for direct files. |
| Calculators | After the Resource Explorer or on an educational/calculator page; does not displace any existing homepage section. | Elementor heading/supporting copy; user selects units. Formulas are fixed, client-side and not saved. |
| Resource Library | Retain its current section and presentation; no replacement or restructuring performed. | Existing theme/Elementor content as configured on the site. |

Placement is intentionally an administrator action: the actual homepage/Elementor document and site database were not supplied, so this plugin does not guess at or overwrite the live page structure. Add the sections as Elementor widgets (or shortcodes) after review on staging.

## 3. What was implemented

Files are under `wp-content/plugins/weightloss-affordable-experience/`:

- Elementor `Experience Section` widget for Treatments, Quote, Results, Videos and Calculators. Presentation headings, supporting text, display limit, quote mode, intake URL and optional CTA are Elementor controls.
- Dynamic treatment cards read from the existing NuestraRx source using `nrx_treatment_data()` (including its WooCommerce adapter when configured); pending-compliance treatments are hidden. If NuestraRx Core is unavailable, the plugin displays existing published WLA treatment records without fabricating price fields. It never imports/duplicates products.
- Quote section with either a configured/auto-detected intake CTA or the original `[nrx_quiz]` shortcode when NuestraRx Core is active. The quiz bridge invokes the original plugin's asset/config loader and adds a small WLA token skin; it does not copy quiz questions, screening rules, validation, submissions or patient data. The quote outcome carries a clear no-diagnosis/no-guaranteed-approval notice.
- Results cards draw only from published WLA Review records. No cards are shown to visitors if that source is empty; administrators see an editor-only setup hint. Add only authorized/substantiated copy and images.
- Private video-story CPT with a URL and optional captions-track meta box. YouTube/Vimeo embed URLs are allowlisted and player iframes load only on Play; enable captions at the provider when available. Direct MP4/WebM uses native controls, lazy poster images and an optional WebVTT captions track. No videos are seeded.
- BMI and weight-change calculators with boundary validation. Values are calculated in-browser and not posted. BMI displays a number only, without medical categories/eligibility advice. The percentage output is relative to a positive starting weight and is an arithmetic comparison, not an outcome forecast.
- Conditional asset loading, responsive layouts, semantic section/card/form markup, labels, keyboard focus styles, live error/result regions and reduced-motion support.

No edits were made to the supplied WLA parent theme or NuestraRx plugin source. The supplied theme and core plugin are included unchanged in the refreshed full `wp-content.zip`.

## 4. Install and configure on staging

1. Back up the WordPress database and `wp-content`; use staging first. Confirm the live site is actually based on the supplied WeightLossAffordable 2.0 theme/Core versions or adapt before use.
2. Install/activate the supplied WeightLossAffordable theme and Core plugin as appropriate; preserve the existing active theme settings and Elementor page. Do **not** activate the NuestraRx theme just to use its backend.
3. Install `weightloss-affordable-experience.zip` from **Plugins → Add New → Upload Plugin**, then activate it. It requires WordPress 6.6+ and PHP 7.4+; Elementor is optional for shortcodes and required for the Experience Section widget.
4. If using NuestraRx product/quiz features, verify that NuestraRx Core is legally approved for this site, install/activate it on staging, run its explicit setup only after backup and review its configuration. Verify product source, published treatment records, compliance flags, plan data and WooCommerce IDs before enabling Treatment Plans.
5. In Elementor, add an Experience Section widget for each desired section. Select the correct mode. For the Quote widget, either choose **Embed the existing NuestraRx quiz** (only when NRX Core and a reviewed published configuration are active) or select the exact approved intake page URL. Do not publish an unverified URL.
6. Place sections according to the table. Check global styles, existing sections, tablet/mobile, nav and footer; retain existing Resource Library content and order.
7. Add only approved WLA Review records and authorized video assets. Keep Results/Video sections unpublished/hidden until approvals and media exist.
8. Complete the staging checklist below, especially a real authorized quote submission and confirmation of downstream routing, before production rollout.

Shortcodes: `[wla_treatment_plans]`, `[wla_get_quote mode="cta" url="/intake/"]`, `[wla_get_quote mode="quiz"]`, `[wla_results]`, `[wla_video_testimonials]`, `[wla_calculators]`. Replace `/intake/` with the verified route.

## 5. Verification status and QA checklist

**Tested in this workspace:** Node calculator unit tests pass (BMI metric, BMI US customary, invalid/boundary inputs, loss/gain/unchanged percentage calculations); both JavaScript assets pass `node --check`; all added PHP files parse with `php-parser` (the native PHP CLI is not installed); both ZIP archives pass `unzip -t`. Public WeightLossAffordable and NuestraRx homepage chunks, treatment detail pages, intake entry point and resource route were inspected. Source architecture was reviewed.

**Not tested and not claimed as passed:** PHP lint (PHP CLI is absent in this workspace), WordPress activation, Elementor rendering/editor experience, installed plugin compatibility, quiz appearance/branching/submission, webhook/email/CRM/checkout, production products/prices, real result/video display, captions playback across platforms, mobile browser behavior, accessibility audit, SEO, caching/performance, or security review on the actual site. No staging site or WordPress database was available.

Before release, verify:

- [ ] Parent theme, child theme (if any), WordPress/PHP versions, Elementor version, active plugins, plugin licenses and backups.
- [ ] Exact source/permissions for NuestraRx Core and its compatibility with the target site's data and service agreements.
- [ ] Product source, IDs, plan/variation prices, details, status, approved imagery, purchase/consultation destination and order.
- [ ] Published quiz content/version, all conditional branches, consent, server validation, outcome copy, submission destination, access permissions, logs and deletion/privacy requirements.
- [ ] Quote intake link, actual test submission and authorized downstream handoff; verify email, webhook signature/secret, CRM, scheduling, payment and checkout separately where applicable.
- [ ] Elementor page placement and edits at mobile/tablet/desktop; preserve URLs, navigation, Resource Library and all original homepage sections.
- [ ] Authorized result/testimonial consent, substantiation, captions/subtitles, host privacy settings and clinical/compliance/legal approval.
- [ ] Calculator outputs against independent cases, error handling, keyboard/screen-reader flow and confirmation that no health inputs are transmitted or logged.
- [ ] PHP/JS logs, browser console, broken links/media, focus/contrast, performance, external requests, canonical/metadata/structured data, privacy and security controls.

This code package is an implementation scaffold ready for staging configuration, not a claim of production readiness or proof that third-party integrations are configured.
