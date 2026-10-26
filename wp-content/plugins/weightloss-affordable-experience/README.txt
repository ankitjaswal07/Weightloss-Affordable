=== WeightLossAffordable Experience ===
Contributors: weightlossaffordable
Requires at least: 6.6
Requires PHP: 7.4
License: GPL-2.0-or-later

Adds editable WeightLossAffordable homepage/page components without replacing the active theme or duplicating product records.

INSTALL
1. Back up the site and install this plugin on staging first.
2. Keep the WeightLossAffordable theme and WeightLossAffordable Core plugin active.
3. Upload/activate this plugin from Plugins > Add New > Upload Plugin. Elementor is optional for shortcodes; Elementor (free) adds the Experience Section widget.
4. In Elementor, add the Experience Section widget from the WeightLossAffordable Experience category. Choose Treatment Plans, Get a Quote, Results, Video Testimonials, or Calculators. Edit the heading and supporting text there.
5. For Get a Quote, either select the verified NuestraRx quiz embed (requires NuestraRx Core active and its published quiz configuration) or set the exact approved secure-intake URL. Do not use a staging/test or unverified destination.
6. Test the complete quote submission on staging and verify downstream delivery before launch.

PRODUCTS
When NuestraRx Core is active, treatment cards read the published nrx_treatment records through its own treatment adapter, including its selected internal/WooCommerce pricing source. Hidden compliance-pending records are not shown. Without NuestraRx Core, published WLA Treatment records are shown without invented pricing. This plugin does not create or migrate product records.

QUIZ
The optional embed renders the original [nrx_quiz] output and uses NuestraRx Core's own published configuration, branching, validation, nonce, submission endpoint and integrations. A compatibility loader makes the original quiz assets work on the WeightLossAffordable theme without activating the NuestraRx theme. The NRX admin quiz editor remains the management UI. If NuestraRx Core is absent, no sample quiz is substituted.

RESULTS AND VIDEOS
Results use only published records in the existing WLA Reviews content type. Add only approved, substantiated stories and imagery; no result records are seeded. Video Testimonials is a private WordPress content type. Add a title, short description, featured poster image, approved video URL, and (for direct video files) an optional WebVTT captions track. Use only authorized media. YouTube/Vimeo players load only after a visitor activates Play; enable any available captions at the provider. Direct MP4/WebM files use native controls and can include captions.

CALCULATORS
BMI uses kg/m² or the US customary 703 formula and reports only a numeric screening calculation. Weight change reports absolute weight difference and percentage change from a positive starting weight. The calculations run in the visitor's browser and do not submit inputs. They are mathematical tools, not medical advice or predicted outcomes.

SHORTCODES
[wla_treatment_plans]
[wla_get_quote url="https://example.test/verified-intake/" mode="cta"]
[wla_get_quote mode="quiz"]
[wla_results]
[wla_video_testimonials]
[wla_calculators]
Use a real approved intake URL; example.test is documentation only.

TESTING
Run: node --test tests/calculators.test.js
WordPress admin, Elementor rendering, NRX plugin integration, quiz submissions, checkout, accessibility and responsive behavior still require staging-site verification with the actual WordPress install and approved integration configuration.
