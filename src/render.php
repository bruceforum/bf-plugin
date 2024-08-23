<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
function render_category_search( $attributes ) {
	global $post;


	if ( ! empty( $attributes['categories'] ) ) {
		$args['category__in'] = array_column( $attributes['categories'], 'id' );
	}

	$query        = new WP_Query();
	$recent_posts = $query->query( $args );

	$list_items_markup = '';

	foreach ( $recent_posts as $post ) {
		$post_link = esc_url( get_permalink( $post ) );
		$title     = get_the_title( $post );

		if ( ! $title ) {
			$title = __( '(no title)' );
		}

		$list_items_markup .= '<li>';

		$list_items_markup .= sprintf(
			'<a class="wp-block-latest-posts__post-title" href="%1$s">%2$s</a>',
			esc_url( $post_link ),
			$title
		);

		$post_content = html_entity_decode( $post->post_content, ENT_QUOTES, get_option( 'blog_charset' ) );

		if ( post_password_required( $post ) ) {
			$post_content = __( 'This content is password protected.' );
		}

		$list_items_markup .= sprintf(
			'<div class="wp-block-latest-posts__post-full-content">%1$s</div>',
			wp_kses_post( $post_content )
		);

		$list_items_markup .= "</li>\n";
	}

	remove_filter( 'excerpt_length', 'block_core_latest_posts_get_excerpt_length', 20 );

	$classes = array( 'wp-block-latest-posts__list' );

	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

	return sprintf(
		'<ul %1$s>%2$s</ul>',
		$wrapper_attributes,
		$list_items_markup
	);
}
?>
<?php esc_html_e(render_category_search($attributes)); ?>