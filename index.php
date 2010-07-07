<?php get_header(); ?>

	<div id="post">
<?php 
$siteShowcase = new WP_Query();
$siteShowcase->query( "post_type=post&post_status=publish&posts_per_page=9" );
if (have_posts()) : 
	while ($siteShowcase->have_posts()) : $siteShowcase->the_post();

		global $post, $url;
		$imgWidth = '250';
		$myurl = trailingslashit( get_post_meta( $post->ID, 'siteS-url', true ) );

		if ( $myurl != '' ) {
			if ( preg_match( "/http(s?):\/\//", $myurl )) {
				//good url and not missing the http://
				$siteurl = get_post_meta( $post->ID, 'siteS-url', true );
				$newurl = 'http://s.wordpress.com/mshots/v1/' . urlencode( $myurl ) . '?w=' . $imgWidth;
			} else {
				//bad url and is missing the http://
				$siteurl = 'http://' . get_post_meta( $post->ID, 'siteS-url', true );
				$newurl .= 'http://s.wordpress.com/mshots/v1/' . urlencode( 'http://' . $myurl ) . '?w=' . $imgWidth;
			}

		} else {
			$myurl = get_bloginfo('template_directory') . '/images/125banner.gif';
		}
		// var_dump ($newurl, $myurl);
		// die;
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
			<?php the_excerpt(__( 'Read more') ); ?>

			<footer>
				<p class="postmetadata"><?php comments_popup_link('No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are disabled'); ?>
				Added by <?php the_author_meta( $post->user_ID, 'author_name', true ); ?></p>
				<p><?php echo get_post_meta( $post->ID, 'siteS_tags', true ); ?></p>
			</footer>							
		</article>
		<div class="cl">&nbsp;</div>

<?php 
endwhile; 
endif; 
?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>  