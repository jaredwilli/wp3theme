<?php get_header(); ?>
<div id="post">
	<ul>
	<?php
	$q = new WP_query();
	$q->query( "post_type=question&post_status=publish&posts_per_page=20" );
	if (have_posts()) :
		while ($q->have_posts()) : $q->the_post();			
		$s = new questionSubmit();
	?>

	<li id="n2-<?php the_ID(); ?>" class="user_id_<?php the_author_ID( ); ?>">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		<div class="shadow notext">&nbsp;</div>
		
		<h3><a href="<?php the_permalink( ); ?>"><?php the_title(); ?></a></h3>
		<?php 
		$current_user_id = get_the_author_ID( );
		if( $previous_user_id !== $current_user_id ) {
			echo member_get_avatar( $current_user_id, get_the_author_email( ), 48 );
		}
		$current_user_id;
		?>
		<div class="entry"><?php the_excerpt(); ?></div>
	</li>

<?php endwhile; ?>
<?php endif; ?>

	</ul>
	<div class="cl">&nbsp;</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>