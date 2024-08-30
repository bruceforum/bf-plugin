<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/latest-posts/index.php
 */
?>
<?php
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

function wrap_input($label, $input)
{
	$input_id = wp_unique_id('wp-block-search__input-');

	$label_inner_html = empty($label) ? __('Search') : $label;
	$label = new WP_HTML_Tag_Processor(sprintf('<label>%s</label>', $label_inner_html));
	if ($label->next_tag()) {
		$label->set_attribute('for', $input_id);
		$label->add_class('wp-block-search__label');
	}

	$input->set_attribute('id', $input_id);

	$field_markup = sprintf(
		'<div class="wp-block-search__inside-wrapper">%s</div>',
		$input
	);

	return $label . $field_markup;
}

function create_input_for($placeholder, $type, $name, $value)
{
	$input = new WP_HTML_Tag_Processor(sprintf('<input type="%s" name="%s" required />', $type, $name));
	if ($input->next_tag()) {
		$input->set_attribute('value', $value);
		$input->set_attribute('placeholder', $placeholder);
	}

	return $input;
}

function create_select_for($name, $value, $options)
{
	$options_html = array_reduce($options, function ($ax, $dx) use ($value) {
		if ($value === $dx) {
			return $ax . sprintf('<option selected>%s</option>', $dx);
		}
		return $ax . sprintf('<option>%s</option>', $dx);
	}, '');

	$select = new WP_HTML_Tag_Processor(sprintf('<select name="%s" required>%s</select>', $name, $options_html));

	return $select;
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

	$search_input = create_input_for($attributes['placeholder'], 'search', 'qls', get_query_var('qls'));
	$year_select = create_select_for('qlyear', '', get_posts_years_array());
	$sort_select = create_select_for('qlorderby', get_query_var('qlorderby', 'date'), ['date', 'title', 'relevance']);

	return sprintf(
		'<form role="search" method="get" action="%1$s">
			%2$s
			<div>
				%3$s
				%4$s
			</div>
			%5$s
			%6$s
		</form>',
		esc_url(home_url($wp->request)),
		create_category_input($attributes),
		wrap_input($attributes['label'], $search_input),
		create_search_button($attributes),
		wrap_input('Year', $year_select),
		wrap_input('Sort by', $sort_select)
	);
}

function render_category_search($attributes)
{
	return sprintf(
		'<div>%1$s %2$s</div>',
		render_category_search_input($attributes)
	);
}
?>