<?php
/**
 * domdag theme bootstrap.
 */

require get_theme_file_path( 'inc/data.php' );
require get_theme_file_path( 'inc/assets.php' );
require get_theme_file_path( 'inc/seo.php' );
require get_theme_file_path( 'inc/contact.php' );

/* ---- Case-study routes: /work/{slug}/ → project.php ----
   Only slugs with a domdag_project_case() entry resolve; everything
   else 302s to /#work so no thin placeholder pages can be found. */

add_action( 'init', function () {
	add_rewrite_rule( '^work/([^/]+)/?$', 'index.php?domdag_project=$matches[1]', 'top' );
} );

add_filter( 'query_vars', function ( array $vars ): array {
	$vars[] = 'domdag_project';
	return $vars;
} );

add_filter( 'template_include', function ( string $template ): string {
	$slug = get_query_var( 'domdag_project' );
	if ( $slug ) {
		if ( ! domdag_project_case( $slug ) ) {
			wp_safe_redirect( home_url( '/#work' ), 302 );
			exit;
		}
		global $wp_query;
		$wp_query->is_404 = false;
		status_header( 200 );
		return get_theme_file_path( 'project.php' );
	}
	return $template;
} );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'responsive-embeds' );
} );

/* ---- Strip front-end weight this fully custom theme doesn't use ---- */

// Emoji detection script + styles.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

// Generator tag, RSD/manifest links, oEmbed discovery, shortlink.
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rel_canonical' ); // inc/seo.php emits the canonical.

// Block-editor CSS and front-end jQuery — nothing in the theme uses them.
add_action( 'wp_enqueue_scripts', function () {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
	}
}, 20 );
