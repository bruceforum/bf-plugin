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

	$input = new WP_HTML_Tag_Processor(sprintf('<input type="search" name="s" required />'));
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

function render_category_search_results($attributes)
{
	global $post;

	$args = array(
		'posts_per_page'      => 7,
		'post_status'         => 'publish',
		'no_found_rows'       => true,
	);

	if (! empty($attributes['categories'])) {
		$args['category__in'] = array_column($attributes['categories'], 'id');
	}

	$query        = new WP_Query();
	$recent_posts = $query->query($args);

	$list_items_markup = '';

	foreach ($recent_posts as $post) {
		$post_link = esc_url(get_permalink($post));
		$title     = get_the_title($post);

		if (! $title) {
			$title = __('(no title)');
		}

		$list_items_markup .= '<li>';

		$list_items_markup .= sprintf(
			'<a class="wp-block-latest-posts__post-title" href="%1$s">%2$s</a>',
			esc_url($post_link),
			$title
		);

		$post_content = html_entity_decode($post->post_content, ENT_QUOTES, get_option('blog_charset'));

		if (post_password_required($post)) {
			$post_content = __('This content is password protected.');
		}

		$list_items_markup .= sprintf(
			'<div class="wp-block-latest-posts__post-full-content">%1$s</div>',
			wp_kses_post($post_content)
		);

		$list_items_markup .= "</li>\n";
	}

	$classes = array('wp-block-latest-posts__list');

	$wrapper_attributes = get_block_wrapper_attributes(array('class' => implode(' ', $classes)));

	return sprintf(
		'<ul %1$s>%2$s</ul>',
		$wrapper_attributes,
		$list_items_markup
	);
}

function render_category_search($attributes)
{
	return sprintf(
		'<div>%1s %2s</div>',
		render_category_search_input($attributes),
		render_category_search_results($attributes)
	);
}
?>