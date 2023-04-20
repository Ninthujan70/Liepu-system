<?php
/**
 * Generates a PDF file from a given HTML content.
 *
 * This function uses the TCPDF library to generate a PDF file from a given HTML content.
 * It sets various options to control the appearance and behavior of the PDF file, such as the page size,
 * margins, font size, and encoding. The resulting PDF file is saved to a temporary file and returned.
 *
 * @since 1.0.0
 */
function generate_pdf() {

    // Get the post ID from the AJAX request
    $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;

    if ( empty( $post_id ) ) {
        return new WP_Error( 'invalid_post_id', __( 'Invalid post ID.', 'document-child' ) );
    }

    // Get the post content
    $content_post = get_post( $post_id );
    $content = apply_filters( 'the_content', $content_post->post_content );
    // $content = strip_tags( $content ); // Strip any HTML tags from the content

    if ( empty( $content ) ) {
        return new WP_Error( 'no_post_content', __( 'No post content found.', 'document-child' ) );
    }

    // Create a new PDF document PDF library
    $pdf = new TCPDF( 'P', 'mm', 'A4', true, 'UTF-8', false );

    // Add a new page
    $pdf->AddPage();

    // Output the post content to the PDF document
    $pdf->writeHTML( $content, true, false, true, false, '' );

    // Save the PDF document to a file
    $filename = 'document-' . $post_id . '.pdf';
    $filepath = WP_CONTENT_DIR . '/uploads/' . $filename; // Save to uploads directory
    $pdf->Output( $filepath, 'F' );

	 // Increment the download count
    $download_count = intval( get_post_meta( $post_id, 'pdf_download_count', true ) );
    $download_count++;
    update_post_meta( $post_id, 'pdf_download_count', $download_count );

    // Return the download URL
    wp_die( esc_url_raw( site_url( '/wp-content/uploads/' . $filename ) ) );
}
// Register the generate_pdf function as an AJAX action for authenticated users
add_action( 'wp_ajax_generate_pdf', 'generate_pdf' );

// Register the generate_pdf function as an AJAX action for non-authenticated users
add_action( 'wp_ajax_nopriv_generate_pdf', 'generate_pdf' );
