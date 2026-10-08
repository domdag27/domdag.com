<?php
$profile = domdag_profile();
$skills  = domdag_skills();

$domdag_icon = static function ( string $name, string $class = 'tech-icon' ): string {
	$path = get_theme_file_path( "assets/icons/$name.svg" );
	if ( ! is_readable( $path ) ) {
		return '';
	}
	$svg = (string) file_get_contents( $path );
	// Simple Icons ship a <title>; strip it (the visible label names the tile)
	// and size/color via a class so the icon inherits currentColor.
	$svg = preg_replace( '/<title>.*?<\/title>/s', '', $svg );
	return str_replace( '<svg ', '<svg aria-hidden="true" focusable="false" class="' . esc_attr( $class ) . '" ', $svg );
};

// The AI category gets the featured card; the rest render as bento cards.
// The grid is 6 columns at lg so the last row can split 50/50; default card width is 2.
$featured_group = 'AI-Assisted Development';
$spans          = [
	'Languages & Frameworks'      => 'lg:col-span-4',
	'Accessibility & Performance' => 'lg:col-span-4',
	'Design'                      => 'lg:col-span-3',
	'Tools & Platforms'           => 'lg:col-span-3',
];
?>
<section id="about" aria-labelledby="about-h" class="scene-about relative border-y border-edge/60 py-20 md:py-[8.1rem]">
	<span class="section-index" aria-hidden="true">02</span>
	<div class="container-site relative">
		<div class="grid gap-5 lg:grid-cols-6">

			<div data-reveal class="bento-card lg:col-span-4 lg:p-10">
				<p class="prompt-eyebrow" aria-hidden="true"><span class="p-user">dom@domdag</span>:<span class="p-path">~/about</span><span class="prompt-caret"></span></p>
				<h2 id="about-h" class="section-title mt-3">Turning complex designs into intuitive interfaces.</h2>
				<p class="mt-6 leading-relaxed text-muted"><?php echo esc_html( $profile['summary'] ); ?></p>
				<p class="mt-4 leading-relaxed text-muted">Every project is built to WCAG accessibility standards and Lighthouse performance budgets. This site included.</p>
			</div>

			<div data-reveal class="bento-card bento-card-accent lg:col-span-2 flex flex-col justify-between gap-8">
				<?php echo $domdag_icon( 'claude', 'bento-icon claude-mark text-bg' ); // phpcs:ignore -- static theme asset, title stripped above. ?>
				<div>
					<h3 class="bento-label"><?php echo esc_html( $featured_group ); ?></h3>
					<p class="mt-3 leading-relaxed text-bg/80">Human powered, AI accelerated. I research the latest AI tools and use Claude-assisted programming daily, but the judgment stays human: I own the architecture, review every line, and make the final call on what goes live.</p>
				</div>
			</div>

			<?php foreach ( $skills as $group => $items ) : ?>
				<?php if ( $group === $featured_group ) continue; ?>
				<?php $panel_id = 'skill-panel-' . sanitize_title( $group ); ?>
				<div data-reveal class="bento-card <?php echo esc_attr( $spans[ $group ] ?? 'lg:col-span-2' ); ?>">
					<h3 class="bento-label"><?php echo esc_html( $group ); ?></h3>
					<ul class="mt-5 flex flex-wrap gap-2.5" role="list">
						<?php foreach ( $items as $item ) : ?>
							<li>
								<button
									type="button"
									class="tech-tile tech-tile-btn focus-ring"
									aria-expanded="false"
									aria-controls="<?php echo esc_attr( $panel_id ); ?>"
									data-skill-label="<?php echo esc_attr( $item['label'] ); ?>"
									data-skill-desc="<?php echo esc_attr( $item['desc'] ); ?>"
								>
									<?php if ( ! empty( $item['icon'] ) && ( $svg = $domdag_icon( $item['icon'] ) ) ) : ?>
										<?php echo $svg; // phpcs:ignore -- static theme asset, title stripped above. ?>
									<?php else : ?>
										<span class="tech-badge" aria-hidden="true"><?php echo esc_html( $item['badge'] ?? substr( $item['label'], 0, 2 ) ); ?></span>
									<?php endif; ?>
									<span class="text-sm font-medium"><?php echo esc_html( $item['label'] ); ?></span>
									<svg aria-hidden="true" class="tile-plus" width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 1.5v9M1.5 6h9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
					<div class="skill-panel" id="<?php echo esc_attr( $panel_id ); ?>" aria-hidden="true">
						<div class="skill-panel-inner">
							<p class="skill-panel-text" aria-live="polite"><strong class="skill-panel-term font-semibold text-ink"></strong> <span class="skill-panel-desc"></span></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>
