<?php
/*
	Template Name: Gallery
*/

/************************************** STILL TO DO ON THIS

	Need to link these to the Site SUB-PAGE, which shows more info and link to site.

*************************/

get_header();
?>
			<nav id="prevnext">
			<?php if(function_exists('get_pagination')) { ?>
				<ul id="subnav">
					<li><?php get_pagination(); ?></li>
				</ul>
			<?php } elseif(function_exists('wp_pagenavi')) { ?>
				<ul class="pagenavi">
					<li class="wp-pagenavi">
						<?php wp_pagenavi();  ?>
					</li>
				</ul><!-- // wp-pagenavi-->
			<?php } else { ?>
				<ul class="page-nav">
					<li><?php previous_post('&laquo; &laquo; %', '', 'yes'); ?></li>
					<li><?php next_post('% &raquo; &raquo; ', '', 'yes'); ?></li>
				</ul><!-- // page-nav-->
			<?php } ?>
			</nav><!-- // posts nav top -->


	<div id="post">

<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>


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
			<?php the_content(__( 'Read more') ); ?>

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
<?php comments_template(); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>  