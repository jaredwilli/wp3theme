<?php

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['post_type'] == 'site' ) {

	$post = array(
		'post_title'	=> $_POST['title'],
		'description'	=> $_POST['description'],
		'siteS-url'		=> $_POST['site'],
		'cat'			=> $_POST['category'],
		'tags'			=> $_POST['post_tags'],
		'post_status'	=> 'publish',
		'post_type'		=> $_POST['post_type']
	);
	wp_insert_post($post);
	wp_redirect($_POST['redirect_to']);

	$insert = new siteSubmit();
	$insert->wp_insert_post($post);

} elseif( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['post_type'] == 'snip' ) {
	
	$post = array(
		'post_title'	=> $_POST['title'],
		'description'	=> $_POST['description'],
		'syntax'		=> $_POST['syntax'],
		'tags'			=> $_POST['post_tags'],
		'post_status'	=> 'publish',
		'post_type'		=> $_POST['post_type']
	);
	wp_insert_post($post);
	wp_redirect($_POST['redirect_to']);

	$insert = new siteSnippet();
	$insert->wp_insert_post($post);

} elseif( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['post_type'] == 'status' ) {

	$post = array(
		'post_title'	=> substr( $_POST['description'], 20),
		'description'	=> $_POST['description'],
		'tags'			=> $_POST['post_tags'],
		'post_status'	=> 'publish',
		'post_type'		=> $_POST['post_type']
	);
	wp_insert_post($post);
	wp_redirect($_POST['redirect_to']);

	$insert = new siteStatus();
	$insert->wp_insert_post($post);

} elseif( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['post_type'] == 'question' ) {
	
	$post = array(
		'post_title'	=> $_POST['title'],
		'description'	=> $_POST['description'],
		'tags'			=> $_POST['post_tags'],
		'post_status'	=> 'publish',
		'post_type'		=> $_POST['post_type']
	);
	wp_insert_post($post);
	wp_redirect($_POST['redirect_to']);

	$insert = new siteQuestion();
	$insert->wp_insert_post($post);
	
}
?>
