<?php
$projects = domdag_projects();
?>
<section id="work" aria-labelledby="work-h" class="scene-work relative py-20 md:py-[8.1rem]">
	<span class="section-index" aria-hidden="true">01</span>
	<div class="container-site relative">
		<header data-reveal class="relative max-w-2xl">
			<p class="prompt-eyebrow" aria-hidden="true"><span class="p-user">dom@domdag</span>:<span class="p-path">~/work</span><span class="prompt-caret"></span></p>
			<h2 id="work-h" class="section-title mt-3">Custom web solutions, for real clients.</h2>
			<p class="mt-4 text-lg text-muted"><span class="intro-comment" aria-hidden="true">//&nbsp;</span>Healthcare, education, hospitality, e-commerce, industrial supply, and enterprise B2B. A cross-section of platforms I've designed and built.</p>
		</header>
	</div>

	<!-- The deck + its dot rail share this wrapper so the sticky rail can
	     only exist alongside the cards, never up by the section header. -->
	<div class="relative">
		<div class="container-site">
		<ol class="stack mt-14" role="list" data-stack>
			<?php foreach ( $projects as $i => $project ) : ?>
				<li class="stack-panel" style="--stack-top: calc(5.5rem + <?php echo (int) ( $i * 12 ); ?>px);">
					<article class="stack-card group<?php echo $project['url'] ? ' stack-card--linked' : ''; ?>">
						<?php $frame = $project['frame'] ?? null; ?>
						<div class="stack-media<?php echo $frame ? ' stack-media--stage' : ''; ?>">
							<?php if ( $frame === 'duo' ) : ?>
								<div class="device-duo">
									<div class="device device-desktop">
										<div class="device-bar" aria-hidden="true"><i></i><i></i><i></i><span class="device-url"></span></div>
										<img src="<?php echo esc_url( get_theme_file_uri( $project['img'] ) ); ?>" alt="<?php echo esc_attr( $project['alt'] ); ?>" width="<?php echo (int) $project['w']; ?>" height="<?php echo (int) $project['h']; ?>" loading="lazy" decoding="async">
									</div>
									<div class="device device-phone">
										<div class="device-notch" aria-hidden="true"><span></span></div>
										<img src="<?php echo esc_url( get_theme_file_uri( $project['img2'] ) ); ?>" alt="<?php echo esc_attr( $project['img2_alt'] ?? '' ); ?>" width="<?php echo (int) $project['img2_w']; ?>" height="<?php echo (int) $project['img2_h']; ?>" loading="lazy" decoding="async">
									</div>
								</div>
							<?php elseif ( $frame ) : ?>
								<div class="device device-<?php echo esc_attr( $frame ); ?><?php echo ( $project['frame_fit'] ?? '' ) === 'natural' ? ' device--natural' : ''; ?>">
									<?php if ( $frame === 'phone' ) : ?>
										<div class="device-notch" aria-hidden="true"><span></span></div>
									<?php else : ?>
										<div class="device-bar" aria-hidden="true"><i></i><i></i><i></i><span class="device-url"></span></div>
									<?php endif; ?>
									<img src="<?php echo esc_url( get_theme_file_uri( $project['img'] ) ); ?>" alt="<?php echo esc_attr( $project['alt'] ); ?>" width="<?php echo (int) $project['w']; ?>" height="<?php echo (int) $project['h']; ?>" loading="lazy" decoding="async">
								</div>
							<?php else : ?>
								<img
									src="<?php echo esc_url( get_theme_file_uri( $project['img'] ) ); ?>"
									alt="<?php echo esc_attr( $project['alt'] ); ?>"
									width="<?php echo (int) $project['w']; ?>" height="<?php echo (int) $project['h']; ?>"
									loading="lazy" decoding="async"
								>
							<?php endif; ?>
						</div>
						<div class="stack-body">
							<span class="stack-num" aria-hidden="true"><?php printf( '%02d', $i + 1 ); ?></span>
							<?php $has_case = function_exists( 'domdag_project_case' ) && domdag_project_case( $project['slug'] ); ?>
							<h3 class="font-display text-2xl font-semibold sm:text-3xl">
								<?php if ( $has_case ) : ?>
									<?php /* case study is the primary destination: the whole card drives there */ ?>
									<a href="<?php echo esc_url( home_url( '/work/' . $project['slug'] . '/' ) ); ?>" class="card-link focus-ring">
										<?php echo esc_html( $project['name'] ); ?>
										<svg aria-hidden="true" class="ml-1 inline-block -translate-y-0.5 transition-transform group-hover:translate-x-1 motion-reduce:transition-none" width="18" height="18" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
									</a>
								<?php elseif ( $project['url'] ) : ?>
									<a href="<?php echo esc_url( $project['url'] ); ?>" rel="noopener noreferrer nofollow" target="_blank" class="card-link focus-ring">
										<?php echo esc_html( $project['name'] ); ?>
										<span class="sr-only">(opens in a new tab)</span>
										<svg aria-hidden="true" class="ml-1 inline-block -translate-y-0.5 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 motion-reduce:transition-none" width="18" height="18" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4m0 0H6m6 0v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
									</a>
								<?php else : ?>
									<?php echo esc_html( $project['name'] ); ?>
								<?php endif; ?>
							</h3>
							<p class="mt-2 text-sm font-medium text-accent"><?php echo esc_html( $project['role'] ); ?></p>
							<p class="mt-4 leading-relaxed text-muted"><?php echo esc_html( $project['blurb'] ); ?></p>
							<ul class="mt-6 flex flex-wrap gap-2" role="list" aria-label="Project tags">
								<?php foreach ( $project['stack'] as $tag ) : ?>
									<li class="pill"><?php echo esc_html( $tag ); ?></li>
								<?php endforeach; ?>
							</ul>
							<?php if ( $has_case ) : ?>
								<?php /* explicit destinations; z-30 beats the stretched .card-link::after overlay (z-20) */ ?>
								<div class="relative z-30 mt-6 flex flex-wrap items-center gap-4">
									<a class="btn-accent min-h-0 px-4 py-2 text-xs focus-ring" href="<?php echo esc_url( home_url( '/work/' . $project['slug'] . '/' ) ); ?>">
										<span class="btn-roll" data-text="View the case study"><span>View the case study</span></span>
										<svg aria-hidden="true" width="13" height="13" viewBox="0 0 16 16" fill="none"><path d="M3 8h9m0 0L8.5 4.5M12 8l-3.5 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
									</a>
									<?php if ( $project['url'] ) : ?>
										<a class="focus-ring inline-flex items-center gap-1.5 text-sm font-semibold text-accent transition-colors hover:text-ink motion-reduce:transition-none" href="<?php echo esc_url( $project['url'] ); ?>" rel="noopener noreferrer nofollow" target="_blank">
											View the live site
											<span class="sr-only">(opens in a new tab)</span>
											<svg aria-hidden="true" width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4m0 0H6m6 0v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="stack-veil" aria-hidden="true"></div>
					</article>
				</li>
			<?php endforeach; ?>
		</ol>
		</div>

		<nav class="deck-nav" aria-label="Jump to a project">
		<div class="deck-nav-track">
		<p class="deck-count" aria-hidden="true"><span data-deck-current>01</span><span class="deck-count-sep">/</span><?php printf( '%02d', count( $projects ) ); ?></p>
		<ul class="deck-dots" role="list">
			<?php foreach ( $projects as $i => $project ) : ?>
				<li>
					<button type="button" class="deck-dot focus-ring" data-deck-dot aria-label="Go to project <?php printf( '%02d', $i + 1 ); ?>: <?php echo esc_attr( $project['name'] ); ?>"></button>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
	</nav>
	</div>
</section>
