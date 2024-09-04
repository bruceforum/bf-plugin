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

include __DIR__ . '/build/category-search/index.php';
include __DIR__ . '/build/contact-form/index.php';

add_filter('query_vars', function ($vars) {
    $vars[] = 'qls'; // As query-loop-search.
	$vars[] = 'qlcat'; // As query-loop-category.
	$vars[] = 'qlorderby'; // As query-loop-orderby.
	$vars[] = 'qlyear'; // As query-loop-year.
    return $vars;
});

add_action( 'pre_get_posts', function( \WP_Query $q ) {
    if ($q->is_search() && ':qls' === trim( $q->get( 's' ))) {
		$qlyear = get_query_var('qlyear');
		$q->set('s', get_query_var('qls'));
		$q->set('cat', get_query_var('qlcat'));
		$q->set('orderby', get_query_var('qlorderby'));
		$q->set('year', $qlyear === 'all' ? '' : $qlyear);
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
		__DIR__ . '/build/category-search',
		array(
			'render_callback' => 'render_category_search',
		)
	);
	register_block_type(
		__DIR__ . '/build/contact-form',
		array(
			'render_callback' => 'render_contact_form',
		)
	);
}
add_action('init', 'create_block_bruceblocks_block_init');
