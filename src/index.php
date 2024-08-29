<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/latest-posts/index.php
 */
?>
<?php
function render_category_search_input($attributes)
{
	$input_id = wp_unique_id('wp-block-search__input-');

	$label_inner_html = empty($attributes['label']) ? __('Search') : wp_kses_post($attributes['label']);
	$label = new WP_HTML_Tag_Processor(sprintf('<label>%1$s</label>', $label_inner_html));
	if ($label->next_tag()) {
		$label->set_attribute('for', $input_id);
		$label->add_class('wp-block-search__label');
	}

	$input = new WP_HTML_Tag_Processor(sprintf('<input type="search" name="qls" required />'));
	if ($input->next_tag()) {
		$input->set_attribute('id', $input_id);
		$input->set_attribute('value', get_search_query());
		$input->set_attribute('placeholder', $attributes['placeholder']);
	}

	$field_markup = sprintf(
		'<div class="wp-block-search__inside-wrapper %s" %s>%s</div>',
		$input
	);

	return sprintf(
		'<form role="search" method="get" action="%1s">%2s</form>',
		esc_url(home_url('/')),
		$label . $field_markup
	);
}

function render_category_search_debug()
{
	return sprintf(
		'<ul>
			<li>
				%1s
			</li>
		</ul>',
		get_query_var('qls', 'no query'),
	);
}

function render_category_search($attributes)
{
	return sprintf(
		'<div>%1s %2s</div>',
		render_category_search_input($attributes),
		render_category_search_debug()
	);
}
?>