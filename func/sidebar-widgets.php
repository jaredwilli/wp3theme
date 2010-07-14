<?php
/*** ALL SIDEBAR WIDGET SETTINGS ***/

if(function_exists('register_sidebar')){
	register_sidebar(array('name' => 'Sidebar1',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'Sidebar2',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'Sidebar3',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'SidebarAds',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<span>',
		'after_title' => '</span>',
	));
	
	// Sidebar Tabs Sections
	register_sidebar(array('name' => 'Tab1',
		'before_widget' => '<div id="tab-1">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'Tab2',
		'before_widget' => '<div id="tab-2">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'Tab3',
		'before_widget' => '<div id="tab-3">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Header
	register_sidebar(array('name' => 'HeaderLeft',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'HeaderRight',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Footer
	register_sidebar(array('name' => 'FooterLeft',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'FooterCenter',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'FooterRight',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'FooterCopyright',
		'before_widget' => '<div id="copy">',
		'after_widget' => '</div>',
	));
	
	// Misc
	register_sidebar(array('name' => 'PostAds',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name' => 'PostBottom',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
} 
?>