<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package PDT.AI
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pdtai_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add a class if dark mode is active
    if ( isset( $_COOKIE['pdtai_dark_mode'] ) && $_COOKIE['pdtai_dark_mode'] === 'true' ) {
        $classes[] = 'dark-mode';
    }

    return $classes;
}
add_filter( 'body_class', 'pdtai_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pdtai_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'pdtai_pingback_header' );

/**
 * Fallback for primary menu
 */
function pdtai_primary_menu_fallback() {
    if ( current_user_can( 'edit_theme_options' ) ) {
        echo '<ul class="menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Create a Menu', 'oralcancerpdt' ) . '</a></li>';
        echo '</ul>';
    }
}

/**
 * Display posted date
 */
function pdtai_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x( 'Posted on %s', 'post date', 'oralcancerpdt' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display post author
 */
function pdtai_posted_by() {
    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x( 'by %s', 'post author', 'oralcancerpdt' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display entry footer with categories, tags, comments and edit links
 */
function pdtai_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'oralcancerpdt' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'oralcancerpdt' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'oralcancerpdt' ) );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'oralcancerpdt' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'oralcancerpdt' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __( 'Edit <span class="screen-reader-text">%s</span>', 'oralcancerpdt' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            wp_kses_post( get_the_title() )
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

/**
 * Generate Schema.org structured data
 */
function pdtai_generate_schema_org() {
    // Organization schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'MedicalOrganization',
        'name' => get_bloginfo('name'),
        'url' => home_url(),
        'logo' => get_custom_logo_url(),
        'description' => get_bloginfo('description'),
    );
    
    // Add address if available
    $address = get_option('pdtai_clinic_address', '');
    if (!empty($address)) {
        $schema['address'] = array(
            '@type' => 'PostalAddress',
            'streetAddress' => $address,
        );
    }
    
    // Add contact info if available
    $phone = get_option('pdtai_phone_number', '');
    if (!empty($phone)) {
        $schema['telephone'] = $phone;
    }
    
    $email = get_option('pdtai_email_address', '');
    if (!empty($email)) {
        $schema['email'] = $email;
    }
    
    // Add medical specialty
    $schema['medicalSpecialty'] = array(
        '@type' => 'MedicalSpecialty',
        'name' => 'Oncology',
    );
    
    // Add opening hours if available
    $hours = get_option('pdtai_clinic_hours', '');
    if (!empty($hours)) {
        // This is a simplified version - in a real implementation, you would parse the hours
        // into the proper openingHoursSpecification format
        $schema['openingHoursSpecification'] = array(
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
            'opens' => '09:00',
            'closes' => '17:00',
        );
    }
    
    return apply_filters('pdtai_schema_org', $schema);
}

/**
 * Get custom logo URL
 */
function get_custom_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if ($logo) {
        return $logo[0];
    }
    return '';
}

/**
 * Output schema.org JSON-LD
 */
function pdtai_output_schema_org() {
    $schema = pdtai_generate_schema_org();
    if (!empty($schema)) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'pdtai_output_schema_org');

/**
 * Generate treatment schema for PDT pages
 */
function pdtai_generate_treatment_schema() {
    if (is_page() && has_tag('pdt-treatment')) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'MedicalProcedure',
            'name' => 'Photodynamic Therapy for Oral Cancer',
            'procedureType' => 'Therapeutic Procedure',
            'description' => 'Photodynamic Therapy (PDT) is a minimally invasive treatment that combines light-sensitive medications with specific wavelengths of light to destroy cancer cells.',
            'bodyLocation' => 'Oral Cavity',
            'preparation' => 'Application of photosensitizing agent to the treatment area.',
            'followup' => 'Regular follow-up appointments to monitor healing and treatment effectiveness.',
            'howPerformed' => 'The procedure involves applying a photosensitizing agent to the affected area, waiting for it to accumulate in cancer cells, then activating it with a specific wavelength of light.',
            'status' => 'Available',
            'relevantSpecialty' => array(
                '@type' => 'MedicalSpecialty',
                'name' => 'Oncology',
            ),
            'recognizingAuthority' => array(
                '@type' => 'Organization',
                'name' => 'International Photodynamic Association',
            ),
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'pdtai_generate_treatment_schema');

/**
 * Add custom image sizes
 */
function pdtai_add_image_sizes() {
    add_image_size('team-thumbnail', 300, 300, true); // For team members
    add_image_size('service-thumbnail', 600, 400, true); // For services
    add_image_size('hero-image', 1600, 800, true); // For hero section
}
add_action('after_setup_theme', 'pdtai_add_image_sizes');

/**
 * Custom excerpt length
 */
function pdtai_custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'pdtai_custom_excerpt_length');

/**
 * Custom excerpt more
 */
function pdtai_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'pdtai_custom_excerpt_more');

/**
 * Add custom query vars for filtering
 */
function pdtai_add_query_vars($vars) {
    $vars[] = 'treatment_type';
    return $vars;
}
add_filter('query_vars', 'pdtai_add_query_vars');

/**
 * Modify main query for custom post types
 */
function pdtai_modify_main_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        // For services archive
        if (is_post_type_archive('service')) {
            $query->set('posts_per_page', 9);
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
            
            // Filter by treatment type if set
            if (get_query_var('treatment_type')) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'treatment_type',
                        'field' => 'slug',
                        'terms' => get_query_var('treatment_type'),
                    ),
                ));
            }
        }
        
        // For team members archive
        if (is_post_type_archive('team_member')) {
            $query->set('posts_per_page', -1);
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
        }
        
        // For research archive
        if (is_post_type_archive('research')) {
            $query->set('posts_per_page', 10);
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'pdtai_modify_main_query');

/**
 * Add custom classes to navigation menu items
 */
function pdtai_nav_menu_css_class($classes, $item) {
    // Add has-children class to parent menu items
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'has-dropdown';
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'pdtai_nav_menu_css_class', 10, 2);

/**
 * Add SVG to allowed mime types
 */
function pdtai_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'pdtai_allow_svg_upload');

/**
 * Add responsive container to embeds
 */
function pdtai_responsive_embeds($html) {
    return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'pdtai_responsive_embeds', 10, 3);

/**
 * Add custom image attributes for better accessibility
 */
function pdtai_image_attributes($attr, $attachment) {
    // Add loading="lazy" to images
    $attr['loading'] = 'lazy';
    
    // If no alt text is set, use the image title
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title($attachment->ID);
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'pdtai_image_attributes', 10, 2);