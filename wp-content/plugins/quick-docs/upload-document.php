<?php
// add custom button next to add new document.
function add_custom_button_after_add_new()
{
	global $post_type;

	if (check_user_permission()) {
		// Display the button only for the "document" post type
		if ($post_type === 'document') {
?>
			<script>
				jQuery(document).ready(function($) {
					var addButton = $('<a href="edit.php?post_type=document&page=upload-documents" class="page-title-action">Upload Document</a>');
					addButton.insertAfter('.page-title-action');
				});
			</script>
<?php
		}
	}
}
add_action('admin_head', 'add_custom_button_after_add_new');

/**
 * Handles form submissions via AJAX.
 *
 * @throws Exception If there is an error parsing the uploaded PDF content.
 * @return void
 */

function handle_form_submission()
{
	check_ajax_referer('your-ajax-nonce', 'security');
	$document = $_FILES['uploadDocument'];

	if (isset($_POST)) {
		$tempName = $document['tmp_name'];
		$fileType = $document['type'];
		$fileName = $document['name'];
		$fileNameWithoutExtension = $_POST['doctitle'] != '' ? $_POST['doctitle'] : pathinfo($fileName, PATHINFO_FILENAME);
		// print_r($fileType);
		// die();
		if ('application/pdf' == $fileType) {

			$parser = new \Smalot\PdfParser\Parser();
			$pdf = $parser->parseFile($tempName);
			// Get all the pages from the PDF
			$pages = $pdf->getPages();
			// Variable to store the extracted content
			$content = '';

			// Loop through each page and extract the text
			foreach ($pages as $page) {
				$text = nl2br($page->getText());
				$text = explode(".<br />", $text);
				$pragraphs = '';
				if ($text) {
					foreach ($text as $key => $value) {
						$textString = remove_br_tags($value);
						$textString = $textString ? $textString . '.' : '';
						if ($textString) {
							$pragraphs .= '<!-- wp:paragraph --><p>' . $textString . '</p><!-- /wp:paragraph -->';
						}
					}
				}
				// Append the extracted text to the content variable
				$content .= $pragraphs;
			}
			// Create the new post
			$post_id = wp_insert_post(array(
				'post_title'   => $fileNameWithoutExtension,
				'post_content' => $content,
				'post_status'  => 'publish',
				'post_type'    => 'document',
			));

			// Check if the post was created successfully
			if ($post_id) {
				$response = array(
					'success' => true,
					'message' => 'Post created successfully with the content from the uploaded PDF!',
					'data'    => $post_id,
				);
				wp_send_json_success($response);
			} else {
				// Display error message if the post creation failed
				$response = array(
					'success' => false,
					'message' => 'Post created successfully with the content from the uploaded PDF!',
					'data'    => $post_id,
				);
				wp_send_json_error('Form submission error. Please try again!');
			}
		}
	}
}

add_action('wp_ajax_handle_form_submission', 'handle_form_submission');
add_action('wp_ajax_nopriv_handle_form_submission', 'handle_form_submission');


/**
 * Custom function to remove <br> tags from the content.
 *
 * @param string $content The content to process.
 * @return string The content without <br> tags.
 */
function remove_br_tags($content)
{
	// Remove <br> tags
	$content = str_replace('<br>', '', $content);
	$content = str_replace('<br/>', '', $content);
	$content = str_replace('<br />', '', $content);
	$content = str_replace('Powered by TCPDF (www.tcpdf.org)', '', $content);
	$content = str_replace('1 / 1', '', $content);

	return $content;
}
