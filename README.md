# PDT.AI

An AI-powered assistant and platform dedicated to Photodynamic Therapy (PDT) for cancer treatment, especially oral cancers.

[![Deploy PDT.AI](https://github.com/yourusername/pdt-ai/actions/workflows/deploy.yml/badge.svg)](https://github.com/yourusername/pdt-ai/actions/workflows/deploy.yml)

## Features

- **Scientific Interpretation & Summarization**: Summarizes and interprets peer-reviewed research, clinical protocols, and device data related to PDT, PpIX fluorescence imaging, and light-based therapies.

- **Treatment Guidance**: Generates evidence-based recommendations for light dosimetry, wavelength, treatment parameters, and workflow optimization for research and clinical practice.

- **Image Analysis Assistance**: Provides step-by-step analysis of PpIX fluorescence imaging, including quantification, image processing, and visualization.

- **Clinical Reporting**: Produces concise, structured clinical reports or dashboards, outlining best practices for PDT data analysis and device integration.

- **Workflow Automation**: Recommends strategies to optimize PDT lab or clinical workflows, including digital tool integration and data tracking.

- **Knowledge Updates**: Accesses credible sources to pull latest research on PDT and related therapies, ensuring advice is up-to-date.

## Project Structure

```
├── client/                 # React frontend
│   ├── public/             # Static files
│   └── src/                # React source code
├── server/                 # Node.js backend
│   ├── controllers/        # Route controllers
│   ├── models/             # Database models
│   ├── routes/             # API routes
│   └── utils/              # Utility functions
├── package.json            # Project dependencies
└── README.md              # Project documentation
```

## Installation

### Prerequisites

- Node.js (v14 or higher)
- npm (v6 or higher)

### Setup Instructions

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/pdt-ai.git
   cd pdt-ai
   ```

2. Install dependencies
   ```bash
   npm run install-all
   ```

3. Create a `.env` file in the root directory with the following variables:
   ```
   PORT=5000
   NODE_ENV=development
   PUBMED_API_KEY=your_pubmed_api_key
   ```

4. Start the development server
   ```bash
   npm run dev
   ```

5. Build for production
   ```bash
   npm run build
   ```

## Deployment

### GitHub Pages Deployment

This project is configured for automatic deployment to GitHub Pages using GitHub Actions.

1. Fork or clone this repository to your GitHub account

2. Update the repository URL in the following files:
   - `package.json`: Update the "homepage" field to match your GitHub Pages URL
   - `README.md`: Update all instances of "yourusername" to your actual GitHub username

3. Set up the required secrets in your GitHub repository:
   - Go to your repository → Settings → Secrets and variables → Actions
   - Add a new repository secret named `PUBMED_API_KEY` with your actual PubMed API key

4. Push your changes to the main branch
   ```bash
   git add .
   git commit -m "Initial setup for deployment"
   git push origin main
   ```

5. GitHub Actions will automatically build and deploy your site to the gh-pages branch

6. Your site will be available at: `https://yourusername.github.io/pdt-ai/`

### Manual Deployment

If you prefer to deploy manually:

1. Build the project
   ```bash
   npm run build
   ```

2. The build files will be in the `client/build` directory

3. Deploy these files to any static hosting service like Netlify, Vercel, or GitHub Pages

### Detailed Deployment Guide

For a comprehensive step-by-step guide with troubleshooting tips and alternative deployment methods, see the [Detailed GitHub Deployment Guide](GITHUB_DEPLOYMENT.md).

## Technologies Used

- **Frontend**: React.js, Material-UI, Chart.js, Three.js
- **Backend**: Node.js, Express.js
- **APIs**: PubMed API for scientific article search
- **Algorithms**: Light-tissue interaction modeling, fluorescence quantification

## Scientific Models

### Optical Properties

PDT.AI implements several key optical models for accurate treatment planning:

- **Beer-Lambert Law**: Models light attenuation through tissue based on absorption coefficient
- **Tissue Optical Properties**: Accounts for wavelength-dependent scattering and absorption
- **Penetration Depth Calculation**: Considers tissue type, melanin content, and hemoglobin content
- **Photosensitizer Activation**: Models wavelength-specific activation efficiency of different photosensitizers

### Fluorescence Measurement

- **PpIX Fluorescence Quantification**: Analyzes pre- and post-treatment fluorescence images
- **Background Correction**: Removes autofluorescence and noise from measurements
- **Normalization Methods**: Standardizes measurements for comparison across patients and time points

## Features

### Home
- Professional landing page with logo, hero images, and introduction
- Patient-friendly and researcher-friendly navigation options

### Article Research
- Real-time search engine for scientific publications
- Integration with PubMed API
- Display of articles with authors, journal, and year

### Treatment Plan
- Algorithmic and physics-verified PDT calculations
- Tunable parameters for light fluence, wavelength, photosensitizer dose, and tissue properties
- Clinical-friendly output format

### Image Analysis
- Quantitative analysis of PpIX and Photofrin fluorescence
- Light-tissue interaction modeling
- Pre- and post-PDT measurements with ratio calculations