<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PDT.AI
 */

get_header();
?>

<main id="primary" class="site-main front-page">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo esc_html(get_option('pdtai_hero_title', __('Advanced Photodynamic Therapy for Oral Cancer', 'oralcancerpdt'))); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html(get_option('pdtai_hero_subtitle', __('Innovative, Non-Invasive Treatment for Oral Cancer and Precancerous Lesions', 'oralcancerpdt'))); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(get_option('pdtai_appointment_url', '#appointment')); ?>" class="btn btn-primary"><?php esc_html_e('Book Appointment', 'oralcancerpdt'); ?></a>
                    <a href="<?php echo esc_url(get_option('pdtai_learn_more_url', '#about-pdt')); ?>" class="btn btn-secondary"><?php esc_html_e('Learn More', 'oralcancerpdt'); ?></a>
                </div>
            </div>
            <div class="hero-image">
                <?php 
                $hero_image_id = get_option('pdtai_hero_image');
                if ($hero_image_id) :
                    echo wp_get_attachment_image($hero_image_id, 'full', false, array('class' => 'hero-img'));
                else :
                ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-placeholder.svg'); ?>" alt="<?php esc_attr_e('Photodynamic Therapy Illustration', 'oralcancerpdt'); ?>" class="hero-img">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_features_title', __('Why Choose PDT Treatment', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_features_subtitle', __('Benefits of Photodynamic Therapy for Oral Cancer', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="features-grid">
                <?php
                $features = array(
                    array(
                        'icon' => 'non-invasive',
                        'title' => __('Non-Invasive', 'oralcancerpdt'),
                        'description' => __('Gentle treatment without surgical incisions, preserving healthy tissue and oral function.', 'oralcancerpdt'),
                    ),
                    array(
                        'icon' => 'targeted',
                        'title' => __('Targeted Therapy', 'oralcancerpdt'),
                        'description' => __('Precisely targets cancer cells while minimizing damage to surrounding healthy tissues.', 'oralcancerpdt'),
                    ),
                    array(
                        'icon' => 'minimal-side-effects',
                        'title' => __('Minimal Side Effects', 'oralcancerpdt'),
                        'description' => __('Fewer complications compared to conventional treatments like surgery or radiation.', 'oralcancerpdt'),
                    ),
                    array(
                        'icon' => 'outpatient',
                        'title' => __('Outpatient Procedure', 'oralcancerpdt'),
                        'description' => __('Convenient treatment that can be performed in our clinic without hospital stay.', 'oralcancerpdt'),
                    ),
                    array(
                        'icon' => 'repeatable',
                        'title' => __('Repeatable Treatment', 'oralcancerpdt'),
                        'description' => __('Can be safely repeated if necessary without cumulative toxicity concerns.', 'oralcancerpdt'),
                    ),
                    array(
                        'icon' => 'cost-effective',
                        'title' => __('Cost-Effective', 'oralcancerpdt'),
                        'description' => __('More affordable than many conventional cancer treatments with shorter recovery time.', 'oralcancerpdt'),
                    ),
                );

                // Allow customization through options
                $custom_features = get_option('pdtai_custom_features');
                if (is_array($custom_features) && !empty($custom_features)) {
                    $features = $custom_features;
                }

                foreach ($features as $feature) :
                ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <?php 
                            // SVG icons based on feature type
                            switch ($feature['icon']) {
                                case 'non-invasive':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>';
                                    break;
                                case 'targeted':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>';
                                    break;
                                case 'minimal-side-effects':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>';
                                    break;
                                case 'outpatient':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>';
                                    break;
                                case 'repeatable':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>';
                                    break;
                                case 'cost-effective':
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>';
                                    break;
                                default:
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
                            }
                            ?>
                        </div>
                        <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                        <p class="feature-description"><?php echo esc_html($feature['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About PDT Section -->
    <section class="about-section" id="about-pdt">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_about_title', __('PDT for Oral Cancer', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_about_subtitle', __('Understanding Photodynamic Therapy Treatment', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <div class="collapsible-content">
                        <div class="collapsible-item">
                            <button class="collapsible-header" aria-expanded="true">
                                <h3><?php esc_html_e('What is Photodynamic Therapy?', 'oralcancerpdt'); ?></h3>
                                <span class="toggle-icon"></span>
                            </button>
                            <div class="collapsible-body" style="display: block;">
                                <p><?php echo wp_kses_post(get_option('pdtai_what_is_pdt', __('Photodynamic Therapy (PDT) is an innovative treatment that combines light-sensitive medications (photosensitizers) with specific wavelengths of light to destroy cancer cells. When the photosensitizer is exposed to light, it produces reactive oxygen species that selectively damage cancer cells while preserving healthy tissue.', 'oralcancerpdt'))); ?></p>
                            </div>
                        </div>
                        <div class="collapsible-item">
                            <button class="collapsible-header">
                                <h3><?php esc_html_e('How PDT Works', 'oralcancerpdt'); ?></h3>
                                <span class="toggle-icon"></span>
                            </button>
                            <div class="collapsible-body">
                                <p><?php echo wp_kses_post(get_option('pdtai_how_pdt_works', __('The PDT procedure involves three key steps:<br>1. <strong>Administration:</strong> A photosensitizing agent is applied topically or injected.<br>2. <strong>Accumulation:</strong> The agent concentrates in cancer cells over several hours.<br>3. <strong>Activation:</strong> Light of a specific wavelength is directed at the treatment area, activating the photosensitizer and destroying the cancer cells.', 'oralcancerpdt'))); ?></p>
                            </div>
                        </div>
                        <div class="collapsible-item">
                            <button class="collapsible-header">
                                <h3><?php esc_html_e('PDT for Oral Lesions', 'oralcancerpdt'); ?></h3>
                                <span class="toggle-icon"></span>
                            </button>
                            <div class="collapsible-body">
                                <p><?php echo wp_kses_post(get_option('pdtai_pdt_for_oral', __('PDT is particularly effective for treating:<br>• Early-stage oral cancers<br>• Precancerous lesions (oral leukoplakia, erythroplakia)<br>• Recurrent oral cancers after previous treatments<br>• Oral lesions in patients who cannot undergo surgery<br><br>The treatment is minimally invasive and can be performed in our outpatient clinic, making it an excellent option for many patients.', 'oralcancerpdt'))); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <?php 
                    $about_image_id = get_option('pdtai_about_image');
                    if ($about_image_id) :
                        echo wp_get_attachment_image($about_image_id, 'large', false, array('class' => 'about-img'));
                    else :
                    ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/pdt-treatment-placeholder.svg'); ?>" alt="<?php esc_attr_e('PDT Treatment Process', 'oralcancerpdt'); ?>" class="about-img">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Symptoms & Risk Factors Section -->
    <section class="symptoms-section" id="symptoms">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_symptoms_title', __('Symptoms & Local Risk Factors', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_symptoms_subtitle', __('Bangladesh Context', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="symptoms-content">
                <div class="symptoms-image">
                    <?php 
                    $symptoms_image_id = get_option('pdtai_symptoms_image');
                    if ($symptoms_image_id) :
                        echo wp_get_attachment_image($symptoms_image_id, 'large', false, array('class' => 'symptoms-img'));
                    else :
                    ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/symptoms-placeholder.svg'); ?>" alt="<?php esc_attr_e('Oral Cancer Symptoms', 'oralcancerpdt'); ?>" class="symptoms-img">
                    <?php endif; ?>
                </div>
                <div class="symptoms-text">
                    <div class="symptoms-list">
                        <h3><?php esc_html_e('Warning Signs to Watch For', 'oralcancerpdt'); ?></h3>
                        <ul>
                            <?php 
                            $symptoms = array(
                                __('Persistent mouth sores or ulcers that don\'t heal within 2-3 weeks', 'oralcancerpdt'),
                                __('White or red patches in the mouth (leukoplakia or erythroplakia)', 'oralcancerpdt'),
                                __('Persistent pain or soreness in the mouth or throat', 'oralcancerpdt'),
                                __('Difficulty chewing, swallowing, or moving the tongue/jaw', 'oralcancerpdt'),
                                __('Swelling or lumps in the mouth, neck, or face', 'oralcancerpdt'),
                                __('Persistent bad breath not explained by poor oral hygiene', 'oralcancerpdt'),
                            );
                            
                            $custom_symptoms = get_option('pdtai_custom_symptoms');
                            if (is_array($custom_symptoms) && !empty($custom_symptoms)) {
                                $symptoms = $custom_symptoms;
                            }
                            
                            foreach ($symptoms as $symptom) :
                            ?>
                                <li><?php echo esc_html($symptom); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="risk-factors">
                        <h3><?php esc_html_e('Local Risk Factors in Bangladesh', 'oralcancerpdt'); ?></h3>
                        <ul>
                            <?php 
                            $risk_factors = array(
                                __('Betel quid (paan) chewing with tobacco', 'oralcancerpdt'),
                                __('Smokeless tobacco products (jorda, gul, sadapata)', 'oralcancerpdt'),
                                __('Smoking bidis and cigarettes', 'oralcancerpdt'),
                                __('Areca nut (supari) consumption', 'oralcancerpdt'),
                                __('Poor oral hygiene and dental care', 'oralcancerpdt'),
                                __('Limited access to early screening services', 'oralcancerpdt'),
                            );
                            
                            $custom_risk_factors = get_option('pdtai_custom_risk_factors');
                            if (is_array($custom_risk_factors) && !empty($custom_risk_factors)) {
                                $risk_factors = $custom_risk_factors;
                            }
                            
                            foreach ($risk_factors as $factor) :
                            ?>
                                <li><?php echo esc_html($factor); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="cta-box">
                        <p><?php esc_html_e('If you notice any of these symptoms, please schedule an examination immediately.', 'oralcancerpdt'); ?></p>
                        <a href="<?php echo esc_url(get_option('pdtai_screening_url', '#appointment')); ?>" class="btn btn-primary"><?php esc_html_e('Book a Screening', 'oralcancerpdt'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PDT in Skin Care Section (Optional) -->
    <?php if (get_option('pdtai_show_skincare_section', true)) : ?>
    <section class="skincare-section" id="skincare">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_skincare_title', __('PDT in Skin Care', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_skincare_subtitle', __('Additional Applications of Photodynamic Therapy', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="skincare-content">
                <div class="skincare-text">
                    <p><?php echo wp_kses_post(get_option('pdtai_skincare_text', __('Beyond oral applications, our clinic also offers Photodynamic Therapy for various skin conditions. PDT has shown excellent results in treating:', 'oralcancerpdt'))); ?></p>
                    
                    <div class="skincare-cards">
                        <?php
                        $skin_conditions = array(
                            array(
                                'title' => __('Actinic Keratosis', 'oralcancerpdt'),
                                'description' => __('Precancerous skin lesions caused by sun damage', 'oralcancerpdt'),
                            ),
                            array(
                                'title' => __('Basal Cell Carcinoma', 'oralcancerpdt'),
                                'description' => __('The most common type of skin cancer', 'oralcancerpdt'),
                            ),
                            array(
                                'title' => __('Bowen's Disease', 'oralcancerpdt'),
                                'description' => __('Early form of skin cancer (squamous cell carcinoma in situ)', 'oralcancerpdt'),
                            ),
                            array(
                                'title' => __('Severe Acne', 'oralcancerpdt'),
                                'description' => __('Inflammatory acne that hasn't responded to other treatments', 'oralcancerpdt'),
                            ),
                        );
                        
                        $custom_skin_conditions = get_option('pdtai_custom_skin_conditions');
                        if (is_array($custom_skin_conditions) && !empty($custom_skin_conditions)) {
                            $skin_conditions = $custom_skin_conditions;
                        }
                        
                        foreach ($skin_conditions as $condition) :
                        ?>
                            <div class="skincare-card">
                                <h3><?php echo esc_html($condition['title']); ?></h3>
                                <p><?php echo esc_html($condition['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="skincare-cta">
                        <a href="<?php echo esc_url(get_option('pdtai_skincare_url', '#appointment')); ?>" class="btn btn-secondary"><?php esc_html_e('Learn More About Skin PDT', 'oralcancerpdt'); ?></a>
                    </div>
                </div>
                <div class="skincare-image">
                    <?php 
                    $skincare_image_id = get_option('pdtai_skincare_image');
                    if ($skincare_image_id) :
                        echo wp_get_attachment_image($skincare_image_id, 'large', false, array('class' => 'skincare-img'));
                    else :
                    ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/skin-pdt-placeholder.svg'); ?>" alt="<?php esc_attr_e('PDT for Skin Conditions', 'oralcancerpdt'); ?>" class="skincare-img">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Research & Collaboration Section -->
    <section class="research-section" id="research">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_research_title', __('Research & Collaboration', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_research_subtitle', __('Advancing PDT Technology Through Science', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="research-content">
                <div class="research-text">
                    <p><?php echo wp_kses_post(get_option('pdtai_research_text', __('Our clinic is actively involved in research to improve PDT techniques and outcomes. We collaborate with leading institutions to advance the science of photodynamic therapy for oral cancer treatment.', 'oralcancerpdt'))); ?></p>
                    
                    <div class="research-highlights">
                        <h3><?php esc_html_e('Current Research Focus', 'oralcancerpdt'); ?></h3>
                        <ul>
                            <?php 
                            $research_areas = array(
                                __('Optimizing light dosimetry for oral PDT applications', 'oralcancerpdt'),
                                __('Developing improved photosensitizers with higher tumor selectivity', 'oralcancerpdt'),
                                __('Clinical trials for PDT efficacy in various oral cancer stages', 'oralcancerpdt'),
                                __('PpIX fluorescence imaging for better tumor margin detection', 'oralcancerpdt'),
                                __('Combining PDT with other treatment modalities for enhanced outcomes', 'oralcancerpdt'),
                            );
                            
                            $custom_research_areas = get_option('pdtai_custom_research_areas');
                            if (is_array($custom_research_areas) && !empty($custom_research_areas)) {
                                $research_areas = $custom_research_areas;
                            }
                            
                            foreach ($research_areas as $area) :
                            ?>
                                <li><?php echo esc_html($area); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="collaboration-info">
                        <h3><?php esc_html_e('Our Partners', 'oralcancerpdt'); ?></h3>
                        <div class="partner-logos">
                            <?php
                            // Display partner logos if available
                            $partner_logos = get_option('pdtai_partner_logos');
                            if (is_array($partner_logos) && !empty($partner_logos)) :
                                foreach ($partner_logos as $logo_id) :
                                    echo wp_get_attachment_image($logo_id, 'medium', false, array('class' => 'partner-logo'));
                                endforeach;
                            else :
                                // Placeholder logos
                                for ($i = 1; $i <= 4; $i++) :
                            ?>
                                <div class="partner-logo-placeholder">
                                    <div class="placeholder-text"><?php esc_html_e('Partner Logo', 'oralcancerpdt'); ?></div>
                                </div>
                            <?php 
                                endfor;
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <div class="research-cta">
                        <a href="<?php echo esc_url(get_option('pdtai_research_url', '#contact')); ?>" class="btn btn-secondary"><?php esc_html_e('Research Collaboration Inquiries', 'oralcancerpdt'); ?></a>
                    </div>
                </div>
                <div class="research-image">
                    <?php 
                    $research_image_id = get_option('pdtai_research_image');
                    if ($research_image_id) :
                        echo wp_get_attachment_image($research_image_id, 'large', false, array('class' => 'research-img'));
                    else :
                    ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/research-placeholder.svg'); ?>" alt="<?php esc_attr_e('PDT Research', 'oralcancerpdt'); ?>" class="research-img">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment & Contact CTA Section -->
    <section class="appointment-section" id="appointment">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_appointment_title', __('Book Your Appointment', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_appointment_subtitle', __('Take the First Step Towards Advanced Cancer Care', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="appointment-content">
                <div class="appointment-form">
                    <?php echo do_shortcode('[pdtai_booking_form]'); ?>
                </div>
                <div class="appointment-info">
                    <div class="contact-details">
                        <h3><?php esc_html_e('Contact Information', 'oralcancerpdt'); ?></h3>
                        <address>
                            <?php if ($address = get_option('pdtai_clinic_address', '')) : ?>
                                <div class="contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <span><?php echo wp_kses_post($address); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($phone = get_option('pdtai_phone_number', '')) : ?>
                                <div class="contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($email = get_option('pdtai_email_address', '')) : ?>
                                <div class="contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($hours = get_option('pdtai_clinic_hours', '')) : ?>
                                <div class="contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    <span><?php echo wp_kses_post($hours); ?></span>
                                </div>
                            <?php endif; ?>
                        </address>
                    </div>
                    
                    <?php if (get_option('pdtai_show_map', 1)) : ?>
                        <div class="clinic-map">
                            <!-- Map placeholder - replace with actual Google Maps embed or other map solution -->
                            <div class="map-placeholder">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/map-placeholder.svg'); ?>" alt="<?php esc_attr_e('Clinic Location Map', 'oralcancerpdt'); ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (Optional) -->
    <?php if (get_option('pdtai_show_testimonials', true)) : ?>
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html(get_option('pdtai_testimonials_title', __('Patient Experiences', 'oralcancerpdt'))); ?></h2>
                <p class="section-subtitle"><?php echo esc_html(get_option('pdtai_testimonials_subtitle', __('What Our Patients Say About PDT Treatment', 'oralcancerpdt'))); ?></p>
            </div>
            <div class="testimonials-slider">
                <?php
                // Check if we have custom testimonials from CPT
                $testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => 5,
                ));
                
                if ($testimonials_query->have_posts()) :
                    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        $patient_name = get_post_meta(get_the_ID(), '_pdtai_patient_name', true);
                        $patient_location = get_post_meta(get_the_ID(), '_pdtai_patient_location', true);
                        $treatment_type = get_post_meta(get_the_ID(), '_pdtai_treatment_type', true);
                ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-quote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.2">
                                        <path d="M10 11H6.5C5.7 11 5 10.3 5 9.5v-2C5 6.7 5.7 6 6.5 6h2C9.3 6 10 6.7 10 7.5V11zm0 0v2c0 .8-.7 1.5-1.5 1.5h-2C5.7 14.5 5 13.8 5 13v-2h5zm9 0h-3.5c-.8 0-1.5-.7-1.5-1.5v-2c0-.8.7-1.5 1.5-1.5h2c.8 0 1.5.7 1.5 1.5V11zm0 0v2c0 .8-.7 1.5-1.5 1.5h-2c-.8 0-1.5-.7-1.5-1.5v-2h5z"/>
                                    </svg>
                                </div>
                                <div class="testimonial-text">
                                    <?php the_content(); ?>
                                </div>
                                <div class="testimonial-author">
                                    <div class="author-info">
                                        <h4 class="author-name"><?php echo esc_html($patient_name); ?></h4>
                                        <?php if ($patient_location) : ?>
                                            <p class="author-location"><?php echo esc_html($patient_location); ?></p>
                                        <?php endif; ?>
                                        <?php if ($treatment_type) : ?>
                                            <p class="treatment-type"><?php echo esc_html($treatment_type); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback testimonials
                    $testimonials = array(
                        array(
                            'content' => __('After trying multiple treatments for my oral lesion, PDT was the only one that worked without significant side effects. The procedure was quick and relatively painless. I'm grateful for the care I received.', 'oralcancerpdt'),
                            'name' => __('Ahmed H.', 'oralcancerpdt'),
                            'location' => __('Dhaka', 'oralcancerpdt'),
                            'treatment' => __('Oral Leukoplakia PDT', 'oralcancerpdt'),
                        ),
                        array(
                            'content' => __('I was diagnosed with early-stage oral cancer and was worried about surgery affecting my speech. The doctors recommended PDT, and I'm happy to say it successfully treated my cancer while preserving normal function.', 'oralcancerpdt'),
                            'name' => __('Fatima K.', 'oralcancerpdt'),
                            'location' => __('Chittagong', 'oralcancerpdt'),
                            'treatment' => __('Early Oral Cancer PDT', 'oralcancerpdt'),
                        ),
                        array(
                            'content' => __('The staff was incredibly supportive throughout my PDT treatment journey. They explained everything clearly and made sure I was comfortable. The results have been excellent with minimal recovery time.', 'oralcancerpdt'),
                            'name' => __('Rahman M.', 'oralcancerpdt'),
                            'location' => __('Sylhet', 'oralcancerpdt'),
                            'treatment' => __('Recurrent Lesion PDT', 'oralcancerpdt'),
                        ),
                    );
                    
                    foreach ($testimonials as $testimonial) :
                ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-quote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.2">
                                        <path d="M10 11H6.5C5.7 11 5 10.3 5 9.5v-2C5 6.7 5.7 6 6.5 6h2C9.3 6 10 6.7 10 7.5V11zm0 0v2c0 .8-.7 1.5-1.5 1.5h-2C5.7 14.5 5 13.8 5 13v-2h5zm9 0h-3.5c-.8 0-1.5-.7-1.5-1.5v-2c0-.8.7-1.5 1.5-1.5h2c.8 0 1.5.7 1.5 1.5V11zm0 0v2c0 .8-.7 1.5-1.5 1.5h-2c-.8 0-1.5-.7-1.5-1.5v-2h5z"/>
                                    </svg>
                                </div>
                                <div class="testimonial-text">
                                    <p><?php echo esc_html($testimonial['content']); ?></p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="author-info">
                                        <h4 class="author-name"><?php echo esc_html($testimonial['name']); ?></h4>
                                        <p class="author-location"><?php echo esc_html($testimonial['location']); ?></p>
                                        <p class="treatment-type"><?php echo esc_html($testimonial['treatment']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main><!-- #primary -->

<?php
get_footer();