<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/latest-posts/index.php
 */
?>
<?php
function wrap_input($label, $input, $class)
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
		'<div class="wp-block-search__inside-wrapper %s">%s</div>',
		$class,
		$input
	);

	return sprintf(
		'<div>%s %s</div>',
		$label,
		$field_markup
	);
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
?>