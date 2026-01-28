# PDT.AI - Oral Cancer PDT Clinic WordPress Theme

A specialized WordPress theme for Photodynamic Therapy (PDT) clinics focusing on oral cancer treatment in Bangladesh.

## Quick Start

### ☁️ Run in Browser (WordPress Playground)
You can test this theme instantly in your browser without any installation:
[Launch in WordPress Playground](https://playground.wordpress.net/?theme=https://github.com/YOUR_USERNAME/YOUR_REPO&blueprint-url=https://raw.githubusercontent.com/YOUR_USERNAME/YOUR_REPO/main/blueprint.json)

*(Note: Replace `YOUR_USERNAME/YOUR_REPO` with your actual GitHub repository path after pushing)*

### 💻 Run in GitHub Codespaces
1. Click the **Code** button in GitHub.
2. Select the **Codespaces** tab.
3. Click **Create codespace on main**.

This will spin up a WordPress environment with the theme pre-installed at `http://localhost:8000`.

## Features

- **Responsive Design**: Fully responsive layout that works on all devices
- **Multilingual Support**: Built-in support for English and Bangla languages
- **Custom Post Types**: Specialized content types for Services, Team Members, Research Publications, Testimonials, and FAQs
- **Dark Mode Toggle**: User-selectable light/dark mode preference
- **Appointment Booking**: Integrated appointment booking functionality
- **Interactive Elements**: Tooltips, collapsible content, and interactive cards
- **SEO Optimized**: Built with search engine optimization best practices
- **Accessibility Ready**: Follows WCAG guidelines for accessibility

## Custom Post Types

1. **Services**: For PDT treatment services offered by the clinic
2. **Team Members**: For doctors, researchers, and staff profiles
3. **Research Publications**: For scientific papers and research related to PDT
4. **Testimonials**: For patient success stories and feedback
5. **FAQs**: For frequently asked questions about PDT treatment

## Theme Structure

```
pdtai/
├── 404.php                 # 404 error page template
├── archive.php             # Archive template
├── comments.php            # Comments template
├── footer.php              # Footer template
├── front-page.php          # Homepage template
├── functions.php           # Theme functions
├── header.php              # Header template
├── inc/                    # Theme includes
│   ├── custom-post-types.php  # Custom post type definitions
│   ├── customizer.php         # Theme customizer settings
│   ├── template-functions.php # Template helper functions
│   └── template-tags.php      # Template tag functions
├── index.php               # Main template file
├── js/                     # JavaScript files
│   └── customizer.js       # Customizer preview JS
├── languages/              # Translation files
│   ├── oralcancerpdt-bn_BD.po # Bangla translation
│   └── oralcancerpdt.pot      # Translation template
├── page.php                # Page template
├── README.md               # Theme documentation
├── search.php              # Search results template
├── sidebar.php             # Sidebar template
├── single.php              # Single post template
├── style.css               # Main stylesheet
└── template-parts/         # Template parts
    ├── content-faq.php        # FAQ single template
    ├── content-none.php       # No results template
    ├── content-page.php       # Page content template
    ├── content-research.php   # Research single template
    ├── content-search.php     # Search results item template
    ├── content-service.php    # Service single template
    ├── content-single.php     # Post single template
    ├── content-team.php       # Team member single template
    ├── content-testimonial.php # Testimonial single template
    └── content.php            # Default content template
```

## Installation

1. Upload the `pdtai` folder to the `/wp-content/themes/` directory
2. Activate the theme through the 'Themes' menu in WordPress
3. Configure theme settings via the WordPress Customizer

## Customization

The theme can be customized through the WordPress Customizer, which includes options for:

- Color schemes (primary, secondary, accent colors)
- Layout options (container width, sidebar position)
- Header settings (sticky header, phone number)
- Footer settings (copyright text, address, contact information)
- Social media links
- Homepage content (hero section, section visibility)

## Requirements

- WordPress 5.6 or higher
- PHP 8.0 or higher
- Recommended plugins: Polylang or WPML for multilingual support

## Credits

- Bootstrap 5 framework
- Font Awesome icons
- Google Fonts

## License

GNU General Public License v2 or later