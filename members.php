<?php 
/*
Template Name: Members
*/
?>

<?php if ( $user_ID ) : // if logged in ?>	

<?php get_header(); ?>

<div id="content-wrap">

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

	<div class="post-container">
		<div class="post-top"></div>
		<div class="post-center" id="post-<?php the_ID(); ?>">
		<div class="post">
			<div class="entry">
	
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		
				<div id="post-content">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				
				</div><!--/post-content-->

			</div><!--/entry-->

			<div class="post-bottom">
				<span class="post-cat">&nbsp;</span><!--/post-cat-->
				<span class="post-author">&nbsp;</span>
			</div><!--/post-bottom-->
		</div><!--/post-->
		</div><!--/post-center-->
	</div><!--/post-container-->  

	<?php endwhile; // end while have posts ?>
	
	<div class="pagenavi">
		<?php if(function_exists('wp_pagenavi')) { ?>
		<div class="wp-pagenavi">
			<?php wp_pagenavi();  ?>
		</div>
			<?php } else { ?>
		<div class="page-nav">
			<div class="nav-previous">
				<?php previous_posts_link('<img src="images/previous.png" alt="Previous" />') ?>
			</div>
			<div class="nav-next">
				<?php next_posts_link('<img src="images/next.png" alt="Next" />') ?>
			</div>
		</div><!--/page-nav-->
	<?php } // end of if pagenavi ?>	
	</div><!--/pagenavi-->
	
<?php else : // if no post to be had then... ?>
	
	<div class="post-container">
		<div class="post-top"></div>
		<div class="post-center">
		<div class="post">

			<h2>404 - Page Not Found</h2>
			<p>The page you were trying to reach has retired and has moved to Florida to live out the rest of it's days as an old useless page. Why not try searching for a cool new page that is ready to teach what you want to learn??</p>
			
			<div class="search404">
				<?php include(TEMPLATEPATH."/searchform.php");?>
			</div>

		</div><!--/post-->
		</div><!--/post-center-->
	</div><!--/post-container-->  

<?php endif; // end if have posts ?>
  
</div><!--content-wrap-->
  
<?php get_sidebar(); ?>
<?php get_footer(); ?>


<?php else : // if not logged in go to login page 

	$url = '/wp-login.php';
	header("Location:$url"); 

endif; // end if logged in
?>
