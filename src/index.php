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
        if (!empty($value)) {
            $input->set_attribute('value', $value);
        }
        if (!empty($placeholder)) {
            $input->set_attribute('placeholder', $placeholder);
        }
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

function render_category_search($attributes)
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

function render_contact_form($attributes)
{
    $firstname_input = create_input_for('', "text", 'firstname', '');
    $lastname_input = create_input_for('', "text", 'lastname', '');
    $email_input = create_input_for('name@mycompany.com', "email", 'email', '');
    $phone_input = create_input_for('+1 235 454 6789', 'phone', 'phone', '');
    $summary_input = create_input_for('Ex : I need help with my account.', 'text', 'summary', '');
    $detail_input = create_input_for('Write down all the details here', 'text', 'detail', '');

    return sprintf(
        '<form role="contact">
            %1$s
            %2$s
            %3$s
            %4$s
            %5$s
            %6$s
		</form>',
        wrap_input('First Name', $firstname_input, ''),
        wrap_input('Last Name', $lastname_input, ''),
        wrap_input('Email', $$email_input, ''),
        wrap_input('Telephone number', $phone_input, ''),
        wrap_input('What is your request?', $summary_input, ''),
        wrap_input('How can we help you?', $detail_input, '')
    );
}
?>