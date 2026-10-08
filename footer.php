<?php $profile = domdag_profile(); ?>
<footer class="border-t border-edge/60 py-10">
	<div class="container-site flex items-center justify-center gap-3 sm:justify-start">
		<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/dd_white.png' ) ); ?>" alt="" width="28" height="28" loading="lazy" decoding="async" class="h-7 w-7">
		<p class="font-mono text-sm text-muted">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $profile['name'] ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
