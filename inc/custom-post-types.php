<?php
/**
 * Custom Post Types and Taxonomies for PDT.AI Theme
 *
 * @package PDT.AI
 */

/**
 * Register custom post types
 */
function pdtai_register_post_types() {
    // Services CPT
    register_post_type('service', array(
        'labels' => array(
            'name'               => _x('Services', 'post type general name', 'oralcancerpdt'),
            'singular_name'      => _x('Service', 'post type singular name', 'oralcancerpdt'),
            'menu_name'          => _x('Services', 'admin menu', 'oralcancerpdt'),
            'name_admin_bar'     => _x('Service', 'add new on admin bar', 'oralcancerpdt'),
            'add_new'            => _x('Add New', 'service', 'oralcancerpdt'),
            'add_new_item'       => __('Add New Service', 'oralcancerpdt'),
            'new_item'           => __('New Service', 'oralcancerpdt'),
            'edit_item'          => __('Edit Service', 'oralcancerpdt'),
            'view_item'          => __('View Service', 'oralcancerpdt'),
            'all_items'          => __('All Services', 'oralcancerpdt'),
            'search_items'       => __('Search Services', 'oralcancerpdt'),
            'parent_item_colon'  => __('Parent Services:', 'oralcancerpdt'),
            'not_found'          => __('No services found.', 'oralcancerpdt'),
            'not_found_in_trash' => __('No services found in Trash.', 'oralcancerpdt')
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-clipboard',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'services'),
        'query_var'           => true,
        'show_in_rest'        => true,
    ));

    // Team Members CPT
    register_post_type('team_member', array(
        'labels' => array(
            'name'               => _x('Team Members', 'post type general name', 'oralcancerpdt'),
            'singular_name'      => _x('Team Member', 'post type singular name', 'oralcancerpdt'),
            'menu_name'          => _x('Team', 'admin menu', 'oralcancerpdt'),
            'name_admin_bar'     => _x('Team Member', 'add new on admin bar', 'oralcancerpdt'),
            'add_new'            => _x('Add New', 'team member', 'oralcancerpdt'),
            'add_new_item'       => __('Add New Team Member', 'oralcancerpdt'),
            'new_item'           => __('New Team Member', 'oralcancerpdt'),
            'edit_item'          => __('Edit Team Member', 'oralcancerpdt'),
            'view_item'          => __('View Team Member', 'oralcancerpdt'),
            'all_items'          => __('All Team Members', 'oralcancerpdt'),
            'search_items'       => __('Search Team Members', 'oralcancerpdt'),
            'parent_item_colon'  => __('Parent Team Members:', 'oralcancerpdt'),
            'not_found'          => __('No team members found.', 'oralcancerpdt'),
            'not_found_in_trash' => __('No team members found in Trash.', 'oralcancerpdt')
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-groups',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'team'),
        'query_var'           => true,
        'show_in_rest'        => true,
    ));

    // Research Publications CPT
    register_post_type('research', array(
        'labels' => array(
            'name'               => _x('Research', 'post type general name', 'oralcancerpdt'),
            'singular_name'      => _x('Research', 'post type singular name', 'oralcancerpdt'),
            'menu_name'          => _x('Research', 'admin menu', 'oralcancerpdt'),
            'name_admin_bar'     => _x('Research', 'add new on admin bar', 'oralcancerpdt'),
            'add_new'            => _x('Add New', 'research', 'oralcancerpdt'),
            'add_new_item'       => __('Add New Research', 'oralcancerpdt'),
            'new_item'           => __('New Research', 'oralcancerpdt'),
            'edit_item'          => __('Edit Research', 'oralcancerpdt'),
            'view_item'          => __('View Research', 'oralcancerpdt'),
            'all_items'          => __('All Research', 'oralcancerpdt'),
            'search_items'       => __('Search Research', 'oralcancerpdt'),
            'parent_item_colon'  => __('Parent Research:', 'oralcancerpdt'),
            'not_found'          => __('No research found.', 'oralcancerpdt'),
            'not_found_in_trash' => __('No research found in Trash.', 'oralcancerpdt')
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-media-document',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'research'),
        'query_var'           => true,
        'show_in_rest'        => true,
    ));

    // Testimonials CPT
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => _x('Testimonials', 'post type general name', 'oralcancerpdt'),
            'singular_name'      => _x('Testimonial', 'post type singular name', 'oralcancerpdt'),
            'menu_name'          => _x('Testimonials', 'admin menu', 'oralcancerpdt'),
            'name_admin_bar'     => _x('Testimonial', 'add new on admin bar', 'oralcancerpdt'),
            'add_new'            => _x('Add New', 'testimonial', 'oralcancerpdt'),
            'add_new_item'       => __('Add New Testimonial', 'oralcancerpdt'),
            'new_item'           => __('New Testimonial', 'oralcancerpdt'),
            'edit_item'          => __('Edit Testimonial', 'oralcancerpdt'),
            'view_item'          => __('View Testimonial', 'oralcancerpdt'),
            'all_items'          => __('All Testimonials', 'oralcancerpdt'),
            'search_items'       => __('Search Testimonials', 'oralcancerpdt'),
            'parent_item_colon'  => __('Parent Testimonials:', 'oralcancerpdt'),
            'not_found'          => __('No testimonials found.', 'oralcancerpdt'),
            'not_found_in_trash' => __('No testimonials found in Trash.', 'oralcancerpdt')
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 23,
        'menu_icon'           => 'dashicons-format-quote',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'testimonials'),
        'query_var'           => true,
        'show_in_rest'        => true,
    ));

    // FAQs CPT
    register_post_type('faq', array(
        'labels' => array(
            'name'               => _x('FAQs', 'post type general name', 'oralcancerpdt'),
            'singular_name'      => _x('FAQ', 'post type singular name', 'oralcancerpdt'),
            'menu_name'          => _x('FAQs', 'admin menu', 'oralcancerpdt'),
            'name_admin_bar'     => _x('FAQ', 'add new on admin bar', 'oralcancerpdt'),
            'add_new'            => _x('Add New', 'faq', 'oralcancerpdt'),
            'add_new_item'       => __('Add New FAQ', 'oralcancerpdt'),
            'new_item'           => __('New FAQ', 'oralcancerpdt'),
            'edit_item'          => __('Edit FAQ', 'oralcancerpdt'),
            'view_item'          => __('View FAQ', 'oralcancerpdt'),
            'all_items'          => __('All FAQs', 'oralcancerpdt'),
            'search_items'       => __('Search FAQs', 'oralcancerpdt'),
            'parent_item_colon'  => __('Parent FAQs:', 'oralcancerpdt'),
            'not_found'          => __('No FAQs found.', 'oralcancerpdt'),
            'not_found_in_trash' => __('No FAQs found in Trash.', 'oralcancerpdt')
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 24,
        'menu_icon'           => 'dashicons-editor-help',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'page-attributes'),
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'faqs'),
        'query_var'           => true,
        'show_in_rest'        => true,
    ));
}
add_action('init', 'pdtai_register_post_types');

/**
 * Register custom taxonomies
 */
function pdtai_register_taxonomies() {
    // Treatment Type Taxonomy for Services
    register_taxonomy('treatment_type', 'service', array(
        'labels' => array(
            'name'              => _x('Treatment Types', 'taxonomy general name', 'oralcancerpdt'),
            'singular_name'     => _x('Treatment Type', 'taxonomy singular name', 'oralcancerpdt'),
            'search_items'      => __('Search Treatment Types', 'oralcancerpdt'),
            'all_items'         => __('All Treatment Types', 'oralcancerpdt'),
            'parent_item'       => __('Parent Treatment Type', 'oralcancerpdt'),
            'parent_item_colon' => __('Parent Treatment Type:', 'oralcancerpdt'),
            'edit_item'         => __('Edit Treatment Type', 'oralcancerpdt'),
            'update_item'       => __('Update Treatment Type', 'oralcancerpdt'),
            'add_new_item'      => __('Add New Treatment Type', 'oralcancerpdt'),
            'new_item_name'     => __('New Treatment Type Name', 'oralcancerpdt'),
            'menu_name'         => __('Treatment Types', 'oralcancerpdt'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'treatment-type'),
        'show_in_rest'      => true,
    ));

    // Team Role Taxonomy for Team Members
    register_taxonomy('team_role', 'team_member', array(
        'labels' => array(
            'name'              => _x('Team Roles', 'taxonomy general name', 'oralcancerpdt'),
            'singular_name'     => _x('Team Role', 'taxonomy singular name', 'oralcancerpdt'),
            'search_items'      => __('Search Team Roles', 'oralcancerpdt'),
            'all_items'         => __('All Team Roles', 'oralcancerpdt'),
            'parent_item'       => __('Parent Team Role', 'oralcancerpdt'),
            'parent_item_colon' => __('Parent Team Role:', 'oralcancerpdt'),
            'edit_item'         => __('Edit Team Role', 'oralcancerpdt'),
            'update_item'       => __('Update Team Role', 'oralcancerpdt'),
            'add_new_item'      => __('Add New Team Role', 'oralcancerpdt'),
            'new_item_name'     => __('New Team Role Name', 'oralcancerpdt'),
            'menu_name'         => __('Team Roles', 'oralcancerpdt'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'team-role'),
        'show_in_rest'      => true,
    ));

    // Research Category Taxonomy
    register_taxonomy('research_category', 'research', array(
        'labels' => array(
            'name'              => _x('Research Categories', 'taxonomy general name', 'oralcancerpdt'),
            'singular_name'     => _x('Research Category', 'taxonomy singular name', 'oralcancerpdt'),
            'search_items'      => __('Search Research Categories', 'oralcancerpdt'),
            'all_items'         => __('All Research Categories', 'oralcancerpdt'),
            'parent_item'       => __('Parent Research Category', 'oralcancerpdt'),
            'parent_item_colon' => __('Parent Research Category:', 'oralcancerpdt'),
            'edit_item'         => __('Edit Research Category', 'oralcancerpdt'),
            'update_item'       => __('Update Research Category', 'oralcancerpdt'),
            'add_new_item'      => __('Add New Research Category', 'oralcancerpdt'),
            'new_item_name'     => __('New Research Category Name', 'oralcancerpdt'),
            'menu_name'         => __('Research Categories', 'oralcancerpdt'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'research-category'),
        'show_in_rest'      => true,
    ));

    // FAQ Category Taxonomy
    register_taxonomy('faq_category', 'faq', array(
        'labels' => array(
            'name'              => _x('FAQ Categories', 'taxonomy general name', 'oralcancerpdt'),
            'singular_name'     => _x('FAQ Category', 'taxonomy singular name', 'oralcancerpdt'),
            'search_items'      => __('Search FAQ Categories', 'oralcancerpdt'),
            'all_items'         => __('All FAQ Categories', 'oralcancerpdt'),
            'parent_item'       => __('Parent FAQ Category', 'oralcancerpdt'),
            'parent_item_colon' => __('Parent FAQ Category:', 'oralcancerpdt'),
            'edit_item'         => __('Edit FAQ Category', 'oralcancerpdt'),
            'update_item'       => __('Update FAQ Category', 'oralcancerpdt'),
            'add_new_item'      => __('Add New FAQ Category', 'oralcancerpdt'),
            'new_item_name'     => __('New FAQ Category Name', 'oralcancerpdt'),
            'menu_name'         => __('FAQ Categories', 'oralcancerpdt'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'faq-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'pdtai_register_taxonomies');

/**
 * Add meta boxes for custom post types
 */
function pdtai_add_meta_boxes() {
    // Team Member Meta Box
    add_meta_box(
        'pdtai_team_member_details',
        __('Team Member Details', 'oralcancerpdt'),
        'pdtai_team_member_meta_box_callback',
        'team_member',
        'normal',
        'high'
    );

    // Research Publication Meta Box
    add_meta_box(
        'pdtai_research_details',
        __('Research Publication Details', 'oralcancerpdt'),
        'pdtai_research_meta_box_callback',
        'research',
        'normal',
        'high'
    );

    // Service Meta Box
    add_meta_box(
        'pdtai_service_details',
        __('Service Details', 'oralcancerpdt'),
        'pdtai_service_meta_box_callback',
        'service',
        'normal',
        'high'
    );

    // Testimonial Meta Box
    add_meta_box(
        'pdtai_testimonial_details',
        __('Testimonial Details', 'oralcancerpdt'),
        'pdtai_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pdtai_add_meta_boxes');

/**
 * Team Member Meta Box Callback
 */
function pdtai_team_member_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('pdtai_team_member_meta_box', 'pdtai_team_member_meta_box_nonce');

    // Get current values
    $position = get_post_meta($post->ID, '_pdtai_team_position', true);
    $email = get_post_meta($post->ID, '_pdtai_team_email', true);
    $phone = get_post_meta($post->ID, '_pdtai_team_phone', true);
    $social_linkedin = get_post_meta($post->ID, '_pdtai_team_linkedin', true);
    $social_twitter = get_post_meta($post->ID, '_pdtai_team_twitter', true);
    $social_researchgate = get_post_meta($post->ID, '_pdtai_team_researchgate', true);
    $education = get_post_meta($post->ID, '_pdtai_team_education', true);
    $specialties = get_post_meta($post->ID, '_pdtai_team_specialties', true);
    
    // Output fields
    echo '<p>';
    echo '<label for="pdtai_team_position">' . __('Position/Title', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_team_position" name="pdtai_team_position" value="' . esc_attr($position) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_email">' . __('Email Address', 'oralcancerpdt') . '</label><br />';
    echo '<input type="email" id="pdtai_team_email" name="pdtai_team_email" value="' . esc_attr($email) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_phone">' . __('Phone Number', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_team_phone" name="pdtai_team_phone" value="' . esc_attr($phone) . '" size="40" />';
    echo '</p>';
    
    echo '<h4>' . __('Social Media', 'oralcancerpdt') . '</h4>';
    
    echo '<p>';
    echo '<label for="pdtai_team_linkedin">' . __('LinkedIn Profile URL', 'oralcancerpdt') . '</label><br />';
    echo '<input type="url" id="pdtai_team_linkedin" name="pdtai_team_linkedin" value="' . esc_attr($social_linkedin) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_twitter">' . __('Twitter/X Profile URL', 'oralcancerpdt') . '</label><br />';
    echo '<input type="url" id="pdtai_team_twitter" name="pdtai_team_twitter" value="' . esc_attr($social_twitter) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_researchgate">' . __('ResearchGate Profile URL', 'oralcancerpdt') . '</label><br />';
    echo '<input type="url" id="pdtai_team_researchgate" name="pdtai_team_researchgate" value="' . esc_attr($social_researchgate) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_education">' . __('Education (one per line)', 'oralcancerpdt') . '</label><br />';
    echo '<textarea id="pdtai_team_education" name="pdtai_team_education" rows="4" cols="40">' . esc_textarea($education) . '</textarea>';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_team_specialties">' . __('Specialties (one per line)', 'oralcancerpdt') . '</label><br />';
    echo '<textarea id="pdtai_team_specialties" name="pdtai_team_specialties" rows="4" cols="40">' . esc_textarea($specialties) . '</textarea>';
    echo '</p>';
}

/**
 * Research Publication Meta Box Callback
 */
function pdtai_research_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('pdtai_research_meta_box', 'pdtai_research_meta_box_nonce');

    // Get current values
    $authors = get_post_meta($post->ID, '_pdtai_research_authors', true);
    $journal = get_post_meta($post->ID, '_pdtai_research_journal', true);
    $publication_date = get_post_meta($post->ID, '_pdtai_research_date', true);
    $doi = get_post_meta($post->ID, '_pdtai_research_doi', true);
    $pubmed_id = get_post_meta($post->ID, '_pdtai_research_pubmed_id', true);
    $external_url = get_post_meta($post->ID, '_pdtai_research_url', true);
    
    // Output fields
    echo '<p>';
    echo '<label for="pdtai_research_authors">' . __('Authors (format: Last Name, First Initial. et al.)', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_research_authors" name="pdtai_research_authors" value="' . esc_attr($authors) . '" size="60" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_research_journal">' . __('Journal/Publication', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_research_journal" name="pdtai_research_journal" value="' . esc_attr($journal) . '" size="60" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_research_date">' . __('Publication Date', 'oralcancerpdt') . '</label><br />';
    echo '<input type="date" id="pdtai_research_date" name="pdtai_research_date" value="' . esc_attr($publication_date) . '" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_research_doi">' . __('DOI', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_research_doi" name="pdtai_research_doi" value="' . esc_attr($doi) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_research_pubmed_id">' . __('PubMed ID', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_research_pubmed_id" name="pdtai_research_pubmed_id" value="' . esc_attr($pubmed_id) . '" size="20" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_research_url">' . __('External URL', 'oralcancerpdt') . '</label><br />';
    echo '<input type="url" id="pdtai_research_url" name="pdtai_research_url" value="' . esc_attr($external_url) . '" size="60" />';
    echo '</p>';
}

/**
 * Service Meta Box Callback
 */
function pdtai_service_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('pdtai_service_meta_box', 'pdtai_service_meta_box_nonce');

    // Get current values
    $icon = get_post_meta($post->ID, '_pdtai_service_icon', true);
    $duration = get_post_meta($post->ID, '_pdtai_service_duration', true);
    $price = get_post_meta($post->ID, '_pdtai_service_price', true);
    $cta_text = get_post_meta($post->ID, '_pdtai_service_cta_text', true);
    $cta_url = get_post_meta($post->ID, '_pdtai_service_cta_url', true);
    
    // Output fields
    echo '<p>';
    echo '<label for="pdtai_service_icon">' . __('Icon Class (e.g., "fa-solid fa-tooth")', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_service_icon" name="pdtai_service_icon" value="' . esc_attr($icon) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_service_duration">' . __('Treatment Duration', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_service_duration" name="pdtai_service_duration" value="' . esc_attr($duration) . '" size="40" placeholder="e.g., 30-45 minutes" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_service_price">' . __('Price/Cost', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_service_price" name="pdtai_service_price" value="' . esc_attr($price) . '" size="40" placeholder="e.g., ৳5000 or Contact for pricing" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_service_cta_text">' . __('Call to Action Text', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_service_cta_text" name="pdtai_service_cta_text" value="' . esc_attr($cta_text) . '" size="40" placeholder="e.g., Book Appointment" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_service_cta_url">' . __('Call to Action URL', 'oralcancerpdt') . '</label><br />';
    echo '<input type="url" id="pdtai_service_cta_url" name="pdtai_service_cta_url" value="' . esc_attr($cta_url) . '" size="60" placeholder="e.g., /contact or /book-appointment" />';
    echo '</p>';
}

/**
 * Testimonial Meta Box Callback
 */
function pdtai_testimonial_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('pdtai_testimonial_meta_box', 'pdtai_testimonial_meta_box_nonce');

    // Get current values
    $client_name = get_post_meta($post->ID, '_pdtai_testimonial_client_name', true);
    $client_title = get_post_meta($post->ID, '_pdtai_testimonial_client_title', true);
    $rating = get_post_meta($post->ID, '_pdtai_testimonial_rating', true);
    $treatment_type = get_post_meta($post->ID, '_pdtai_testimonial_treatment_type', true);
    
    // Output fields
    echo '<p>';
    echo '<label for="pdtai_testimonial_client_name">' . __('Client Name', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_testimonial_client_name" name="pdtai_testimonial_client_name" value="' . esc_attr($client_name) . '" size="40" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_testimonial_client_title">' . __('Client Title/Location', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_testimonial_client_title" name="pdtai_testimonial_client_title" value="' . esc_attr($client_title) . '" size="40" placeholder="e.g., Patient from Dhaka" />';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_testimonial_rating">' . __('Rating (1-5)', 'oralcancerpdt') . '</label><br />';
    echo '<select id="pdtai_testimonial_rating" name="pdtai_testimonial_rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . '</option>';
    }
    echo '</select>';
    echo '</p>';
    
    echo '<p>';
    echo '<label for="pdtai_testimonial_treatment_type">' . __('Treatment Type', 'oralcancerpdt') . '</label><br />';
    echo '<input type="text" id="pdtai_testimonial_treatment_type" name="pdtai_testimonial_treatment_type" value="' . esc_attr($treatment_type) . '" size="40" placeholder="e.g., Oral Cancer PDT" />';
    echo '</p>';
}

/**
 * Save meta box data
 */
function pdtai_save_meta_box_data($post_id) {
    // Check if our nonce is set for each post type
    $nonces = array(
        'pdtai_team_member_meta_box_nonce' => 'pdtai_team_member_meta_box',
        'pdtai_research_meta_box_nonce' => 'pdtai_research_meta_box',
        'pdtai_service_meta_box_nonce' => 'pdtai_service_meta_box',
        'pdtai_testimonial_meta_box_nonce' => 'pdtai_testimonial_meta_box'
    );
    
    $nonce_verified = false;
    foreach ($nonces as $nonce_field => $nonce_action) {
        if (isset($_POST[$nonce_field]) && wp_verify_nonce($_POST[$nonce_field], $nonce_action)) {
            $nonce_verified = true;
            break;
        }
    }
    
    if (!$nonce_verified) {
        return;
    }

    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (isset($_POST['post_type'])) {
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
    }

    // Team Member fields
    $team_fields = array(
        'pdtai_team_position' => '_pdtai_team_position',
        'pdtai_team_email' => '_pdtai_team_email',
        'pdtai_team_phone' => '_pdtai_team_phone',
        'pdtai_team_linkedin' => '_pdtai_team_linkedin',
        'pdtai_team_twitter' => '_pdtai_team_twitter',
        'pdtai_team_researchgate' => '_pdtai_team_researchgate',
        'pdtai_team_education' => '_pdtai_team_education',
        'pdtai_team_specialties' => '_pdtai_team_specialties'
    );
    
    foreach ($team_fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Research fields
    $research_fields = array(
        'pdtai_research_authors' => '_pdtai_research_authors',
        'pdtai_research_journal' => '_pdtai_research_journal',
        'pdtai_research_date' => '_pdtai_research_date',
        'pdtai_research_doi' => '_pdtai_research_doi',
        'pdtai_research_pubmed_id' => '_pdtai_research_pubmed_id',
        'pdtai_research_url' => '_pdtai_research_url'
    );
    
    foreach ($research_fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Service fields
    $service_fields = array(
        'pdtai_service_icon' => '_pdtai_service_icon',
        'pdtai_service_duration' => '_pdtai_service_duration',
        'pdtai_service_price' => '_pdtai_service_price',
        'pdtai_service_cta_text' => '_pdtai_service_cta_text',
        'pdtai_service_cta_url' => '_pdtai_service_cta_url'
    );
    
    foreach ($service_fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Testimonial fields
    $testimonial_fields = array(
        'pdtai_testimonial_client_name' => '_pdtai_testimonial_client_name',
        'pdtai_testimonial_client_title' => '_pdtai_testimonial_client_title',
        'pdtai_testimonial_rating' => '_pdtai_testimonial_rating',
        'pdtai_testimonial_treatment_type' => '_pdtai_testimonial_treatment_type'
    );
    
    foreach ($testimonial_fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'pdtai_save_meta_box_data');

/**
 * Add columns to admin list tables
 */
function pdtai_add_custom_columns($columns) {
    $post_type = get_current_screen()->post_type;
    
    switch ($post_type) {
        case 'team_member':
            $columns['position'] = __('Position', 'oralcancerpdt');
            $columns['team_role'] = __('Role', 'oralcancerpdt');
            break;
            
        case 'service':
            $columns['treatment_type'] = __('Treatment Type', 'oralcancerpdt');
            $columns['price'] = __('Price', 'oralcancerpdt');
            break;
            
        case 'research':
            $columns['authors'] = __('Authors', 'oralcancerpdt');
            $columns['journal'] = __('Journal', 'oralcancerpdt');
            $columns['pub_date'] = __('Publication Date', 'oralcancerpdt');
            break;
            
        case 'testimonial':
            $columns['client'] = __('Client', 'oralcancerpdt');
            $columns['rating'] = __('Rating', 'oralcancerpdt');
            break;
            
        case 'faq':
            $columns['faq_category'] = __('Category', 'oralcancerpdt');
            break;
    }
    
    return $columns;
}
add_filter('manage_posts_columns', 'pdtai_add_custom_columns');

/**
 * Display custom column content
 */
function pdtai_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'position':
            echo esc_html(get_post_meta($post_id, '_pdtai_team_position', true));
            break;
            
        case 'team_role':
            $terms = get_the_terms($post_id, 'team_role');
            if (!empty($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo esc_html(implode(', ', $term_names));
            }
            break;
            
        case 'treatment_type':
            $terms = get_the_terms($post_id, 'treatment_type');
            if (!empty($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo esc_html(implode(', ', $term_names));
            }
            break;
            
        case 'price':
            echo esc_html(get_post_meta($post_id, '_pdtai_service_price', true));
            break;
            
        case 'authors':
            echo esc_html(get_post_meta($post_id, '_pdtai_research_authors', true));
            break;
            
        case 'journal':
            echo esc_html(get_post_meta($post_id, '_pdtai_research_journal', true));
            break;
            
        case 'pub_date':
            $date = get_post_meta($post_id, '_pdtai_research_date', true);
            if (!empty($date)) {
                echo esc_html(date_i18n(get_option('date_format'), strtotime($date)));
            }
            break;
            
        case 'client':
            echo esc_html(get_post_meta($post_id, '_pdtai_testimonial_client_name', true));
            break;
            
        case 'rating':
            $rating = get_post_meta($post_id, '_pdtai_testimonial_rating', true);
            echo str_repeat('★', intval($rating)) . str_repeat('☆', 5 - intval($rating));
            break;
            
        case 'faq_category':
            $terms = get_the_terms($post_id, 'faq_category');
            if (!empty($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo esc_html(implode(', ', $term_names));
            }
            break;
    }
}
add_action('manage_posts_custom_column', 'pdtai_custom_column_content', 10, 2);