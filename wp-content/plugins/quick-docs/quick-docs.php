<?php

/**
 * Plugin Name:       Quick Docs
 * Description:       Generate documentation from previously added content pages Final Project Liepaja University.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Ninthujan
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       quick-docs
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Initializes the Quick Docs block.
 *
 * Registers the Quick Docs block type with WordPress so it can be used in the block editor.
 *
 * @since 1.0.0
 *
 * @return void
 */
function create_block_quick_docs_block_init()
{
	register_block_type(__DIR__ . '/build');
}

add_action('init', 'create_block_quick_docs_block_init');

/**
 * Generate short-code for the same functionality.
 *
 * @param array $attributes The short-code attributes. The content of the specified paragraph block,
 * or null if not found.
 */
function quick_docs_generate_shortcode($attributes)
{
	$args = shortcode_atts(
		array(
			'pg' => 0,
			'pr' => 0,
		),
		$attributes
	);

	$page = get_post($args['pg']);
	if (!$page) {
		return null;
	}

	$blocks           = parse_blocks($page->post_content);
	$paragraph_blocks = content_grabber_pro_filter_blocks($blocks, 'core/paragraph');
	$paragraph_index  = intval($args['pr']) - 1;

	return array_key_exists($paragraph_index, $paragraph_blocks) ? $paragraph_blocks[$paragraph_index]['innerHTML'] : null;
}

add_shortcode('quick-docs', 'quick_docs_generate_shortcode');

require 'post-type-changes.php';
require 'download-pdf.php';
