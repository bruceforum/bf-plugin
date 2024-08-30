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
	$vars[] = 'qlcat'; // As query-loop-category.
	$vars[] = 'qlorderby'; // As query-loop-orderby.
	$vars[] = 'qlyear'; // As query-loop-year.
    return $vars;
});

add_action( 'pre_get_posts', function( \WP_Query $q ) {
	echo 'HEY!' . is_admin();
	if (is_admin() || $q->is_main_query()) {
        return;
    }
	$qls = get_query_var('qls');
	$qlcat = get_query_var('qlcat');
	$qlorderby = get_query_var('qlorderby');
	$qlyear = get_query_var('qlyear');
    if ($q->is_search() && ':qls' === trim( $q->get( 's' ))) {
		if (!empty($qls)) {
        	$q->set('s', $qls);
		}
		if (!empty($qlcat)) {
        	$q->set('cat', $qlcat);
		}
		if (!empty($qlorderby)) {
			$q->set('orderby', $qlorderby);
		}
		if (!empty($qlyear)) {
			$q->set('year', $qlyear);
		}
    }
	return;
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
