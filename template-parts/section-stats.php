<?php
$profile = domdag_profile();

// Stroke icons for the ticker items, in stats order (inherit currentColor).
$stat_icons = [
	'<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
	'<path d="M12 3l9 5-9 5-9-5 9-5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M3 13l9 5 9-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
	'<circle cx="12" cy="4.5" r="2" stroke="currentColor" stroke-width="2"/><path d="M4.5 9c2.5.8 5 1.2 7.5 1.2S17 9.8 19.5 9M12 10.2V14m0 0-2.8 6M12 14l2.8 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
];

$ticker_half = static function () use ( $profile, $stat_icons ): void {
	foreach ( $profile['stats'] as $i => $stat ) :
		?>
		<span class="ticker-item">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><?php echo $stat_icons[ $i ] ?? $stat_icons[0]; // phpcs:ignore -- static markup above. ?></svg>
			<?php echo esc_html( $stat['value'] . ' ' . $stat['label'] ); ?>
		</span>
		<span class="ticker-sep">&#10022;</span>
		<?php
	endforeach;
};
?>
<section id="stats" aria-labelledby="stats-h" class="ticker">
	<h2 id="stats-h" class="sr-only">Career highlights</h2>
	<p class="sr-only">
		<?php
		echo esc_html( implode( '. ', array_map(
			static fn( $s ) => $s['value'] . ' ' . $s['label'],
			$profile['stats']
		) ) . '.' );
		?>
	</p>
	<div class="ticker-viewport" aria-hidden="true">
		<div class="ticker-track">
			<span class="ticker-half"><?php $ticker_half(); ?></span>
			<span class="ticker-half"><?php $ticker_half(); ?></span>
		</div>
	</div>
</section>
