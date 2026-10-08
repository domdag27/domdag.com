<?php
/**
 * Vite manifest reader + front-end asset enqueue.
 * Build with `npm run build` inside the theme directory.
 */

function domdag_vite_entry(): ?array {
	static $entry = null;
	if ( $entry !== null ) {
		return $entry ?: null;
	}
	$manifest_path = get_theme_file_path( 'dist/.vite/manifest.json' );
	if ( ! is_readable( $manifest_path ) ) {
		$entry = false;
		return null;
	}
	$manifest = json_decode( (string) file_get_contents( $manifest_path ), true );
	$entry    = $manifest['src/js/main.js'] ?? false;
	return $entry ?: null;
}

add_action( 'wp_enqueue_scripts', function () {
	$entry = domdag_vite_entry();
	if ( ! $entry ) {
		add_action( 'wp_head', function () {
			echo "\n<!-- domdag: dist/.vite/manifest.json missing — run `npm run build` in the theme directory -->\n";
		} );
		return;
	}

	$dist = get_theme_file_path( 'dist' );

	// The stylesheet is inlined into <head> instead of enqueued: it is the
	// only render-blocking request on the page, and dropping it saves a
	// full round trip before first paint on throttled mobile (the whole
	// file is ~10KB over the wire, well under the inline-budget rule of
	// thumb). If the CSS ever grows past ~20KB gzipped, revert to the
	// enqueue so it can be cached across views.
	$inline_css = '';
	foreach ( $entry['css'] ?? [] as $css ) {
		if ( is_readable( "$dist/$css" ) ) {
			$inline_css .= file_get_contents( "$dist/$css" );
		}
	}
	if ( $inline_css !== '' ) {
		add_action( 'wp_head', function () use ( $inline_css ) {
			echo '<style id="domdag-css">' . $inline_css . '</style>' . "\n"; // phpcs:ignore -- built asset, not user input.
		}, 3 );
	} else {
		foreach ( $entry['css'] ?? [] as $i => $css ) {
			wp_enqueue_style( 'domdag' . ( $i ? "-$i" : '' ), get_theme_file_uri( "dist/$css" ), [], (string) filemtime( "$dist/$css" ) );
		}
	}

	wp_enqueue_script( 'domdag', get_theme_file_uri( "dist/{$entry['file']}" ), [], (string) filemtime( "$dist/{$entry['file']}" ), [ 'strategy' => 'defer', 'in_footer' => true ] );
} );

/** Preload the self-hosted fonts (both are used above the fold).
 *  Vite fingerprints them into dist/assets/, so preload the built files
 *  the stylesheet actually references. */
add_action( 'wp_head', function () {
	$entry = domdag_vite_entry();
	foreach ( $entry['assets'] ?? [] as $asset ) {
		if ( str_ends_with( $asset, '.woff2' ) ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( get_theme_file_uri( "dist/$asset" ) )
			);
		}
	}
}, 2 );
