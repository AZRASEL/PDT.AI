/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Primary color.
	wp.customize( 'pdtai_primary_color', function( value ) {
		value.bind( function( to ) {
			// Update custom color CSS
			var style = $( '#pdtai-primary-color' ),
				darker = adjustBrightness(to, -20);

			if ( ! style.length ) {
				style = $( 'head' ).append( '<style id="pdtai-primary-color"></style>' )
					.find( '#pdtai-primary-color' );
			}

			style.html( '\
				:root { --color-primary: ' + to + '; }\
				.btn-primary { background-color: ' + to + '; border-color: ' + to + '; }\
				.btn-primary:hover, .btn-primary:focus { background-color: ' + darker + '; border-color: ' + darker + '; }\
				a { color: ' + to + '; }\
				a:hover, a:focus { color: ' + darker + '; }\
				.main-navigation a:hover, .main-navigation .current-menu-item > a { color: ' + to + '; }\
				.collapsible-trigger[aria-expanded="true"] { color: ' + to + '; border-color: ' + to + '; }\
				.floating-chat-widget .chat-toggle { background-color: ' + to + '; }\
				.floating-chat-widget .chat-toggle:hover { background-color: ' + darker + '; }\
				.floating-chat-widget .chat-header { background-color: ' + to + '; }\
				.back-to-top { background-color: ' + to + '; }\
				.back-to-top:hover { background-color: ' + darker + '; }\
				.dark-mode-toggle:hover { color: ' + to + '; }\
				.hero-section { background-color: ' + to + '; background-image: linear-gradient(135deg, ' + to + ', ' + darker + '); }\
				.language-switcher .active a { color: ' + to + '; }\
				.phone-cta a { color: ' + to + '; }\
				.team-member-card:hover, .service-card:hover, .research-card:hover { border-color: ' + to + '; }\
				.pagination .current { background-color: ' + to + '; border-color: ' + to + '; }\
				.wp-block-button__link { background-color: ' + to + '; }\
				.wp-block-button__link:hover { background-color: ' + darker + '; }\
				.wp-block-quote { border-left-color: ' + to + '; }\
				.has-tooltip .tooltip { background-color: ' + to + '; }\
				.has-tooltip .tooltip:after { border-top-color: ' + to + '; }\
			' );
		} );
	} );

	// Secondary color.
	wp.customize( 'pdtai_secondary_color', function( value ) {
		value.bind( function( to ) {
			var style = $( '#pdtai-secondary-color' ),
				darker = adjustBrightness(to, -20);

			if ( ! style.length ) {
				style = $( 'head' ).append( '<style id="pdtai-secondary-color"></style>' )
					.find( '#pdtai-secondary-color' );
			}

			style.html( '\
				:root { --color-secondary: ' + to + '; }\
				.btn-secondary { background-color: ' + to + '; border-color: ' + to + '; }\
				.btn-secondary:hover, .btn-secondary:focus { background-color: ' + darker + '; border-color: ' + darker + '; }\
				.dark-mode-toggle { color: ' + to + '; }\
			' );
		} );
	} );

	// Accent color.
	wp.customize( 'pdtai_accent_color', function( value ) {
		value.bind( function( to ) {
			var style = $( '#pdtai-accent-color' ),
				darker = adjustBrightness(to, -20);

			if ( ! style.length ) {
				style = $( 'head' ).append( '<style id="pdtai-accent-color"></style>' )
					.find( '#pdtai-accent-color' );
			}

			style.html( '\
				:root { --color-accent: ' + to + '; }\
				.btn-accent { background-color: ' + to + '; border-color: ' + to + '; }\
				.btn-accent:hover, .btn-accent:focus { background-color: ' + darker + '; border-color: ' + darker + '; }\
				.section-title:after { background-color: ' + to + '; }\
				.testimonial-rating .star.filled { color: ' + to + '; }\
				.dark-mode .main-navigation a:hover, .dark-mode .main-navigation .current-menu-item > a { color: ' + to + '; }\
				.dark-mode .dark-mode-toggle:hover { color: ' + to + '; }\
				.footer-widget h3:after { background-color: ' + to + '; }\
				.footer-contact-info .contact-item svg { color: ' + to + '; }\
				.social-icons a:hover svg { color: ' + to + '; }\
				.dark-mode .social-icons a:hover svg { color: ' + to + '; }\
				.dark-mode .language-switcher .active a { color: ' + to + '; }\
				.dark-mode .phone-cta a { color: ' + to + '; }\
				.dark-mode .wp-block-quote { border-left-color: ' + to + '; }\
				.dark-mode .has-tooltip .tooltip { background-color: ' + to + '; }\
				.dark-mode .has-tooltip .tooltip:after { border-top-color: ' + to + '; }\
			' );
		} );
	} );

	// Container width.
	wp.customize( 'pdtai_container_width', function( value ) {
		value.bind( function( to ) {
			var style = $( '#pdtai-container-width' );

			if ( ! style.length ) {
				style = $( 'head' ).append( '<style id="pdtai-container-width"></style>' )
					.find( '#pdtai-container-width' );
			}

			style.html( '\
				:root { --container-width: ' + to + 'px; }\
				.container, .container-narrow { max-width: ' + to + 'px; }\
			' );
		} );
	} );

	// Hero title.
	wp.customize( 'pdtai_hero_title', function( value ) {
		value.bind( function( to ) {
			$( '.hero-title' ).text( to );
		} );
	} );

	// Hero subtitle.
	wp.customize( 'pdtai_hero_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '.hero-subtitle' ).text( to );
		} );
	} );

	// Hero button text.
	wp.customize( 'pdtai_hero_button_text', function( value ) {
		value.bind( function( to ) {
			$( '.hero-cta .btn-primary' ).text( to );
		} );
	} );

	// Hero button URL.
	wp.customize( 'pdtai_hero_button_url', function( value ) {
		value.bind( function( to ) {
			$( '.hero-cta .btn-primary' ).attr( 'href', to );
		} );
	} );

	// Phone number.
	wp.customize( 'pdtai_phone_number', function( value ) {
		value.bind( function( to ) {
			$( '.phone-cta a' ).text( to );
			$( '.phone-cta a' ).attr( 'href', 'tel:' + to.replace(/[^0-9+]/g, '') );
			$( '.footer-contact-info .contact-phone a' ).text( to );
			$( '.footer-contact-info .contact-phone a' ).attr( 'href', 'tel:' + to.replace(/[^0-9+]/g, '') );
		} );
	} );

	// Clinic address.
	wp.customize( 'pdtai_clinic_address', function( value ) {
		value.bind( function( to ) {
			$( '.footer-contact-info .contact-address' ).text( to );
		} );
	} );

	// Email address.
	wp.customize( 'pdtai_email_address', function( value ) {
		value.bind( function( to ) {
			$( '.footer-contact-info .contact-email a' ).text( to );
			$( '.footer-contact-info .contact-email a' ).attr( 'href', 'mailto:' + to );
		} );
	} );

	// Clinic hours.
	wp.customize( 'pdtai_clinic_hours', function( value ) {
		value.bind( function( to ) {
			$( '.footer-contact-info .contact-hours' ).text( to );
		} );
	} );

	// Copyright text.
	wp.customize( 'pdtai_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-info .copyright' ).html( to );
		} );
	} );

	// Helper function to adjust brightness of a hex color
	function adjustBrightness(hex, steps) {
		// Remove # if present
		hex = hex.replace(/^#/, '');
		
		// Parse r, g, b values
		var r = parseInt(hex.substring(0, 2), 16);
		var g = parseInt(hex.substring(2, 4), 16);
		var b = parseInt(hex.substring(4, 6), 16);
		
		// Adjust brightness
		r = Math.max(0, Math.min(255, r + steps));
		g = Math.max(0, Math.min(255, g + steps));
		b = Math.max(0, Math.min(255, b + steps));
		
		// Convert back to hex
		return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
	}

} )( jQuery );