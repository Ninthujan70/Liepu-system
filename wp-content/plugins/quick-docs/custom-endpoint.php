<?php

function custom_document_endpoint() {
	register_rest_route(
		'quick-doc/api',
		'/documents/(?P<id>\d+)',
		array(
			'methods'             => 'GET',
			'callback'            => 'custom_document_callback',
			'permission_callback' => 'check_user_permission',
		)
	);
}

function check_user_permission() {
	if ( is_user_logged_in() ) {
		// User is logged in, grant permission
		$data = get_current_user_data();
		if ( $data['name'] == 'administrator' || $data['name'] == 'editor' ) {
			return true;
		} else {
			return false;
		}
	} else {
		// User is not logged in, deny permission
		return false;
	}
}

// TEST
function custom_document_callback( $request ) {
	$id   = $request->get_param( 'id' );
	$post = get_post( $id );

	if ( $post && $post->post_type === 'document' ) {
		$data = array(
			'id'             => $post->ID,
			'title'          => $post->post_title,
			'content'        => $post->post_content,
			'content_render' => apply_filters( 'the_content', $post->post_content ),
			'author'         => $post->post_author,
		// add additional fields as needed
		);
		return $data;
	} else {
		return new WP_Error( '404', 'Document not found', array( 'status' => 404 ) );
	}
}

add_action( 'rest_api_init', 'custom_document_endpoint' );



