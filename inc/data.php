<?php
/**
 * Single source of truth for all site content.
 * Template parts and the JSON-LD builder both read from here;
 * edit this file to change copy, projects, skills, or experience.
 *
 * Copy rules: no em dashes in visitor-facing text; see .claude/skills/writing-style.
 */

function domdag_profile(): array {
	return [
		'name'        => "Domenick D'Agostino",
		'short_name'  => "Dom D'Agostino",
		'first_name'  => 'Domenick',
		'title'       => 'Senior Front-End Engineer / UI Developer',
		'tagline'     => 'Transforming ideas into interactive experiences.',
		'summary'     => 'Front-end engineer with 8+ years and 25+ client sites built in Vue.js, Laravel, and WordPress for healthcare, education, e-commerce, enterprise, and B2B clients. I turn client requirements into fast, accessible, scalable products, and pair hands-on engineering with an AI-assisted workflow that shortens delivery cycles without sacrificing quality.',
		'location'    => 'Middletown, NJ',
		'location_site' => 'NYC Area',
		'phone'       => '551-265-1425',
		'phone_href'  => '+15512651425',
		'email'       => 'domdag27@gmail.com',
		'linkedin'    => 'https://www.linkedin.com/in/domenickedagostino/',
		'resume'      => 'assets/Domenick-DAgostino-Resume.pdf',
		'photo'       => 'assets/img/me2.webp',
		'photo_alt'   => "Portrait of Domenick D'Agostino",
		'photo_w'     => 800,
		'photo_h'     => 800,
		'meta_desc'   => 'Senior Front-End Engineer & UI Developer with 8+ years building fast, accessible web apps in Vue.js, Laravel, and WordPress for healthcare, education, e-commerce, and B2B.',
		'alumni'      => 'Monmouth University',
		'stats'       => [
			[ 'value' => '8+', 'label' => 'years building for the web' ],
			[ 'value' => '25+', 'label' => 'client sites delivered' ],
			[ 'value' => 'AA', 'label' => 'accessibility and Lighthouse speed, built into every project' ],
		],
	];
}

function domdag_projects(): array {
	return [
		[
			'slug'  => 'frankford-umbrellas',
			'name'  => 'Frankford Umbrellas',
			'role'  => 'Hospitality · Brand flagship site',
			'stack' => [ 'Concrete CMS', 'B2B', 'Hospitality' ],
			'blurb' => 'Flagship site for an American shade maker crafting commercial-grade umbrellas since 1898, serving resorts, hospitality, and homes.',
			'img'   => 'assets/img/projects/frankford_devices_v3.webp',
			'w'     => 1320, 'h' => 947,
			'alt'   => 'Frankford Umbrellas website shown on a desktop monitor and laptop on a desk',
			'url'   => 'https://www.frankfordumbrellas.com/',
		],
		[
			'slug'  => 'shade-designer',
			'name'  => 'Frankford Shade Designer',
			'role'  => 'Sales Enablement · Interactive tool',
			'stack' => [ 'Vue.js', 'Sales Tool' ],
			'blurb' => 'Interactive sales tool the Frankford team uses to show buyers umbrella styles, fabrics, and finishes with a live preview.',
			'img'   => 'assets/img/projects/case_sd_eclipse.webp',
			'w'     => 1600, 'h' => 772,
			'frame' => 'desktop',
			'frame_fit' => 'natural',
			'alt'   => 'Frankford Shade Designer: the Eclipse umbrella in the live 3D configurator',
			'url'   => 'https://sd.frankford.co/',
		],
		[
			'slug'  => 'pdi-healthcare',
			'name'  => 'PDI Healthcare',
			'role'  => 'Healthcare · Enterprise platform',
			'stack' => [ 'Enterprise', 'Healthcare', 'CMS' ],
			'blurb' => 'Enterprise platform for a global leader in infection-prevention products: a large product catalog and resource library built for a regulated industry.',
			'img'   => 'assets/img/projects/pdi.webp',
			'w'     => 1043, 'h' => 824,
			'alt'   => 'PDI Healthcare website product pages on desktop and mobile',
			'url'   => 'https://pdihc.com/',
		],
		[
			'slug'  => 'recasens-usa',
			'name'  => 'Recasens USA',
			'role'  => 'Manufacturing · Brand flagship site',
			'stack' => [ 'Concrete CMS', 'B2B', 'Manufacturing' ],
			'blurb' => 'Flagship site for the US arm of Recasens, a Barcelona fabric maker weaving performance textiles since 1886 for the awning, marine, and decor trades.',
			'img'   => 'assets/img/projects/recasens_devices.webp',
			'w'     => 1320, 'h' => 947,
			'alt'   => 'Recasens USA website shown on a desktop monitor and laptop on a desk',
			'url'   => 'https://recasensusa.com/',
		],
		[
			'slug'  => 'pds-sustainability',
			'name'  => 'Princeton Day School',
			'role'  => 'Education · Data dashboard',
			'stack' => [ 'Dashboard', 'Data Viz', 'Education' ],
			'blurb' => 'Interactive sustainability-impact dashboard that turns the school\'s environmental data into a live, explorable story.',
			'img'   => 'assets/img/projects/pdsv2.webp',
			'w'     => 1600, 'h' => 1065,
			'alt'   => 'Princeton Day School sustainability dashboard with charts and impact metrics',
			'url'   => 'https://sustainabilityimpact.pds.org/',
		],
		[
			'slug'  => 'jersey-college',
			'name'  => 'Jersey College',
			'role'  => 'Education · Multi-campus site',
			'stack' => [ 'Concrete CMS', 'Education' ],
			'blurb' => 'Multi-campus nursing school site serving thousands of prospective students, with program finders, campus pages, and enrollment funnels.',
			'img'   => 'assets/img/projects/jersey_college.webp',
			'w'     => 880, 'h' => 879,
			'alt'   => 'Jersey College School of Nursing homepage on desktop',
			'url'   => 'https://www.jerseycollege.edu/',
		],
		[
			'slug'  => 'frankford',
			'name'  => 'Beach by Frankford',
			'role'  => 'D2C Retail · E-commerce storefront',
			'stack' => [ 'E-Commerce', 'D2C' ],
			'blurb' => 'Direct-to-consumer storefront bringing a 100-year-old resort umbrella maker to individual buyers for the first time.',
			'img'   => 'assets/img/projects/frankfordbeachv2.webp',
			'w'     => 1320, 'h' => 947,
			'alt'   => 'Beach by Frankford e-commerce storefront with beach umbrella products',
			'url'   => 'https://beachbyfrankford.com/',
		],
		[
			'slug'  => 'snap-pak',
			'name'  => 'Snap Pak',
			'role'  => 'B2B Packaging · E-commerce network',
			'stack' => [ 'E-Commerce', 'B2B' ],
			'blurb' => 'Built and managed a network of B2B e-commerce sites for a packaging retailer, driving an 80% overall increase in online sales. The network has since been retired.',
			'img'   => 'assets/img/projects/snap_pak.webp',
			'w'     => 1249, 'h' => 834,
			'alt'   => 'Snap Pak B2B packaging e-commerce website on desktop',
			'url'   => null,
		],
		[
			'slug'  => 'saint-charles',
			'name'  => 'Saint Charles Seminary',
			'role'  => 'Higher Education · Institutional site',
			'stack' => [ 'WordPress', 'Education' ],
			'blurb' => 'Full redesign for a historic Roman Catholic seminary covering admissions, academics, and giving, built on a custom WordPress theme.',
			'img'   => 'assets/img/projects/scs.webp',
			'w'     => 666, 'h' => 834,
			'alt'   => 'Saint Charles Borromeo Seminary website on mobile',
			'url'   => 'https://www.scs.edu/',
		],
		[
			'slug'  => 'mbyc',
			'name'  => 'Mamaroneck Beach & Yacht Club',
			'role'  => 'Hospitality · Members club site',
			'stack' => [ 'Hospitality', 'CMS' ],
			'blurb' => 'Members-first site for a club that has defined "the art of living" since 1885: events, dining, and membership in one place.',
			'img'   => 'assets/img/projects/mbyc.webp',
			'w'     => 659, 'h' => 826,
			'alt'   => 'Mamaroneck Beach and Yacht Club website on mobile',
			'url'   => 'https://www.mamaroneckbeachandyacht.com/',
		],
		[
			'slug'  => 'workmaster',
			'name'  => 'Workmaster',
			'role'  => 'Industrial Supply · B2B e-commerce',
			'stack' => [ 'E-Commerce', 'B2B' ],
			'blurb' => 'Industrial supply storefront with catalog-heavy B2B e-commerce tuned for repeat ordering.',
			'img'   => 'assets/img/projects/workmasterv2.webp',
			'w'     => 1600, 'h' => 1120,
			'alt'   => 'Workmaster industrial supply e-commerce website on desktop',
			'url'   => 'https://www.workmaster.net/',
		],
	];
}

function domdag_education(): array {
	return [
		'degree'  => 'BA in Communications, Minor in IT',
		'school'  => 'Monmouth University',
		'period'  => '2012 - 2016',
		'extra'   => 'Track and Cross Country team',
	];
}

/**
 * Case-study content for /work/{slug}/ pages. Every claim below is
 * Dom-verified (provided 2026-10-06) — add new cases ONLY from facts Dom
 * supplies, never drafted speculatively. A project with an entry here
 * gets a "Case study" link on its deck card automatically.
 */
function domdag_project_case( string $slug ): ?array {
	$cases = [
		'frankford-umbrellas' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'Concrete CMS' ],
				[ 'label' => 'Scope', 'value' => 'Full front-end build' ],
			],
			'brief'     => 'A full redesign of the flagship site for a major, established brand, built to carry a message of luxury, quality, and trust. The design came from an external agency; I was responsible for the entire build, working efficiently with the designer, on a CMS the client\'s own team could run.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the full front end from the agency\'s designs as a library of reusable Concrete CMS components.' ],
				[ 'tag' => 'feat', 'text' => 'Made every component client-friendly to edit: I build the structure, their team fills in the content, no developer needed.' ],
				[ 'tag' => 'refactor', 'text' => 'Kept a large content footprint manageable: reusable components mean new pages assemble instead of being rebuilt by hand.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the client\'s team to use the CMS effectively on their own.' ],
			],
			'challenge' => 'The hardest part was the sheer scale of content. Building reusable components early was the difference between keeping the project moving and rebuilding every page from scratch, and it\'s why the site stays maintainable today.',
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_fu_hero.webp', 'w' => 1600, 'h' => 1000, 'alt' => 'Frankford Umbrellas homepage hero', 'caption' => 'The homepage hero' ],
				[ 'img' => 'assets/img/projects/case_fu_categories.webp', 'w' => 1600, 'h' => 540, 'alt' => 'Shop-by-category component grid: umbrellas, cabanas, beach, accessories', 'caption' => 'Category grid, one reusable component' ],
				[ 'img' => 'assets/img/projects/case_fu_spaces.webp', 'w' => 1600, 'h' => 705, 'alt' => 'Spaces gallery switcher: a garden dining scene with toggle pills that change the photography to match the chosen setting and style', 'caption' => 'Spaces switcher, the scene follows your picks' ],
				[ 'img' => 'assets/img/projects/case_fu_values.webp', 'w' => 1600, 'h' => 637, 'alt' => 'Heritage values section: expandable photo cards under the heading "The values behind 125+ years of service"', 'caption' => 'Heritage gallery, expand-on-tap cards' ],
				[ 'img' => 'assets/img/projects/case_fu_timeline.webp', 'w' => 1600, 'h' => 765, 'alt' => 'Interactive company history timeline at 1898, with a vintage photograph of the first umbrella repair shop', 'caption' => 'History timeline, 1898 to today' ],
				[ 'img' => 'assets/img/projects/case_fu_catalog.webp', 'w' => 1600, 'h' => 875, 'alt' => 'Catalog launch band with cabana photography', 'caption' => 'Catalog launch band, editor-assembled' ],
				[ 'img' => 'assets/img/projects/frankford_beach_page.webp', 'w' => 1600, 'h' => 1325, 'alt' => 'All Beach collection page', 'caption' => 'The All Beach collection' ],
			],
			'results'   => [
				[ 'value' => 'Flagship', 'label' => 'the public face of an established brand' ],
				[ 'value' => 'Self-serve', 'label' => 'the client team publishes without a developer' ],
				[ 'value' => 'Reusable', 'label' => 'one component library behind every page' ],
			],
		],
		'pdi-healthcare' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'WordPress' ],
				[ 'label' => 'Scope', 'value' => 'Full front-end build' ],
			],
			'brief'     => 'An enterprise platform for PDI, a global leader in infection-prevention products. The site carries a large product catalog and clinical resource library for a regulated industry, and it follows the same playbook as my flagship builds: a full front-end build on a CMS the client\'s own team can run.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the full front end as a library of reusable WordPress components.' ],
				[ 'tag' => 'feat', 'text' => 'Made every component client-friendly to edit: products, resources, and campaigns update without a developer.' ],
				[ 'tag' => 'refactor', 'text' => 'Kept an enterprise-scale catalog and resource library manageable with components that assemble pages instead of rebuilding them.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the client\'s team to run the CMS effectively on their own.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_pdi_hero2.webp', 'w' => 1600, 'h' => 909, 'alt' => 'PDI Healthcare homepage with product and program highlights', 'caption' => 'The homepage' ],
				[ 'img' => 'assets/img/projects/case_pdi_layered.webp', 'w' => 1600, 'h' => 1073, 'alt' => 'The Our Layered Approach section: an isometric stack of five layers, each tied to an infection-prevention practice', 'caption' => 'The layered-approach diagram' ],
				[ 'img' => 'assets/img/projects/case_pdi_products.webp', 'w' => 1600, 'h' => 901, 'alt' => 'PDI product catalog page', 'caption' => 'The product catalog' ],
				[ 'img' => 'assets/img/projects/case_pdi_serve.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Who we serve: infection preventionists audience page', 'caption' => 'Audience pages: who we serve' ],
			],
			'results'   => [
				[ 'value' => 'Enterprise', 'label' => 'platform for a global infection-prevention leader' ],
				[ 'value' => 'Self-serve', 'label' => 'the client team publishes without a developer' ],
				[ 'value' => 'Reusable', 'label' => 'one component library across catalog and resources' ],
			],
		],
		'recasens-usa' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'Concrete CMS' ],
				[ 'label' => 'Scope', 'value' => 'Full front-end build' ],
			],
			'brief'     => 'A full build of the flagship US site for Recasens, a Barcelona fabric maker weaving performance textiles since 1886. Same playbook as the Frankford flagship: the design came from an external agency, I was responsible for the entire front end, and the site had to serve three trades at once, solar and shade, marine, and decor, on a CMS the client\'s own team could run.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the complete front end from the agency\'s designs as a library of reusable Concrete CMS components.' ],
				[ 'tag' => 'feat', 'text' => 'Structured every component for client editing: their team updates fabrics, collections, and news without a developer.' ],
				[ 'tag' => 'refactor', 'text' => 'One component library serves all three trade sections, so the solar, marine, and decor pages assemble from the same building blocks.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the client\'s team to run the CMS effectively on their own.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_reca_hero.webp', 'w' => 1600, 'h' => 901, 'alt' => 'Recasens USA homepage hero', 'caption' => 'The homepage hero' ],
				[ 'img' => 'assets/img/projects/case_reca_fabrics.webp', 'w' => 1600, 'h' => 973, 'alt' => 'Fabrics landing page with fabric search and where-to-buy entries', 'caption' => 'The fabrics hub' ],
				[ 'img' => 'assets/img/projects/case_reca_search.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Fabric search with type, color, and design filters over a grid of swatches', 'caption' => 'Fabric search, 377 fabrics filtered live' ],
				[ 'img' => 'assets/img/projects/case_reca_detail.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Fabric detail page for Recacril R-122 Seashell with a woven texture band and swatch render', 'caption' => 'Fabric detail: R-122 Seashell' ],
				[ 'img' => 'assets/img/projects/case_reca_overview.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Our Company page with archival photography of the Barcelona looms', 'caption' => 'The company story, weaving since 1886' ],
			],
			'results'   => [
				[ 'value' => 'Flagship', 'label' => 'the US face of a Barcelona original' ],
				[ 'value' => 'Self-serve', 'label' => 'the client team publishes without a developer' ],
				[ 'value' => 'Reusable', 'label' => 'one component library across three trades' ],
			],
		],
		'shade-designer' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Stack', 'value' => 'Vue + 3D configurator' ],
				[ 'label' => 'Scope', 'value' => 'Front-end build' ],
			],
			'brief'     => 'Frankford\'s sales team needed a tool to use right on the floor: a way to demonstrate the different umbrella models to a buyer standing in front of them. The answer was an interactive 3D configurator. I built the interface it all lives in, working alongside the designers, the 3D team, the backend team, and the client.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the front end in Vue: the configurator interface, model and option selection, and the data layer behind them.' ],
				[ 'tag' => 'feat', 'text' => 'Worked with the 3D team to integrate their model viewer into the interface, so reps can show each umbrella live as it\'s configured.' ],
				[ 'tag' => 'perf', 'text' => 'Worked with a large product dataset from the database and shaped it into options a salesperson can browse quickly.' ],
				[ 'tag' => 'merge', 'text' => 'Coordinated the front end across the designers, the 3D team, backend, and the client. A project with a lot of moving parts, and a full team effort.' ],
			],
			'challenge' => 'The hardest part was tying all the different areas of the project together. I\'m not a 3D model expert, and this build taught me a lot about getting 3D, product data, and UI to come together as one tool.',
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_sd_eclipse.webp', 'w' => 1600, 'h' => 772, 'alt' => 'The Eclipse umbrella in the live 3D configurator, canopy step', 'caption' => 'The Eclipse, live in 3D' ],
				[ 'img' => 'assets/img/projects/case_sd_collections.webp', 'w' => 1600, 'h' => 1000, 'alt' => 'Umbrella collections menu with rendered models', 'caption' => 'Collections menu, every model rendered' ],
				[ 'img' => 'assets/img/projects/case_sd_valance.webp', 'w' => 1065, 'h' => 688, 'alt' => 'The Greenwich in the canopy step, choosing between valance styles: standard, whale tail, classic scallop, French', 'caption' => 'Down to the valance: every option rendered live' ],
				[ 'img' => 'assets/img/projects/case_sd_giant.webp', 'w' => 1600, 'h' => 836, 'alt' => 'The Giant collection: Nova, Giant Greenwich, and Giant Monterey rendered side by side', 'caption' => 'The Giant collection, rendered' ],
			],
			'results'   => [
				[ 'value' => 'Daily', 'label' => 'used by the sales team to sell umbrellas' ],
				[ 'value' => '3D', 'label' => 'live model configurator on the sales floor' ],
				[ 'value' => 'Team', 'label' => 'designers, 3D, backend, client, and my front end' ],
			],
		],
		'jersey-college' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'Concrete CMS' ],
				[ 'label' => 'Scope', 'value' => 'Full front-end build' ],
			],
			'brief'     => 'A multi-campus nursing school serving students across the country, with program finders, campus pages, and enrollment funnels. Same playbook as my flagship builds: a full front-end build on a CMS the school\'s own team can run.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the full front end as a library of reusable Concrete CMS components.' ],
				[ 'tag' => 'feat', 'text' => 'Made every component client-friendly to edit: programs, campuses, and admissions content update without a developer.' ],
				[ 'tag' => 'refactor', 'text' => 'Nineteen campuses across seven states render from one component set, so a new campus is a content entry, not a build project.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the school\'s team to run the CMS effectively on their own.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_jc_finder.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Program finder: state cards with campus and program selectors, daytime and evening toggles, beside the campus index', 'caption' => 'The program finder, every state and schedule' ],
				[ 'img' => 'assets/img/projects/case_jc_maps.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Find a campus near you: state map cards with campus markers for New Jersey, Florida, Indiana, and more', 'caption' => 'Campus finder, drawn state by state' ],
				[ 'img' => 'assets/img/projects/case_jc_tracks.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Three program tracks, RN, LPN to RN bridge, and LPN, with student testimonials beneath', 'caption' => 'Program tracks and student voices' ],
				[ 'img' => 'assets/img/projects/case_jc_campusdetail.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Tampa campus page: connected classrooms, skills lab, and learning centers with the campus map', 'caption' => 'Campus detail: labs, classrooms, map' ],
			],
			'results'   => [
				[ 'value' => '19', 'label' => 'campuses in seven states, one component system' ],
				[ 'value' => 'Self-serve', 'label' => 'the school\'s team publishes without a developer' ],
				[ 'value' => 'Reusable', 'label' => 'one component library behind every campus and program' ],
			],
		],
		'frankford' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'Shopify' ],
				[ 'label' => 'Scope', 'value' => 'Full build' ],
			],
			'brief'     => 'Frankford\'s umbrellas had served resorts and concessionaires for a century; Beach by Frankford brought them to individual buyers for the first time. A full Shopify build, working directly with our in-house designers.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the full Shopify storefront, the brand\'s first direct-to-consumer channel.' ],
				[ 'tag' => 'ui', 'text' => 'Worked directly with our in-house designers to bring the Beach brand to the screen.' ],
				[ 'tag' => 'feat', 'text' => 'The complete buying flow: collections, fabric choices on each product, and cart to checkout.' ],
				[ 'tag' => 'launch', 'text' => 'Took a hundred-year-old B2B maker direct to consumers.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_bb_hero.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Beach by Frankford homepage: Own the Beach hero with colorful loungers', 'caption' => 'The homepage' ],
				[ 'img' => 'assets/img/projects/case_bb_collection.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Product collection page with beach umbrellas and lounge chairs', 'caption' => 'The collection' ],
				[ 'img' => 'assets/img/projects/case_bb_product.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Product page for The Classic Frankford with fabric swatch choices', 'caption' => 'Product page, fabric picker included' ],
				[ 'img' => 'assets/img/projects/case_bb_about.webp', 'w' => 1600, 'h' => 836, 'alt' => 'About page: a striped umbrella and loungers on white sand', 'caption' => 'The brand story' ],
			],
			'results'   => [
				[ 'value' => 'D2C', 'label' => 'the brand\'s first direct-to-consumer storefront' ],
				[ 'value' => 'Shopify', 'label' => 'full storefront build, collections to checkout' ],
				[ 'value' => 'In-house', 'label' => 'designed and built side by side with our team' ],
			],
		],
		'saint-charles' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'UI Developer, MCG Strategic' ],
				[ 'label' => 'Platform', 'value' => 'WordPress' ],
				[ 'label' => 'Scope', 'value' => 'Full build' ],
			],
			'brief'     => 'A full redesign for a historic Roman Catholic seminary, covering admissions, formation programs, academics, and giving. A full custom WordPress build, handed to a team that runs it themselves.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the full custom WordPress theme for the seminary\'s redesign.' ],
				[ 'tag' => 'feat', 'text' => 'Made every section editable: admissions, formation, academics, and giving all update without a developer.' ],
				[ 'tag' => 'refactor', 'text' => 'One component set serves the seminary\'s many programs and pages.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the seminary\'s team to run the CMS effectively on their own.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_scs_programs.webp', 'w' => 1600, 'h' => 836, 'alt' => 'The three formation schools presented as cards, above the Stay Connected community section', 'caption' => 'Three schools of formation' ],
				[ 'img' => 'assets/img/projects/case_scs_community.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Upcoming events, newsletter signup, and a watercolor illustration of the seminary campus', 'caption' => 'Events and the illustrated campus' ],
				[ 'img' => 'assets/img/projects/case_scs_campus.webp', 'w' => 1600, 'h' => 836, 'alt' => 'The seminary building across the full width of the screen', 'caption' => 'The campus, full bleed' ],
				[ 'img' => 'assets/img/projects/case_scs_priestly.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Priestly Formation page with the four formation stages', 'caption' => 'Priestly formation, four stages' ],
			],
			'results'   => [
				[ 'value' => 'WordPress', 'label' => 'custom theme, built from scratch' ],
				[ 'value' => 'Self-serve', 'label' => 'the seminary\'s team publishes without a developer' ],
				[ 'value' => 'Trained', 'label' => 'handed over with the team ready to run it' ],
			],
		],
		'mbyc' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'Designer and developer' ],
				[ 'label' => 'Client', 'value' => 'Private members club' ],
				[ 'label' => 'Scope', 'value' => 'Rebrand: full design and build' ],
			],
			'brief'     => 'A rebranding effort for a club that has defined "the art of living" since 1885. I worked directly with the club\'s owner and handled both sides myself: the full design and the full build.',
			'build'     => [
				[ 'tag' => 'design', 'text' => 'Designed the site end to end as part of the club\'s rebrand, one on one with the owner.' ],
				[ 'tag' => 'init', 'text' => 'Built what I designed: a members-first site covering beach, yacht, tennis, dining, and events.' ],
				[ 'tag' => 'feat', 'text' => 'Full-screen imagery leads; the club\'s waterfront does the selling.' ],
				[ 'tag' => 'merge', 'text' => 'One stakeholder, direct line: every decision made with the owner, no telephone game.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_mbyc_yacht.webp', 'w' => 1600, 'h' => 836, 'alt' => 'The marina at sunset under the club monogram', 'caption' => 'The marina at sunset' ],
				[ 'img' => 'assets/img/projects/case_mbyc_relax.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Beach page editorial section: RELAX ghost heading, monogrammed towel photography, and a patterned quote band', 'caption' => 'Editorial sections with ghost headings' ],
				[ 'img' => 'assets/img/projects/case_mbyc_boating.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Yacht page: quote band, BOATING section, and a classic wooden boat', 'caption' => 'Boating, quote bands and all' ],
				[ 'img' => 'assets/img/projects/case_mbyc_perfection.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Events page: PERFECTION section with a floral wedding arbor on the water', 'caption' => 'Weddings: the PERFECTION section' ],
			],
			'results'   => [
				[ 'value' => 'Design + build', 'label' => 'both sides of the project, one pair of hands' ],
				[ 'value' => '1885', 'label' => 'a heritage brand carried into the rebrand' ],
				[ 'value' => 'Direct', 'label' => 'built one on one with the club\'s owner' ],
			],
		],
		'workmaster' => [
			'facts'     => [
				[ 'label' => 'Role', 'value' => 'Front-end developer' ],
				[ 'label' => 'Focus', 'value' => 'Catalog-heavy B2B e-commerce' ],
				[ 'label' => 'Scope', 'value' => 'Front-end build + CMS training' ],
			],
			'brief'     => 'An industrial supply storefront for bulk-solids handling equipment, where the product data is the product: specs, parts, and accessories across the catalog. I built the front end, working with the backend developers to connect all of the product and part specs, then trained the team on the CMS.',
			'build'     => [
				[ 'tag' => 'init', 'text' => 'Built the storefront\'s full front end.' ],
				[ 'tag' => 'merge', 'text' => 'Worked with the backend developers to wire every product and part spec into the templates.' ],
				[ 'tag' => 'feat', 'text' => 'Spec-heavy product pages tuned for repeat B2B ordering.' ],
				[ 'tag' => 'docs', 'text' => 'Trained the client\'s team to run the CMS on their own.' ],
			],
			'gallery'   => [
				[ 'img' => 'assets/img/projects/case_wm_hero.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Workmaster homepage: We Find A Way Or Make One, over railcar imagery', 'caption' => 'The homepage' ],
				[ 'img' => 'assets/img/projects/case_wm_products.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Products page with equipment categories from railcar gate openers to vacuum mount vibrators', 'caption' => 'The product catalog' ],
				[ 'img' => 'assets/img/projects/case_wm_category.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Railcar gate openers category page', 'caption' => 'Category: railcar gate openers' ],
				[ 'img' => 'assets/img/projects/case_wm_specs.webp', 'w' => 1600, 'h' => 836, 'alt' => 'Pneumatic gate openers list with working torque, RPM, and CFM spec filters on every product', 'caption' => 'Spec filters: the backend data, live in the front end' ],
			],
			'results'   => [
				[ 'value' => 'Integrated', 'label' => 'front end wired to backend product and part data' ],
				[ 'value' => 'B2B', 'label' => 'catalog built for repeat ordering' ],
				[ 'value' => 'Trained', 'label' => 'the client\'s team runs the CMS' ],
			],
		],
	];
	return $cases[ $slug ] ?? null;
}

/**
 * Skills as icon tiles. 'icon' names an SVG in assets/icons/ (inlined with
 * currentColor); 'badge' renders a two-letter monogram tile instead (used
 * where no brand icon is available). 'desc' is a plain-English explanation
 * shown when a visitor clicks the tile — written for non-technical readers.
 */
function domdag_skills(): array {
	return [
		'Languages & Frameworks' => [
			[ 'label' => 'Vue.js', 'icon' => 'vuedotjs', 'desc' => 'A framework for building interactive web apps. It powers the dynamic parts of a site, like dashboards, filters, and anything that updates on screen without reloading the page.' ],
			[ 'label' => 'TypeScript', 'icon' => 'typescript', 'desc' => 'A stricter version of JavaScript that catches mistakes while the code is being written, so fewer bugs ever reach the live site.' ],
			[ 'label' => 'JavaScript', 'icon' => 'javascript', 'desc' => 'The language that makes websites interactive. Menus, animations, forms, anything that responds when you click: that\'s JavaScript.' ],
			[ 'label' => 'Laravel', 'icon' => 'laravel', 'desc' => 'A toolkit for the behind-the-scenes side of a website: logins, databases, forms, and the logic that makes an app actually work.' ],
			[ 'label' => 'PHP', 'icon' => 'php', 'desc' => 'The language running behind most of the web, including WordPress. It builds each page on the server before it reaches your browser.' ],
			[ 'label' => 'Node.js', 'icon' => 'nodedotjs', 'desc' => 'Lets JavaScript run on the server instead of just in the browser. I use it with Express to build APIs and real-time features.' ],
			[ 'label' => 'Tailwind CSS', 'icon' => 'tailwindcss', 'desc' => 'A styling system for designing sites quickly and consistently, so every page looks like it belongs to the same brand.' ],
		],
		'CMS & E-Commerce' => [
			[ 'label' => 'WordPress', 'icon' => 'wordpress', 'desc' => 'The world\'s most popular website platform. I build fully custom themes on it, so clients get a one-of-a-kind site they can update themselves.' ],
			[ 'label' => 'Shopify', 'icon' => 'shopify', 'desc' => 'A platform for online stores: products, carts, and checkout, with a storefront designed to turn visitors into buyers.' ],
			[ 'label' => 'Concrete CMS', 'badge' => 'C5', 'desc' => 'A content management system used by schools and businesses. Editors can click right on a page and change it in place.' ],
		],
		'Accessibility & Performance' => [
			[ 'label' => 'Accessibility', 'badge' => 'AA', 'desc' => 'Sites built so everyone can use them, including people who rely on keyboards or screen readers. I build to WCAG guidelines: readable contrast, clear focus states, and motion that respects user settings. It\'s also the standard behind ADA compliance.' ],
			[ 'label' => 'Web Performance', 'icon' => 'lighthouse', 'desc' => 'Speed is a feature. I build to Lighthouse performance budgets with lean code and optimized images, because fast pages keep visitors around and rank better in search.' ],
		],
		'AI-Assisted Development' => [
			[ 'label' => 'Claude Code', 'icon' => 'claude', 'desc' => 'An AI programming assistant from Anthropic. I use it daily to build, review, and improve code faster.' ],
		],
		'Databases' => [
			[ 'label' => 'MongoDB', 'icon' => 'mongodb', 'desc' => 'A database that stores an app\'s information in a flexible way, which suits fast-moving projects.' ],
			[ 'label' => 'MySQL', 'icon' => 'mysql', 'desc' => 'The classic language for databases: storing, finding, and connecting all the data behind a site, from products to user accounts.' ],
		],
		'Design' => [
			[ 'label' => 'Figma', 'icon' => 'figma', 'desc' => 'A design tool where page layouts are drawn and shared before any code is written. I both read designs from it and create them in it.' ],
			[ 'label' => 'Adobe XD', 'badge' => 'Xd', 'desc' => 'Adobe\'s tool for designing website mockups and clickable prototypes, so clients can preview a site before it\'s built.' ],
			[ 'label' => 'Photoshop', 'badge' => 'Ps', 'desc' => 'The standard tool for editing images: cutting out photos, polishing graphics, and preparing visuals so they load fast on the web.' ],
		],
		'Tools & Platforms' => [
			[ 'label' => 'Git', 'icon' => 'git', 'desc' => 'A system that tracks every change ever made to a project\'s code. Nothing gets lost, and whole teams can build together safely.' ],
			[ 'label' => 'Bitbucket', 'icon' => 'bitbucket', 'desc' => 'An online home for code, where projects are stored, reviewed, and released from.' ],
			[ 'label' => 'Jira', 'icon' => 'jira', 'desc' => 'A project tracker teams use to organize tasks, bugs, and deadlines, so everyone knows what\'s being worked on.' ],
		],
	];
}

function domdag_experience(): array {
	return [
		[
			'role'    => 'UI Developer',
			'company' => 'MCG Strategic',
			'where'   => 'Marlton, NJ (Remote)',
			'period'  => '2022 - Present',
			'bullets' => [
				'Built 15+ client platforms across healthcare, education, and enterprise, architecting custom web applications in Vue.js, Laravel, WordPress, and Node.js.',
				'Improve site performance, SEO rankings, and accessibility compliance across client engagements.',
				'Create reusable UI components and front-end systems shared across client builds.',
				'Stay on top of new AI tools and practices, bringing Claude-assisted programming into daily development work for feature building, refactoring, and code review.',
			],
		],
		[
			'role'    => 'Senior Front-End Developer',
			'company' => 'Snap Pak',
			'where'   => 'Hackensack, NJ',
			'period'  => '2020 - 2022',
			'bullets' => [
				'Drove an 80% overall increase in online sales by building and managing a network of B2B e-commerce websites for a packaging retailer.',
				'Partnered with marketing to design sites that were not just polished but high-converting, turning traffic into B2B orders.',
				'Ran targeted digital ad campaigns to attract new B2B buyers.',
			],
		],
		[
			'role'    => 'Senior Front-End Developer',
			'company' => 'Two Words Digital Agency',
			'where'   => 'Fort Lee, NJ',
			'period'  => '2018 - 2020',
			'bullets' => [
				'Joined as a junior developer and was promoted to senior, going on to manage client relationships and mentor junior developers.',
				'Led end-to-end design and build of high-performance, high-traffic websites.',
				'Delivered showcase presentation sites demonstrating high-scale architecture that helped close major client deals.',
			],
		],
	];
}
