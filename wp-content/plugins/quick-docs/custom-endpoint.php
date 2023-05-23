<?php

function custom_document_endpoint() {
	register_rest_route(
		'quick-doc/api',
		'/documents/',
		array(
			'methods' => 'POST',
			'headers' => array(
				'Content-Type' => 'application/json',
			),
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
function custom_document_callback( WP_REST_Request $request  ) {
	global $wpdb;
	$passedParam = $request->get_json_params();
	$trimmedString = $passedParam['term'];
	$post_id = null;
	if (preg_match('/^[0-9]+$/', $trimmedString)) {
		$post_id = array($trimmedString);
	}else {
		$post_id = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT ID
				FROM $wpdb->posts
				WHERE post_title LIKE %s
				AND post_type = 'document'
				AND post_status = 'publish'",
				'%' . $trimmedString . '%'
			)
		);
	}


	if ( $post_id ) {
		$data = [];
		foreach ($post_id as $key => $value) {
			$post = get_post( $value );
			if ( $post && $post->post_type === 'document' ) {
				$data[] = array(
					'id'             => $post->ID,
					'title'          => $post->post_title,
					'content'        => $post->post_content,
					'content_render' => apply_filters( 'the_content', $post->post_content ),
					'author'         => $post->post_author,
				// add additional fields as needed
				);
			} else {
				return new WP_Error( '404', 'Document not found', array( 'status' => 404 ) );
			}
		}
		return $data;

	}else{
		return new WP_Error( '403', 'Document not found', array( 'status' => 403 ) );
	}
}

add_action( 'rest_api_init', 'custom_document_endpoint' );



