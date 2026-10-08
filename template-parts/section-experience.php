<?php $experience = domdag_experience(); ?>
<section id="experience" aria-labelledby="experience-h" class="scene-exp relative py-20 md:py-[8.1rem]">
	<span class="section-index" aria-hidden="true">03</span>
	<div class="container-site relative">
		<header data-reveal class="relative max-w-2xl">
			<p class="prompt-eyebrow" aria-hidden="true"><span class="p-user">dom@domdag</span>:<span class="p-path">~/experience</span><span class="prompt-caret"></span></p>
			<h2 id="experience-h" class="section-title mt-3">Eight years, three teams, 25+ sites delivered.</h2>
		</header>

		<ol class="timeline mt-12" role="list">
			<?php foreach ( $experience as $job ) : ?>
				<li data-reveal class="timeline-item">
					<div class="timeline-dot" aria-hidden="true"></div>
					<div class="flex flex-wrap items-baseline gap-x-4 gap-y-1">
						<h3 class="font-display text-xl font-semibold"><?php echo esc_html( $job['role'] ); ?></h3>
						<p class="text-accent"><?php echo esc_html( $job['company'] ); ?></p>
						<p class="font-mono text-sm text-muted"><?php echo esc_html( $job['period'] ); ?><?php if ( ! empty( $job['where'] ) ) : ?> &middot; <?php echo esc_html( $job['where'] ); ?><?php endif; ?></p>
					</div>
					<ul class="mt-4 space-y-2.5 pl-5" role="list">
						<?php foreach ( $job['bullets'] as $bullet ) : ?>
							<li class="flex gap-3 leading-relaxed text-muted">
								<svg aria-hidden="true" class="mt-2 h-1.5 w-1.5 shrink-0 text-accent" viewBox="0 0 6 6" fill="currentColor"><circle cx="3" cy="3" r="3"/></svg>
								<?php echo esc_html( $bullet ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ol>

		<?php $edu = domdag_education(); ?>
		<p data-reveal class="mt-12 text-muted">
			Education: <?php echo esc_html( $edu['degree'] ); ?>, <?php echo esc_html( $edu['school'] ); ?>.
		</p>
	</div>
</section>
