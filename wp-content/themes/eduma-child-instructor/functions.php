<?php

function thim_child_enqueue_styles() {
	if ( is_multisite() ) {
		wp_enqueue_style( 'thim-child-style', get_stylesheet_uri(), array(), THIM_THEME_VERSION );
	} else {
		wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array(), THIM_THEME_VERSION );
	}

	wp_enqueue_script( 'thim_child_script', get_stylesheet_directory_uri() . '/js/child_script.js', array( 'jquery' ), THIM_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1 );

load_theme_textdomain( 'eduma-child', get_stylesheet_directory() . '/languages' );

add_filter( 'body_class', 'thim_instructor_custom_class' );
function thim_instructor_custom_class( $classes ) {
	$classes[] = 'thim-child-instructor';
	return $classes;
}