<?php
/**
 * Case-study page: /work/{slug}/.
 * Renders Dom-verified case content from domdag_project_case();
 * functions.php already 302s any slug without a case entry.
 * Design language mirrors the homepage: terminal prompts, ghost
 * numerals, bento cards, device frames, grid-rain backdrop. The
 * gallery is a native scroll-snap carousel (carousel.js adds
 * buttons/dots; swipe works without JS).
 */

$slug    = get_query_var( 'domdag_project' );
$case    = domdag_project_case( $slug );
$project = null;
$index   = 0;
$cased   = [];
foreach ( domdag_projects() as $i => $p ) {
	if ( domdag_project_case( $p['slug'] ) ) {
		$cased[] = $p;
	}
	if ( $p['slug'] === $slug ) {
		$project = $p;
		$index   = $i;
	}
}
if ( ! $case || ! $project ) {
	wp_safe_redirect( home_url( '/#work' ), 302 );
	exit;
}
// The next case study (wraps) for the footer hand-off.
$next = null;
foreach ( $cased as $k => $p ) {
	if ( $p['slug'] === $slug ) {
		$next = $cased[ ( $k + 1 ) % count( $cased ) ];
		break;
	}
}
if ( $next && $next['slug'] === $slug ) {
	$next = null;
}

// Stroke icon for results tiles — drawicons.js traces any
// [data-draw-icon] strokes in on scroll.
$result_icon = '<circle cx="12" cy="12" r="8.5"/><path d="M8 12.5l2.8 2.8L16.5 9"/>';

get_header();
?>

<main id="main">

	<!-- Case hero: grid-rain backdrop, ghost numeral, terminal prompt -->
	<section class="hero-bg relative overflow-hidden border-b border-edge/60 pt-32 pb-14 md:pt-44 md:pb-20" aria-labelledby="case-h" data-case-hero>
		<div class="hero-rain" data-hero-rain aria-hidden="true"></div>
		<span class="section-index case-index" aria-hidden="true"><?php printf( '%02d', $index + 1 ); ?></span>
		<div class="container-site relative">
			<a class="focus-ring inline-flex items-center gap-2 text-sm font-medium text-muted transition-colors hover:text-accent motion-reduce:transition-none" href="<?php echo esc_url( home_url( '/#work' ) ); ?>">
				<svg aria-hidden="true" width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M13 8H4m0 0 3.5-3.5M4 8l3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
				All work
			</a>

			<p class="prompt-eyebrow mt-10" aria-hidden="true"><span class="p-user">dom@domdag</span>:<span class="p-path">~/work/<?php echo esc_html( $slug ); ?></span><span class="prompt-caret"></span></p>
			<h1 id="case-h" class="mt-4 max-w-3xl font-display text-[clamp(2.4rem,5.5vw,4.6rem)] font-bold leading-[1.05] tracking-tight text-balance"><?php echo esc_html( $project['name'] ); ?></h1>
			<p class="mt-3 text-base font-medium text-accent"><?php echo esc_html( $project['role'] ); ?></p>

			<ul class="mt-8 flex flex-wrap gap-2.5" role="list" aria-label="Project facts">
				<?php foreach ( $case['facts'] as $fact ) : ?>
					<li class="case-chip"><b><?php echo esc_html( $fact['label'] ); ?></b><span aria-hidden="true">:</span> <?php echo esc_html( $fact['value'] ); ?></li>
				<?php endforeach; ?>
				<?php foreach ( $project['stack'] as $tag ) : ?>
					<li class="case-chip"><?php echo esc_html( $tag ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 01 / the brief -->
	<section class="relative py-16 md:py-24" aria-labelledby="brief-h">
		<div class="container-site">
			<div data-reveal class="grid gap-6 lg:grid-cols-[1fr_1.618fr]">
				<h2 id="brief-h" class="case-label">01 / The brief</h2>
				<p class="max-w-2xl text-lg leading-relaxed text-muted sm:text-xl"><span class="intro-comment" aria-hidden="true">//&nbsp;</span><?php echo esc_html( $case['brief'] ); ?></p>
			</div>
		</div>
	</section>

	<!-- 02 / what I built -->
	<section class="relative border-t border-edge/60 py-16 md:py-24" aria-labelledby="build-h">
		<div class="container-site">
			<h2 id="build-h" data-reveal class="case-label">02 / What I built</h2>
			<!-- The build as numbered steps on one signal wire — the hero
			     diagram's how-it-works language. The dashes carry a
			     traveling pulse (CSS); steps cascade in on scroll. -->
			<div class="relative mt-12" data-build-flow>
				<svg class="build-wire hidden md:block" aria-hidden="true">
					<line class="wire-base" x1="0" y1="7" x2="100%" y2="7"/>
					<line class="wire-sweep" x1="0" y1="7" x2="100%" y2="7" fill="none"/>
					<line class="wire-pulse" pathLength="100" x1="0" y1="7" x2="100%" y2="7" stroke-dasharray="7 93" fill="none"/>
				</svg>
				<ol class="grid gap-10 md:grid-cols-4 md:gap-8" role="list">
					<?php foreach ( $case['build'] as $bi => $item ) : ?>
						<li>
							<span class="flow-node" aria-hidden="true"></span>
							<p class="flow-label mt-5 font-mono text-xs font-semibold tracking-wide text-accent"><?php printf( '%02d', $bi + 1 ); ?> <span aria-hidden="true">/</span> <?php echo esc_html( $item['tag'] ); ?></p>
							<p class="flow-body mt-3 text-sm leading-relaxed text-muted"><?php echo esc_html( $item['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- 03 / the work, up close: fixed stage + filmstrip thumbnails -->
	<?php if ( ! empty( $case['gallery'] ) ) : $first = $case['gallery'][0]; ?>
		<section class="relative border-t border-edge/60 py-16 md:py-24" aria-labelledby="shots-h">
			<div class="container-site" data-gallery>
				<div data-reveal class="flex flex-wrap items-end justify-between gap-4">
					<h2 id="shots-h" class="case-label">03 / The work, up close</h2>
					<?php if ( count( $case['gallery'] ) > 1 ) : ?>
						<div class="flex gap-2.5">
							<button type="button" class="carousel-btn focus-ring" data-gal-prev aria-label="Previous screenshot">
								<svg aria-hidden="true" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13 8H4m0 0 3.5-3.5M4 8l3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</button>
							<button type="button" class="carousel-btn focus-ring" data-gal-next aria-label="Next screenshot">
								<svg aria-hidden="true" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</button>
						</div>
					<?php endif; ?>
				</div>
				<figure data-reveal class="mt-8">
					<button
						type="button"
						class="gallery-stage focus-ring"
						data-gal-stage
						aria-haspopup="dialog"
						aria-label="View larger"
					>
						<img
							src="<?php echo esc_url( get_theme_file_uri( $first['img'] ) ); ?>"
							alt="<?php echo esc_attr( $first['alt'] ); ?>"
							width="<?php echo (int) $first['w']; ?>" height="<?php echo (int) $first['h']; ?>"
							decoding="async"
							data-gal-img
						>
					</button>
					<figcaption class="mt-3 font-mono text-xs text-muted" aria-live="polite">
						<span class="text-accent" data-gal-num>01</span><span class="text-accent" aria-hidden="true">&nbsp;/&nbsp;</span><span data-gal-cap><?php echo esc_html( $first['caption'] ?? '' ); ?></span>
					</figcaption>
				</figure>
				<?php if ( count( $case['gallery'] ) > 1 ) : ?>
					<ul class="gallery-rail mt-5 flex gap-3 overflow-x-auto px-1 pb-2 pt-1" role="list" aria-label="Screenshots">
						<?php foreach ( $case['gallery'] as $si => $shot ) : ?>
							<li>
								<button
									type="button"
									class="gallery-thumb focus-ring"
									data-gal-thumb
									data-gal-src="<?php echo esc_url( get_theme_file_uri( $shot['img'] ) ); ?>"
									data-gal-alt="<?php echo esc_attr( $shot['alt'] ); ?>"
									data-gal-caption="<?php echo esc_attr( $shot['caption'] ?? '' ); ?>"
									data-gal-w="<?php echo (int) $shot['w']; ?>"
									data-gal-h="<?php echo (int) $shot['h']; ?>"
									<?php echo $si === 0 ? 'aria-current="true"' : ''; ?>
									aria-label="Show screenshot <?php echo (int) ( $si + 1 ); ?>: <?php echo esc_attr( $shot['caption'] ?? $shot['alt'] ); ?>"
								>
									<img src="<?php echo esc_url( get_theme_file_uri( $shot['img'] ) ); ?>" alt="" width="160" height="96" loading="lazy" decoding="async">
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<dialog class="lightbox" aria-label="Screenshot viewer">
				<button type="button" class="carousel-btn lightbox-close focus-ring" data-lb-close autofocus aria-label="Close viewer">
					<svg aria-hidden="true" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M4 4l8 8M12 4l-8 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
				</button>
				<figure>
					<img src="" alt="" data-lb-img>
					<figcaption class="font-mono text-xs text-muted" data-lb-cap></figcaption>
				</figure>
				<div class="lightbox-nav">
					<button type="button" class="carousel-btn focus-ring" data-lb-prev aria-label="Previous screenshot">
						<svg aria-hidden="true" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13 8H4m0 0 3.5-3.5M4 8l3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<button type="button" class="carousel-btn focus-ring" data-lb-next aria-label="Next screenshot">
						<svg aria-hidden="true" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</div>
			</dialog>
		</section>
	<?php endif; ?>

	<!-- 04 / the challenge: a terminal retro -->
	<?php if ( ! empty( $case['challenge'] ) ) : ?>
		<section class="relative border-t border-edge/60 py-16 md:py-24" aria-labelledby="hard-h">
			<div class="container-site">
				<h2 id="hard-h" data-reveal class="case-label">04 / The Challenge</h2>
				<div data-reveal class="terminal-card mt-8 max-w-3xl">
					<div class="terminal-bar" aria-hidden="true">
						<span class="terminal-dot bg-accent/90"></span>
						<span class="terminal-dot bg-accent/40"></span>
						<span class="terminal-dot bg-accent/20"></span>
						<span class="terminal-title">~/work/<?php echo esc_html( $slug ); ?>/challenge.md</span>
					</div>
					<div class="terminal-body">
						<p class="font-mono text-xs text-accent" aria-hidden="true">$ cat challenge.md</p>
						<p class="mt-3 leading-relaxed text-muted"><?php echo esc_html( $case['challenge'] ); ?><span class="prompt-caret" aria-hidden="true"></span></p>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 05 / where it landed -->
	<?php if ( ! empty( $case['results'] ) ) : ?>
		<section class="relative border-t border-edge/60 py-16 md:py-24" aria-labelledby="results-h">
			<div class="container-site">
				<h2 id="results-h" data-reveal class="case-label">05 / Where it landed</h2>
				<dl class="mt-8 grid gap-5 sm:grid-cols-3">
					<?php foreach ( $case['results'] as $result ) : ?>
						<div data-reveal class="case-build-card flex flex-col">
							<dt class="order-3 mt-2 text-sm leading-snug text-muted"><?php echo esc_html( $result['label'] ); ?></dt>
							<dd class="order-2 mt-4 font-display text-3xl font-bold text-accent sm:text-4xl"><?php echo esc_html( $result['value'] ); ?></dd>
							<span class="case-card-icon order-1 self-end" data-draw-icon aria-hidden="true"><svg viewBox="0 0 24 24"><?php echo $result_icon; // phpcs:ignore -- static markup above. ?></svg></span>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>
		</section>
	<?php endif; ?>

	<!-- hand-off: live site, next case, contact -->
	<section class="relative border-t border-edge/60 bg-surface/30 py-16 md:py-20" data-case-end>
		<div class="container-site">
			<div data-reveal class="flex flex-wrap items-center gap-4">
				<?php if ( ! empty( $project['url'] ) ) : ?>
					<a class="btn-accent" href="<?php echo esc_url( $project['url'] ); ?>" rel="noopener noreferrer nofollow" target="_blank">
						<span class="btn-roll" data-text="Visit the live site"><span>Visit the live site</span></span>
						<span class="sr-only">(opens in a new tab)</span>
						<svg aria-hidden="true" width="15" height="15" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4m0 0H6m6 0v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				<?php endif; ?>
				<a class="btn-ghost" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Hire me</a>
			</div>
			<?php if ( $next ) : ?>
				<a data-reveal class="group mt-12 flex flex-wrap items-baseline justify-between gap-3 border-t border-edge/60 pt-8 focus-ring" href="<?php echo esc_url( home_url( '/work/' . $next['slug'] . '/' ) ); ?>">
					<span class="font-mono text-xs uppercase tracking-[0.18em] text-muted">Next case study</span>
					<span class="font-display text-2xl font-semibold text-ink transition-colors group-hover:text-accent sm:text-3xl motion-reduce:transition-none">
						<?php echo esc_html( $next['name'] ); ?>
						<svg aria-hidden="true" class="ml-1 inline-block -translate-y-0.5 transition-transform group-hover:translate-x-1.5 motion-reduce:transition-none" width="22" height="22" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
				</a>
			<?php endif; ?>
		</div>
	</section>
	<!-- Floating case dock: follows the scroll between hero and the
	     hand-off section (carousel.js toggles .is-on via observers). -->
	<div class="case-float" data-case-float>
		<?php if ( $next ) : ?>
			<a class="btn-accent min-h-0 px-4 py-2 text-xs focus-ring" href="<?php echo esc_url( home_url( '/work/' . $next['slug'] . '/' ) ); ?>">
				<span class="btn-roll" data-text="Next case"><span>Next case</span></span>
				<svg aria-hidden="true" width="13" height="13" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		<?php endif; ?>
		<?php if ( ! empty( $project['url'] ) ) : ?>
			<a class="btn-ghost min-h-0 px-4 py-2 text-xs focus-ring" href="<?php echo esc_url( $project['url'] ); ?>" rel="noopener noreferrer nofollow" target="_blank">
				Live site
				<span class="sr-only">(opens in a new tab)</span>
				<svg aria-hidden="true" width="13" height="13" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4m0 0H6m6 0v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
