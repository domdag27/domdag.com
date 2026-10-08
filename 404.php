<?php get_header(); ?>

<main id="main" class="flex min-h-[70vh] items-center pt-16">
	<div class="container-site max-w-xl py-20">
		<div class="terminal-card">
			<div class="terminal-bar" aria-hidden="true">
				<span class="terminal-dot bg-accent/90"></span>
				<span class="terminal-dot bg-accent/40"></span>
				<span class="terminal-dot bg-accent/20"></span>
				<span class="terminal-title">dom@domdag:~</span>
			</div>
			<div class="terminal-body">
				<p class="font-mono text-sm text-muted" aria-hidden="true"><span class="text-accent">$</span> open <?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'domdag.com' ); ?>/that-page</p>
				<h1 class="mt-4 font-display text-2xl font-semibold"><span class="text-accent">404:</span> No such file or directory.</h1>
				<p class="mt-3 text-muted">It's a one-page site. Everything lives on the homepage.</p>
				<p class="mt-8"><a class="btn-accent" href="<?php echo esc_url( home_url( '/' ) ); ?>">cd ~<span class="sr-only"> (back to the homepage)</span></a></p>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
