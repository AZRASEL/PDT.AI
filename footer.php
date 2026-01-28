<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PDT.AI
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-widget-area footer-widget-1">
                    <div class="footer-logo">
                        <?php 
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if ($logo) :
                        ?>
                            <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="footer-logo-img">
                        <?php else : ?>
                            <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
                        <?php endif; ?>
                    </div>
                    <div class="footer-description">
                        <?php echo wp_kses_post(get_option('pdtai_footer_description', esc_html__('Specialized clinic for Photodynamic Therapy (PDT) treatment of oral cancer and precancerous lesions.', 'oralcancerpdt'))); ?>
                    </div>
                    <div class="social-links">
                        <?php
                        $social_links = array(
                            'facebook' => get_option('pdtai_facebook_url', ''),
                            'twitter' => get_option('pdtai_twitter_url', ''),
                            'instagram' => get_option('pdtai_instagram_url', ''),
                            'linkedin' => get_option('pdtai_linkedin_url', ''),
                            'youtube' => get_option('pdtai_youtube_url', ''),
                        );

                        foreach ($social_links as $platform => $url) :
                            if (!empty($url)) :
                        ?>
                                <a href="<?php echo esc_url($url); ?>" class="social-link <?php echo esc_attr($platform); ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="screen-reader-text"><?php echo esc_html(ucfirst($platform)); ?></span>
                                    <?php 
                                    // SVG icons for social media
                                    switch ($platform) {
                                        case 'facebook':
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>';
                                            break;
                                        case 'twitter':
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>';
                                            break;
                                        case 'instagram':
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>';
                                            break;
                                        case 'linkedin':
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>';
                                            break;
                                        case 'youtube':
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>';
                                            break;
                                    }
                                    ?>
                                </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
                
                <div class="footer-widget-area footer-widget-2">
                    <h3 class="footer-widget-title"><?php esc_html_e('Quick Links', 'oralcancerpdt'); ?></h3>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-1',
                            'menu_id'        => 'footer-menu-1',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </div>
                
                <div class="footer-widget-area footer-widget-3">
                    <h3 class="footer-widget-title"><?php esc_html_e('Services', 'oralcancerpdt'); ?></h3>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-2',
                            'menu_id'        => 'footer-menu-2',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </div>
                
                <div class="footer-widget-area footer-widget-4">
                    <h3 class="footer-widget-title"><?php esc_html_e('Contact Us', 'oralcancerpdt'); ?></h3>
                    <address class="contact-info">
                        <?php if ($address = get_option('pdtai_clinic_address', '')) : ?>
                            <div class="contact-item address">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span><?php echo wp_kses_post($address); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($phone = get_option('pdtai_phone_number', '')) : ?>
                            <div class="contact-item phone">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($email = get_option('pdtai_email_address', '')) : ?>
                            <div class="contact-item email">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($hours = get_option('pdtai_clinic_hours', '')) : ?>
                            <div class="contact-item hours">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span><?php echo wp_kses_post($hours); ?></span>
                            </div>
                        <?php endif; ?>
                    </address>
                    
                    <?php if (get_option('pdtai_show_map', 1)) : ?>
                        <div class="footer-map">
                            <!-- Map placeholder - replace with actual Google Maps embed or other map solution -->
                            <div class="map-placeholder">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/map-placeholder.svg'); ?>" alt="<?php esc_attr_e('Clinic Location Map', 'oralcancerpdt'); ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="site-info">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'oralcancerpdt'); ?>
                </div>
                <div class="footer-links">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-legal',
                            'menu_id'        => 'footer-legal-menu',
                            'container'      => false,
                            'menu_class'     => 'footer-legal-menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </div>
            </div><!-- .site-info -->
        </div>
    </footer><!-- #colophon -->
    
    <?php if (get_option('pdtai_enable_floating_chat', 1)) : ?>
    <div class="floating-chat-widget" id="floating-chat-widget">
        <button class="chat-toggle" aria-label="<?php esc_attr_e('Toggle chat', 'oralcancerpdt'); ?>" id="chat-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="chat-icon">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="close-icon" style="display: none;">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="chat-container" id="chat-container" style="display: none;">
            <div class="chat-header">
                <h3><?php esc_html_e('PDT.AI Assistant', 'oralcancerpdt'); ?></h3>
                <p><?php esc_html_e('Ask questions about PDT treatment', 'oralcancerpdt'); ?></p>
            </div>
            <div class="chat-messages" id="chat-messages">
                <div class="message bot">
                    <div class="message-content">
                        <?php esc_html_e('Hello! I\'m PDT.AI, your assistant for Photodynamic Therapy information. How can I help you today?', 'oralcancerpdt'); ?>
                    </div>
                </div>
            </div>
            <div class="chat-input">
                <input type="text" id="chat-input-field" placeholder="<?php esc_attr_e('Type your question here...', 'oralcancerpdt'); ?>">
                <button id="chat-send-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (get_option('pdtai_enable_back_to_top', 1)) : ?>
    <a href="#" class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'oralcancerpdt'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </a>
    <?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>