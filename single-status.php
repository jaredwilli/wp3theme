<?php get_header(); 
$snipp = new snipSubmit(); ?>
<div class="gallery-details" id="post">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="description entry">
		<h2><a href="<?php echo $siteurl; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<pre><code><?php the_content(); ?></code></pre>
		<?php echo get_post_meta($post->ID, 'siteS_tags', true); ?>
	
		<div class="meta">Added by: 
		<?php the_author_posts_link( ); ?> on 
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ); ?>
			<?php edit_post_link( __( 'Edit' ) ); ?>
		</div>	
	</article>
	
	
<?php endwhile; endif; ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>