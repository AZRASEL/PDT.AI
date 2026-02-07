# PDT Oral Cancer Center Website

A professional, bilingual (English/Bangla) website for a Photodynamic Therapy (PDT) clinic specializing in oral cancer treatment.

## Features

- ✅ **7 Complete Pages**: Home, About PDT, How It Works, Research, Our Clinic, FAQ, Contact
- ✅ **Bilingual Support**: Full English/Bangla translation with language toggle
- ✅ **Research-Based Content**: Includes citations from clinical trials, especially groundbreaking India studies
- ✅ **Responsive Design**: Works perfectly on mobile, tablet, and desktop
- ✅ **Professional Medical Design**: Clean, modern interface with smooth animations
- ✅ **Interactive Elements**: FAQ accordions, mobile navigation, contact form
- ✅ **No Dependencies**: Pure HTML, CSS, and JavaScript - no frameworks needed

## Pages Overview

1. **index.html** - Homepage with hero section, PDT overview, statistics, and CTA
2. **about.html** - Detailed information about PDT, history, and advantages
3. **how-it-works.html** - Step-by-step treatment process explanation
4. **research.html** - Clinical trials and scientific evidence (India studies featured)
5. **clinic.html** - Information about services, technology, and facilities
6. **faq.html** - Frequently asked questions with interactive accordion
7. **contact.html** - Contact form and clinic information

## Local Testing

1. Extract all files to a folder
2. Open `index.html` in your web browser
3. Navigate between pages using the menu
4. Test language toggle (English/Bangla button in top-right)

## Deploying to GitHub Pages

### Method 1: GitHub Web Interface (Easiest)

1. Create a new repository on GitHub (e.g., `pdt-clinic-website`)
2. Go to "Add file" → "Upload files"
3. Drag and drop all the website files (HTML, CSS, JS)
4. Commit the files
5. Go to Settings → Pages
6. Under "Source", select "main" branch and "/" (root) folder
7. Click "Save"
8. Your site will be live at: `https://AZRASEL.github.io/PDT Clinic`

### Method 2: Git Command Line

```bash
# Navigate to your website folder
cd /path/to/website

# Initialize git repository
git init

# Add all files
git add .

# Commit files
git commit -m "Initial commit: PDT clinic website"

# Add remote repository (replace with your repo URL)
git remote add origin https://github.com/AZRASEL/pdt-clinic-website.git

# Push to GitHub
git branch -M main
git push -u origin main

# Enable GitHub Pages in repository settings
```

### Method 3: GitHub Desktop (User-Friendly)

1. Download and install GitHub Desktop
2. Create new repository
3. Copy all website files to the repository folder
4. Commit changes
5. Publish repository
6. Enable GitHub Pages in repository settings on GitHub.com

## File Structure

```
/
├── index.html          # Homepage
├── about.html          # About PDT page
├── how-it-works.html   # Treatment process
├── research.html       # Clinical evidence
├── clinic.html         # Clinic information
├── faq.html           # FAQ page
├── contact.html       # Contact form
├── styles.css         # All styling
├── script.js          # JavaScript functionality
└── README.md          # This file
```

## Customization

### Updating Content

- **Text Content**: Edit the HTML files directly
- **Colors**: Modify CSS variables in `styles.css` (`:root` section)
- **Contact Info**: Update in footer section of each HTML file
- **Images**: Replace placeholder divs with `<img>` tags pointing to your images

### Adding Images

Replace placeholder divs like this:
```html
<div class="placeholder-image">...</div>
```

With actual images:
```html
<img src="images/your-image.jpg" alt="Description">
```

## Key Research Citations Included

- **India Clinical Trial (2022)**: Low-cost PDT system treating 30 patients successfully
- **Meta-Analysis**: 52-82% response rates for oral precancerous lesions
- **Advanced Cancer Study**: 76.9% complete response in palliative cases
- **Global Research**: USA, European, and Asian PDT innovations

## Browser Compatibility

- ✅ Chrome (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Edge (Latest)
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Technologies Used

- HTML5
- CSS3 (Flexbox, Grid, CSS Variables)
- Vanilla JavaScript (ES6+)
- Google Fonts (Inter)

## License

This website template is provided for medical/clinic use. Modify and use as needed for your PDT clinic.

## Support

For questions about deployment or customization, refer to:
- [GitHub Pages Documentation](https://docs.github.com/en/pages)
- [HTML Documentation](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS Documentation](https://developer.mozilla.org/en-US/docs/Web/CSS)

---

**Built with research-backed content to educate patients about PDT's effectiveness for oral cancer treatment.**
