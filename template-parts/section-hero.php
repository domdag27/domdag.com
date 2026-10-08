<?php $profile = domdag_profile(); ?>
<section id="hero" aria-labelledby="hero-h" class="hero-bg relative overflow-hidden pt-32 pb-16 md:pt-40 md:pb-20">
	<div class="hero-rain" data-hero-rain aria-hidden="true"></div>
	<div class="container-site relative">
		<div class="grid items-center gap-10 lg:grid-cols-[1.618fr_1fr]">
			<div>
				<p data-animate class="flex items-center gap-2.5 text-sm font-medium tracking-wide text-muted">
					<span aria-hidden="true" class="relative flex h-2.5 w-2.5"><span class="absolute inline-flex h-full w-full animate-ping hero-ping rounded-full bg-accent/60 motion-reduce:hidden"></span><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-accent"></span></span>
					<span class="flex items-center gap-2"><?php echo esc_html( $profile['title'] ); ?> <span class="text-edge-strong" aria-hidden="true">&middot;</span> <svg aria-hidden="true" class="h-3.5 w-3.5 shrink-0 text-accent" viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-5.5-7-11a7 7 0 0 1 14 0c0 5.5-7 11-7 11Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg><?php echo esc_html( $profile['location_site'] ?? $profile['location'] ); ?></span>
				</p>

				<h1 id="hero-h" data-split class="mt-6 font-display text-[clamp(2.6rem,4.8vw,5.24rem)] font-bold leading-[1.04] tracking-tight text-balance">
					Transforming ideas into <span class="text-accent text-glow">interactive experiences</span>.
				</h1>

				<p data-animate class="mt-6 max-w-md text-lg leading-relaxed text-muted">
					I'm <?php echo esc_html( $profile['first_name'] ); ?>. I believe good design doesn't need to be complicated: the best sites are clean, fast, and effortless to use.
				</p>

				<div data-animate class="mt-8 flex flex-wrap items-center gap-4">
					<a href="#work" class="btn-accent">
						<span class="btn-roll" data-text="View my work"><span>View my work</span></span>
						<svg aria-hidden="true" width="15" height="15" viewBox="0 0 16 16" fill="none"><path d="M8 3v10m0 0 4-4m-4 4L4 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
					<a href="#contact" class="btn-ghost">
						Hire me
					</a>
				</div>
			</div>

			<div data-hero-drift class="relative hidden lg:block" aria-hidden="true">
			<div data-animate data-hero-art class="relative">
				<!-- How-it-works diagram of the headline, three numbered steps
				     on one signal axis: 01 the idea orb, 02 the code chip,
				     03 the product in a browser. Signal pulses travel the
				     connections (CSS); hero.js plays the build story in the
				     browser on a loop. The drawn (no-JS/reduced-motion) state
				     is the finished site. -->
				<svg class="relative w-full" viewBox="36 134 448 202" fill="none" shape-rendering="geometricPrecision" aria-hidden="true" focusable="false">
					<!-- the signal axis (bleeds past the viewBox edges) -->
					<line x1="20" y1="219" x2="500" y2="219" stroke="var(--color-edge-strong)" stroke-opacity="0.25" stroke-width="0.75" stroke-dasharray="2 5"/>
					<!-- 01: the idea -->
					<g class="in-halo">
						<circle cx="64" cy="219" r="17" stroke="var(--color-accent)" stroke-opacity="0.35" stroke-width="0.75" stroke-dasharray="3 4"/>
					</g>
					<circle cx="64" cy="219" r="10" fill="var(--color-bg)" stroke="var(--color-edge-strong)" stroke-width="1"/>
					<circle class="in-node" cx="64" cy="219" r="3.5" fill="var(--color-accent)"/>
					<!-- idea -> chip -->
					<path d="M82 219C103 219 124 219 145 219" stroke="var(--color-edge-strong)" stroke-opacity="0.6" stroke-width="0.9"/>
					<path class="wire-pulse" d="M82 219C103 219 124 219 145 219" pathLength="100" stroke="var(--color-accent)" stroke-width="1.4" stroke-linecap="round" stroke-dasharray="12 88"/>
					<!-- 02: the code chip, a 3x3 pixel matrix whose cells flip
					     into code glyphs (hero.js; drawn as a checkerboard) -->
					<g class="chip-halo">
						<rect x="147" y="181" width="76" height="76" rx="12" stroke="var(--color-edge-strong)" stroke-opacity="0.45" stroke-width="0.75" stroke-dasharray="3 4"/>
					</g>
					<rect x="155" y="189" width="60" height="60" rx="8" fill="var(--color-surface)" stroke="var(--color-edge-strong)" stroke-width="1"/>
					<rect class="chip-flash" x="155" y="189" width="60" height="60" rx="8" stroke="var(--color-accent)" stroke-width="1.25" opacity="0"/>
					<g font-family="ui-monospace, monospace" font-size="10" font-weight="600">
						<g class="px-cell"><rect class="px-sq" x="165" y="199" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.9" opacity="0"/><text class="px-gl" x="170" y="207.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.9">{</text></g>
						<g class="px-cell"><rect class="px-sq" x="180" y="199" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.35"/><text class="px-gl" x="185" y="207.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.6" opacity="0">&lt;</text></g>
						<g class="px-cell"><rect class="px-sq" x="195" y="199" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.6" opacity="0"/><text class="px-gl" x="200" y="207.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.9">}</text></g>
						<g class="px-cell"><rect class="px-sq" x="165" y="214" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.45"/><text class="px-gl" x="170" y="222.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.6" opacity="0">(</text></g>
						<g class="px-cell"><rect class="px-sq" x="180" y="214" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.8" opacity="0"/><text class="px-gl" x="185" y="222.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.95">/</text></g>
						<g class="px-cell"><rect class="px-sq" x="195" y="214" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.3"/><text class="px-gl" x="200" y="222.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.6" opacity="0">)</text></g>
						<g class="px-cell"><rect class="px-sq" x="165" y="229" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.55" opacity="0"/><text class="px-gl" x="170" y="237.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.9">;</text></g>
						<g class="px-cell"><rect class="px-sq" x="180" y="229" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.7"/><text class="px-gl" x="185" y="237.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.6" opacity="0">&gt;</text></g>
						<g class="px-cell"><rect class="px-sq" x="195" y="229" width="10" height="10" rx="1.5" fill="var(--color-accent)" fill-opacity="0.4" opacity="0"/><text class="px-gl" x="200" y="237.5" text-anchor="middle" fill="var(--color-accent)" fill-opacity="0.9">=</text></g>
					</g>
					<!-- chip pins -->
					<g stroke="var(--color-edge-strong)" stroke-width="1">
						<line x1="170" y1="189" x2="170" y2="183"/><line x1="185" y1="189" x2="185" y2="183"/><line x1="200" y1="189" x2="200" y2="183"/>
						<line x1="170" y1="249" x2="170" y2="255"/><line x1="185" y1="249" x2="185" y2="255"/><line x1="200" y1="249" x2="200" y2="255"/>
					</g>
					<!-- chip -> product -->
					<path d="M223 219C243 219 260 219 280 219" stroke="var(--color-edge-strong)" stroke-opacity="0.6" stroke-width="0.9"/>
					<path class="wire-pulse wire-pulse-b" d="M223 219C243 219 260 219 280 219" pathLength="100" stroke="var(--color-accent)" stroke-width="1.4" stroke-linecap="round" stroke-dasharray="12 88"/>
					<!-- annotations -->
					<g font-family="ui-monospace, monospace" font-size="10.5" fill="var(--color-muted)" fill-opacity="0.75">
						<text x="64" y="268" text-anchor="middle">01 / idea</text>
						<text x="185" y="283" text-anchor="middle">02 / code</text>
						<text x="375" y="320" text-anchor="middle">03 / interactive_experience</text>
						<text x="113" y="207" text-anchor="middle" font-size="9" fill-opacity="0.6">requirements</text>
						<text x="251" y="207" text-anchor="middle" font-size="9" fill-opacity="0.6">deploy</text>
					</g>
					<!-- 03: the product -->
					<rect x="280" y="148" width="190" height="142" rx="4" fill="var(--color-surface)" stroke="var(--color-edge-strong)" stroke-width="1"/>
					<circle cx="294" cy="164" r="3" fill="var(--color-accent)" fill-opacity="0.9"/>
					<circle cx="306" cy="164" r="3" fill="var(--color-accent)" fill-opacity="0.45"/>
					<circle cx="318" cy="164" r="3" fill="var(--color-accent)" fill-opacity="0.2"/>
					<rect x="330" y="159" width="126" height="10" rx="2" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75"/>
					<line x1="281" y1="175" x2="469" y2="175" stroke="var(--color-edge-strong)" stroke-opacity="0.6" stroke-width="0.75"/>
					<clipPath id="ddg-screen"><rect x="288" y="180" width="174" height="102" rx="2"/></clipPath>
					<g clip-path="url(#ddg-screen)">
						<rect class="scr-loader" x="288" y="180" width="174" height="2" fill="var(--color-accent)" opacity="0"/>
						<g class="scr-site">
							<g class="scr-site-inner">
								<rect class="site-el" x="288" y="184" width="174" height="13" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75" fill="none"/>
								<circle class="site-el" cx="297" cy="190.5" r="3" fill="var(--color-accent)"/>
								<rect class="site-el" x="410" y="188" width="12" height="4" fill="var(--color-ink)" fill-opacity="0.3"/>
								<rect class="site-el" x="428" y="188" width="12" height="4" fill="var(--color-ink)" fill-opacity="0.3"/>
								<rect class="site-el" x="446" y="186" width="12" height="8" fill="var(--color-accent)" fill-opacity="0.85"/>
								<rect class="site-el" x="296" y="210" width="86" height="7" fill="var(--color-ink)" fill-opacity="0.4"/>
								<rect class="site-el" x="296" y="224" width="62" height="7" fill="var(--color-ink)" fill-opacity="0.4"/>
								<rect class="site-el" x="296" y="239" width="74" height="4" fill="var(--color-ink)" fill-opacity="0.18"/>
								<rect class="site-el" x="296" y="252" width="40" height="11" fill="var(--color-accent)"/>
								<rect class="site-el" x="394" y="206" width="60" height="47" stroke="var(--color-accent)" stroke-opacity="0.55" stroke-width="0.9" fill="none"/>
								<path class="site-el" d="M400 246l14-16 10 11 7-7 17 12" stroke="var(--color-accent)" stroke-opacity="0.7" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
								<rect x="296" y="276" width="52" height="30" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75" fill="none"/>
								<rect x="356" y="276" width="52" height="30" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75" fill="none"/>
								<rect x="416" y="276" width="46" height="30" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75" fill="none"/>
								<rect x="296" y="318" width="160" height="4" fill="var(--color-ink)" fill-opacity="0.15"/>
								<rect x="296" y="330" width="138" height="4" fill="var(--color-ink)" fill-opacity="0.15"/>
								<rect x="296" y="342" width="150" height="4" fill="var(--color-ink)" fill-opacity="0.15"/>
								<rect x="296" y="358" width="78" height="34" stroke="var(--color-accent)" stroke-opacity="0.4" stroke-width="0.9" fill="none"/>
								<rect x="382" y="358" width="78" height="34" stroke="var(--color-accent)" stroke-opacity="0.4" stroke-width="0.9" fill="none"/>
								<rect x="288" y="402" width="174" height="13" stroke="var(--color-edge-strong)" stroke-opacity="0.5" stroke-width="0.75" fill="none"/>
							</g>
						</g>
					</g>
				</svg>
			</div>
			</div>
		</div>
	</div>
</section>
