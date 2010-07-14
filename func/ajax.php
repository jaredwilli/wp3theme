<?php
define('DOING_AJAX', true);
@header('Content-Type: text/html; charset=' . get_option('blog_charset'));

class P2Ajax {
	function dispatch() {
		$action = isset( $_REQUEST['action'] )? $_REQUEST['action'] : '';
		add_action( 'wp_ajax_' . $action, $action );
		do_action( "p2_ajax", $action );
		if ( is_callable( array( 'P2Ajax', $action ) ) )
			call_user_func( array( 'P2Ajax', $action ) );
		else
			die('-1');
		exit;
	}
	
	function get_post() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}
		$post_id = $_GET['post_ID'];
		$post_id = substr( $post_id, strpos( $post_id, '-' ) + 1 );
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			die('<p>'.__('Error: not allowed to edit post.', 'p2').'</p>');
		}
		$post = get_post( $post_id );
		echo $post->post_content ;
	}
	
	function tag_search() {
		global $wpdb;
		$term = $_GET['q'];
		if ( false !== strpos( $term, ',' ) ) {
			$term = explode( ',', $term );
			$term = $term[count( $term ) - 1];
		}
		$term = trim( $term );
		if ( strlen( $term ) < 2 )
			die(); // require 2 chars for matching
		$results = $wpdb->get_col( "SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'post_tag' AND t.name LIKE ('%". like_escape( $wpdb->escape( $term ) ) . "%')" );
		echo join( $results, "\n" );
	}

	function logged_in_out() {
			check_ajax_referer( 'ajaxnonce', '_loggedin' );
			echo is_user_logged_in()? 'logged_in' : 'not_logged_in';
	}
	
	function save_post() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) { die('<p>'.__('Error: not logged in.', 'p2').'</p>'); }

		$post_id = $_POST['post_ID'];
		$post_id = substr( $post_id, strpos( $post_id, '-' ) + 1 );

		if ( !current_user_can( 'edit_post', $post_id )) { die('<p>'.__('Error: not allowed to edit post.', 'p2').'</p>'); }

		$new_post_content = $_POST['description'];

		$post = get_post( $post_id );
		if ( !$post ) die('-1');

		$post = wp_update_post( array(
			'title'				=> $title,
			'description'		=> $description,
			'post_modified'		=> current_time('mysql'),
			'post_modified_gmt'	=> current_time('mysql', 1),
			'ID' 				=> $post_id
		));
		
		$post = get_post( $post );
		echo apply_filters( 'the_content', $post->post_content );
	}

	function new_post() {
		global $user_ID; 
		
		if('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['action'])) { 
			die;
		}
		
		if ( !is_user_logged_in() ) { die('<p>'.__('Error: not logged in.', 'p2').'</p>'); }
		if ( !( current_user_can( 'publish_posts' ) || (get_option( 'p2_allow_users_publish' ) && $user_ID ) )) { die('<p>'.__('Error: not allowed to post.', 'p2').'</p>'); }
		
		check_ajax_referer( 'ajaxnonce', '_ajax_post' );
		
		$user = wp_get_current_user();		
		$user_id		= $user->ID;
		$title 			= $_POST['title'];
		$description	= $_POST['description'];
		$tags			= trim( $_POST['post_tags'] );
		$cats			= $_POST['category'];
		$posttype 		= $_POST['post_type'];
		$site			= $_POST['site'];
		$lbls			= trim( $_POST['lbls'] );
		$snip			= $_POST['snip'];
		$syntax			= $_POST['syntax'];
		$status			= $_POST['status'];
		$question		= $_POST['question'];
		
		if ( post_type_exists($postype) && $posttype == 'site' ) {
			if (empty($title)){ echo 'Please enter a title'; } else { $title = $_POST['title']; }
			if (empty($site)){ echo 'Please enter a url'; } else { $site = $_POST['site']; }
			if (empty($description)){ echo 'Please enter a description'; } else { $description = $_POST['description']; }
			if (empty($cats)){ echo 'Please choose a category'; } else { $cat = $_POST['cat']; }
		} elseif ( post_type_exists($postype) && $posttype == 'snip' ) {
			if (empty($title)){ echo 'Please enter a title'; } else { $title = $_POST['title']; }
			if (empty($snip)){ echo 'Please enter a code snippet'; } else {$snip = $_POST['snip']; }
			if (empty($syntax)){ echo 'Please choose a syntax'; } else {$syntax = $_POST['syntax']; }
		} elseif ( post_type_exists($postype) && $posttype == 'status' ) {
			if (empty($status)){echo 'You didn\'t say anything...';} else {$status= $_POST['status'];}
		} elseif ( post_type_exists($postype) && $posttype == 'question' ) {
			if (empty($title)){ echo 'Please enter a title'; } else { $title = $_POST['title']; }
			if (empty($question)){echo 'Ask a question';} else {$question= $_POST['question'];}
		}
		
		require_once ( ABSPATH . '/wp-admin/includes/taxonomy.php' );
		require_once ( ABSPATH . WPINC . '/category.php' );
		
		
		if ( $posttype == 'site' ) {
			$post_id = wp_insert_post( array(
				'post_author'	=> $user_id,
				'title'			=> $title,
				'site'			=> $site,
				'description'	=> $description,
				'post_category' => array( $post_cat->cat_ID ),
				'lbls'			=> $lbls,
				'post_type'		=> 'site',
				'post_status'	=> 'publish'
			));
		} elseif ( $posttype == 'snip' ) {
			$post_id = wp_insert_post( array(
				'post_author'	=> $user_id,
				'title'			=> $title,
				'snip'			=> $snip,
				'excerpt'		=> $description,
				'syntax'		=> $syntax,
				'tags'			=> $tags,
				'post_type'		=> 'site',
				'post_status'	=> 'publish'
			));
		} elseif ( $posttype == 'status' ) {
			$post_id = wp_insert_post( array(
				'post_author'	=> $user_id,
				'excerpt'		=> $status,
				'post_type'		=> 'status',
				'post_status'	=> 'publish'
			));
		} elseif ( $posttype == 'question' ) {
			$post_id = wp_insert_post( array(
				'post_author'	=> $user_id,
				'title'			=> $title,
				'description'	=> $description,
				'post_type'		=> 'question',
				'post_status'	=> 'publish'
			));
		}
		
		echo $post_id ? $post_id : '0';
	}
	
}