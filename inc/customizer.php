<?php
/**
 * PDT.AI Theme Customizer
 *
 * @package PDT.AI
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pdtai_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'pdtai_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'pdtai_customize_partial_blogdescription',
        ) );
    }
    
    // Add Theme Options Panel
    $wp_customize->add_panel( 'pdtai_theme_options', array(
        'title'       => __( 'Theme Options', 'oralcancerpdt' ),
        'description' => __( 'Configure PDT.AI theme settings', 'oralcancerpdt' ),
        'priority'    => 130,
    ) );
    
    // Add Color Scheme Section
    $wp_customize->add_section( 'pdtai_color_scheme', array(
        'title'       => __( 'Color Scheme', 'oralcancerpdt' ),
        'description' => __( 'Customize the theme colors', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 10,
    ) );
    
    // Primary Color
    $wp_customize->add_setting( 'pdtai_primary_color', array(
        'default'           => '#0056b3',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pdtai_primary_color', array(
        'label'    => __( 'Primary Color', 'oralcancerpdt' ),
        'section'  => 'pdtai_color_scheme',
        'settings' => 'pdtai_primary_color',
    ) ) );
    
    // Secondary Color
    $wp_customize->add_setting( 'pdtai_secondary_color', array(
        'default'           => '#6c757d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pdtai_secondary_color', array(
        'label'    => __( 'Secondary Color', 'oralcancerpdt' ),
        'section'  => 'pdtai_color_scheme',
        'settings' => 'pdtai_secondary_color',
    ) ) );
    
    // Accent Color
    $wp_customize->add_setting( 'pdtai_accent_color', array(
        'default'           => '#ff5722',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pdtai_accent_color', array(
        'label'    => __( 'Accent Color', 'oralcancerpdt' ),
        'section'  => 'pdtai_color_scheme',
        'settings' => 'pdtai_accent_color',
    ) ) );
    
    // Dark Mode Default
    $wp_customize->add_setting( 'pdtai_dark_mode_default', array(
        'default'           => false,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_dark_mode_default', array(
        'label'    => __( 'Enable Dark Mode by Default', 'oralcancerpdt' ),
        'section'  => 'pdtai_color_scheme',
        'settings' => 'pdtai_dark_mode_default',
        'type'     => 'checkbox',
    ) );
    
    // Add Layout Section
    $wp_customize->add_section( 'pdtai_layout', array(
        'title'       => __( 'Layout Options', 'oralcancerpdt' ),
        'description' => __( 'Configure layout settings', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 20,
    ) );
    
    // Container Width
    $wp_customize->add_setting( 'pdtai_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'pdtai_container_width', array(
        'label'       => __( 'Container Width (px)', 'oralcancerpdt' ),
        'section'     => 'pdtai_layout',
        'settings'    => 'pdtai_container_width',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 10,
        ),
    ) );
    
    // Sidebar Position
    $wp_customize->add_setting( 'pdtai_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'pdtai_sanitize_select',
    ) );
    
    $wp_customize->add_control( 'pdtai_sidebar_position', array(
        'label'    => __( 'Sidebar Position', 'oralcancerpdt' ),
        'section'  => 'pdtai_layout',
        'settings' => 'pdtai_sidebar_position',
        'type'     => 'select',
        'choices'  => array(
            'right' => __( 'Right', 'oralcancerpdt' ),
            'left'  => __( 'Left', 'oralcancerpdt' ),
            'none'  => __( 'No Sidebar', 'oralcancerpdt' ),
        ),
    ) );
    
    // Add Header Section
    $wp_customize->add_section( 'pdtai_header', array(
        'title'       => __( 'Header Options', 'oralcancerpdt' ),
        'description' => __( 'Configure header settings', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 30,
    ) );
    
    // Sticky Header
    $wp_customize->add_setting( 'pdtai_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_sticky_header', array(
        'label'    => __( 'Enable Sticky Header', 'oralcancerpdt' ),
        'section'  => 'pdtai_header',
        'settings' => 'pdtai_sticky_header',
        'type'     => 'checkbox',
    ) );
    
    // Phone Number
    $wp_customize->add_setting( 'pdtai_phone_number', array(
        'default'           => '+880 1234-567890',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_phone_number', array(
        'label'    => __( 'Phone Number', 'oralcancerpdt' ),
        'section'  => 'pdtai_header',
        'settings' => 'pdtai_phone_number',
        'type'     => 'text',
    ) );
    
    // Add Footer Section
    $wp_customize->add_section( 'pdtai_footer', array(
        'title'       => __( 'Footer Options', 'oralcancerpdt' ),
        'description' => __( 'Configure footer settings', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 40,
    ) );
    
    // Copyright Text
    $wp_customize->add_setting( 'pdtai_copyright_text', array(
        'default'           => '© ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('All rights reserved.', 'oralcancerpdt'),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'pdtai_copyright_text', array(
        'label'    => __( 'Copyright Text', 'oralcancerpdt' ),
        'section'  => 'pdtai_footer',
        'settings' => 'pdtai_copyright_text',
        'type'     => 'textarea',
    ) );
    
    // Clinic Address
    $wp_customize->add_setting( 'pdtai_clinic_address', array(
        'default'           => 'Dhaka Medical College Hospital, Dhaka, Bangladesh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_clinic_address', array(
        'label'    => __( 'Clinic Address', 'oralcancerpdt' ),
        'section'  => 'pdtai_footer',
        'settings' => 'pdtai_clinic_address',
        'type'     => 'text',
    ) );
    
    // Email Address
    $wp_customize->add_setting( 'pdtai_email_address', array(
        'default'           => 'info@oralcancerpdt.com',
        'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( 'pdtai_email_address', array(
        'label'    => __( 'Email Address', 'oralcancerpdt' ),
        'section'  => 'pdtai_footer',
        'settings' => 'pdtai_email_address',
        'type'     => 'email',
    ) );
    
    // Clinic Hours
    $wp_customize->add_setting( 'pdtai_clinic_hours', array(
        'default'           => 'Mon-Fri: 9:00 AM - 5:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_clinic_hours', array(
        'label'    => __( 'Clinic Hours', 'oralcancerpdt' ),
        'section'  => 'pdtai_footer',
        'settings' => 'pdtai_clinic_hours',
        'type'     => 'text',
    ) );
    
    // Google Maps Embed
    $wp_customize->add_setting( 'pdtai_map_embed', array(
        'default'           => '',
        'sanitize_callback' => 'pdtai_sanitize_html',
    ) );
    
    $wp_customize->add_control( 'pdtai_map_embed', array(
        'label'       => __( 'Google Maps Embed Code', 'oralcancerpdt' ),
        'description' => __( 'Paste the iframe embed code from Google Maps', 'oralcancerpdt' ),
        'section'     => 'pdtai_footer',
        'settings'    => 'pdtai_map_embed',
        'type'        => 'textarea',
    ) );
    
    // Add Social Media Section
    $wp_customize->add_section( 'pdtai_social', array(
        'title'       => __( 'Social Media', 'oralcancerpdt' ),
        'description' => __( 'Add your social media profile links', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 50,
    ) );
    
    // Facebook
    $wp_customize->add_setting( 'pdtai_facebook_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_facebook_url', array(
        'label'    => __( 'Facebook URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_social',
        'settings' => 'pdtai_facebook_url',
        'type'     => 'url',
    ) );
    
    // Twitter
    $wp_customize->add_setting( 'pdtai_twitter_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_twitter_url', array(
        'label'    => __( 'Twitter URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_social',
        'settings' => 'pdtai_twitter_url',
        'type'     => 'url',
    ) );
    
    // Instagram
    $wp_customize->add_setting( 'pdtai_instagram_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_instagram_url', array(
        'label'    => __( 'Instagram URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_social',
        'settings' => 'pdtai_instagram_url',
        'type'     => 'url',
    ) );
    
    // LinkedIn
    $wp_customize->add_setting( 'pdtai_linkedin_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_linkedin_url', array(
        'label'    => __( 'LinkedIn URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_social',
        'settings' => 'pdtai_linkedin_url',
        'type'     => 'url',
    ) );
    
    // YouTube
    $wp_customize->add_setting( 'pdtai_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_youtube_url', array(
        'label'    => __( 'YouTube URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_social',
        'settings' => 'pdtai_youtube_url',
        'type'     => 'url',
    ) );
    
    // Add Features Section
    $wp_customize->add_section( 'pdtai_features', array(
        'title'       => __( 'Features', 'oralcancerpdt' ),
        'description' => __( 'Enable or disable theme features', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 60,
    ) );
    
    // Enable Chat Widget
    $wp_customize->add_setting( 'pdtai_enable_chat', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_enable_chat', array(
        'label'    => __( 'Enable Floating Chat Widget', 'oralcancerpdt' ),
        'section'  => 'pdtai_features',
        'settings' => 'pdtai_enable_chat',
        'type'     => 'checkbox',
    ) );
    
    // Enable Back to Top
    $wp_customize->add_setting( 'pdtai_enable_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_enable_back_to_top', array(
        'label'    => __( 'Enable Back to Top Button', 'oralcancerpdt' ),
        'section'  => 'pdtai_features',
        'settings' => 'pdtai_enable_back_to_top',
        'type'     => 'checkbox',
    ) );
    
    // Enable Preloader
    $wp_customize->add_setting( 'pdtai_enable_preloader', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_enable_preloader', array(
        'label'    => __( 'Enable Preloader', 'oralcancerpdt' ),
        'section'  => 'pdtai_features',
        'settings' => 'pdtai_enable_preloader',
        'type'     => 'checkbox',
    ) );
    
    // Add Homepage Section
    $wp_customize->add_section( 'pdtai_homepage', array(
        'title'       => __( 'Homepage Settings', 'oralcancerpdt' ),
        'description' => __( 'Configure homepage sections', 'oralcancerpdt' ),
        'panel'       => 'pdtai_theme_options',
        'priority'    => 70,
    ) );
    
    // Hero Title
    $wp_customize->add_setting( 'pdtai_hero_title', array(
        'default'           => __('Photodynamic Therapy for Oral Cancer', 'oralcancerpdt'),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_hero_title', array(
        'label'    => __( 'Hero Title', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_hero_title',
        'type'     => 'text',
    ) );
    
    // Hero Subtitle
    $wp_customize->add_setting( 'pdtai_hero_subtitle', array(
        'default'           => __('Advanced, minimally invasive treatment for oral cancer patients in Bangladesh', 'oralcancerpdt'),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_hero_subtitle', array(
        'label'    => __( 'Hero Subtitle', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_hero_subtitle',
        'type'     => 'text',
    ) );
    
    // Hero Button Text
    $wp_customize->add_setting( 'pdtai_hero_button_text', array(
        'default'           => __('Book Consultation', 'oralcancerpdt'),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'pdtai_hero_button_text', array(
        'label'    => __( 'Hero Button Text', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_hero_button_text',
        'type'     => 'text',
    ) );
    
    // Hero Button URL
    $wp_customize->add_setting( 'pdtai_hero_button_url', array(
        'default'           => '#appointment',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( 'pdtai_hero_button_url', array(
        'label'    => __( 'Hero Button URL', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_hero_button_url',
        'type'     => 'url',
    ) );
    
    // Hero Background Image
    $wp_customize->add_setting( 'pdtai_hero_background', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pdtai_hero_background', array(
        'label'     => __( 'Hero Background Image', 'oralcancerpdt' ),
        'section'   => 'pdtai_homepage',
        'settings'  => 'pdtai_hero_background',
        'mime_type' => 'image',
    ) ) );
    
    // Enable PDT in Skin Care Section
    $wp_customize->add_setting( 'pdtai_enable_skincare_section', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_enable_skincare_section', array(
        'label'    => __( 'Enable PDT in Skin Care Section', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_enable_skincare_section',
        'type'     => 'checkbox',
    ) );
    
    // Enable Testimonials Section
    $wp_customize->add_setting( 'pdtai_enable_testimonials_section', array(
        'default'           => true,
        'sanitize_callback' => 'pdtai_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control( 'pdtai_enable_testimonials_section', array(
        'label'    => __( 'Enable Testimonials Section', 'oralcancerpdt' ),
        'section'  => 'pdtai_homepage',
        'settings' => 'pdtai_enable_testimonials_section',
        'type'     => 'checkbox',
    ) );
}
add_action( 'customize_register', 'pdtai_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function pdtai_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function pdtai_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function pdtai_customize_preview_js() {
    wp_enqueue_script( 'pdtai-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'pdtai_customize_preview_js' );

/**
 * Sanitize checkbox values.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool
 */
function pdtai_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize select values.
 *
 * @param string $input The input from the setting.
 * @param object $setting The selected setting.
 * @return string The sanitized input.
 */
function pdtai_sanitize_select( $input, $setting ) {
    // Get the list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize HTML content.
 *
 * @param string $input The input to be sanitized.
 * @return string The sanitized input.
 */
function pdtai_sanitize_html( $input ) {
    return wp_kses_post( $input );
}

/**
 * Output customizer CSS.
 */
function pdtai_customizer_css() {
    $primary_color = get_theme_mod( 'pdtai_primary_color', '#0056b3' );
    $secondary_color = get_theme_mod( 'pdtai_secondary_color', '#6c757d' );
    $accent_color = get_theme_mod( 'pdtai_accent_color', '#ff5722' );
    $container_width = get_theme_mod( 'pdtai_container_width', '1200' );
    
    $css = ''
        . ':root {'
        . '  --color-primary: ' . esc_attr( $primary_color ) . ';'
        . '  --color-secondary: ' . esc_attr( $secondary_color ) . ';'
        . '  --color-accent: ' . esc_attr( $accent_color ) . ';'
        . '  --container-width: ' . esc_attr( $container_width ) . 'px;'
        . '}'
        . '.container, .container-narrow {'
        . '  max-width: var(--container-width);'
        . '}'
        . '.btn-primary {'
        . '  background-color: var(--color-primary);'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.btn-primary:hover, .btn-primary:focus {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '  border-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '}'
        . '.btn-secondary {'
        . '  background-color: var(--color-secondary);'
        . '  border-color: var(--color-secondary);'
        . '}'
        . '.btn-secondary:hover, .btn-secondary:focus {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $secondary_color, -20 ) ) . ';'
        . '  border-color: ' . esc_attr( pdtai_adjust_brightness( $secondary_color, -20 ) ) . ';'
        . '}'
        . '.btn-accent {'
        . '  background-color: var(--color-accent);'
        . '  border-color: var(--color-accent);'
        . '}'
        . '.btn-accent:hover, .btn-accent:focus {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $accent_color, -20 ) ) . ';'
        . '  border-color: ' . esc_attr( pdtai_adjust_brightness( $accent_color, -20 ) ) . ';'
        . '}'
        . 'a {'
        . '  color: var(--color-primary);'
        . '}'
        . 'a:hover, a:focus {'
        . '  color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '}'
        . '.site-header {'
        . '  background-color: #fff;'
        . '}'
        . '.dark-mode .site-header {'
        . '  background-color: #222;'
        . '}'
        . '.main-navigation a:hover, .main-navigation .current-menu-item > a {'
        . '  color: var(--color-primary);'
        . '}'
        . '.dark-mode .main-navigation a:hover, .dark-mode .main-navigation .current-menu-item > a {'
        . '  color: var(--color-accent);'
        . '}'
        . '.section-title:after {'
        . '  background-color: var(--color-accent);'
        . '}'
        . '.service-card:hover {'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.testimonial-rating .star.filled {'
        . '  color: var(--color-accent);'
        . '}'
        . '.collapsible-trigger[aria-expanded="true"] {'
        . '  color: var(--color-primary);'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.floating-chat-widget .chat-toggle {'
        . '  background-color: var(--color-primary);'
        . '}'
        . '.floating-chat-widget .chat-toggle:hover {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '}'
        . '.floating-chat-widget .chat-header {'
        . '  background-color: var(--color-primary);'
        . '}'
        . '.back-to-top {'
        . '  background-color: var(--color-primary);'
        . '}'
        . '.back-to-top:hover {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '}'
        . '.dark-mode-toggle {'
        . '  color: var(--color-secondary);'
        . '}'
        . '.dark-mode-toggle:hover {'
        . '  color: var(--color-primary);'
        . '}'
        . '.dark-mode .dark-mode-toggle:hover {'
        . '  color: var(--color-accent);'
        . '}'
        . '.hero-section {'
        . '  background-color: var(--color-primary);'
        . '  background-image: linear-gradient(135deg, var(--color-primary), ' . esc_attr( pdtai_adjust_brightness( $primary_color, -30 ) ) . ');'
        . '}'
        . '.dark-mode .hero-section {'
        . '  background-color: #222;'
        . '  background-image: linear-gradient(135deg, #222, #111);'
        . '}'
        . '.site-footer {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -40 ) ) . ';'
        . '}'
        . '.dark-mode .site-footer {'
        . '  background-color: #111;'
        . '}'
        . '.footer-widget h3:after {'
        . '  background-color: var(--color-accent);'
        . '}'
        . '.footer-contact-info .contact-item svg {'
        . '  color: var(--color-accent);'
        . '}'
        . '.social-icons a:hover svg {'
        . '  color: var(--color-accent);'
        . '}'
        . '.dark-mode .social-icons a:hover svg {'
        . '  color: var(--color-accent);'
        . '}'
        . '.language-switcher .active a {'
        . '  color: var(--color-primary);'
        . '}'
        . '.dark-mode .language-switcher .active a {'
        . '  color: var(--color-accent);'
        . '}'
        . '.phone-cta a {'
        . '  color: var(--color-primary);'
        . '}'
        . '.dark-mode .phone-cta a {'
        . '  color: var(--color-accent);'
        . '}'
        . '.team-member-card:hover {'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.research-card:hover {'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.pagination .current {'
        . '  background-color: var(--color-primary);'
        . '  border-color: var(--color-primary);'
        . '}'
        . '.wp-block-button__link {'
        . '  background-color: var(--color-primary);'
        . '}'
        . '.wp-block-button__link:hover {'
        . '  background-color: ' . esc_attr( pdtai_adjust_brightness( $primary_color, -20 ) ) . ';'
        . '}'
        . '.wp-block-quote {'
        . '  border-left-color: var(--color-primary);'
        . '}'
        . '.dark-mode .wp-block-quote {'
        . '  border-left-color: var(--color-accent);'
        . '}'
        . '.has-tooltip .tooltip {'
        . '  background-color: var(--color-primary);'
        . '}'
        . '.has-tooltip .tooltip:after {'
        . '  border-top-color: var(--color-primary);'
        . '}'
        . '.dark-mode .has-tooltip .tooltip {'
        . '  background-color: var(--color-accent);'
        . '}'
        . '.dark-mode .has-tooltip .tooltip:after {'
        . '  border-top-color: var(--color-accent);'
        . '}'
        . '';
    
    // Sidebar position
    $sidebar_position = get_theme_mod( 'pdtai_sidebar_position', 'right' );
    if ( 'left' === $sidebar_position ) {
        $css .= ''
            . '@media (min-width: 992px) {'
            . '  .content-area {'
            . '    float: right;'
            . '  }'
            . '  .widget-area {'
            . '    float: left;'
            . '  }'
            . '}'
            . '';
    } elseif ( 'none' === $sidebar_position ) {
        $css .= ''
            . '.content-area {'
            . '  width: 100%;'
            . '  float: none;'
            . '}'
            . '.widget-area {'
            . '  display: none;'
            . '}'
            . '';
    }
    
    // Sticky header
    $sticky_header = get_theme_mod( 'pdtai_sticky_header', true );
    if ( $sticky_header ) {
        $css .= ''
            . '.site-header {'
            . '  position: sticky;'
            . '  top: 0;'
            . '  z-index: 1000;'
            . '}'
            . '.admin-bar .site-header {'
            . '  top: 32px;'
            . '}'
            . '@media screen and (max-width: 782px) {'
            . '  .admin-bar .site-header {'
            . '    top: 46px;'
            . '  }'
            . '}'
            . '';
    }
    
    // Dark mode default
    $dark_mode_default = get_theme_mod( 'pdtai_dark_mode_default', false );
    if ( $dark_mode_default ) {
        $css .= ''
            . 'body {'
            . '  background-color: var(--color-dark-bg);'
            . '  color: var(--color-dark-text);'
            . '}'
            . '.site-header {'
            . '  background-color: #222;'
            . '}'
            . '.site-footer {'
            . '  background-color: #111;'
            . '}'
            . '.main-navigation a {'
            . '  color: var(--color-dark-text);'
            . '}'
            . '.main-navigation a:hover, .main-navigation .current-menu-item > a {'
            . '  color: var(--color-accent);'
            . '}'
            . '.dark-mode-icon.light {'
            . '  display: none;'
            . '}'
            . '.dark-mode-icon.dark {'
            . '  display: block;'
            . '}'
            . '.card, .team-member-card, .service-card, .research-card, .testimonial-card {'
            . '  background-color: #222;'
            . '  border-color: #333;'
            . '}'
            . '.collapsible-trigger {'
            . '  background-color: #222;'
            . '  border-color: #333;'
            . '}'
            . '.collapsible-content {'
            . '  background-color: #222;'
            . '  border-color: #333;'
            . '}'
            . '.hero-section {'
            . '  background-color: #222;'
            . '  background-image: linear-gradient(135deg, #222, #111);'
            . '}'
            . '';
    }
    
    echo '<style type="text/css">' . $css . '</style>';
}
add_action( 'wp_head', 'pdtai_customizer_css' );

/**
 * Adjust brightness of a hex color.
 *
 * @param string $hex Hex color code.
 * @param int $steps Steps to adjust brightness (negative for darker, positive for lighter).
 * @return string Adjusted hex color.
 */
function pdtai_adjust_brightness( $hex, $steps ) {
    // Remove # if present
    $hex = ltrim( $hex, '#' );
    
    // Convert to RGB
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    
    // Adjust brightness
    $r = max( 0, min( 255, $r + $steps ) );
    $g = max( 0, min( 255, $g + $steps ) );
    $b = max( 0, min( 255, $b + $steps ) );
    
    // Convert back to hex
    return sprintf( '#%02x%02x%02x', $r, $g, $b );
}