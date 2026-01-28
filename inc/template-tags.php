<?php
/**
 * Custom template tags for this theme
 *
 * @package PDT.AI
 */

/**
 * Displays the site logo, linked to home.
 */
function pdtai_site_logo() {
    if (function_exists('the_custom_logo') && has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" rel="home" class="custom-logo-link text-logo">';
        echo '<span class="site-title">' . get_bloginfo('name') . '</span>';
        echo '</a>';
    }
}

/**
 * Displays the site description.
 */
function pdtai_site_description() {
    $description = get_bloginfo('description', 'display');
    if ($description || is_customize_preview()) {
        echo '<p class="site-description">' . $description . '</p>';
    }
}

/**
 * Displays the mobile menu toggle button.
 */
function pdtai_mobile_menu_toggle() {
    echo '<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">';
    echo '<span class="menu-toggle-icon"></span>';
    echo '<span class="screen-reader-text">' . esc_html__('Menu', 'oralcancerpdt') . '</span>';
    echo '</button>';
}

/**
 * Displays the primary navigation menu.
 */
function pdtai_primary_navigation() {
    if (has_nav_menu('menu-1')) {
        wp_nav_menu(array(
            'theme_location' => 'menu-1',
            'menu_id'        => 'primary-menu',
            'container'      => 'nav',
            'container_class' => 'main-navigation',
            'fallback_cb'    => 'pdtai_primary_menu_fallback',
        ));
    } else {
        echo '<nav class="main-navigation">';
        pdtai_primary_menu_fallback();
        echo '</nav>';
    }
}

/**
 * Displays the language switcher.
 */
function pdtai_language_switcher() {
    echo '<div class="language-switcher">';
    
    // Check if Polylang is active
    if (function_exists('pll_the_languages')) {
        $args = array(
            'show_flags' => 0,
            'show_names' => 1,
            'hide_if_empty' => 0,
            'display_names_as' => 'name',
        );
        pll_the_languages($args);
    } 
    // Check if WPML is active
    elseif (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0');
        if (!empty($languages)) {
            echo '<ul>';
            foreach ($languages as $language) {
                $class = $language['active'] ? ' class="active"' : '';
                echo '<li' . $class . '>';
                echo '<a href="' . esc_url($language['url']) . '">';
                echo esc_html($language['native_name']);
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
    } 
    // Fallback if no plugin is active
    else {
        echo '<ul>';
        echo '<li class="active"><a href="#">English</a></li>';
        echo '<li><a href="#">বাংলা</a></li>';
        echo '</ul>';
    }
    
    echo '</div>';
}

/**
 * Displays the dark mode toggle.
 */
function pdtai_dark_mode_toggle() {
    echo '<button class="dark-mode-toggle" aria-label="' . esc_attr__('Toggle Dark Mode', 'oralcancerpdt') . '">';
    echo '<span class="dark-mode-icon light"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM11 1h2v3h-2V1zm0 19h2v3h-2v-3zM3.515 4.929l1.414-1.414L7.05 5.636 5.636 7.05 3.515 4.93zM16.95 18.364l1.414-1.414 2.121 2.121-1.414 1.414-2.121-2.121zm2.121-14.85l1.414 1.415-2.121 2.121-1.414-1.414 2.121-2.121zM5.636 16.95l1.414 1.414-2.121 2.121-1.414-1.414 2.121-2.121zM23 11v2h-3v-2h3zM4 11v2H1v-2h3z"/></svg></span>';
    echo '<span class="dark-mode-icon dark"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 7a7 7 0 0 0 12 4.9v.1c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2h.1A6.979 6.979 0 0 0 10 7zm-6 5a8 8 0 0 0 15.062 3.762A9 9 0 0 1 8.238 4.938 7.999 7.999 0 0 0 4 12z"/></svg></span>';
    echo '</button>';
}

/**
 * Displays the phone CTA in the header.
 */
function pdtai_phone_cta() {
    $phone = get_option('pdtai_phone_number', '+880 1234-567890');
    if ($phone) {
        echo '<div class="phone-cta">';
        echo '<a href="tel:' . esc_attr(preg_replace('/[^0-9+]/', '', $phone)) . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"/></svg>';
        echo '<span>' . esc_html($phone) . '</span>';
        echo '</a>';
        echo '</div>';
    }
}

/**
 * Displays social media icons.
 */
function pdtai_social_icons() {
    $facebook = get_option('pdtai_facebook_url', '#');
    $twitter = get_option('pdtai_twitter_url', '#');
    $instagram = get_option('pdtai_instagram_url', '#');
    $linkedin = get_option('pdtai_linkedin_url', '#');
    $youtube = get_option('pdtai_youtube_url', '');
    
    echo '<div class="social-icons">';
    
    if ($facebook) {
        echo '<a href="' . esc_url($facebook) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__('Facebook', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>';
        echo '</a>';
    }
    
    if ($twitter) {
        echo '<a href="' . esc_url($twitter) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__('Twitter', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M22.162 5.656a8.384 8.384 0 0 1-2.402.658A4.196 4.196 0 0 0 21.6 4c-.82.488-1.719.83-2.656 1.015a4.182 4.182 0 0 0-7.126 3.814 11.874 11.874 0 0 1-8.62-4.37 4.168 4.168 0 0 0-.566 2.103c0 1.45.738 2.731 1.86 3.481a4.168 4.168 0 0 1-1.894-.523v.052a4.185 4.185 0 0 0 3.355 4.101 4.21 4.21 0 0 1-1.89.072A4.185 4.185 0 0 0 7.97 16.65a8.394 8.394 0 0 1-6.191 1.732 11.83 11.83 0 0 0 6.41 1.88c7.693 0 11.9-6.373 11.9-11.9 0-.18-.005-.362-.013-.54a8.496 8.496 0 0 0 2.087-2.165z"/></svg>';
        echo '</a>';
    }
    
    if ($instagram) {
        echo '<a href="' . esc_url($instagram) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__('Instagram', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-2a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6.5-.25a1.25 1.25 0 0 1-2.5 0 1.25 1.25 0 0 1 2.5 0zM12 4c-2.474 0-2.878.007-4.029.058-.784.037-1.31.142-1.798.332-.434.168-.747.369-1.08.703a2.89 2.89 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.006 9.075 4 9.461 4 12c0 2.474.007 2.878.058 4.029.037.783.142 1.31.331 1.797.17.435.37.748.702 1.08.337.336.65.537 1.08.703.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.474 0 2.878-.007 4.029-.058.782-.037 1.309-.142 1.797-.331.433-.169.748-.37 1.08-.702.337-.337.538-.65.704-1.08.19-.493.296-1.02.332-1.8.052-1.104.058-1.49.058-4.029 0-2.474-.007-2.878-.058-4.029-.037-.782-.142-1.31-.332-1.798a2.911 2.911 0 0 0-.703-1.08 2.884 2.884 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.925 4.006 14.539 4 12 4zm0-2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2z"/></svg>';
        echo '</a>';
    }
    
    if ($linkedin) {
        echo '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__('LinkedIn', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M6.94 5a2 2 0 1 1-4-.002 2 2 0 0 1 4 .002zM7 8.48H3V21h4V8.48zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68z"/></svg>';
        echo '</a>';
    }
    
    if ($youtube) {
        echo '<a href="' . esc_url($youtube) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__('YouTube', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>';
        echo '</a>';
    }
    
    echo '</div>';
}

/**
 * Displays the footer widgets.
 */
function pdtai_footer_widgets() {
    if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) {
        echo '<div class="footer-widgets">';
        
        // Footer Widget Area 1
        if (is_active_sidebar('footer-1')) {
            echo '<div class="footer-widget footer-widget-1">';
            dynamic_sidebar('footer-1');
            echo '</div>';
        }
        
        // Footer Widget Area 2
        if (is_active_sidebar('footer-2')) {
            echo '<div class="footer-widget footer-widget-2">';
            dynamic_sidebar('footer-2');
            echo '</div>';
        }
        
        // Footer Widget Area 3
        if (is_active_sidebar('footer-3')) {
            echo '<div class="footer-widget footer-widget-3">';
            dynamic_sidebar('footer-3');
            echo '</div>';
        }
        
        // Footer Widget Area 4
        if (is_active_sidebar('footer-4')) {
            echo '<div class="footer-widget footer-widget-4">';
            dynamic_sidebar('footer-4');
            echo '</div>';
        }
        
        echo '</div>';
    }
}

/**
 * Displays the footer contact information.
 */
function pdtai_footer_contact_info() {
    $address = get_option('pdtai_clinic_address', 'Dhaka Medical College Hospital, Dhaka, Bangladesh');
    $phone = get_option('pdtai_phone_number', '+880 1234-567890');
    $email = get_option('pdtai_email_address', 'info@oralcancerpdt.com');
    $hours = get_option('pdtai_clinic_hours', 'Mon-Fri: 9:00 AM - 5:00 PM');
    
    echo '<div class="footer-contact-info">';
    echo '<h3>' . esc_html__('Contact Us', 'oralcancerpdt') . '</h3>';
    
    if ($address) {
        echo '<div class="contact-item address">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 20.9l4.95-4.95a7 7 0 1 0-9.9 0L12 20.9zm0 2.828l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zM12 13a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>';
        echo '<span>' . esc_html($address) . '</span>';
        echo '</div>';
    }
    
    if ($phone) {
        echo '<div class="contact-item phone">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"/></svg>';
        echo '<a href="tel:' . esc_attr(preg_replace('/[^0-9+]/', '', $phone)) . '">' . esc_html($phone) . '</a>';
        echo '</div>';
    }
    
    if ($email) {
        echo '<div class="contact-item email">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"/></svg>';
        echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
        echo '</div>';
    }
    
    if ($hours) {
        echo '<div class="contact-item hours">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8h4v2h-6V7h2v5z"/></svg>';
        echo '<span>' . esc_html($hours) . '</span>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Displays the footer map.
 */
function pdtai_footer_map() {
    $map_embed = get_option('pdtai_map_embed', '');
    
    echo '<div class="footer-map">';
    if (!empty($map_embed)) {
        echo $map_embed; // This should be properly sanitized in the theme options
    } else {
        // Fallback map placeholder
        echo '<div class="map-placeholder">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 20.9l4.95-4.95a7 7 0 1 0-9.9 0L12 20.9zm0 2.828l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zM12 13a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>';
        echo '<p>' . esc_html__('Map loading...', 'oralcancerpdt') . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

/**
 * Displays the copyright text.
 */
function pdtai_copyright_text() {
    $copyright_text = get_option('pdtai_copyright_text', '© ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('All rights reserved.', 'oralcancerpdt'));
    echo '<div class="copyright">';
    echo wp_kses_post($copyright_text);
    echo '</div>';
}

/**
 * Displays the back to top button.
 */
function pdtai_back_to_top() {
    echo '<a href="#page" class="back-to-top" aria-label="' . esc_attr__('Back to top', 'oralcancerpdt') . '">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/></svg>';
    echo '</a>';
}

/**
 * Displays the floating chat widget.
 */
function pdtai_floating_chat() {
    $chat_enabled = get_option('pdtai_enable_chat', true);
    
    if ($chat_enabled) {
        echo '<div class="floating-chat-widget" id="floatingChat">';
        echo '<button class="chat-toggle" id="chatToggle" aria-label="' . esc_attr__('Open chat', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 3h4a8 8 0 1 1 0 16v3.5c-5-2-12-5-12-11.5a8 8 0 0 1 8-8zm2 14h2a6 6 0 1 0 0-12h-4a6 6 0 0 0-6 6c0 3.61 2.462 5.966 8 8.48V17z"/></svg>';
        echo '</button>';
        echo '<div class="chat-window" id="chatWindow">';
        echo '<div class="chat-header">';
        echo '<h3>' . esc_html__('Chat with us', 'oralcancerpdt') . '</h3>';
        echo '<button class="close-chat" id="closeChat" aria-label="' . esc_attr__('Close chat', 'oralcancerpdt') . '">&times;</button>';
        echo '</div>';
        echo '<div class="chat-messages" id="chatMessages">';
        echo '<div class="message bot">';
        echo '<p>' . esc_html__('Hello! How can we help you today?', 'oralcancerpdt') . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="chat-input">';
        echo '<input type="text" id="chatInput" placeholder="' . esc_attr__('Type your message...', 'oralcancerpdt') . '">';
        echo '<button id="sendMessage" aria-label="' . esc_attr__('Send message', 'oralcancerpdt') . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"/></svg>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Displays a section heading with optional subtitle.
 */
function pdtai_section_heading($title, $subtitle = '') {
    echo '<div class="section-heading">';
    echo '<h2>' . esc_html($title) . '</h2>';
    if (!empty($subtitle)) {
        echo '<p class="section-subtitle">' . esc_html($subtitle) . '</p>';
    }
    echo '</div>';
}

/**
 * Displays a button with optional icon.
 */
function pdtai_button($text, $url, $class = '', $icon = '') {
    $button_class = 'btn ' . $class;
    echo '<a href="' . esc_url($url) . '" class="' . esc_attr($button_class) . '">';
    if (!empty($icon)) {
        echo '<span class="btn-icon">' . $icon . '</span>';
    }
    echo '<span class="btn-text">' . esc_html($text) . '</span>';
    echo '</a>';
}

/**
 * Displays a collapsible content section.
 */
function pdtai_collapsible($title, $content, $id, $is_open = false) {
    $expanded = $is_open ? 'true' : 'false';
    $hidden = $is_open ? 'false' : 'true';
    $active_class = $is_open ? ' active' : '';
    
    echo '<div class="collapsible' . $active_class . '">';
    echo '<button class="collapsible-trigger" id="trigger-' . esc_attr($id) . '" aria-expanded="' . $expanded . '" aria-controls="content-' . esc_attr($id) . '">';
    echo esc_html($title);
    echo '<svg class="collapsible-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>';
    echo '</button>';
    echo '<div class="collapsible-content" id="content-' . esc_attr($id) . '" aria-hidden="' . $hidden . '">';
    echo '<div class="collapsible-inner">';
    echo wp_kses_post($content);
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

/**
 * Displays a tooltip.
 */
function pdtai_tooltip($text, $tooltip, $tag = 'span', $class = '') {
    echo '<' . $tag . ' class="has-tooltip ' . esc_attr($class) . '">';
    echo esc_html($text);
    echo '<span class="tooltip">' . wp_kses_post($tooltip) . '</span>';
    echo '</' . $tag . '>';
}

/**
 * Displays a card.
 */
function pdtai_card($title, $content, $image = '', $link = '', $class = '') {
    $card_class = 'card ' . $class;
    $has_link = !empty($link);
    
    echo '<div class="' . esc_attr($card_class) . '">';
    
    if (!empty($image)) {
        echo '<div class="card-image">';
        if ($has_link) {
            echo '<a href="' . esc_url($link) . '">';
        }
        echo $image; // This should be an img tag or background style
        if ($has_link) {
            echo '</a>';
        }
        echo '</div>';
    }
    
    echo '<div class="card-content">';
    echo '<h3 class="card-title">';
    if ($has_link) {
        echo '<a href="' . esc_url($link) . '">';
    }
    echo esc_html($title);
    if ($has_link) {
        echo '</a>';
    }
    echo '</h3>';
    echo '<div class="card-text">';
    echo wp_kses_post($content);
    echo '</div>';
    echo '</div>';
    
    echo '</div>';
}

/**
 * Displays a team member card.
 */
function pdtai_team_member_card($post_id) {
    $title = get_the_title($post_id);
    $position = get_post_meta($post_id, '_pdtai_team_position', true);
    $image = get_the_post_thumbnail($post_id, 'team-thumbnail');
    $permalink = get_permalink($post_id);
    
    echo '<div class="team-member-card">';
    
    echo '<div class="team-member-image">';
    if (!empty($image)) {
        echo '<a href="' . esc_url($permalink) . '">';
        echo $image;
        echo '</a>';
    } else {
        // Placeholder image
        echo '<a href="' . esc_url($permalink) . '" class="team-placeholder">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/></svg>';
        echo '</a>';
    }
    echo '</div>';
    
    echo '<div class="team-member-info">';
    echo '<h3 class="team-member-name"><a href="' . esc_url($permalink) . '">' . esc_html($title) . '</a></h3>';
    if (!empty($position)) {
        echo '<p class="team-member-position">' . esc_html($position) . '</p>';
    }
    
    // Get team roles
    $roles = get_the_terms($post_id, 'team_role');
    if (!empty($roles) && !is_wp_error($roles)) {
        echo '<div class="team-member-roles">';
        $role_names = array();
        foreach ($roles as $role) {
            $role_names[] = $role->name;
        }
        echo esc_html(implode(', ', $role_names));
        echo '</div>';
    }
    
    echo '</div>';
    
    echo '</div>';
}

/**
 * Displays a service card.
 */
function pdtai_service_card($post_id) {
    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $image = get_the_post_thumbnail($post_id, 'service-thumbnail');
    $permalink = get_permalink($post_id);
    $icon = get_post_meta($post_id, '_pdtai_service_icon', true);
    $cta_text = get_post_meta($post_id, '_pdtai_service_cta_text', true);
    $cta_url = get_post_meta($post_id, '_pdtai_service_cta_url', true);
    
    if (empty($cta_text)) {
        $cta_text = __('Learn More', 'oralcancerpdt');
    }
    
    if (empty($cta_url)) {
        $cta_url = $permalink;
    }
    
    echo '<div class="service-card">';
    
    if (!empty($image)) {
        echo '<div class="service-image">';
        echo '<a href="' . esc_url($permalink) . '">';
        echo $image;
        echo '</a>';
        echo '</div>';
    }
    
    echo '<div class="service-content">';
    
    if (!empty($icon)) {
        echo '<div class="service-icon"><i class="' . esc_attr($icon) . '"></i></div>';
    }
    
    echo '<h3 class="service-title"><a href="' . esc_url($permalink) . '">' . esc_html($title) . '</a></h3>';
    
    if (!empty($excerpt)) {
        echo '<div class="service-excerpt">' . wp_kses_post($excerpt) . '</div>';
    }
    
    echo '<a href="' . esc_url($cta_url) . '" class="btn btn-outline">' . esc_html($cta_text) . '</a>';
    
    echo '</div>';
    
    echo '</div>';
}

/**
 * Displays a testimonial card.
 */
function pdtai_testimonial_card($post_id) {
    $content = get_the_content(null, false, $post_id);
    $client_name = get_post_meta($post_id, '_pdtai_testimonial_client_name', true);
    $client_title = get_post_meta($post_id, '_pdtai_testimonial_client_title', true);
    $rating = get_post_meta($post_id, '_pdtai_testimonial_rating', true);
    $image = get_the_post_thumbnail($post_id, 'thumbnail');
    
    if (empty($client_name)) {
        $client_name = get_the_title($post_id);
    }
    
    echo '<div class="testimonial-card">';
    
    echo '<div class="testimonial-content">';
    echo '<svg class="quote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/></svg>';
    echo wp_kses_post($content);
    echo '</div>';
    
    if (!empty($rating)) {
        echo '<div class="testimonial-rating">';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                echo '<span class="star filled">★</span>';
            } else {
                echo '<span class="star">☆</span>';
            }
        }
        echo '</div>';
    }
    
    echo '<div class="testimonial-author">';
    
    if (!empty($image)) {
        echo '<div class="testimonial-author-image">';
        echo $image;
        echo '</div>';
    }
    
    echo '<div class="testimonial-author-info">';
    echo '<div class="testimonial-author-name">' . esc_html($client_name) . '</div>';
    if (!empty($client_title)) {
        echo '<div class="testimonial-author-title">' . esc_html($client_title) . '</div>';
    }
    echo '</div>';
    
    echo '</div>';
    
    echo '</div>';
}

/**
 * Displays a research publication card.
 */
function pdtai_research_card($post_id) {
    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $permalink = get_permalink($post_id);
    $authors = get_post_meta($post_id, '_pdtai_research_authors', true);
    $journal = get_post_meta($post_id, '_pdtai_research_journal', true);
    $publication_date = get_post_meta($post_id, '_pdtai_research_date', true);
    $external_url = get_post_meta($post_id, '_pdtai_research_url', true);
    
    if (!empty($external_url)) {
        $link_url = $external_url;
    } else {
        $link_url = $permalink;
    }
    
    echo '<div class="research-card">';
    
    echo '<h3 class="research-title"><a href="' . esc_url($link_url) . '"' . (!empty($external_url) ? ' target="_blank" rel="noopener noreferrer"' : '') . '>' . esc_html($title) . '</a></h3>';
    
    if (!empty($authors)) {
        echo '<div class="research-authors">' . esc_html($authors) . '</div>';
    }
    
    if (!empty($journal)) {
        echo '<div class="research-journal">';
        echo esc_html($journal);
        if (!empty($publication_date)) {
            echo ' (' . esc_html(date_i18n(get_option('date_format'), strtotime($publication_date))) . ')';
        }
        echo '</div>';
    }
    
    if (!empty($excerpt)) {
        echo '<div class="research-excerpt">' . wp_kses_post($excerpt) . '</div>';
    }
    
    echo '<a href="' . esc_url($link_url) . '" class="btn btn-text"' . (!empty($external_url) ? ' target="_blank" rel="noopener noreferrer"' : '') . '>';
    echo esc_html__('Read More', 'oralcancerpdt');
    if (!empty($external_url)) {
        echo ' <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z"/></svg>';
    }
    echo '</a>';
    
    echo '</div>';
}

/**
 * Displays an FAQ item.
 */
function pdtai_faq_item($post_id, $is_open = false) {
    $title = get_the_title($post_id);
    $content = get_the_content(null, false, $post_id);
    $id = 'faq-' . $post_id;
    
    pdtai_collapsible($title, $content, $id, $is_open);
}