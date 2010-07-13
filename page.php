<?php get_header(); ?>

	<div id="post">

<?php 
if (have_posts()) :
while (have_posts()) : the_post(); 

?>
		<article class="entry">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail' );
				} else { ?>
					<img src="<?php bloginfo('template_directory'); ?>/images/125banner.gif" alt="No Image" title="No Image" />
			<?php }	?>
				</a>
			<?php the_content(); ?>
		</article>

<?php endwhile; ?>
<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>