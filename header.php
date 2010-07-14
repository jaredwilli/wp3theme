<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?></title>
	<?php if ( (!is_paged() ) && ( is_single() || is_page() || is_home() ) ) { echo '<meta name="robots" content="index, follow" />' . "\n"; } else { echo '<meta name="robots" content="noindex, follow, noodp, noydir" />' . "\n"; } ?>
	<meta name="description" content="<?php if ( is_single() ) { wp_title('-', true, 'right'); echo  strip_tags( get_the_excerpt() ); } elseif ( is_page() ) { wp_title('-', true, 'right'); echo  strip_tags( get_the_excerpt() ); } else { bloginfo('description'); } ?>" />
	
	<meta name="siteinfo" content="robots.txt" />
	<meta name="author" content="Jared Williams - http://tweeaks.com" />

<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" /> 
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/css/jqueryui.css" />
	<!--[if lt IE 8]><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/modernizr.min.js"><![endif]-->
	<!--[if IE]><style type="text/css" media="screen">@font-face{font-family:'Rockwell';src: url('<?php bloginfo('template_directory'); ?>/fonts/ROCK.TTF');}</style><![endif]-->

<?php wp_head(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12899866-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>

<section id="headwrap">
	<div id="shell">
		<nav id="mainmenu">
			<ul class="menu-top">
			<?php if (is_user_logged_in()) { ?>			
			<?php global $current_user; get_currentuserinfo(); ?>
				<li><a href="<?php echo site_url(); ?>/profile/<?php echo $current_user->user_nicename; ?>/">My Profile</a></li>
				<li><a href="<?php echo site_url(); ?>/author/<?php echo $current_user->user_nicename; ?>/">My Posts</a></li>
				<li><a href="<?php echo site_url(); ?>/wp-admin/">Settings</a></li>
				<li><a href="#TB_inline?height=470&amp;width=500&amp;inlineId=dialog" class="thickbox" title="Submit">Submit</a></li>
				<li><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
			<?php } else { ?>
				<li><a href="#TB_inline?height=300&amp;width=400&amp;inlineId=dialog" class="thickbox" title="Login">Login</a></li>
			<?php } ?>
			</ul>
		</nav>
		<header role="head">
			<hgroup>
				<h1 class="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('title'); ?>"><?php bloginfo('title'); ?></a></h1>
				<h3 class="tagline"><?php bloginfo('description'); ?></h3>
			</hgroup>
		</header>
		<nav id="nav">
			<ul class="cat-nav">
				<li><?php wp_nav_menu( array('menu' => 'Sub Menu' )); ?></li>
			</ul>
		</nav>
	</div>
</section>

<section id="content">
	<div id="shell">