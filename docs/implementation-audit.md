# WeightLossAffordable + NuestraRx combined package

**Status:** a one-theme/one-plugin staging and demo package is being assembled. It is not a claim of clinical, legal, privacy, security, WordPress-runtime, or production approval. Use an isolated staging site with backups before any installation.

## 1. Package shape

The deliverable is exactly:

1. `wp-content/themes/weightloss-affordable/` — the original WeightLossAffordable theme and design system, updated with the requested demo content and WLA-styled treatment view.
2. `wp-content/plugins/weightloss-affordable-core/` — the sole installable plugin. It contains WLA Core and Elementor widgets, the demo importer, the original NuestraRx Core implementation in `modules/nuestrarx/`, and WLA Experience content/shortcodes/widgets in `modules/experience/`.

Do not activate a separate NuestraRx Core or Experience plugin. Those modules are embedded to provide one plugin activation while preserving the original `nrx_*` question, validation, submission, treatment and admin code paths. Elementor (free) is optional for the theme fallback and recommended for editing imported pages.

The WLA theme’s original forest/sage/ivory palette, typography, card shapes, section composition, navigation and interaction patterns are retained. Content and required sections were adapted to the supplied WLA references rather than replacing the site with the NuestraRx theme.

## 2. Homepage and demo experience

The demo importer and front-page fallback include:

- WLA hero, guidance cards, and the four-stage `Explore → Question → Confirm → Decide` journey.
- “Our treatments / Two medications. One community.” with Semaglutide and Tirzepatide demo cards, feature bullets, comparison prices and links to dedicated WLA-styled detail pages.
- A science overview for the supplied GLP-1 and GLP-1 + GIP descriptions.
- Existing WLA resource explorer, FAQ, navigation/footer and educational article set.
- “Real transformations, before and after” with visual slots only; no patient identities, before/after photos, testimonials or outcomes are fabricated.
- A video-stories section with a playable generic stock sample (`flower.mp4`) explicitly labeled as stock footage, not a patient story. Replace it with genuine, consented and reviewed media before publication.
- Dedicated education, video, calculator, review and treatment pages, all rendered with WLA sections.
- Generated editorial hero/walk/nutrition photographs. These are illustrative and must not be represented as patients or treatment outcomes.

Demo prices and comparison prices displayed are the figures supplied by the client: Semaglutide from $139/month compared with $199; Tirzepatide from $239/month compared with $299. The supplied pharmacy statement and medication bullets are visible only as explicitly labeled demo copy. Confirm present-day product records, total cost, billing intervals, pharmacy, preparation, availability, clinical statements, substantiation, disclaimers and legal requirements before publishing. Do not treat a client-supplied figure as live pricing approval.

## 3. Original NuestraRx quiz and treatment workflow

The eligibility page’s `Experience Section` widget invokes the bundled original `[nrx_quiz]` renderer. The underlying configuration, questions/answers, branching, validation, bilingual labels, AJAX handler, intake workflow and admin editor are reused; no new quiz questions or substitute screening logic were written.

The combined package adds a server-side submission gate:

- The default setting `quiz_submissions_enabled` is off.
- Public submissions are rejected while it is off. The quiz may be viewed/navigated as demo content, but users should not enter real health information.
- After appropriate review, an administrator can enable it in **NuestraRx → Settings → Evaluación e integraciones** only after verifying HTTPS, consent/privacy text, storage and retention, access controls, security and the authorized clinical destination/webhook.
- The default NuestraRx treatment seed records remain drafts and carry `require_approval`. They are not shown as approved dynamic products. The visible home demo cards are separately and explicitly marked demo content.
- The optional NuestraRx Setup page was adjusted in combined mode so it does not replace the WLA homepage, site identity, timezone, locale or navigation; its seeded treatment records remain drafts.

The public quiz flow is not production-ready merely because the original source code is included. Its clinical copy, consent, screening rules, privacy, server configuration and downstream handling need client/clinical/legal review and a real authorized staging test.

## 4. Story and video publication controls

- Before/after areas are layout placeholders. No testimonials or transformations are seeded.
- Published WLA reviews render only when `_wla_review_approved` is explicitly set in the editorial approval panel.
- Published video stories render only when `_wla_video_approved` is explicitly checked. The private video-story content type supports provider/direct video URLs and optional WebVTT captions for direct video files.
- The one playable stock sample is a short generic plant clip solely to demonstrate a player; it is clearly not a patient story. Remove/replace it before a production launch.
- Obtain documented permission, substantiation and required clinical/legal approval for every real story, image, result and caption.

## 5. Install on staging

1. Back up the WordPress database and `wp-content`; use a staging site first.
2. Install and activate the `weightloss-affordable` theme ZIP.
3. Install and activate the single `weightloss-affordable-core` plugin ZIP. Do not activate extracted module folders separately.
4. Install/activate free Elementor if visual editing is desired.
5. In **WeightLossAffordable → Demo Import**, import the demo. It creates the WLA homepage and pages, Elementor documents, images, demo articles and review placeholders. On an existing site, review any page/menu updates before importing; do not use the importer as an unreviewed production migration.
6. Check WordPress permalinks and refresh them if needed. Verify WLA front page, treatment details, the quiz page, footer/navigation and all mobile layouts.
7. Leave public quiz submissions disabled. Verify exact content and integration on a secured test environment before enabling submissions.
8. Replace demo prices/claims, video and every placeholder only after appropriate confirmation and approval.

## 6. Verification performed and not performed

**Source/package checks:** review of the supplied WLA and NuestraRx sources and seed content; JavaScript calculator unit tests and syntax checks; JSON validation; PHP parsing (native PHP CLI/WordPress runtime not available); diff whitespace checks; ZIP archive integrity checks.

**Not tested or certified:** WordPress activation, Elementor rendering/editor behavior, database migrations, browser-side quiz branches/submission, privacy/data retention, webhook/email/CRM/checkout, pharmacy/product state, clinical accuracy, legal disclosures, result/video playback on a deployed site, end-to-end production flow, accessibility audit or actual device/browser layout. No staging database, credentials, production approvals or clinical endpoint were provided.

Before publication, verify the current WordPress/PHP/Elementor versions, backup/restore, WLA menu/routes, copy/prices/pharmacy, treatment approval flags, quiz Q&A and clinical review, consent/privacy, HTTPS/security, storage/retention, actual clinical routing, accessibility, captions, media rights, legal disclosures, error logs and mobile behavior. This package is installable; production readiness remains unverified and approval-dependent.
