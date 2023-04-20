<?php

/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package document_child
 *
 */

/**
 *  Enqueues child theme stylesheets.
 *
 * @since 1.0
 *
 * @return void
 */
function twentytwentythree_child_enqueue_styles()
{
	wp_enqueue_style('twentytwentythree-child-style', get_stylesheet_uri(), false, '1.0');
	wp_enqueue_style('twentytwentythree-child', get_stylesheet_uri(), false, '1.0');
}
add_action('wp_enqueue_scripts', 'twentytwentythree_child_enqueue_styles');

/**
 * Add admin js file to wp admin
 *
 * @return void
 */
function load_custom_admin_js()
{
	wp_enqueue_script('custom-admin-js', get_stylesheet_directory_uri() . '//assets/js/admin-functions.js', array('jquery'), '1.0', false, true);
}
add_action('admin_enqueue_scripts', 'load_custom_admin_js');


/**
 * Redirect to home if user not logged in
 */
function redirect_to_login_page()
{
	if (!is_user_logged_in()) {
		wp_safe_redirect(wp_login_url());
		exit;
	} else {
		global $post;
		if ('document' !== $post->post_type && !is_front_page()) {
			wp_safe_redirect(get_site_url());
			exit;
		}
	}
}
add_action('template_redirect', 'redirect_to_login_page');

// login page customization
function custom_login_styles()
{
	wp_enqueue_style('custom-login-styles', get_stylesheet_directory_uri() . '../style.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

// admin css
function document_admin_css()
{
	global $post_type;
	if ('document' == $post_type) {
		wp_enqueue_style('document-admin-css', get_stylesheet_directory_uri() . '/assets/admin-css/document-style.css');
	}
}
add_action('admin_enqueue_scripts', 'document_admin_css');

// remove updates
function hide_update_messages()
{
	echo '<style>.update-message { display:none !important; }</style>';
}
add_action('admin_head', 'hide_update_messages');
