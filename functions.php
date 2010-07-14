<?php
define( 'N2_INC_PATH', get_template_directory() . '/inc' );
define( 'N2_INC_URL', get_bloginfo('template_directory') . '/inc' );
define( 'N2_FUNC_PATH', get_template_directory() . '/func' ); 
define( 'N2_FUNC_URL', get_bloginfo('template_directory') . '/func' );
define( 'N2_JS_PATH',  get_template_directory() . '/js' );
define( 'N2_JS_URL', get_bloginfo('template_directory' ).'/js' );
//require_once( N2_INC_PATH . '/ajax.php' );
//require_once( N2_INC_PATH . '/template-tags.php' );

// Get functions paths
$functions_path = TEMPLATEPATH . '/func';
//require_once ($functions_path . 'options-page.php');
require_once ( $functions_path . '/sidebar-widgets.php' );
require_once ( $functions_path . '/custom-snips.php' );
require_once ( $functions_path . '/posttypes.php' );
require_once ( $functions_path . '/N2.php' );
require_once ( $functions_path . '/js.php' );

//require_once TEMPLATEPATH . '/qjax.php';

// #####################################
// CUSTOMIZATION STUFF, LINKS, TUTORIALS

// http://robertbasic.com/blog/wordpress-as-cms-tutorial/#more-644
// http://wefunction.com/2008/12/taking-wordpress-one-step-further/

// #####################################



wp_register_sidebar_widget( 'n2_recent_projects_widget', __( 'Recent Projects' ), 'n2_recent_projects_widget' );
wp_register_widget_control( 'n2_recent_projects_widget', __( 'Recent Projects' ), 'n2_recent_projects_control' );

// Get user avatar
function member_get_avatar( $wpcom_user_id, $email, $size, $rating = '', $default = 'http://s.wordpress.com/i/mu.gif' ) {
	if( !empty( $wpcom_user_id ) && $wpcom_user_id !== false && function_exists( 'get_avatar' ) ) {
		return get_avatar( $wpcom_user_id, $size );
	}
	elseif( !empty( $email ) && $email !== false ) {
		$default = urlencode( $default );

		$out = 'http://www.gravatar.com/avatar.php?gravatar_id=';
		$out .= md5( $email );
		$out .= "&amp;size={$size}";
		$out .= "&amp;default={$default}";

		if( !empty( $rating ) ) {
			$out .= "&amp;rating={$rating}";
		}
		return "<img alt='' src='{$out}' class='avatar avatar-{$size}' height='{$size}' width='{$size}' />";
	}
	else {
		return "<img alt='' src='{$default}' />";
	}
}/**
 * Scripts
	jQuery 1.4.2	-	jquery
	jQuery UI Core	-	jquery-ui-core
	jQuery UI Tabs 	-	jquery-ui-tabs
	jQuery Thickbox	-	thickbox
	jQuery Tools 	-	jqtools
	
**/	 
function my_init() {
	if (!is_admin()) {
		wp_deregister_script( 'jquery' );
		wp_register_script	( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', false, '1.4.2', true );
		wp_register_script	( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js', false, '1.8.0', true );
		wp_register_script	( 'jqtools', 'http://cdn.jquerytools.org/1.1.2/tiny/jquery.tools.min.js' );
		wp_enqueue_script	( 'jquery' );
		wp_enqueue_script	( 'jqueryui' );
		wp_enqueue_script	( 'thickbox' );
		
		// load a JS file from my theme: js/theme.js
		wp_enqueue_script	( 'my_script', get_bloginfo('template_url').'/js/actions.js', 
				  	array	( 'jquery', 'jqueryui', 'thickbox' ), '1.0', true);
	}
}
add_action('wp_head', 'my_init');
?>