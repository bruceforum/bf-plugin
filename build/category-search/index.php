<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/latest-posts/index.php
 */
?>
<?php
include '../utilities.php';

function get_posts_years_array()
{
	global $wpdb;
	$result = array();
	$years = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' GROUP BY YEAR(post_date) DESC"
		),
		ARRAY_N
	);
	if (is_array($years) && count($years) > 0) {
		foreach ($years as $year) {
			$result[] = strval($year[0]);
		}
	}
	return $result;
}

function create_category_input($attributes)
{
	$categories = '';

	if (!empty($attributes['categories'])) {
		$categories = array_reduce($attributes['categories'], function ($ax, $dx) {
			if (empty($ax)) {
				return $ax . (int)$dx['id'];
			}
			return $ax . ',' . (int)$dx['id'];
		}, $categories);
	}

	$input = new WP_HTML_Tag_Processor('<input type="hidden" name="qlcat" required />');
	if ($input->next_tag()) {
		$input->set_attribute('value', $categories);
	}

	return $input;
}

function create_search_button($attributes)
{
	$submit_button = '<button type="submit" class="wp-block-button wp-element-button">Search</button>';

	return $submit_button;
}

function render_category_search_input($attributes)
{
	global $wp;

	$year_options = array_merge(['all'], get_posts_years_array());

	$search_input = create_input_for($attributes['placeholder'], 'search', 'qls', get_query_var('qls'));
	$year_select = create_select_for('qlyear', get_query_var('qlyear', 'all'), $year_options);
	$sort_select = create_select_for('qlorderby', get_query_var('qlorderby', 'date'), ['date', 'title', 'relevance']);

	return sprintf(
		'<form role="search" method="get" action="%1$s">
			%2$s
			<div class="bb-search-wrapper">
				%3$s
				%4$s
			</div>
			<div class="bb-refine-wrapper">
				%5$s
				%6$s
			</div>
		</form>',
		esc_url(home_url($wp->request)),
		create_category_input($attributes),
		wrap_input($attributes['label'], $search_input, 'bb-search'),
		create_search_button($attributes),
		wrap_input('Year', $year_select, 'bb-year'),
		wrap_input('Sort by', $sort_select, 'bb-sort')
	);
}

function render_category_search($attributes)
{
	return sprintf(
		'<div>%1$s</div>',
		render_category_search_input($attributes)
	);
}
?>