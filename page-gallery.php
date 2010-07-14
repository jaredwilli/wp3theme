<?php get_header(); ?>
	<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
	<div class="gallery-thumbs">
		<ul>
		<?php
		$q = new WP_query();
		$q->query( "post_type=site&post_status=publish&posts_per_page=9" );
		if (have_posts()) : /*$previous_user_id = 0; $previous_user_id = */
			while ($q->have_posts()) : $q->the_post();

			 $s = new siteSubmit();
			// var_dump($s->mshot('200'));
			// die;
		?>

			<li id="n2-<?php the_ID(); ?>" class="user_id_<?php the_author_ID( ); ?>">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php $s->mshot(200); ?>
				</a>
			<div class="shadow notext">&nbsp;</div>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php // Don't show the avatar if the previous post was by the same user
			$current_user_id = get_the_author_ID( );
			if( $previous_user_id !== $current_user_id ) {
				echo member_get_avatar( $current_user_id, get_the_author_email( ), 48 );
			}
			$current_user_id;
			?>
				<div class="entry">
					<?php the_content( __( '(More ...)' ) ); ?>
				</div>
					<div class="meta">Added by: 
					<?php the_author_posts_link( ); ?> on 
						<?php the_time( 'F j' ); ?><br />
						<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ); ?>
						<?php edit_post_link( __( 'edit' ) ); ?>
						<br />
						<?php the_tags( __( 'Tags: ' ), ', ', ' ' ); ?>
					</div>

					</li>

<?php endwhile; ?>
<?php endif; ?>

		</ul>
	<div class="cl">&nbsp;</div>
	</div><!--// gallery-thumbs -->

<?php get_footer(); ?>