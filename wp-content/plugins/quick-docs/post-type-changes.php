<?php
// create documentation post types
function custom_post_type() {
	$labels = array(
		'name'               => 'Documents',
		'singular_name'      => 'Document',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Document',
		'edit_item'          => 'Edit Document',
		'new_item'           => 'New Document',
		'view_item'          => 'View Document',
		'search_items'       => 'Search Documents',
		'not_found'          => 'No documents found',
		'not_found_in_trash' => 'No documents found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Documents',
	);
	$args   = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'document' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 0,
		'menu_icon'          => 'dashicons-media-document',
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
	);
	register_post_type( 'document', $args );
}

add_action( 'init', 'custom_post_type' );

function get_current_user_data() {
	include_once ABSPATH . 'wp-includes/pluggable.php';
	$current_user = wp_get_current_user();
	$user_roles   = $current_user->roles;
	$user_role    = array_shift( $user_roles );
	$role_name    = get_role( $user_role )->name;
	return array(
		'name'      => $role_name,
		'roles'     => $user_roles,
		'is_logged' => is_user_logged_in(),
	);
}



// add custom post type column
function custom_posts_columns( $columns ) {
	$columns['doc-id']   = 'Document ID';
	if ( is_user_logged_in() ) {
		// User is logged in, grant permission
		$data = get_current_user_data();
		if ( $data['name'] == 'administrator' || $data['name'] == 'editor' ) {
			$columns['download'] = 'Download';
			$columns['total-download'] = 'Total Downloads';
		}
	}
	$columns['role']     = 'Your Role';
	return $columns;
}

add_filter( 'manage_document_posts_columns', 'custom_posts_columns' );

// append contents for download and post id columns
function custom_posts_column_content( $column_name, $post_id ) {
	if ( $column_name == 'doc-id' ) {
		$styles = 'style="font-size:25px;display: grid;justify-content: start;align-items: center;margin-top: 14px;color: green;"';
		echo '<span ' . $styles . '>' . $post_id . '</span>';
	}
	if ( $column_name == 'download' ) {
		$styles = 'style="font-size:15px;display: inline-flex;justify-content: start;align-items: center;margin-top: 5px;background: green;color: #ffff;padding: 8px 15px;border-radius: 4px;"';
		echo '<a href="#' . $post_id . '" onClick="downloadPdf(' . $post_id . ');" ' . $styles . '>Download</a>';
	}
	if ( $column_name == 'total-download' ) {
		$downloads 	=	get_post_meta( $post_id, 'pdf_download_count', true );
		echo '<span>('.$downloads.')</span>';
	}
	if ( $column_name == 'role' ) {

		echo '<p>' . get_current_user_data()['name'] . '</p>';
	}
}

add_action( 'manage_document_posts_custom_column', 'custom_posts_column_content', 10, 2 );

// Move the "Author" column to the end of the list table
function move_author_column( $columns ) {
	$author = $columns['author'];
	unset( $columns['author'] );
	$columns['author'] = $author;
	return $columns;
}

add_filter( 'manage_document_posts_columns', 'move_author_column' );

// include custom api call changes
require 'custom-endpoint.php';




