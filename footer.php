	</div>
</section><!-- // End Content -->

<section id="bottom">
	<div id="shell">
		<nav class="widgetbox">
			<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(FooterLeft)) : endif; ?>
		</nav>
		<nav class="widgetbox">
			<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(FooterCenter)) : endif;?>
		</nav>
		<nav class="widgetbox">
			<?php if(function_exists('dynamic_sidebar') && dynamic_sidebar(FooterRight)) : endif; ?>
		</nav>

		<footer id="footer" role="contentinfo">			
			<div class="copy">
				Copyright &copy;<?php echo date(Y); ?> 
				<a href="<?php home_url(); ?>" title="<?php bloginfo('title'); ?>"><?php bloginfo('title'); ?></a>

			<?php // if(function_exists('dynamic_sidebar') && dynamic_sidebar(FooterCopyright)) : endif; ?>
			
			<!--
			<ul class="foot-nav">
				<li><?php wp_nav_menu( array('menu' => 'Main Menu' )); ?></li>
			</ul>
			-->
				
			</div>	
		</footer><!-- // End Footer -->
	</div>
</section>


<div id="dialog" style="display:none;">
<?php 
if( !is_user_logged_in() ) { include_once(TEMPLATEPATH.'/func/userForm.php'); 
} else { 
include_once(TEMPLATEPATH.'/post-form.php'); } 
?>
</div>


<script type="text/javascript" src="http://jquery.com/src/jquery-latest.pack.js"></script>

<script type="text/javascript" src="http://jquery.com/demo/thickbox/thickbox-code/thickbox-compressed.js"></script>
<link rel="stylesheet" type="text/css" href="http://jquery.com/demo/thickbox/thickbox-code/thickbox.css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jqueryui.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/actions.js"></script>
<?php wp_enqueue_script( 'suggest' ); ?>
<?php wp_footer(); ?>

</body>
</html>