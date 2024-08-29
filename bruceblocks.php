<?php

/**
 * Plugin Name:       Bruceblocks
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bruceblocks
 *
 * @package CreateBlock
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

include __DIR__ . '/build/index.php';

add_filter('query_vars', function ($vars) {
    $vars[] = 'qls'; // As query-loop-search.
    return $vars;
});

add_action( 'pre_get_posts', function( \WP_Query $q ) {
	$qls = get_query_var('qls');
    if (empty( $qls )) {
        return;
    }
    if ( $q->is_search() ) {
        $q->set( 's', $qls );
    }
} );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_bruceblocks_block_init()
{
	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'render_category_search',
		)
	);
}
add_action('init', 'create_block_bruceblocks_block_init');
