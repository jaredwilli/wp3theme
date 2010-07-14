<?php get_header(); ?>
	<div class="gallery-details" id="post">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="description entry">
<?php
$s = new siteSubmit();
// print_r($s->meta_options());
// var_dump($s->siteurl); die;
?>

			<h2><a href="<?php echo $siteurl; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<?php the_content(); ?>
			<?php the_tags( __( 'Tags: ' ), ', ', ' ' ); ?>
			<a href="<?php echo $s->url; ?>" title="<?php the_title(); ?>">
				<?php echo $s->mshot(500); ?>
			</a>
			<div class="shadow notext">&nbsp;</div>
		</article>

<?php endwhile; ?>
<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>