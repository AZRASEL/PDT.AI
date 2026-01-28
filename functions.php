<?php
/**
 * PDT.AI - Oral Cancer PDT Clinic functions and definitions
 *
 * @link https://oralcancerpdt.com
 * @package PDT.AI
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define theme constants
define( 'PDTAI_VERSION', '1.0.0' );
define( 'PDTAI_DIR', get_template_directory() );
define( 'PDTAI_URI', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function pdtai_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'oralcancerpdt', PDTAI_DIR . '/languages' );
    
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Add support for custom logo.
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 100,
            'width'       => 350,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Add support for HTML5 features.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'oralcancerpdt' ),
            'footer'  => esc_html__( 'Footer Menu', 'oralcancerpdt' ),
        )
    );

    // Set content width.
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add support for editor color palette.
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name'  => esc_html__( 'Primary', 'oralcancerpdt' ),
                'slug'  => 'primary',
                'color' => '#0A6CF1',
            ),
            array(
                'name'  => esc_html__( 'Secondary', 'oralcancerpdt' ),
                'slug'  => 'secondary',
                'color' => '#14B8A6',
            ),
            array(
                'name'  => esc_html__( 'Dark', 'oralcancerpdt' ),
                'slug'  => 'dark',
                'color' => '#111827',
            ),
            array(
                'name'  => esc_html__( 'Light', 'oralcancerpdt' ),
                'slug'  => 'light',
                'color' => '#F5F7FB',
            ),
        )
    );
}
add_action( 'after_setup_theme', 'pdtai_setup' );

/**
 * Enqueue scripts and styles.
 */
function pdtai_scripts() {
    // Enqueue Google Fonts: Inter
    wp_enqueue_style(
        'pdtai-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Enqueue main stylesheet.
    wp_enqueue_style(
        'pdtai-style',
        get_stylesheet_uri(),
        array(),
        PDTAI_VERSION
    );

    // Enqueue theme script.
    wp_enqueue_script(
        'pdtai-script',
        PDTAI_URI . '/assets/js/main.js',
        array('jquery'),
        PDTAI_VERSION,
        true
    );

    // Localize script for translations and dynamic values.
    wp_localize_script(
        'pdtai-script',
        'pdtaiSettings',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'themeUri' => PDTAI_URI,
        )
    );

    // Add comment reply script if needed.
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'pdtai_scripts' );

/**
 * Register widget areas.
 */
function pdtai_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'oralcancerpdt' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'oralcancerpdt' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer widget areas
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar(
            array(
                'name'          => sprintf( esc_html__( 'Footer %d', 'oralcancerpdt' ), $i ),
                'id'            => 'footer-' . $i,
                'description'   => esc_html__( 'Add footer widgets here.', 'oralcancerpdt' ),
                'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="footer-widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }
}
add_action( 'widgets_init', 'pdtai_widgets_init' );

/**
 * Custom template tags for this theme.
 */
require PDTAI_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require PDTAI_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require PDTAI_DIR . '/inc/customizer.php';

/**
 * Custom Post Types.
 */
require PDTAI_DIR . '/inc/post-types.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require PDTAI_DIR . '/inc/jetpack.php';
}

/**
 * Register Custom Navigation Walker
 */
function register_navwalker() {
    require_once PDTAI_DIR . '/inc/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

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
 * Implement the Custom Header feature.
 */
require PDTAI_DIR . '/inc/custom-header.php';

/**
 * Add custom image sizes
 */
function pdtai_add_image_sizes() {
    add_image_size( 'pdtai-featured', 1200, 600, true );
    add_image_size( 'pdtai-card', 600, 400, true );
    add_image_size( 'pdtai-team', 400, 400, true );
}
add_action( 'after_setup_theme', 'pdtai_add_image_sizes' );

/**
 * Add custom image sizes to media library dropdown
 */
function pdtai_custom_image_sizes( $sizes ) {
    return array_merge(
        $sizes,
        array(
            'pdtai-featured' => esc_html__( 'Featured Image', 'oralcancerpdt' ),
            'pdtai-card'     => esc_html__( 'Card Image', 'oralcancerpdt' ),
            'pdtai-team'     => esc_html__( 'Team Member', 'oralcancerpdt' ),
        )
    );
}
add_filter( 'image_size_names_choose', 'pdtai_custom_image_sizes' );

/**
 * Add custom body classes
 */
function pdtai_body_classes( $classes ) {
    // Add a class if there is a custom header.
    if ( has_header_image() ) {
        $classes[] = 'has-header-image';
    }

    // Add a class if there is a custom background.
    if ( get_background_image() || get_background_color() !== 'ffffff' ) {
        $classes[] = 'has-custom-background';
    }

    return $classes;
}
add_filter( 'body_class', 'pdtai_body_classes' );

/**
 * Add a theme settings page
 */
function pdtai_add_theme_page() {
    add_theme_page(
        esc_html__( 'PDT.AI Theme Settings', 'oralcancerpdt' ),
        esc_html__( 'PDT.AI Settings', 'oralcancerpdt' ),
        'edit_theme_options',
        'pdtai-settings',
        'pdtai_theme_settings_page'
    );
}
add_action( 'admin_menu', 'pdtai_add_theme_page' );

/**
 * Display the theme settings page
 */
function pdtai_theme_settings_page() {
    // Check user capabilities
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        return;
    }

    // Save settings if data has been posted
    if ( isset( $_POST['pdtai_settings_nonce'] ) ) {
        if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pdtai_settings_nonce'] ) ), 'pdtai_save_settings' ) ) {
            wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'oralcancerpdt' ) );
        }

        // Save custom settings here
        if ( isset( $_POST['pdtai_phone_number'] ) ) {
            update_option( 'pdtai_phone_number', sanitize_text_field( wp_unslash( $_POST['pdtai_phone_number'] ) ) );
        }

        if ( isset( $_POST['pdtai_email'] ) ) {
            update_option( 'pdtai_email', sanitize_email( wp_unslash( $_POST['pdtai_email'] ) ) );
        }

        if ( isset( $_POST['pdtai_address'] ) ) {
            update_option( 'pdtai_address', sanitize_textarea_field( wp_unslash( $_POST['pdtai_address'] ) ) );
        }

        if ( isset( $_POST['pdtai_social_facebook'] ) ) {
            update_option( 'pdtai_social_facebook', esc_url_raw( wp_unslash( $_POST['pdtai_social_facebook'] ) ) );
        }

        if ( isset( $_POST['pdtai_social_twitter'] ) ) {
            update_option( 'pdtai_social_twitter', esc_url_raw( wp_unslash( $_POST['pdtai_social_twitter'] ) ) );
        }

        if ( isset( $_POST['pdtai_social_instagram'] ) ) {
            update_option( 'pdtai_social_instagram', esc_url_raw( wp_unslash( $_POST['pdtai_social_instagram'] ) ) );
        }

        if ( isset( $_POST['pdtai_social_linkedin'] ) ) {
            update_option( 'pdtai_social_linkedin', esc_url_raw( wp_unslash( $_POST['pdtai_social_linkedin'] ) ) );
        }

        if ( isset( $_POST['pdtai_enable_dark_mode'] ) ) {
            update_option( 'pdtai_enable_dark_mode', 1 );
        } else {
            update_option( 'pdtai_enable_dark_mode', 0 );
        }

        if ( isset( $_POST['pdtai_enable_chat_widget'] ) ) {
            update_option( 'pdtai_enable_chat_widget', 1 );
        } else {
            update_option( 'pdtai_enable_chat_widget', 0 );
        }

        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'oralcancerpdt' ) . '</p></div>';
    }

    // Get current settings
    $phone_number = get_option( 'pdtai_phone_number', '' );
    $email = get_option( 'pdtai_email', '' );
    $address = get_option( 'pdtai_address', '' );
    $social_facebook = get_option( 'pdtai_social_facebook', '' );
    $social_twitter = get_option( 'pdtai_social_twitter', '' );
    $social_instagram = get_option( 'pdtai_social_instagram', '' );
    $social_linkedin = get_option( 'pdtai_social_linkedin', '' );
    $enable_dark_mode = get_option( 'pdtai_enable_dark_mode', 1 );
    $enable_chat_widget = get_option( 'pdtai_enable_chat_widget', 1 );
    ?>

    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'pdtai_save_settings', 'pdtai_settings_nonce' ); ?>
            
            <h2><?php esc_html_e( 'Contact Information', 'oralcancerpdt' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="pdtai_phone_number"><?php esc_html_e( 'Phone Number', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="pdtai_phone_number" name="pdtai_phone_number" value="<?php echo esc_attr( $phone_number ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pdtai_email"><?php esc_html_e( 'Email Address', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="email" id="pdtai_email" name="pdtai_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pdtai_address"><?php esc_html_e( 'Address', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <textarea id="pdtai_address" name="pdtai_address" rows="3" class="large-text"><?php echo esc_textarea( $address ); ?></textarea>
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'Social Media', 'oralcancerpdt' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="pdtai_social_facebook"><?php esc_html_e( 'Facebook URL', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="pdtai_social_facebook" name="pdtai_social_facebook" value="<?php echo esc_url( $social_facebook ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pdtai_social_twitter"><?php esc_html_e( 'Twitter URL', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="pdtai_social_twitter" name="pdtai_social_twitter" value="<?php echo esc_url( $social_twitter ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pdtai_social_instagram"><?php esc_html_e( 'Instagram URL', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="pdtai_social_instagram" name="pdtai_social_instagram" value="<?php echo esc_url( $social_instagram ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="pdtai_social_linkedin"><?php esc_html_e( 'LinkedIn URL', 'oralcancerpdt' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="pdtai_social_linkedin" name="pdtai_social_linkedin" value="<?php echo esc_url( $social_linkedin ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>

            <h2><?php esc_html_e( 'Theme Features', 'oralcancerpdt' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Dark Mode', 'oralcancerpdt' ); ?></th>
                    <td>
                        <label for="pdtai_enable_dark_mode">
                            <input type="checkbox" id="pdtai_enable_dark_mode" name="pdtai_enable_dark_mode" value="1" <?php checked( $enable_dark_mode, 1 ); ?>>
                            <?php esc_html_e( 'Enable dark mode toggle', 'oralcancerpdt' ); ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e( 'Chat Widget', 'oralcancerpdt' ); ?></th>
                    <td>
                        <label for="pdtai_enable_chat_widget">
                            <input type="checkbox" id="pdtai_enable_chat_widget" name="pdtai_enable_chat_widget" value="1" <?php checked( $enable_chat_widget, 1 ); ?>>
                            <?php esc_html_e( 'Enable floating chat widget', 'oralcancerpdt' ); ?>
                        </label>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Add custom meta boxes for team members
 */
function pdtai_add_team_meta_boxes() {
    add_meta_box(
        'pdtai_team_details',
        esc_html__( 'Team Member Details', 'oralcancerpdt' ),
        'pdtai_team_details_callback',
        'team',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'pdtai_add_team_meta_boxes' );

/**
 * Team member details meta box callback
 */
function pdtai_team_details_callback( $post ) {
    // Add a nonce field for security
    wp_nonce_field( 'pdtai_save_team_details', 'pdtai_team_details_nonce' );

    // Get current values
    $position = get_post_meta( $post->ID, '_pdtai_team_position', true );
    $email = get_post_meta( $post->ID, '_pdtai_team_email', true );
    $phone = get_post_meta( $post->ID, '_pdtai_team_phone', true );
    $linkedin = get_post_meta( $post->ID, '_pdtai_team_linkedin', true );
    $twitter = get_post_meta( $post->ID, '_pdtai_team_twitter', true );
    $research_interests = get_post_meta( $post->ID, '_pdtai_team_research', true );
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="pdtai_team_position"><?php esc_html_e( 'Position/Title', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_team_position" name="pdtai_team_position" value="<?php echo esc_attr( $position ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_team_email"><?php esc_html_e( 'Email Address', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="email" id="pdtai_team_email" name="pdtai_team_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_team_phone"><?php esc_html_e( 'Phone Number', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_team_phone" name="pdtai_team_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_team_linkedin"><?php esc_html_e( 'LinkedIn Profile', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="url" id="pdtai_team_linkedin" name="pdtai_team_linkedin" value="<?php echo esc_url( $linkedin ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_team_twitter"><?php esc_html_e( 'Twitter Profile', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="url" id="pdtai_team_twitter" name="pdtai_team_twitter" value="<?php echo esc_url( $twitter ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_team_research"><?php esc_html_e( 'Research Interests', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <textarea id="pdtai_team_research" name="pdtai_team_research" rows="4" class="large-text"><?php echo esc_textarea( $research_interests ); ?></textarea>
                <p class="description"><?php esc_html_e( 'Enter research interests or specializations, separated by commas.', 'oralcancerpdt' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save team member details
 */
function pdtai_save_team_details( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['pdtai_team_details_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pdtai_team_details_nonce'] ) ), 'pdtai_save_team_details' ) ) {
        return;
    }

    // If this is an autosave, don't do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permissions
    if ( isset( $_POST['post_type'] ) && 'team' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Save team member details
    if ( isset( $_POST['pdtai_team_position'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_position', sanitize_text_field( wp_unslash( $_POST['pdtai_team_position'] ) ) );
    }

    if ( isset( $_POST['pdtai_team_email'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_email', sanitize_email( wp_unslash( $_POST['pdtai_team_email'] ) ) );
    }

    if ( isset( $_POST['pdtai_team_phone'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_phone', sanitize_text_field( wp_unslash( $_POST['pdtai_team_phone'] ) ) );
    }

    if ( isset( $_POST['pdtai_team_linkedin'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_linkedin', esc_url_raw( wp_unslash( $_POST['pdtai_team_linkedin'] ) ) );
    }

    if ( isset( $_POST['pdtai_team_twitter'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_twitter', esc_url_raw( wp_unslash( $_POST['pdtai_team_twitter'] ) ) );
    }

    if ( isset( $_POST['pdtai_team_research'] ) ) {
        update_post_meta( $post_id, '_pdtai_team_research', sanitize_textarea_field( wp_unslash( $_POST['pdtai_team_research'] ) ) );
    }
}
add_action( 'save_post', 'pdtai_save_team_details' );

/**
 * Add custom meta boxes for research publications
 */
function pdtai_add_research_meta_boxes() {
    add_meta_box(
        'pdtai_research_details',
        esc_html__( 'Publication Details', 'oralcancerpdt' ),
        'pdtai_research_details_callback',
        'research',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'pdtai_add_research_meta_boxes' );

/**
 * Research publication details meta box callback
 */
function pdtai_research_details_callback( $post ) {
    // Add a nonce field for security
    wp_nonce_field( 'pdtai_save_research_details', 'pdtai_research_details_nonce' );

    // Get current values
    $authors = get_post_meta( $post->ID, '_pdtai_research_authors', true );
    $journal = get_post_meta( $post->ID, '_pdtai_research_journal', true );
    $year = get_post_meta( $post->ID, '_pdtai_research_year', true );
    $doi = get_post_meta( $post->ID, '_pdtai_research_doi', true );
    $pubmed = get_post_meta( $post->ID, '_pdtai_research_pubmed', true );
    $abstract = get_post_meta( $post->ID, '_pdtai_research_abstract', true );
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="pdtai_research_authors"><?php esc_html_e( 'Authors', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_research_authors" name="pdtai_research_authors" value="<?php echo esc_attr( $authors ); ?>" class="large-text">
                <p class="description"><?php esc_html_e( 'Enter authors in format: Last FM, Last FM, etc.', 'oralcancerpdt' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_research_journal"><?php esc_html_e( 'Journal/Publication', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_research_journal" name="pdtai_research_journal" value="<?php echo esc_attr( $journal ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_research_year"><?php esc_html_e( 'Publication Year', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="number" id="pdtai_research_year" name="pdtai_research_year" value="<?php echo esc_attr( $year ); ?>" class="small-text" min="1900" max="<?php echo esc_attr( date( 'Y' ) ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_research_doi"><?php esc_html_e( 'DOI', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_research_doi" name="pdtai_research_doi" value="<?php echo esc_attr( $doi ); ?>" class="regular-text">
                <p class="description"><?php esc_html_e( 'Digital Object Identifier (e.g., 10.1000/xyz123)', 'oralcancerpdt' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_research_pubmed"><?php esc_html_e( 'PubMed ID', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <input type="text" id="pdtai_research_pubmed" name="pdtai_research_pubmed" value="<?php echo esc_attr( $pubmed ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="pdtai_research_abstract"><?php esc_html_e( 'Abstract', 'oralcancerpdt' ); ?></label>
            </th>
            <td>
                <textarea id="pdtai_research_abstract" name="pdtai_research_abstract" rows="6" class="large-text"><?php echo esc_textarea( $abstract ); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save research publication details
 */
function pdtai_save_research_details( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['pdtai_research_details_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pdtai_research_details_nonce'] ) ), 'pdtai_save_research_details' ) ) {
        return;
    }

    // If this is an autosave, don't do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permissions
    if ( isset( $_POST['post_type'] ) && 'research' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Save research publication details
    if ( isset( $_POST['pdtai_research_authors'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_authors', sanitize_text_field( wp_unslash( $_POST['pdtai_research_authors'] ) ) );
    }

    if ( isset( $_POST['pdtai_research_journal'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_journal', sanitize_text_field( wp_unslash( $_POST['pdtai_research_journal'] ) ) );
    }

    if ( isset( $_POST['pdtai_research_year'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_year', intval( $_POST['pdtai_research_year'] ) );
    }

    if ( isset( $_POST['pdtai_research_doi'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_doi', sanitize_text_field( wp_unslash( $_POST['pdtai_research_doi'] ) ) );
    }

    if ( isset( $_POST['pdtai_research_pubmed'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_pubmed', sanitize_text_field( wp_unslash( $_POST['pdtai_research_pubmed'] ) ) );
    }

    if ( isset( $_POST['pdtai_research_abstract'] ) ) {
        update_post_meta( $post_id, '_pdtai_research_abstract', sanitize_textarea_field( wp_unslash( $_POST['pdtai_research_abstract'] ) ) );
    }
}
add_action( 'save_post', 'pdtai_save_research_details' );

/**
 * Register translation strings for Polylang/WPML compatibility
 */
function pdtai_register_strings() {
    if ( function_exists( 'pll_register_string' ) ) {
        // Register strings for Polylang
        pll_register_string( 'pdtai_phone_number', get_option( 'pdtai_phone_number', '' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_email', get_option( 'pdtai_email', '' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_address', get_option( 'pdtai_address', '' ), 'PDT.AI Theme', true );
        
        // Register common UI strings
        pll_register_string( 'pdtai_book_appointment', esc_html__( 'Book an Appointment', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_learn_more', esc_html__( 'Learn More', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_read_more', esc_html__( 'Read More', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_contact_us', esc_html__( 'Contact Us', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_our_team', esc_html__( 'Our Team', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_research', esc_html__( 'Research', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_treatments', esc_html__( 'Treatments', 'oralcancerpdt' ), 'PDT.AI Theme', false );
        pll_register_string( 'pdtai_faq', esc_html__( 'Frequently Asked Questions', 'oralcancerpdt' ), 'PDT.AI Theme', false );
    }
}
add_action( 'init', 'pdtai_register_strings' );

/**
 * Add Schema.org structured data to the head
 */
function pdtai_add_schema_org() {
    if ( is_singular( 'post' ) ) {
        // Article schema for blog posts
        global $post;
        $author_id = $post->post_author;
        $author_name = get_the_author_meta( 'display_name', $author_id );
        $author_url = get_author_posts_url( $author_id );
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date( 'c' ),
            'dateModified' => get_the_modified_date( 'c' ),
            'author' => array(
                '@type' => 'Person',
                'name' => $author_name,
                'url' => $author_url,
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_custom_logo_url(),
                ),
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink(),
            ),
        );
        
        // Add featured image if available
        if ( has_post_thumbnail() ) {
            $image_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            if ( $image_data ) {
                $schema['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $image_data[0],
                    'width' => $image_data[1],
                    'height' => $image_data[2],
                );
            }
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
    } elseif ( is_singular( 'team' ) ) {
        // Person schema for team members
        global $post;
        $position = get_post_meta( $post->ID, '_pdtai_team_position', true );
        $email = get_post_meta( $post->ID, '_pdtai_team_email', true );
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => get_the_title(),
            'jobTitle' => $position,
            'email' => $email,
            'worksFor' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
            ),
        );
        
        // Add profile image if available
        if ( has_post_thumbnail() ) {
            $schema['image'] = get_the_post_thumbnail_url( $post->ID, 'full' );
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
    } elseif ( is_singular( 'research' ) ) {
        // ScholarlyArticle schema for research publications
        global $post;
        $authors = get_post_meta( $post->ID, '_pdtai_research_authors', true );
        $journal = get_post_meta( $post->ID, '_pdtai_research_journal', true );
        $year = get_post_meta( $post->ID, '_pdtai_research_year', true );
        $doi = get_post_meta( $post->ID, '_pdtai_research_doi', true );
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'ScholarlyArticle',
            'headline' => get_the_title(),
            'datePublished' => $year . '-01-01',
            'isPartOf' => array(
                '@type' => 'Periodical',
                'name' => $journal,
            ),
        );
        
        // Add DOI if available
        if ( $doi ) {
            $schema['sameAs'] = 'https://doi.org/' . $doi;
        }
        
        // Add authors if available
        if ( $authors ) {
            $author_list = explode( ',', $authors );
            $schema_authors = array();
            
            foreach ( $author_list as $author ) {
                $schema_authors[] = array(
                    '@type' => 'Person',
                    'name' => trim( $author ),
                );
            }
            
            $schema['author'] = $schema_authors;
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
    } elseif ( is_front_page() ) {
        // Organization schema for homepage
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'MedicalOrganization',
            'name' => get_bloginfo( 'name' ),
            'url' => home_url(),
            'logo' => get_custom_logo_url(),
            'description' => get_bloginfo( 'description' ),
            'medicalSpecialty' => array(
                '@type' => 'MedicalSpecialty',
                'name' => 'Oncology',
            ),
        );
        
        // Add contact information if available
        $phone = get_option( 'pdtai_phone_number', '' );
        $email = get_option( 'pdtai_email', '' );
        $address = get_option( 'pdtai_address', '' );
        
        if ( $phone || $email || $address ) {
            $schema['contactPoint'] = array(
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
            );
            
            if ( $phone ) {
                $schema['contactPoint']['telephone'] = $phone;
            }
            
            if ( $email ) {
                $schema['contactPoint']['email'] = $email;
            }
        }
        
        if ( $address ) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
            );
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
    }
}
add_action( 'wp_head', 'pdtai_add_schema_org' );

/**
 * Helper function to get custom logo URL
 */
function get_custom_logo_url() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = '';
    
    if ( $custom_logo_id ) {
        $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
    }
    
    return $logo_url;
}

/**
 * Add custom body class for dark mode
 */
function pdtai_dark_mode_body_class( $classes ) {
    if ( isset( $_COOKIE['pdtai_dark_mode'] ) && 'true' === $_COOKIE['pdtai_dark_mode'] ) {
        $classes[] = 'dark-mode';
    }
    
    return $classes;
}
add_filter( 'body_class', 'pdtai_dark_mode_body_class' );

/**
 * Add dark mode toggle script to footer
 */
function pdtai_dark_mode_script() {
    if ( get_option( 'pdtai_enable_dark_mode', 1 ) ) {
        ?>
        <script>
        (function() {
            // Dark mode toggle functionality
            const darkModeToggle = document.querySelector('.theme-toggle');
            const htmlElement = document.documentElement;
            
            if (darkModeToggle) {
                // Check for saved user preference
                const darkMode = localStorage.getItem('pdtai_dark_mode');
                
                // Set initial state based on preference or system preference
                if (darkMode === 'true' || (darkMode === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    htmlElement.setAttribute('data-theme', 'dark');
                    document.cookie = 'pdtai_dark_mode=true; path=/; max-age=31536000'; // 1 year
                    localStorage.setItem('pdtai_dark_mode', 'true');
                }
                
                // Toggle dark mode on click
                darkModeToggle.addEventListener('click', function() {
                    if (htmlElement.getAttribute('data-theme') === 'dark') {
                        htmlElement.removeAttribute('data-theme');
                        document.cookie = 'pdtai_dark_mode=false; path=/; max-age=31536000';
                        localStorage.setItem('pdtai_dark_mode', 'false');
                    } else {
                        htmlElement.setAttribute('data-theme', 'dark');
                        document.cookie = 'pdtai_dark_mode=true; path=/; max-age=31536000';
                        localStorage.setItem('pdtai_dark_mode', 'true');
                    }
                });
            }
        })();
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'pdtai_dark_mode_script' );

/**
 * Add chat widget to footer
 */
function pdtai_chat_widget() {
    if ( get_option( 'pdtai_enable_chat_widget', 1 ) ) {
        ?>
        <div class="floating-chat">
            <button class="chat-button" id="chat-toggle" aria-label="<?php esc_attr_e( 'Open chat', 'oralcancerpdt' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </button>
            <div class="chat-container" id="chat-container" style="display: none;">
                <div class="chat-header">
                    <h3><?php esc_html_e( 'PDT.AI Assistant', 'oralcancerpdt' ); ?></h3>
                    <button class="chat-close" id="chat-close" aria-label="<?php esc_attr_e( 'Close chat', 'oralcancerpdt' ); ?>">&times;</button>
                </div>
                <div class="chat-messages" id="chat-messages">
                    <div class="chat-message bot">
                        <div class="message-content">
                            <?php esc_html_e( 'Hello! I\'m PDT.AI, your assistant for Photodynamic Therapy information. How can I help you today?', 'oralcancerpdt' ); ?>
                        </div>
                    </div>
                </div>
                <div class="chat-input">
                    <input type="text" id="chat-input-field" placeholder="<?php esc_attr_e( 'Type your message...', 'oralcancerpdt' ); ?>">
                    <button id="chat-send" aria-label="<?php esc_attr_e( 'Send message', 'oralcancerpdt' ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <style>
        .floating-chat {
            position: fixed;
            bottom: var(--spacing-6);
            right: var(--spacing-6);
            z-index: 1000;
        }

        .chat-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            border: none;
            transition: var(--transition-normal);
        }

        .chat-button:hover {
            transform: scale(1.05);
        }

        .chat-container {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 350px;
            height: 450px;
            background-color: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            padding: var(--spacing-4);
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h3 {
            margin: 0;
            font-size: var(--font-size-lg);
            color: var(--white);
        }

        .chat-close {
            background: none;
            border: none;
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
        }

        .chat-messages {
            flex: 1;
            padding: var(--spacing-4);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: var(--spacing-3);
        }

        .chat-message {
            max-width: 80%;
            padding: var(--spacing-3);
            border-radius: var(--border-radius-lg);
            margin-bottom: var(--spacing-2);
        }

        .chat-message.user {
            align-self: flex-end;
            background-color: var(--primary-color);
            color: var(--white);
            border-bottom-right-radius: 0;
        }

        .chat-message.bot {
            align-self: flex-start;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-bottom-left-radius: 0;
        }

        .chat-input {
            display: flex;
            padding: var(--spacing-3);
            border-top: 1px solid var(--light-gray);
        }

        .chat-input input {
            flex: 1;
            padding: var(--spacing-2) var(--spacing-3);
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-md);
            margin-right: var(--spacing-2);
        }

        .chat-input button {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius-md);
            padding: var(--spacing-2) var(--spacing-3);
            cursor: pointer;
        }

        @media (max-width: 480px) {
            .chat-container {
                width: 300px;
                height: 400px;
                bottom: 70px;
                right: 0;
            }
        }
        </style>

        <script>
        (function() {
            // Chat widget functionality
            const chatToggle = document.getElementById('chat-toggle');
            const chatContainer = document.getElementById('chat-container');
            const chatClose = document.getElementById('chat-close');
            const chatMessages = document.getElementById('chat-messages');
            const chatInput = document.getElementById('chat-input-field');
            const chatSend = document.getElementById('chat-send');
            
            // Sample responses for demo purposes
            const responses = {
                'hello': '<?php echo esc_js( __( 'Hello! How can I help you with Photodynamic Therapy today?', 'oralcancerpdt' ) ); ?>',
                'pdt': '<?php echo esc_js( __( 'Photodynamic Therapy (PDT) is a treatment that uses special drugs, called photosensitizing agents, along with light to kill cancer cells. The drugs only work after they have been activated by certain kinds of light.', 'oralcancerpdt' ) ); ?>',
                'appointment': '<?php echo esc_js( __( 'To book an appointment, please use our online booking form or call us directly at the number shown in the header.', 'oralcancerpdt' ) ); ?>',
                'treatment': '<?php echo esc_js( __( 'Our PDT treatment process involves applying a photosensitizing agent to the affected area, waiting for it to be absorbed by the cancer cells, and then exposing the area to a specific wavelength of light to activate the drug and destroy the cancer cells.', 'oralcancerpdt' ) ); ?>',
                'side effects': '<?php echo esc_js( __( 'Common side effects of PDT may include skin sensitivity to light, redness, swelling, burning, or pain at the treatment site. These typically resolve within a few days to weeks after treatment.', 'oralcancerpdt' ) ); ?>',
                'cost': '<?php echo esc_js( __( 'The cost of PDT treatment varies depending on the specific condition being treated and the extent of the treatment area. Please contact us for a personalized consultation and cost estimate.', 'oralcancerpdt' ) ); ?>',
                'research': '<?php echo esc_js( __( 'Our clinic is actively involved in research to improve PDT techniques and outcomes. You can find our latest publications in the Research section of our website.', 'oralcancerpdt' ) ); ?>',
                'team': '<?php echo esc_js( __( 'Our team consists of experienced specialists in oncology, dermatology, and photodynamic therapy. You can learn more about our team members in the Our Team section.', 'oralcancerpdt' ) ); ?>',
                'location': '<?php echo esc_js( __( 'Our clinic is located in Dhaka, Bangladesh. You can find our exact address and directions in the Contact section.', 'oralcancerpdt' ) ); ?>',
                'default': '<?php echo esc_js( __( 'Thank you for your question. For more detailed information, please contact our clinic directly or browse the relevant sections of our website.', 'oralcancerpdt' ) ); ?>'
            };
            
            // Toggle chat visibility
            chatToggle.addEventListener('click', function() {
                chatContainer.style.display = chatContainer.style.display === 'none' ? 'flex' : 'none';
            });
            
            // Close chat
            chatClose.addEventListener('click', function() {
                chatContainer.style.display = 'none';
            });
            
            // Send message function
            function sendMessage() {
                const message = chatInput.value.trim();
                if (message === '') return;
                
                // Add user message to chat
                addMessage(message, 'user');
                chatInput.value = '';
                
                // Get response after a short delay
                setTimeout(function() {
                    const response = getResponse(message.toLowerCase());
                    addMessage(response, 'bot');
                }, 500);
            }
            
            // Add message to chat
            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('chat-message', sender);
                messageElement.innerHTML = `<div class="message-content">${message}</div>`;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            
            // Get response based on user input
            function getResponse(input) {
                // Check for keywords in the input
                for (const keyword in responses) {
                    if (input.includes(keyword)) {
                        return responses[keyword];
                    }
                }
                return responses.default;
            }
            
            // Send message on button click
            chatSend.addEventListener('click', sendMessage);
            
            // Send message on Enter key
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        })();
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'pdtai_chat_widget' );

/**
 * Add booking form shortcode
 */
function pdtai_booking_form_shortcode() {
    ob_start();
    ?>
    <div class="booking-form">
        <form id="pdtai-booking-form" method="post">
            <div class="form-group">
                <label for="booking-name"><?php esc_html_e( 'Your Name', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <input type="text" id="booking-name" name="booking-name" required>
            </div>
            
            <div class="form-group">
                <label for="booking-email"><?php esc_html_e( 'Email Address', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <input type="email" id="booking-email" name="booking-email" required>
            </div>
            
            <div class="form-group">
                <label for="booking-phone"><?php esc_html_e( 'Phone Number', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <input type="tel" id="booking-phone" name="booking-phone" required>
            </div>
            
            <div class="form-group">
                <label for="booking-date"><?php esc_html_e( 'Preferred Date', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <input type="date" id="booking-date" name="booking-date" required>
            </div>
            
            <div class="form-group">
                <label for="booking-time"><?php esc_html_e( 'Preferred Time', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <select id="booking-time" name="booking-time" required>
                    <option value=""><?php esc_html_e( 'Select a time', 'oralcancerpdt' ); ?></option>
                    <option value="morning"><?php esc_html_e( 'Morning (9:00 AM - 12:00 PM)', 'oralcancerpdt' ); ?></option>
                    <option value="afternoon"><?php esc_html_e( 'Afternoon (12:00 PM - 3:00 PM)', 'oralcancerpdt' ); ?></option>
                    <option value="evening"><?php esc_html_e( 'Evening (3:00 PM - 6:00 PM)', 'oralcancerpdt' ); ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="booking-service"><?php esc_html_e( 'Service Type', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
                <select id="booking-service" name="booking-service" required>
                    <option value=""><?php esc_html_e( 'Select a service', 'oralcancerpdt' ); ?></option>
                    <option value="consultation"><?php esc_html_e( 'Initial Consultation', 'oralcancerpdt' ); ?></option>
                    <option value="pdt-treatment"><?php esc_html_e( 'PDT Treatment', 'oralcancerpdt' ); ?></option>
                    <option value="follow-up"><?php esc_html_e( 'Follow-up Visit', 'oralcancerpdt' ); ?></option>
                    <option value="screening"><?php esc_html_e( 'Oral Cancer Screening', 'oralcancerpdt' ); ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="booking-message"><?php esc_html_e( 'Additional Information', 'oralcancerpdt' ); ?></label>
                <textarea id="booking-message" name="booking-message" rows="4"></textarea>
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" id="booking-consent" name="booking-consent" required>
                <label for="booking-consent"><?php esc_html_e( 'I consent to the collection and processing of my personal data for the purpose of scheduling an appointment.', 'oralcancerpdt' ); ?> <span class="required">*</span></label>
            </div>
            
            <div class="form-submit">
                <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Request Appointment', 'oralcancerpdt' ); ?></button>
            </div>
            
            <div id="booking-response" class="form-response"></div>
        </form>
    </div>
    
    <script>
    (function() {
        const bookingForm = document.getElementById('pdtai-booking-form');
        const bookingResponse = document.getElementById('booking-response');
        
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // In a real implementation, you would send the form data to the server
                // For demo purposes, we'll just show a success message
                bookingResponse.innerHTML = '<div class="success-message"><?php echo esc_js( __( 'Thank you for your appointment request. We will contact you shortly to confirm your appointment.', 'oralcancerpdt' ) ); ?></div>';
                bookingForm.reset();
            });
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode( 'pdtai_booking_form', 'pdtai_booking_form_shortcode' );

/**
 * Add FAQ accordion shortcode
 */
function pdtai_faq_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'category' => '',
            'limit' => -1,
        ),
        $atts,
        'pdtai_faq'
    );
    
    $args = array(
        'post_type' => 'faq',
        'posts_per_page' => $atts['limit'],
    );
    
    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }
    
    $faqs = new WP_Query( $args );
    
    ob_start();
    
    if ( $faqs->have_posts() ) :
        ?>
        <div class="faq-accordion">
            <?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
                <details class="faq-item">
                    <summary class="faq-question"><?php the_title(); ?></summary>
                    <div class="faq-answer">
                        <?php the_content(); ?>
                    </div>
                </details>
            <?php endwhile; ?>
        </div>
        <?php
    else :
        echo '<p>' . esc_html__( 'No FAQs found.', 'oralcancerpdt' ) . '</p>';
    endif;
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode( 'pdtai_faq', 'pdtai_faq_shortcode' );