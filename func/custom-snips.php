<?php
$themedir = get_bloginfo('template_directory');
$funcdir  = get_bloginfo('template_url') . "/func/";

function p2_is_ajax_request() {
	global $post_request_ajax;
	
	return ( $post_request_ajax ) ? $post_request_ajax : false;
}
function posting_type2() {
	echo get_posting_type();
}
function get_posting_type2() {
	return $_GET['p'];
}
function media_upload_form2() { 
	require( ABSPATH . '/wp-admin/includes/template.php' );
	media_upload_form();
}
function media_buttons2() {
	echo N2::media_buttons();
}

function new2_pagination() {
	global $wp_query;
	$request = $wp_query->request;
	$numposts = $wp_query->found_posts;
	if($numposts > get_option("new2_home_page_posts")) :
?>
		<ul class="page_button_content clearfix">
			<li class="previous-page"><?php previous_posts_link(""); ?></li>
			<?php
				for($i = 1; $i <= (ceil($numposts/get_option("new2_home_page_posts"))); $i++) : ?>
				<li><a href="<?php echo clean_url(get_pagenum_link($i)); ?>" class="<?php if($i == get_query_var('paged') || ($i == 1 && get_query_var('paged') == "")) :?>selected-page<?php else : ?>other-page<?php endif; ?>"><?php echo $i; ?></a></li>  
			<?php endfor; ?>
			<li class="next-page"><?php next_posts_link(""); ?></li>
		</ul>
<?php
	endif;
}

/**
 * This file contains all of the custom functoins and various code snippets for the theme.
**
**/

/* add_actions and filters */
add_action( 'admin_head', 'custom_colors' );
add_filter( 'admin_footer_text', 'custom_admin_footer');
add_action( 'admin_menu', 'all_settings_link' );
add_action( 'login_head', 'custom_login_logo' );
add_action( 'check_comment_flood', 'check_referrer' );
add_filter( 'avatar_defaults', 'newgravatar' );
add_filter( 'avatar_defaults', 'custom_gravatars' );

add_filter( 'pre_comment_content', 'encode_code_in_comment' );
remove_filter('pre_comment_content', 'wp_rel_nofollow' );
add_filter( 'get_comment_author_link', 'xwp_dofollow' );
add_filter( 'post_comments_link',      'xwp_dofollow' );
add_filter( 'comment_reply_link',      'xwp_dofollow' );
add_filter( 'comment_text',            'xwp_dofollow' );

// Change dashboard header 
function custom_colors() {
   echo '<style type="text/css">#wpwrap{background:#efefef;}#header-logo{ background-image:url('.get_bloginfo('template_directory').'/images/2small.png)!important; } #wphead{background:#191919 url('.get_bloginfo('template_directory').'/images/tilebg.png) repeat-x!important;} h1#site-heading a{font-family:Rockwell, Palintino Linotype; color:#7BCC02;}#excerpt, .attachmentlinks {
height:10em;}</style>';
}
// customize admin footer text
function custom_admin_footer() {
	echo '<a href="http://tweeaks.com">Theme created by Tweeaks Design</a>';
} 
// Use custom logo on Login page 
function custom_login_logo() {
   echo '<style type="text/css">h1 a{ background-image:url('. $themedir . 'images/new2wp-logo.png ) !important; }</style>';
}
// admin link for all settings
function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
// customize default gravatars
function custom_gravatars($avatar_defaults) {

	// change the default gravatar
	$customGravatar1 = get_bloginfo('template_directory').'/images/default-avatar.png';
	$avatar_defaults[$customGravatar1] = 'Default';

	// add a custom user gravatar
	$customGravatar2 = get_bloginfo('template_directory').'/images/125banner.gif';
	$avatar_defaults[$customGravatar2] = 'Custom Gravatar';

	// add another custom gravatar
	$customGravatar3 = get_bloginfo('template_directory').'/images/2small.png';
	$avatar_defaults[$customGravatar3] = 'Custom gravatar';
	return $avatar_defaults;
}



/**
 * @param Adding WP 3.0 Support
**/

// Add this to wp-config.php to enable multi-site feature
// define('WP_ALLOW_MULTISITE', true);
/*****/
// Background image support for the theme
add_custom_background();
/*****/
// add menus support -- used ing header.php: 
// wp_nav_menu( 'sort_column=menu_order&container_class=menu-header' );
add_theme_support( 'nav-menus' );

/*****
// enable new wysiwyg features
add_filter('mce_css', 'my_editor_style');
function my_editor_style($url) {
	if ( !empty($url) )
		$url .= ',';
		// Change the path here if using sub-directory
		$url .= trailingslashit( get_stylesheet_directory_uri() ) . 'editor-style.css';
	return $url;
}/** end of support enabling **/


/** Code Syntax Display Function **/
// escape html entities in comments
function encode_code_in_comment($source) {
	$encoded = preg_replace_callback('/<code>(.*?)<\/code>/ims',
	create_function('$matches', '$matches[1] = preg_replace(array("/^[\r|\n]+/i", "/[\r|\n]+$/i"), "", $matches[1]); 
	return "<code>" . htmlentities($matches[1]) . "</"."code>";'), $source);
	if ($encoded)
		return $encoded;
	else
		return $source;
}


// remove nofollow from comments
function xwp_dofollow($str) {
	$str = preg_replace(
		'~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
		'<a ${1}${2}${3}>', $str);
	return str_replace(array(' rel=""', " rel=''"), '', $str);
}

// disable the autosave
function disableAutoSave(){
    wp_deregister_script('autosave');
}
// remove [...] from excerpts
function trim_excerpt($text) {
	return rtrim($text,'[...]');
}
/**
 * @param, since 2.9
**/
// Add support for post thumbnails, and show them in edit post list
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) { 
	// for post and page
	add_theme_support('post-thumbnails', array( 'post', 'page' ) );
 
	function fb_AddThumbColumn($cols) { 
		$cols['thumbnail'] = __('Thumbnail');
		return $cols;
	}
	function fb_AddThumbValue( $column_name, $post_id ) { 
		$width = (int) 35;
		$height = (int) 35;

		if ( 'thumbnail' == $column_name ) {
			// thumbnail of WP 2.9
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			// image from gallery
			$attachments = get_children( array(
									'post_parent' => $post_id, 
									'post_type' => 'attachment', 
									'post_mime_type' => 'image'
								)
							);
			
			if ( $thumbnail_id )
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			elseif ( $attachments ) {
				foreach ( $attachments as $attachment_id => $attachment ) {
					$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
				}
			}
			if ( isset($thumb) && $thumb ) {
				echo $thumb;
			} else {
				echo __('None');
			}
		}
	}
	// for posts
	add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
 
	// for pages
	add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}


// For category lists on category archives: Returns other categories except the current one
function cats_arch($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;
	return trim(join( $glue, $cats ));
} // end cats_arch


// For tag lists on tag archives: Returns other tags except the current one (redundant)
function tags_arch($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
  	if ( empty($tags) )
		return false;
	return trim(join( $glue, $tags ));
} // end tags_arch()




/**
* Post pagination function
* @param integer $range: The range of the slider, works best with even numbers
* get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4
* previous_posts_link(' « '); - returns the Previous page link
* next_posts_link(' » '); - returns the Next page link
*/
function get_pagination( $range = 5 ) {
	// $paged - number of the current page
	global $paged, $wp_query;
	// How much pages do we have?
	if ( !$max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	// We need the pagination only if there are more than 1 page
	if($max_page > 1){
		if(!$paged){
			$paged = 1;
		}
		// On the first page, don't put the First page link
		if($paged != 1){
			echo "<a href=" . get_pagenum_link(1) . "> First </a>";
		}
		// To the previous page
		previous_posts_link(' &laquo; '); // add before
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
			// When closer to the beginning
			if($paged < $range){
				for($i = 1; $i <= ($range + 1); $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged) echo "class='current'";
					echo ">$i</a>";
				}
			}
			// When closer to the end
			elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range; $i <= $max_page; $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged) echo "class='current'";
					echo ">$i</a>";
				}
			}
			// Somewhere in the middle
			elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
				for($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range/2))); $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged) echo "class='current'";
					echo ">$i</a>";
				}
			}
		}
		// Less pages than the range, no sliding effect needed
		else{
			for($i = 1; $i <= $max_page; $i++){
				echo "<a href='" . get_pagenum_link($i) ."'";
				if($i==$paged) echo "class='current'";
				echo ">$i</a>";
			}
		}
		// Next page
		next_posts_link(' &raquo; '); // add after
		// On the last page, don't put the Last page link
		if($paged != $max_page){
			echo " <a href=" . get_pagenum_link($max_page) . "> Last </a>";
		}
	}
} // end of pagination function()
?>