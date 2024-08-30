<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/latest-posts/index.php
 */
?>
<?php
function create_input_for($label, $placeholder, $name, $value)
{
	if (empty($value)) {
		$value = get_query_var($name, '');
	}
	$input_id = wp_unique_id('wp-block-search__input-');

	$label_inner_html = empty($attributes['label']) ? __('Search') : $label;
	$label = new WP_HTML_Tag_Processor(sprintf('<label>%1$s</label>', $label_inner_html));
	if ($label->next_tag()) {
		$label->set_attribute('for', $input_id);
		$label->add_class('wp-block-search__label');
	}

	$input = new WP_HTML_Tag_Processor(sprintf('<input type="search" name="%s" required />'), $name);
	if ($input->next_tag()) {
		$input->set_attribute('id', $input_id);
		$input->set_attribute('value', $value);
		$input->set_attribute('placeholder', $placeholder);
	}
	
	$field_markup = sprintf(
		'<div class="wp-block-search__inside-wrapper">%s</div>',
		$input
	);

	return $label . $field_markup;
}

function render_category_search_input($attributes)
{
	global $wp;
	$categories = ''; 

	if (!empty($attributes['categories'])) {
		$categories = array_reduce($attributes['categories'], function ($ax, $dx) {
			return $ax + (string)$dx['id'];
		}, $categories);  // Returns 10
	}

	$search_input = create_input_for(wp_kses_post($attributes['label']), $attributes['placeholder'], 'qls');
	$category_input = create_input_for('Categories', 'Categories', 'qlcat', $categories);

	return sprintf(
		'<form role="search" method="get" action="%1$s">%2$s</form>',
		esc_url(home_url($wp->request)),
		$search_input . $category_input
	);
}

function render_category_search_debug($attributes)
{
	return sprintf(
		'<pre>%s</pre>',
		json_encode($attributes)
	);
}

function render_category_search($attributes)
{
	return sprintf(
		'<div>%1$s %2$s</div>',
		render_category_search_input($attributes),
		render_category_search_debug($attributes)
	);
}
?>