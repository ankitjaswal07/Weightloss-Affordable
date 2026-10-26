=== WeightLossAffordable Core + NuestraRx ===
Contributors: weightlossaffordable
Requires at least: 6.6
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPL-2.0-or-later

One installable plugin combining the WeightLossAffordable Elementor widgets, site/demo importer, and the original NuestraRx quiz, intake, content, treatment and administration modules. Pair it with the WeightLossAffordable theme. Do not install separate NuestraRx Core or WeightLossAffordable Experience plugins; their source modules are bundled here.

== Design and demo sections ==

- Native WeightLossAffordable Elementor widgets and theme-compatible styles.
- One-click multi-page demo import with hero, information cards, treatment cards, the four-stage journey, science overview, resource library, transformation placeholders, video-story section, FAQ and contact content.
- Dedicated demo pages for Semaglutide, Tirzepatide, the original eligibility quiz, science, educational calculators, resources, video stories and the rest of the supplied WLA demo.
- Treatment cards show the client-provided demonstration prices ($139 and $239 from; $199 and $299 comparison) with an explicit demo/verify-before-publishing notice.
- Three empty before/after story slots; no patient photos, identities or outcomes are invented.
- One playable generic stock-clip video sample, visibly labeled as not a patient testimonial. Replace before publication.
- Generated editorial lifestyle images are illustrative, not patients or treatment outcome evidence.

== NuestraRx functionality ==

The original NuestraRx question configuration, quiz UI, branching, validation, intake handlers, admin editor, content structures, safety/compliance tools and treatment records are bundled under `modules/nuestrarx/`. Quiz questions and answers have not been rewritten. WLA styling is applied without substituting a new quiz.

Public quiz submissions are disabled by default and rejected server-side until an administrator enables them in NuestraRx → Settings → Evaluación e integraciones. The quiz can be viewed and navigated in demo mode. Do not use real health information in an unconfigured installation. Enable intake only after privacy/consent, HTTPS, security, clinical review, storage/retention and downstream clinical routing have been verified.

The demo importer creates the two NuestraRx seed treatment records as drafts with the compliance-approval requirement enabled. The visible treatment cards use client-supplied demo copy until a published, review-cleared treatment record exists. Approval state is not inferred from a demo import.

== Installation ==

1. Back up WordPress files and database. Test on staging.
2. Install and activate the `weightloss-affordable` theme.
3. Install and activate this single plugin ZIP. Do not separately activate extracted NRX or Experience modules.
4. Install Elementor (free) if you want to edit sections with the visual builder. The WLA theme has a styled front-page fallback without Elementor.
5. In WordPress Admin → WeightLossAffordable → Demo Import, import the sample site. This creates/updates demo pages, Elementor data, editorial images, demo articles and review placeholders. It preserves the WLA homepage and site branding.
6. Review admin notices. Public quiz submissions remain disabled. Product seed records are drafts. Demo prices/claims need verification. No patient transformation content is included.
7. Verify the environment, page links, mobile layout, clinical copy, pharmacy information, current prices, legal disclosures, consent and intake handoff before launch.

== Approval and publication notes ==

This is an installable staging/demo package, not a certification that the site is production-ready. Client-supplied prices, pharmacy statements, medication descriptions and all medical/legal copy require current clinical, pharmacy, compliance and legal verification. Individual eligibility, diagnosis and prescribing decisions belong to licensed clinicians. Never convert demo stories or demo stock video into patient testimonials.

== Testing ==

Workspace checks cover PHP syntax parsing, JavaScript syntax/calculators, JSON validity and archive integrity. No WordPress/Elementor database runtime, clinical staging endpoint or production integration was available; installation and live submissions remain unverified.
