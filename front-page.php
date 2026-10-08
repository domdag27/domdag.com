<?php get_header(); ?>

<main id="main">
	<?php
	get_template_part( 'template-parts/section', 'hero' );
	get_template_part( 'template-parts/section', 'stats' );
	get_template_part( 'template-parts/section', 'work' );
	get_template_part( 'template-parts/section', 'philosophy' );
	get_template_part( 'template-parts/section', 'about' );
	get_template_part( 'template-parts/section', 'experience' );
	get_template_part( 'template-parts/section', 'contact' );
	?>
</main>

<?php get_footer(); ?>
