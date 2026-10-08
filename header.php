<?php
$profile = domdag_profile();
// Anchor links must resolve from subpages (project case studies) too;
// on the front page they stay bare so the smooth-scroll handler owns them.
$nav_base = is_front_page() ? '' : home_url( '/' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.classList.add('js');</script>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-bg text-ink font-sans antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">Skip to content</a>

<div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

<header class="fixed inset-x-0 top-0 z-50">
	<div class="dock-wrap">
		<div class="dock">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 rounded-md py-1 pl-1.5 pr-3 focus-ring">
				<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/dd_white.png' ) ); ?>" alt="" width="30" height="30" class="h-[30px] w-[30px]">
				<span class="hidden font-display text-sm font-semibold tracking-wide sm:block"><?php echo esc_html( $profile['short_name'] ); ?></span>
			</a>

			<nav aria-label="Primary" data-nav-spy class="relative hidden md:block">
				<span class="nav-ind" data-nav-ind aria-hidden="true"></span>
				<ul class="relative z-10 flex items-center" role="list">
					<li><a class="nav-link" href="<?php echo esc_url( $nav_base ); ?>#work">Work</a></li>
					<li><a class="nav-link" href="<?php echo esc_url( $nav_base ); ?>#about">About</a></li>
					<li><a class="nav-link" href="<?php echo esc_url( $nav_base ); ?>#experience">Experience</a></li>
					<li><a class="nav-link" href="<?php echo esc_url( $nav_base ); ?>#contact">Contact</a></li>
				</ul>
			</nav>

			<a class="btn-accent ml-2 hidden min-h-0 px-4 py-2 text-xs md:inline-flex" href="<?php echo esc_url( $nav_base ); ?>#contact">
				<span class="btn-roll" data-text="Hire me"><span>Hire me</span></span>
			</a>

			<button type="button" class="menu-toggle inline-flex h-11 w-11 items-center justify-center rounded-md md:hidden focus-ring" aria-expanded="false" aria-controls="mobile-menu">
				<span class="sr-only">Menu</span>
				<svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none"><path class="menu-icon-open" d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path class="menu-icon-close hidden" d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</button>
		</div>
	</div>

	<div id="mobile-menu" hidden class="mx-3 mt-2 rounded-2xl border border-edge bg-bg/95 p-2 shadow-2xl backdrop-blur-xl sm:mx-4 md:hidden">
		<nav aria-label="Primary mobile" class="flex flex-col gap-1">
			<a class="nav-link-mobile" href="<?php echo esc_url( $nav_base ); ?>#work">Work</a>
			<a class="nav-link-mobile" href="<?php echo esc_url( $nav_base ); ?>#about">About</a>
			<a class="nav-link-mobile" href="<?php echo esc_url( $nav_base ); ?>#experience">Experience</a>
			<a class="nav-link-mobile" href="<?php echo esc_url( $nav_base ); ?>#contact">Contact</a>
			<a class="btn-accent mx-3 mb-2 mt-2 self-start" href="<?php echo esc_url( $nav_base ); ?>#contact"><span class="btn-roll" data-text="Hire me"><span>Hire me</span></span></a>
		</nav>
	</div>
</header>
