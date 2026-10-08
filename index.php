<?php get_header(); ?>

<main id="main" class="pt-32 pb-20">
	<div class="container-site">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1 class="font-display text-3xl font-semibold"><?php the_title(); ?></h1>
					<div class="prose-dark mt-6"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1 class="font-display text-3xl font-semibold">Nothing here</h1>
			<p class="mt-4 text-muted"><a class="text-accent underline focus-ring" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to the homepage</a></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
