<?php
/**
 * SEO: document title, meta description, canonical, Open Graph / Twitter,
 * and JSON-LD built from the same data file the page renders from.
 *
 * NOTE: all URLs derive from home_url() / get_theme_file_uri() — never
 * hardcode a domain here. When the site moves from the temp domain to
 * domdag.com, everything follows automatically.
 */

add_filter( 'document_title_parts', function ( array $parts ): array {
	$p = domdag_profile();
	if ( $proj_slug = get_query_var( 'domdag_project' ) ) {
		foreach ( domdag_projects() as $proj ) {
			if ( $proj['slug'] === $proj_slug ) {
				return [ 'title' => $proj['name'] . ' - Case Study - ' . $p['name'] ];
			}
		}
	}
	if ( is_front_page() ) {
		$parts = [ 'title' => $p['name'] . ' - ' . $p['title'] ];
	}
	return $parts;
} );

add_filter( 'document_title_separator', fn() => '-' );

add_action( 'wp_head', function () {
	$p   = domdag_profile();
	$url = home_url( '/' );
	if ( $proj_slug = get_query_var( 'domdag_project' ) ) {
		$url = home_url( '/work/' . $proj_slug . '/' );
	}
	$og = get_theme_file_uri( 'assets/img/og.png' );

	echo '<meta name="description" content="' . esc_attr( $p['meta_desc'] ) . '">' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

	// Open Graph.
	echo '<meta property="og:type" content="profile">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $p['name'] . ' - ' . $p['title'] ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $p['meta_desc'] ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og ) . '">' . "\n";
	echo '<meta property="og:image:width" content="1200">' . "\n";
	echo '<meta property="og:image:height" content="630">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $p['name'] ) . '">' . "\n";

	// Twitter.
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $p['name'] . ' - ' . $p['title'] ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $p['meta_desc'] ) . '">' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $og ) . '">' . "\n";

	echo '<meta name="theme-color" content="#0b0d10">' . "\n";
	// Outbound clicks must not identify this site: strip the Referer header.
	echo '<meta name="referrer" content="no-referrer">' . "\n";

	// "Dd" favicon from the old site: dark mark on light-scheme browsers,
	// white mark on dark-scheme ones.
	echo '<link rel="icon" type="image/png" href="' . esc_url( get_theme_file_uri( 'assets/img/dd_dark.png' ) ) . '" media="(prefers-color-scheme: light)">' . "\n";
	echo '<link rel="icon" type="image/png" href="' . esc_url( get_theme_file_uri( 'assets/img/dd_white.png' ) ) . '" media="(prefers-color-scheme: dark)">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( get_theme_file_uri( 'assets/img/dd_dark.png' ) ) . '">' . "\n";
}, 1 );

add_action( 'wp_head', function () {
	$p      = domdag_profile();
	$skills = [];
	foreach ( domdag_skills() as $items ) {
		foreach ( $items as $item ) {
			$skills[] = $item['label'];
		}
	}

	$graph = [
		'@context' => 'https://schema.org',
		'@graph'   => [
			[
				'@type'       => 'Person',
				'@id'         => home_url( '/#person' ),
				'name'        => $p['name'],
				'jobTitle'    => $p['title'],
				'description' => $p['meta_desc'],
				'url'         => home_url( '/' ),
				'image'       => get_theme_file_uri( $p['photo'] ),
				'email'       => 'mailto:' . $p['email'],
				'telephone'   => $p['phone'],
				'sameAs'      => [ $p['linkedin'] ],
				'knowsAbout'  => array_values( $skills ),
				'alumniOf'    => [
					'@type' => 'CollegeOrUniversity',
					'name'  => $p['alumni'],
				],
				'worksFor'    => [
					'@type' => 'Organization',
					'name'  => 'MCG Strategic',
				],
				'address'     => [
					'@type'           => 'PostalAddress',
					'addressLocality' => 'Middletown',
					'addressRegion'   => 'NJ',
				],
			],
			[
				'@type'     => 'WebSite',
				'@id'       => home_url( '/#website' ),
				'url'       => home_url( '/' ),
				'name'      => $p['name'],
				'publisher' => [ '@id' => home_url( '/#person' ) ],
			],
		],
	];

	echo '<script type="application/ld+json">' . wp_json_encode( $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}, 3 );
